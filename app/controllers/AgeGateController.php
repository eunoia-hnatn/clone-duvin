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
 */
final class AgeGateController extends BaseController
{
    private const COOKIE_VERIFIED     = 'duvin_age_verified';
    private const COOKIE_DENIED       = 'duvin_age_denied';
    private const COOKIE_DENIED_UNTIL = 'duvin_age_denied_until';

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
        $action   = $_POST['action'] ?? 'deny';
        $settings = (new SiteRepository())->getSettings();
        $ag       = $settings['age_gate'] ?? [];

        if ($action === 'confirm') {
            $minutes   = max(1, (int) ($ag['cookie_minutes'] ?? 10080));
            $expiresAt = time() + $minutes * 60;
            setcookie(self::COOKIE_VERIFIED, '1', $this->cookieOptions($expiresAt));
            setcookie(self::COOKIE_DENIED, '', $this->cookieOptions(time() - 3600));
            setcookie(self::COOKIE_DENIED_UNTIL, '', $this->cookieOptions(time() - 3600));
            $this->redirect($this->getRedirectDestination());
            return;
        }

        // deny — chặn truy cập trong deny_minutes từ settings
        $minutes   = max(1, (int) ($ag['deny_minutes'] ?? 30));
        $expiresAt = time() + $minutes * 60;
        setcookie(self::COOKIE_DENIED, '1', $this->cookieOptions($expiresAt));
        setcookie(self::COOKIE_DENIED_UNTIL, (string) $expiresAt, $this->cookieOptions($expiresAt));
        setcookie(self::COOKIE_VERIFIED, '', $this->cookieOptions(time() - 3600));
        $this->redirect('/under-18');
    }

    /** Hiển thị trang từ chối /under-18. */
    public function showUnder18(): void
    {
        // Cookie hết hạn → thời gian phạt đã xong, redirect về trang chủ để chọn lại
        if (!$this->isDenied()) {
            $this->redirect('/');
            return;
        }

        $settings    = (new SiteRepository())->getSettings();
        $denyMinutes = max(1, (int) ($settings['age_gate']['deny_minutes'] ?? 30));
        $maxSeconds  = $denyMinutes * 60;
        $until       = (int) ($_COOKIE[self::COOKIE_DENIED_UNTIL] ?? (time() + $maxSeconds));
        $remaining   = max(1, min($maxSeconds, $until - time()));

        $this->render('under-18', [
            'remainingSeconds' => $remaining,
            'denyMinutes'      => $denyMinutes,
        ], null);
    }

    // ── Private helpers ───────────────────────────────────────────────────────

    private function cookieOptions(int $expires): array
    {
        $isHttps = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off')
            || (($_SERVER['HTTP_X_FORWARDED_PROTO'] ?? '') === 'https');

        return [
            'expires'  => $expires,
            'path'     => '/',
            'secure'   => $isHttps,
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
        $raw     = $_POST['redirect'] ?? $_GET['redirect'] ?? '/';
        $decoded = urldecode((string) $raw);

        if (!str_starts_with($decoded, '/') || str_starts_with($decoded, '//')) {
            return '/';
        }

        return $decoded;
    }
}
