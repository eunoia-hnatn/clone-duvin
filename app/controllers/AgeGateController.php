<?php

declare(strict_types=1);

/**
 * AgeGateController — Xử lý xác nhận 18+ (server-side cookie) & trang từ chối /under-18.
 *
 * Routes:
 *   POST /age-verify → Xử lý khi user bấm "Tôi chưa đủ 18 tuổi" (hoặc fallback form "Đủ 18 tuổi")
 *   GET  /under-18   → Trang từ chối truy cập trong 30 phút
 */
final class AgeGateController extends BaseController
{
    private const COOKIE_VERIFIED     = 'duvin_age_verified';
    private const COOKIE_DENIED       = 'duvin_age_denied';
    private const COOKIE_DENIED_UNTIL = 'duvin_age_denied_until';

    /** Xử lý POST submit xác minh tuổi. */
    public function handleVerify(): void
    {
        $action   = $_POST['action'] ?? 'deny';
        $settings = (new SiteRepository())->getSettings();
        $ag       = $settings['age_gate'] ?? [];

        if ($action === 'confirm') {
            $minutes = max(1, (int) ($ag['cookie_minutes'] ?? 10080));
            setcookie(self::COOKIE_VERIFIED, '1', $this->cookieOptions(time() + $minutes * 60));
            setcookie(self::COOKIE_DENIED, '', $this->cookieOptions(time() - 3600));
            setcookie(self::COOKIE_DENIED_UNTIL, '', $this->cookieOptions(time() - 3600));
            $this->redirect($this->getRedirectDestination());
            return;
        }

        // deny — chặn truy cập trong 30 phút (hoặc deny_minutes từ settings)
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
        // Cookie hết hạn → hết thời gian chờ 30 phút, đưa về trang chủ
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
        if ($decoded === '/age-verify' || str_starts_with($decoded, '/age-verify/') || $decoded === '/under-18') {
            return '/';
        }
        return $decoded;
    }
}

