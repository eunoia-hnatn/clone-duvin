<?php
/**
 * Trang từ chối truy cập (/under-18) — hiển thị khi user chọn chưa đủ 18 tuổi.
 *
 * @var int $remainingSeconds Số giây còn lại trước khi tự động đưa về trang chủ
 * @var int $denyMinutes      Số phút chặn mặc định
 */
$remaining = max(1, (int) ($remainingSeconds ?? 1800));
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta name="robots" content="noindex, nofollow" />
    <title>Truy cập bị từ chối — Duvin</title>
    <link rel="stylesheet" href="/assets/css/age-gate.css" />
</head>
<body class="under18-page" data-under18-remaining="<?= $remaining ?>">

    <div class="under18-card" role="main">

        <div class="under18-logo">
            <img src="/assets/images/duvin-logo-red-transparent.png" alt="Duvin" />
        </div>

        <div class="under18-icon" aria-hidden="true">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none"
                 stroke="currentColor" stroke-width="1.5" stroke-linecap="round"
                 width="26" height="26">
                <circle cx="12" cy="12" r="10"/>
                <line x1="4.93" y1="4.93" x2="19.07" y2="19.07"/>
            </svg>
        </div>

        <h1 class="under18-title">Truy cập bị từ chối</h1>
        <hr class="under18-divider" />

        <div class="under18-message">
            <strong>Bạn chưa đủ tuổi để truy cập trang này.</strong>
            Truy cập bị tạm khóa trong <?= (int) ($denyMinutes ?? 30) ?> phút. Website Duvin chỉ dành cho người từ đủ 18 tuổi trở lên theo quy định của pháp luật Việt Nam về kinh doanh rượu.
        </div>

        <p class="under18-legal">
            Chấp hành Nghị định số 105/2017/NĐ-CP về kinh doanh rượu.<br />
            Duvin không bán sản phẩm có cồn cho người dưới 18 tuổi.
        </p>

    </div>

    <script src="/assets/js/age-gate.js" defer></script>
</body>
</html>

