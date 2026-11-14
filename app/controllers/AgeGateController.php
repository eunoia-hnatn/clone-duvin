<?php

declare(strict_types=1);

/**
 * AgeGateController — Xử lý trang xác minh 18+ và trang từ chối.
 *
 * Routes:
 *   GET  /age-verify   → hiển thị trang xác minh
 *   POST /age-verify   → xử lý submit (server-side setcookie)
 *   GET  /under-18     → trang từ chối truy cập
 *
 * Thời gian cookie được đọc động từ SiteRepository::getSettings():
 *   age_gate.cookie_minutes  — khi xác nhận ĐỦ 18 tuổi
 *   age_gate.deny_minutes    — khi chọn CHƯA ĐỦ 18 tuổi
 * Thay đổi 2 giá trị đó là toàn bộ hệ thống tự cập nhật.
 */
final class AgeGateController extends BaseController
{
    private const COOKIE_VERIFIED = 'duvin_age_verified';
    private const COOKIE_DENIED   = 'duvin_age_denied';

    /** Hiển thị trang xác minh độ tuổi. */
    public function showVerify(): void
    {
        if ($this->isVerified()) {
            $this->redirect($this->getRedirectDestination());
            return;
        }

        if ($this->isDenied()) {
            $this->redirect('/under-18');
            return;
        }

        $this->render('age-verify', [], null);
    }

    /** Xử lý POST submit từ trang xác minh. */
    public function handleVerify(): void
    {
        $action   = $_POST['action'] ?? '';
        $settings = (new SiteRepository())->getSettings();
        $ag       = $settings['age_gate'] ?? [];

        if ($action === 'confirm') {
            $minutes = max(1, (int)($ag['cookie_minutes'] ?? 15));
            setcookie(self::COOKIE_VERIFIED, '1', $this->cookieOptions($minutes));
            $this->redirect($this->getRedirectDestination());
            return;
        }

        // deny — chặn truy cập trong deny_minutes phút
        $minutes = max(1, (int)($ag['deny_minutes'] ?? 15));
        setcookie(self::COOKIE_DENIED, '1', $this->cookieOptions($minutes));
        $this->redirect('/under-18');
    }

    /** Hiển thị trang từ chối. */
    public function showUnder18(): void
    {
        // Cookie hết hạn → thời gian phạt đã xong, redirect về trang chủ để chọn lại
        if (!$this->isDenied()) {
            $this->redirect('/');
            return;
        }

        $this->render('under-18', [], null);
    }

    // ── Private helpers ───────────────────────────────────────────────────────

    private function cookieOptions(int $minutes): array
    {
        return [
            'expires'  => time() + $minutes * 60,
            'path'     => '/',
            'secure'   => isset($_SERVER['HTTPS']),
            'httponly' => false,
            'samesite' => 'Lax',
        ];
    }

    private function isVerified(): bool
    {
        return ($_COOKIE[self::COOKIE_VERIFIED] ?? '') === '1';
    }

    private function isDenied(): bool
    {
        return ($_COOKIE[self::COOKIE_DENIED] ?? '') === '1';
    }

    private function getRedirectDestination(): string
    {
        $raw     = $_GET['redirect'] ?? $_POST['redirect'] ?? '/';
        $decoded = urldecode($raw);

        if (!str_starts_with($decoded, '/') || str_starts_with($decoded, '//')) {
            return '/';
        }
        if ($decoded === '/age-verify' || str_starts_with($decoded, '/age-verify/') || $decoded === '/under-18') {
            return '/';
        }
        return $decoded;
    }
}
