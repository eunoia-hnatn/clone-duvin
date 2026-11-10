<?php
/**
 * Age Gate Modal — Xác minh độ tuổi 18+
 *
 * Component hiển thị popup yêu cầu xác nhận đủ 18 tuổi trước khi xem nội dung.
 * JS (age-gate.js) kiểm soát việc hiện/ẩn dựa trên Cookie `duvin_age_verified`.
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

<!-- Inline CSS — sẽ chuyển sang duvin-light.css sau khi chốt giao diện -->
<style>
.age-gate-overlay {
    position: fixed;
    inset: 0;
    z-index: 99999;
    display: none;
    align-items: center;
    justify-content: center;
    background: rgba(22, 22, 22, 0.92);
    backdrop-filter: blur(6px);
    -webkit-backdrop-filter: blur(6px);
}
.age-gate-overlay.is-active { display: flex; }

.age-gate-card {
    background: #fff;
    width: 90%;
    max-width: 460px;
    padding: 48px 40px 40px;
    border-radius: 8px;
    text-align: center;
    box-shadow: 0 12px 60px rgba(0, 0, 0, 0.35);
    animation: ageGateFadeIn 0.4s ease;
}
@keyframes ageGateFadeIn {
    from { opacity: 0; transform: translateY(20px) scale(0.96); }
    to   { opacity: 1; transform: translateY(0)    scale(1);    }
}

.age-gate-logo img {
    max-height: 80px;
    width: auto;
    margin: 0 auto 28px;
    display: block;
}

.age-gate-title {
    font-family: "Baskerville Old Face", Georgia, serif;
    font-size: 1.6rem;
    color: #161616;
    margin: 0 0 16px;
}

.age-gate-message {
    font-family: "Futura", "Century Gothic", sans-serif;
    font-size: 0.95rem;
    line-height: 1.6;
    color: #555;
    margin: 0 0 32px;
}

.age-gate-buttons {
    display: flex;
    flex-direction: column;
    gap: 12px;
}

.age-gate-btn {
    font-family: "Futura", "Century Gothic", sans-serif;
    font-size: 1rem;
    padding: 14px 32px;
    border-radius: 4px;
    border: none;
    cursor: pointer;
    transition: all 0.25s ease;
    outline: none;
}
.age-gate-btn--confirm {
    background: #B62025;
    color: #fff;
}
.age-gate-btn--confirm:hover {
    background: #9c1a1f;
    transform: translateY(-1px);
    box-shadow: 0 4px 14px rgba(182, 32, 37, 0.35);
}
.age-gate-btn--deny {
    background: transparent;
    color: #888;
    border: 1px solid #ddd;
}
.age-gate-btn--deny:hover {
    border-color: #aaa;
    color: #555;
}

.age-gate-denied {
    margin-top: 20px;
}
.age-gate-denied p {
    font-family: "Futura", "Century Gothic", sans-serif;
    font-size: 0.9rem;
    color: #999;
    margin: 4px 0;
}

@media (max-width: 480px) {
    .age-gate-card { padding: 36px 24px 32px; }
    .age-gate-title { font-size: 1.35rem; }
    .age-gate-message { font-size: 0.88rem; }
}
</style>
