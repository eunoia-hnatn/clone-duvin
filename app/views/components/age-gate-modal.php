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
$ag = $settings['age_gate'];
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
        <hr class="age-gate-divider" />

        <!-- Message -->
        <p class="age-gate-message"><?= htmlspecialchars($ag['message'], ENT_QUOTES, 'UTF-8') ?></p>

        <!-- Buttons -->
        <div class="age-gate-buttons">
            <button type="button"
                    id="age-gate-confirm"
                    class="age-gate-btn age-gate-btn--confirm">
                <?= htmlspecialchars($ag['confirm_label'], ENT_QUOTES, 'UTF-8') ?>
            </button>
            <form method="POST" action="/age-verify" class="age-gate-deny-form">
                <input type="hidden" name="action" value="deny" />
                <button type="submit"
                        id="age-gate-deny"
                        class="age-gate-btn age-gate-btn--deny">
                    <?= htmlspecialchars($ag['deny_label'], ENT_QUOTES, 'UTF-8') ?>
                </button>
            </form>
        </div>

        <p class="age-gate-legal">
            Chấp hành Nghị định số 105/2017/NĐ-CP về kinh doanh rượu.<br />
            Duvin không bán sản phẩm có cồn cho người dưới 18 tuổi.
        </p>
    </div>
</div>

