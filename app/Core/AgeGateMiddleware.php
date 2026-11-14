<?php

declare(strict_types=1);

/**
 * AgeGateMiddleware — Chặn toàn bộ request chưa xác minh 18+.
 *
 * Cơ chế:
 *   - Kiểm tra cookie `duvin_age_verified` trên mỗi request.
 *   - Nếu chưa có cookie → redirect 302 về /age-verify và dừng hoàn toàn.
 *   - Server không render bất kỳ HTML nội dung nào khi chưa xác minh.
 *
 * Ngoại lệ (bypass):
 *   - GET /age-verify  — trang xác minh tuổi
 *   - POST /age-verify — submit xác nhận
 *   - GET /under-18    — trang từ chối
 *   - /assets/*        — static files (phòng trường hợp không qua .htaccess)
 *
 * Sử dụng trong Router:
 *   $router->get('/', $handler, [], [AgeGateMiddleware::class]);
 *   hoặc group-level:
 *   $router->group('/', fn($r) => ..., [AgeGateMiddleware::class]);
 */
final class AgeGateMiddleware
{
    private const COOKIE_NAME = 'duvin_age_verified';

    /** Danh sách đường dẫn không áp dụng middleware. */
    private const BYPASS_PATHS = [
        '/age-verify',
        '/under-18',
    ];

    /**
     * Chạy middleware.
     * Trả về false để Router dừng pipeline (không gọi controller).
     * Trả về true để Router tiếp tục.
     */
    public function handle(): bool
    {
        $path = parse_url($_SERVER['REQUEST_URI'] ?? '/', PHP_URL_PATH) ?? '/';

        // Bypass: trang xác minh, trang từ chối, static assets
        if ($this->isBypassed($path)) {
            return true;
        }

        // Đã xác minh → cho qua
        if ($this->isVerified()) {
            return true;
        }

        // Đã từ chối (cookie block còn hiệu lực) → redirect /under-18, không render gì
        if ($this->isDenied()) {
            $this->redirectTo('/under-18');
            return false;
        }

        // Chưa xác minh → redirect server-side, không render HTML
        $this->redirectToAgeVerify();
        return false;
    }

    private function isBypassed(string $path): bool
    {
        // Static files
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

    private function isVerified(): bool
    {
        return isset($_COOKIE[self::COOKIE_NAME]) && $_COOKIE[self::COOKIE_NAME] === '1';
    }

    private function isDenied(): bool
    {
        return isset($_COOKIE['duvin_age_denied']) && $_COOKIE['duvin_age_denied'] === '1';
    }

    private function redirectTo(string $url): void
    {
        http_response_code(302);
        header('Location: ' . $url, true, 302);
    }

    private function redirectToAgeVerify(): void
    {
        // Lưu URL đích để sau khi xác minh có thể redirect về đúng trang
        $destination = $_SERVER['REQUEST_URI'] ?? '/';
        $redirectTo = '/age-verify?redirect=' . urlencode($destination);

        http_response_code(302);
        header('Location: ' . $redirectTo, true, 302);
        // Không exit() — Router kiểm soát flow qua return false
    }
}
