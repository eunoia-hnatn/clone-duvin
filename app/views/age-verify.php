<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta name="robots" content="noindex, nofollow" />
    <title>Xác minh độ tuổi — Duvin</title>
    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

        body {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            background-color: #111;
            background-image:
                radial-gradient(ellipse at 30% 20%, rgba(182, 32, 37, 0.18) 0%, transparent 60%),
                radial-gradient(ellipse at 75% 80%, rgba(99, 97, 70, 0.14) 0%, transparent 55%);
            font-family: "Futura", "Century Gothic", "Trebuchet MS", sans-serif;
        }

        .card {
            background: #fff;
            width: 90%;
            max-width: 460px;
            padding: 52px 44px 44px;
            border-radius: 6px;
            text-align: center;
            box-shadow: 0 20px 80px rgba(0, 0, 0, 0.5);
        }

        .card__logo {
            margin-bottom: 32px;
        }
        .card__logo img {
            max-height: 80px;
            width: auto;
        }

        .card__title {
            font-family: "Baskerville Old Face", "Baskerville", Georgia, serif;
            font-size: 1.55rem;
            font-weight: normal;
            color: #161616;
            letter-spacing: 0.02em;
            margin-bottom: 18px;
        }

        .card__message {
            font-size: 0.92rem;
            line-height: 1.65;
            color: #666;
            margin-bottom: 36px;
        }

        .card__divider {
            width: 40px;
            height: 2px;
            background: #B62025;
            margin: 0 auto 32px;
            border: none;
        }

        .card__actions {
            display: flex;
            flex-direction: column;
            gap: 14px;
        }

        .btn {
            display: block;
            width: 100%;
            padding: 15px 24px;
            font-family: inherit;
            font-size: 0.95rem;
            letter-spacing: 0.03em;
            border-radius: 3px;
            border: none;
            cursor: pointer;
            transition: all 0.22s ease;
            outline: none;
        }

        .btn--confirm {
            background: #B62025;
            color: #fff;
        }
        .btn--confirm:hover,
        .btn--confirm:focus-visible {
            background: #9c1a1f;
            transform: translateY(-1px);
            box-shadow: 0 6px 20px rgba(182, 32, 37, 0.35);
        }

        .btn--deny {
            background: transparent;
            color: #999;
            border: 1px solid #ddd;
        }
        .btn--deny:hover,
        .btn--deny:focus-visible {
            border-color: #bbb;
            color: #666;
        }

        .card__legal {
            margin-top: 28px;
            font-size: 0.75rem;
            color: #bbb;
            line-height: 1.5;
        }

        @media (max-width: 480px) {
            .card { padding: 40px 24px 36px; }
            .card__title { font-size: 1.3rem; }
        }
    </style>
</head>
<body>

    <div class="card" role="main">

        <div class="card__logo">
            <img src="/assets/images/duvin-logo-red-transparent.png"
                 alt="Duvin — Fine Wine" />
        </div>

        <h1 class="card__title">Xác minh độ tuổi</h1>
        <hr class="card__divider" />

        <p class="card__message">
            Duvin cung cấp thông tin về rượu vang cao cấp dành cho người từ đủ 18 tuổi trở lên theo quy định pháp luật Việt Nam. Vui lòng xác nhận độ tuổi của bạn để tiếp tục.
        </p>

        <form method="POST" action="/age-verify" class="card__actions">
            <?php
            // Truyền tham số redirect qua hidden field để không mất sau POST
            $redirect = $_GET['redirect'] ?? '/';
            $safeRedirect = (str_starts_with($redirect, '/') && !str_starts_with($redirect, '//'))
                ? htmlspecialchars($redirect, ENT_QUOTES, 'UTF-8')
                : '/';
            ?>
            <input type="hidden" name="redirect" value="<?= $safeRedirect ?>" />

            <button type="submit" name="action" value="confirm" class="btn btn--confirm">
                Tôi đủ 18 tuổi — Tiếp tục
            </button>
            <button type="submit" name="action" value="deny" class="btn btn--deny">
                Tôi chưa đủ 18 tuổi
            </button>
        </form>

        <p class="card__legal">
            Chấp hành Nghị định số 105/2017/NĐ-CP về kinh doanh rượu.<br />
            Duvin không bán sản phẩm có cồn cho người dưới 18 tuổi.
        </p>

    </div>

</body>
</html>
