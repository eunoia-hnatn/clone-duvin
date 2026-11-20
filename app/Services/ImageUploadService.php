<?php

declare(strict_types=1);

/**
 * ImageUploadService — Giải mã ảnh Base64 từ Google Sheet, kiểm tra magic bytes,
 * chuẩn hóa kích thước <= 768x768px và chuyển đổi sang định dạng .webp.
 *
 * Vị trí lưu trữ cố định: public/uploads/products/{sku-lowercase}.webp
 * Đường dẫn web trả về:  /uploads/products/{sku-lowercase}.webp
 */
final class ImageUploadService
{
    public const MAX_BYTES = 5242880; // 5 MB
    public const MAX_DIMENSION = 768;
    public const WEBP_QUALITY = 82;

    private const ALLOWED_MIMES = [
        'image/png',
        'image/jpeg',
        'image/webp',
        'image/gif',
        'image/bmp',
        'image/x-ms-bmp',
    ];

    private string $uploadDir;

    public function __construct(?string $uploadDir = null)
    {
        $root = defined('ROOT_PATH') ? ROOT_PATH : dirname(__DIR__, 2);
        $this->uploadDir = rtrim($uploadDir ?? ($root . '/public/uploads/products'), '/\\');
    }

    /**
     * Lưu ảnh Base64 thành file .webp theo mã SKU.
     *
     * @throws InvalidArgumentException Nếu Base64 lỗi, vượt dung lượng hoặc không phải ảnh hợp lệ.
     * @throws RuntimeException Nếu không thể ghi file xuống ổ đĩa.
     */
    public function saveBase64AsWebp(string $base64Data, string $sku): string
    {
        $cleanSku = $this->sanitizeSku($sku);
        if ($cleanSku === '') {
            throw new InvalidArgumentException('Mã SKU không hợp lệ để đặt tên file ảnh.');
        }

        $rawBase64 = trim($base64Data);
        if ($rawBase64 === '') {
            throw new InvalidArgumentException('Dữ liệu ảnh Base64 trống.');
        }

        if (preg_match('/^data:image\/[a-zA-Z0-9.+-]+;base64,(.*)$/s', $rawBase64, $matches)) {
            $rawBase64 = $matches[1];
        }

        $binary = base64_decode(str_replace([' ', "\r", "\n"], ['+', '', ''], $rawBase64), true);
        if ($binary === false || $binary === '') {
            throw new InvalidArgumentException('Chuỗi Base64 không thể giải mã.');
        }

        if (strlen($binary) > self::MAX_BYTES) {
            throw new InvalidArgumentException('Dung lượng ảnh vượt quá giới hạn 5MB.');
        }

        $imageInfo = @getimagesizefromstring($binary);
        if ($imageInfo === false || empty($imageInfo['mime'])) {
            throw new InvalidArgumentException('Dữ liệu không phải là file hình ảnh hợp lệ.');
        }

        $mime = strtolower((string) $imageInfo['mime']);
        if (!in_array($mime, self::ALLOWED_MIMES, true)) {
            throw new InvalidArgumentException('Định dạng ảnh không được hỗ trợ: ' . $mime);
        }

        $srcWidth = (int) ($imageInfo[0] ?? 0);
        $srcHeight = (int) ($imageInfo[1] ?? 0);
        if ($srcWidth <= 0 || $srcHeight <= 0 || $srcWidth > 6000 || $srcHeight > 6000) {
            throw new InvalidArgumentException('Kích thước pixel của ảnh không hợp lệ.');
        }

        if (!is_dir($this->uploadDir) && !@mkdir($this->uploadDir, 0775, true) && !is_dir($this->uploadDir)) {
            throw new RuntimeException('Không thể tạo thư mục lưu ảnh: ' . $this->uploadDir);
        }

        $filename = $cleanSku . '.webp';
        $destPath = $this->uploadDir . DIRECTORY_SEPARATOR . $filename;

        if (function_exists('imagecreatefromstring') && function_exists('imagewebp')) {
            $this->convertAndSaveWithGd($binary, $srcWidth, $srcHeight, $destPath);
        } else {
            if (@file_put_contents($destPath, $binary) === false) {
                throw new RuntimeException('Không thể ghi file ảnh: ' . $destPath);
            }
        }

        return '/uploads/products/' . $filename;
    }

    public function sanitizeSku(string $sku): string
    {
        $clean = strtolower(trim($sku));
        $clean = (string) preg_replace('/[^a-z0-9-]+/', '-', $clean);
        return trim($clean, '-');
    }

    private function convertAndSaveWithGd(string $binary, int $srcW, int $srcH, string $destPath): void
    {
        $srcImg = @imagecreatefromstring($binary);
        if ($srcImg === false) {
            throw new InvalidArgumentException('Không thể đọc dữ liệu pixel từ ảnh.');
        }

        try {
            $maxDim = self::MAX_DIMENSION;
            $dstW = $srcW;
            $dstH = $srcH;

            if ($srcW > $maxDim || $srcH > $maxDim) {
                $ratio = min($maxDim / $srcW, $maxDim / $srcH);
                $dstW = max(1, (int) round($srcW * $ratio));
                $dstH = max(1, (int) round($srcH * $ratio));
            }

            $dstImg = imagecreatetruecolor($dstW, $dstH);
            if ($dstImg === false) {
                throw new RuntimeException('Không thể cấp phát bộ nhớ xử lý ảnh.');
            }

            try {
                imagealphablending($dstImg, false);
                imagesavealpha($dstImg, true);
                $transparent = imagecolorallocatealpha($dstImg, 0, 0, 0, 127);
                imagefilledrectangle($dstImg, 0, 0, $dstW, $dstH, $transparent);

                imagecopyresampled($dstImg, $srcImg, 0, 0, 0, 0, $dstW, $dstH, $srcW, $srcH);

                if (!@imagewebp($dstImg, $destPath, self::WEBP_QUALITY)) {
                    throw new RuntimeException('Chuyển đổi sang định dạng .webp thất bại.');
                }
            } finally {
                imagedestroy($dstImg);
            }
        } finally {
            imagedestroy($srcImg);
        }
    }
}

