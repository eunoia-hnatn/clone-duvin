<?php
/**
 * Age Gate Modal — Xác minh độ tuổi 18+
 *
 * Component hiển thị popup yêu cầu xác nhận đủ 18 tuổi trước khi xem nội dung.
 * CSS: public/assets/css/age-gate.css
 * JS:  public/assets/js/age-gate.js (kiểm soát Cookie `duvin_age_verified`)
 *
 * Biến:
 * @var array $settings Cấu hình từ SiteRepository::getSettings()
 */
$ag = $settings['age_gate'] ?? [
    'enabled'        => true,
    'cookie_minutes' => 15,
    'title'          => 'Xác minh độ tuổi',
    'message'        => 'Duvin cung cấp thông tin về sản phẩm rượu vang dành cho người trên 18 tuổi. Vui lòng xác nhận bạn đủ 18 tuổi để tiếp tục.',
    'confirm_label'  => 'Tôi đủ 18 tuổi',
    'deny_label'     => 'Tôi chưa đủ 18 tuổi',
];
?>
<!-- Age Gate 18+ Modal -->
<div id="age-gate-overlay" class="age-gate-overlay" role="dialog"
     aria-modal="true" aria-labelledby="age-gate-title"
     data-cookie-minutes="<?= (int)$ag['cookie_minutes'] ?>">

    <div class="age-gate-card">
        <!-- Logo -->
        <div class="age-gate-logo">
            <img src="/assets/images/duvin-logo-red-transparent.png"
                 alt="Duvin" width="120" height="auto" />
        </div>

        <!-- Title -->
        <h2 id="age-gate-title" class="age-gate-title"><?= htmlspecialchars($ag['title'], ENT_QUOTES, 'UTF-8') ?></h2>

        <!-- Message -->
        <p class="age-gate-message"><?= htmlspecialchars($ag['message'], ENT_QUOTES, 'UTF-8') ?></p>

        <!-- Buttons -->
        <div class="age-gate-buttons">
            <button type="button"
                    id="age-gate-confirm"
                    class="age-gate-btn age-gate-btn--confirm">
                <?= htmlspecialchars($ag['confirm_label'], ENT_QUOTES, 'UTF-8') ?>
            </button>
            <button type="button"
                    id="age-gate-deny"
                    class="age-gate-btn age-gate-btn--deny">
                <?= htmlspecialchars($ag['deny_label'], ENT_QUOTES, 'UTF-8') ?>
            </button>
        </div>

        <!-- Deny message (hidden by default) -->
        <div id="age-gate-denied" class="age-gate-denied" style="display:none;">
            <p>Bạn cần đủ 18 tuổi để truy cập website Duvin.</p>
            <p>Vui lòng quay lại khi bạn đủ tuổi.</p>
        </div>
    </div>
</div>

