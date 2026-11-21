// DUVIN GOOGLE SHEETS 1-WAY SYNC SCRIPT (Duvin_v1 - 19 cot)
// Huong dan: Ctrl+A xoa sach Ma.gs cu -> Dan toan bo file nay -> Ctrl+S -> F5 lai Google Sheet -> Menu "🍷 Duvin Sync"

var DUVIN_CONFIG = {
  EXPECTED_HEADERS: [
    'Mã sản phẩm',
    'Tên sản phẩm',
    'Niên vụ',
    'Loại rượu',
    'Giống nho',
    'Xuất xứ',
    'Nhà sản xuất',
    'Nồng độ (% ABV)',
    'Đẳng cấp',
    'Giới thiệu tổng quan',
    'Tasting notes: Màu sắc',
    'Tasting notes: Mùi hương',
    'Tasting notes: Hương vị',
    'Tasting notes: Hậu vị',
    'Thông tin chi tiết sản phẩm',
    'Bảo quản & Cách thưởng thức',
    'Sản phẩm dành cho ai?',
    'Ảnh chính',
    'Thứ tự hiển thị'
  ],
  READ_CHUNK_SIZE: 50,        // Đọc mỗi lượt 50 dòng từ Google Sheet
  MAX_PAYLOAD_BYTES: 1800000, // Tối đa ~1.8MB mỗi HTTP POST (an toàn cho Shared Hosting)
  MAX_IMAGES_PER_REQ: 8,      // Tối đa 8 ảnh Base64 mới trong 1 request
  SAFE_RUNTIME_MS: 270000     // 4.5 phút -> lưu cursor & hẹn Trigger chạy tiếp trước ngưỡng 6 phút
};

/**
 * Tự động tạo menu "🍷 Duvin Sync" khi mở Google Sheet.
 */
function onOpen() {
  SpreadsheetApp.getUi()
    .createMenu('🍷 Duvin Sync')
    .addItem('🔄 Đồng bộ toàn bộ sản phẩm', 'syncAllRows')
    .addItem('🎯 Đồng bộ các dòng đang chọn', 'syncSelectedRows')
    .addSeparator()
    .addItem('🧹 Xóa cache ảnh (Ép gửi lại toàn bộ ảnh)', 'clearImageHashCache')
    .addItem('⚙️ Cài đặt API URL & Secret Key', 'configureSettings')
    .addToUi();
}

/**
 * Hộp thoại cấu hình DUVIN_API_URL và DUVIN_SECRET_KEY vào Script Properties.
 */
function configureSettings() {
  var ui = SpreadsheetApp.getUi();
  var props = PropertiesService.getScriptProperties();

  var currentUrl = props.getProperty('DUVIN_API_URL') || 'https://duvin.gt.tc/api/admin/sheet-sync';
  var urlRes = ui.prompt(
    'Cài đặt Endpoint API Duvin',
    'Nhập URL API đồng bộ (hiện tại: ' + currentUrl + '):',
    ui.ButtonSet.OK_CANCEL
  );
  if (urlRes.getSelectedButton() !== ui.Button.OK) return;
  var newUrl = (urlRes.getResponseText() || '').trim() || currentUrl;

  var keyRes = ui.prompt(
    'Cài đặt GATEWAY_SECRET_KEY',
    'Nhập GATEWAY_SECRET_KEY trùng với file .env trên hosting:',
    ui.ButtonSet.OK_CANCEL
  );
  if (keyRes.getSelectedButton() !== ui.Button.OK) return;
  var newKey = (keyRes.getResponseText() || '').trim();

  props.setProperty('DUVIN_API_URL', newUrl);
  if (newKey !== '') {
    props.setProperty('DUVIN_SECRET_KEY', newKey);
  }

  ui.alert('Đã lưu cấu hình thành công!\nAPI URL: ' + newUrl);
}

/**
 * Xóa toàn bộ hash ảnh đã lưu để ép gửi lại toàn bộ ảnh trong lần đồng bộ kế tiếp.
 */
function clearImageHashCache() {
  var props = PropertiesService.getScriptProperties();
  var all = props.getProperties();
  var removed = 0;
  for (var k in all) {
    if (k.indexOf('IMG_HASH_') === 0) {
      props.deleteProperty(k);
      removed++;
    }
  }
  SpreadsheetApp.getUi().alert('Đã xóa cache của ' + removed + ' ảnh sản phẩm.');
}

/**
 * Đồng bộ toàn bộ dữ liệu sản phẩm từ dòng 2 đến dòng cuối cùng.
 */
function syncAllRows() {
  var sheet = SpreadsheetApp.getActiveSpreadsheet().getActiveSheet();
  var lastRow = sheet.getLastRow();
  if (lastRow < 2) {
    SpreadsheetApp.getUi().alert('Bảng tính chưa có dòng dữ liệu sản phẩm nào (từ dòng 2).');
    return;
  }

  var headers = getSheetHeaders_(sheet);
  var check = validateHeadersClient_(headers);
  if (!check.valid) {
    SpreadsheetApp.getUi().alert('Lỗi cấu trúc bảng (VR-01):\n' + check.message);
    return;
  }

  var batchId = 'gas_' + Utilities.formatDate(new Date(), 'GMT+7', 'yyyyMMdd_HHmmss');
  clearContinuationState_();

  runSyncLoop_(sheet, headers, 2, lastRow, batchId, {
    total_rows: 0,
    success_rows: 0,
    error_rows: 0,
    inserted: 0,
    updated: 0,
    errors: [],
    warnings: []
  });
}

/**
 * Chỉ đồng bộ các dòng đang được bôi đen trên Google Sheet.
 */
function syncSelectedRows() {
  var sheet = SpreadsheetApp.getActiveSpreadsheet().getActiveSheet();
  var range = sheet.getActiveRange();
  if (!range) {
    SpreadsheetApp.getUi().alert('Vui lòng bôi đen ít nhất 1 dòng sản phẩm (từ dòng 2 trở đi).');
    return;
  }

  var startRow = Math.max(2, range.getRow());
  var endRow = range.getLastRow();
  if (endRow < 2) {
    SpreadsheetApp.getUi().alert('Không thể đồng bộ dòng tiêu đề (dòng 1). Hãy chọn từ dòng 2.');
    return;
  }

  var headers = getSheetHeaders_(sheet);
  var check = validateHeadersClient_(headers);
  if (!check.valid) {
    SpreadsheetApp.getUi().alert('Lỗi cấu trúc bảng (VR-01):\n' + check.message);
    return;
  }

  var batchId = 'gas_sel_' + Utilities.formatDate(new Date(), 'GMT+7', 'yyyyMMdd_HHmmss');
  runSyncLoop_(sheet, headers, startRow, endRow, batchId, {
    total_rows: 0,
    success_rows: 0,
    error_rows: 0,
    inserted: 0,
    updated: 0,
    errors: [],
    warnings: []
  });
}

/**
 * Hàm được Trigger tự động gọi khi đồng bộ danh sách lớn (1.000 SP có ảnh) vượt quá 4.5 phút.
 */
function continueSyncFromTrigger_() {
  var props = PropertiesService.getScriptProperties();
  var stateRaw = props.getProperty('SYNC_CONT_STATE');
  if (!stateRaw) return;

  var state = JSON.parse(stateRaw);
  var ss = SpreadsheetApp.getActiveSpreadsheet();
  var sheet = ss.getSheetByName(state.sheet_name) || ss.getActiveSheet();
  var headers = getSheetHeaders_(sheet);

  runSyncLoop_(
    sheet,
    headers,
    state.next_row,
    state.end_row,
    state.batch_id,
    state.stats
  );
}

/**
 * Vòng lặp đọc lô 50 dòng -> tách mini-batch <= 1.8MB -> gửi POST về API.
 */
function runSyncLoop_(sheet, headers, startRow, endRow, batchId, stats) {
  var startTime = Date.now();
  var props = PropertiesService.getScriptProperties();
  var apiUrl = (props.getProperty('DUVIN_API_URL') || 'https://duvin.gt.tc/api/admin/sheet-sync').trim();
  var secretKey = (props.getProperty('DUVIN_SECRET_KEY') || '').trim();

  if (!secretKey) {
    SpreadsheetApp.getUi().alert('Chưa cấu hình GATEWAY_SECRET_KEY!\nHãy vào menu "🍷 Duvin Sync -> ⚙️ Cài đặt API URL & Secret Key".');
    return;
  }

  var cursor = startRow;
  while (cursor <= endRow) {
    // Kiểm tra thời gian chạy để tránh chạm giới hạn 6 phút của Google
    if (Date.now() - startTime >= DUVIN_CONFIG.SAFE_RUNTIME_MS) {
      saveContinuationAndSchedule_(sheet.getName(), cursor, endRow, batchId, stats);
      SpreadsheetApp.getActiveSpreadsheet().toast(
        'Đã xử lý tới dòng ' + (cursor - 1) + '/' + endRow + '. Hệ thống sẽ tự động chạy tiếp sau 10 giây...',
        '🍷 Duvin Sync (Đang chạy nền)',
        10
      );
      return;
    }

    var numRows = Math.min(DUVIN_CONFIG.READ_CHUNK_SIZE, endRow - cursor + 1);
    var batchRows = readSheetChunkWithImages_(sheet, cursor, numRows, props);

    if (batchRows.length > 0) {
      sendChunkedRequests_(apiUrl, secretKey, headers, batchRows, batchId, stats);
    }

    SpreadsheetApp.getActiveSpreadsheet().toast(
      'Đã đồng bộ tới dòng ' + (cursor + numRows - 1) + '/' + endRow + '...',
      '🍷 Duvin Sync',
      4
    );

    cursor += numRows;
  }

  clearContinuationState_();
  showFinalReport_(batchId, stats);
}

/**
 * Đọc 1 lô dòng từ Sheet kèm trích xuất ảnh cột 18 (index 17 - Ảnh chính) sang Base64.
 */
function readSheetChunkWithImages_(sheet, startRow, numRows, props) {
  var range = sheet.getRange(startRow, 1, numRows, DUVIN_CONFIG.EXPECTED_HEADERS.length);
  var values = range.getValues();
  var formulas = range.getFormulas();
  var rows = [];

  for (var i = 0; i < values.length; i++) {
    var rowVals = values[i];
    var rowFormulas = formulas[i];
    var rowNumber = startRow + i;

    var sku = String(rowVals[0] || '').trim().toUpperCase();
    var name = String(rowVals[1] || '').trim();
    if (sku === '' && name === '') {
      continue; // Bỏ qua dòng trống hoàn toàn
    }

    var rawImageCell = rowVals[17];
    var formulaImageCell = rowFormulas[17];
    var imageResult = extractImageBase64_(rawImageCell, formulaImageCell, sku, props);

    var cleanCells = [];
    for (var c = 0; c < DUVIN_CONFIG.EXPECTED_HEADERS.length; c++) {
      if (c === 17) {
        cleanCells.push(imageResult.label);
      } else {
        cleanCells.push(rowVals[c] !== null && rowVals[c] !== undefined ? String(rowVals[c]).trim() : '');
      }
    }

    rows.push({
      row_number: rowNumber,
      cells: cleanCells,
      image_base64: imageResult.base64,
      image_hash: imageResult.hash
    });
  }

  return rows;
}

/**
 * Trích xuất ảnh trong ô (CellImage / =IMAGE("url") / URL trực tiếp) sang Base64 + kiểm tra MD5 hash.
 */
function extractImageBase64_(cellValue, cellFormula, sku, props) {
  try {
    var imageUrl = null;

    // 1. Ảnh chèn trực tiếp trong ô (Insert -> Image -> Insert image in cell)
    if (cellValue && typeof cellValue.getContentUrl === 'function') {
      imageUrl = cellValue.getContentUrl();
    }

    // 2. Công thức =IMAGE("https://...")
    if (!imageUrl && cellFormula) {
      var m = cellFormula.match(/=IMAGE\s*\(\s*["']([^"']+)["']/i);
      if (m && m[1]) {
        imageUrl = m[1];
      }
    }

    // 3. Dán trực tiếp URL http(s) vào ô
    if (!imageUrl && typeof cellValue === 'string' && /^https?:\/\/.+/i.test(cellValue.trim())) {
      imageUrl = cellValue.trim();
    }

    if (!imageUrl) {
      return { base64: '', hash: '', label: '' };
    }

    var response = UrlFetchApp.fetch(imageUrl, { muteHttpExceptions: true });
    if (response.getResponseCode() !== 200) {
      return { base64: '', hash: '', label: '[Fetch Error ' + response.getResponseCode() + ']' };
    }

    var blob = response.getBlob();
    var bytes = blob.getBytes();
    var hashBytes = Utilities.computeDigest(Utilities.DigestAlgorithm.MD5, bytes);
    var hashHex = hashBytes.map(function(b) {
      var v = (b < 0 ? b + 256 : b).toString(16);
      return v.length === 1 ? '0' + v : v;
    }).join('');

    // Nếu ảnh của SKU này không thay đổi so với lần sync trước -> bỏ qua gửi lại Base64
    if (sku && props.getProperty('IMG_HASH_' + sku) === hashHex) {
      return { base64: '', hash: hashHex, label: '[Unchanged Image]' };
    }

    var mime = blob.getContentType() || 'image/png';
    var b64 = 'data:' + mime + ';base64,' + Utilities.base64Encode(bytes);
    return { base64: b64, hash: hashHex, label: '[CellImage]' };
  } catch (err) {
    return { base64: '', hash: '', label: '[Image Error: ' + err.message + ']' };
  }
}

/**
 * Tự động cắt thành các mini-batch <= 1.8MB hoặc <= 8 ảnh rồi gửi POST tuần tự về API.
 */
function sendChunkedRequests_(apiUrl, secretKey, headers, rows, batchId, stats) {
  var props = PropertiesService.getScriptProperties();
  var currentBatch = [];
  var currentBytes = 0;
  var currentImages = 0;

  for (var i = 0; i < rows.length; i++) {
    var r = rows[i];
    var rowSize = JSON.stringify(r).length;
    var hasImg = r.image_base64 && r.image_base64.length > 0;

    if (
      currentBatch.length > 0 &&
      (currentBytes + rowSize > DUVIN_CONFIG.MAX_PAYLOAD_BYTES ||
       (hasImg && currentImages >= DUVIN_CONFIG.MAX_IMAGES_PER_REQ))
    ) {
      flushMiniBatch_(apiUrl, secretKey, headers, currentBatch, batchId, stats, props);
      currentBatch = [];
      currentBytes = 0;
      currentImages = 0;
    }

    currentBatch.push(r);
    currentBytes += rowSize;
    if (hasImg) currentImages++;
  }

  if (currentBatch.length > 0) {
    flushMiniBatch_(apiUrl, secretKey, headers, currentBatch, batchId, stats, props);
  }
}

/**
 * Gửi 1 HTTP POST request về POST /api/admin/sheet-sync và cộng dồn kết quả.
 */
function flushMiniBatch_(apiUrl, secretKey, headers, batchRows, batchId, stats, props) {
  var payload = {
    batch_id: batchId,
    triggered_by: 'google_apps_script',
    headers: headers,
    rows: batchRows
  };

  var res = UrlFetchApp.fetch(apiUrl, {
    method: 'post',
    contentType: 'application/json',
    headers: {
      'X-Gateway-Key': secretKey,
      'Accept': 'application/json'
    },
    payload: JSON.stringify(payload),
    muteHttpExceptions: true
  });

  var code = res.getResponseCode();
  var text = res.getContentText();
  var data = null;
  try {
    data = JSON.parse(text);
  } catch (e) {
    throw new Error('Server trả về phản hồi không phải JSON (HTTP ' + code + '): ' + text.substring(0, 200));
  }

  if (code === 401) {
    throw new Error('Sai GATEWAY_SECRET_KEY (HTTP 401). Hãy kiểm tra lại cài đặt Secret Key.');
  }

  stats.total_rows += Number(data.total_rows || batchRows.length);
  stats.success_rows += Number(data.success_rows || 0);
  stats.error_rows += Number(data.error_rows || 0);
  stats.inserted += Number(data.inserted || 0);
  stats.updated += Number(data.updated || 0);

  if (Array.isArray(data.errors)) {
    stats.errors = stats.errors.concat(data.errors);
  }
  if (Array.isArray(data.warnings)) {
    stats.warnings = stats.warnings.concat(data.warnings);
  }

  // Lưu hash ảnh của các sản phẩm đã đồng bộ thành công để lần sau không gửi trùng
  var failedSkus = {};
  if (Array.isArray(data.errors)) {
    data.errors.forEach(function(err) {
      if (err && err.sku) failedSkus[String(err.sku).toUpperCase()] = true;
    });
  }
  batchRows.forEach(function(r) {
    var sku = String((r.cells && r.cells[0]) || '').trim().toUpperCase();
    if (sku && r.image_base64 && r.image_hash && !failedSkus[sku]) {
      props.setProperty('IMG_HASH_' + sku, r.image_hash);
    }
  });
}

function getSheetHeaders_(sheet) {
  return sheet.getRange(1, 1, 1, DUVIN_CONFIG.EXPECTED_HEADERS.length).getValues()[0].map(function(h) {
    return String(h || '').trim();
  });
}

function validateHeadersClient_(headers) {
  for (var i = 0; i < DUVIN_CONFIG.EXPECTED_HEADERS.length; i++) {
    var expected = DUVIN_CONFIG.EXPECTED_HEADERS[i];
    var actual = String(headers[i] || '').trim();
    if (actual.toLowerCase() !== expected.toLowerCase()) {
      return {
        valid: false,
        message: 'Cột thứ ' + (i + 1) + ' đang là "' + actual + '", yêu cầu phải là "' + expected + '".'
      };
    }
  }
  return { valid: true, message: 'OK' };
}

function saveContinuationAndSchedule_(sheetName, nextRow, endRow, batchId, stats) {
  var props = PropertiesService.getScriptProperties();
  props.setProperty('SYNC_CONT_STATE', JSON.stringify({
    sheet_name: sheetName,
    next_row: nextRow,
    end_row: endRow,
    batch_id: batchId,
    stats: stats
  }));

  deleteContinuationTriggers_();
  ScriptApp.newTrigger('continueSyncFromTrigger_')
    .timeBased()
    .after(10 * 1000)
    .create();
}

function clearContinuationState_() {
  PropertiesService.getScriptProperties().deleteProperty('SYNC_CONT_STATE');
  deleteContinuationTriggers_();
}

function deleteContinuationTriggers_() {
  var triggers = ScriptApp.getProjectTriggers();
  for (var i = 0; i < triggers.length; i++) {
    if (triggers[i].getHandlerFunction() === 'continueSyncFromTrigger_') {
      ScriptApp.deleteTrigger(triggers[i]);
    }
  }
}

function showFinalReport_(batchId, stats) {
  var lines = [
    '✅ ĐỒNG BỘ HOÀN TẤT (Mã phiên: ' + batchId + ')',
    '----------------------------------------',
    '• Tổng số dòng xử lý: ' + stats.total_rows,
    '• Thành công: ' + stats.success_rows + ' (Thêm mới: ' + stats.inserted + ', Cập nhật: ' + stats.updated + ')',
    '• Lỗi bỏ qua: ' + stats.error_rows,
    '• Cảnh báo: ' + stats.warnings.length
  ];

  if (stats.errors.length > 0) {
    lines.push('\n❌ Chi tiết lỗi (tối đa 10 dòng đầu):');
    stats.errors.slice(0, 10).forEach(function(e) {
      lines.push('  - ' + (e.message || JSON.stringify(e)));
    });
  }

  if (stats.warnings.length > 0) {
    lines.push('\n⚠️ Cảnh báo (tối đa 5 dòng đầu):');
    stats.warnings.slice(0, 5).forEach(function(w) {
      lines.push('  - ' + (w.message || JSON.stringify(w)));
    });
  }

  try {
    SpreadsheetApp.getUi().alert(lines.join('\n'));
  } catch (e) {
    // Khi chạy từ Trigger nền không có UI context -> hiển thị qua Toast
    SpreadsheetApp.getActiveSpreadsheet().toast(
      'Thành công: ' + stats.success_rows + '/' + stats.total_rows + ' (Lỗi: ' + stats.error_rows + ')',
      '✅ Duvin Sync Hoàn tất',
      15
    );
  }
}

