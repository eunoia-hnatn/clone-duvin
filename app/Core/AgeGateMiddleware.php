<?php

declare(strict_types=1);

/**
 * AgeGateMiddleware — Chặn truy cập khi người dùng đã chọn "Chưa đủ 18 tuổi".
 *
 * Cơ chế:
 *   - Nếu chưa có cookie nào → CHO QUA bình thường (render HTML cho SEO + bật Modal 18+ overlay).
 *   - Nếu có cookie `duvin_age_denied=1` (đã bấm "Không", hiệu lực 30 phút)
 *     → redirect 302 về `/under-18` và dừng pipeline.
 */
final class AgeGateMiddleware
{
    private const COOKIE_DENIED = 'duvin_age_denied';

    private const BYPASS_PATHS = [
        '/under-18',
        '/age-verify',
    ];

    public function handle(): bool
    {
        $path = parse_url($_SERVER['REQUEST_URI'] ?? '/', PHP_URL_PATH) ?? '/';

        if ($this->isBypassed($path)) {
            return true;
        }

        if ($this->isDenied()) {
            http_response_code(302);
            header('Location: /under-18', true, 302);
            return false;
        }

        return true;
    }

    private function isBypassed(string $path): bool
    {
        if (str_starts_with($path, '/assets/')) {
            return true;
        }

        foreach (self::BYPASS_PATHS as $bypass) {
            if ($path === $bypass || str_starts_with($path, $bypass . '/')) {
                return true;
            }
        }

        return false;
    }

    private function isDenied(): bool
    {
        return isset($_COOKIE[self::COOKIE_DENIED]) && $_COOKIE[self::COOKIE_DENIED] === '1';
    }
}

