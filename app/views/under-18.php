<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta name="robots" content="noindex, nofollow" />
    <title>Truy cập bị từ chối — Duvin</title>
    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

        body {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            background-color: #111;
            background-image:
                radial-gradient(ellipse at 30% 20%, rgba(182, 32, 37, 0.1) 0%, transparent 60%);
            font-family: "Futura", "Century Gothic", "Trebuchet MS", sans-serif;
        }

        .card {
            background: #fff;
            width: 90%;
            max-width: 420px;
            padding: 52px 44px 44px;
            border-radius: 6px;
            text-align: center;
            box-shadow: 0 20px 80px rgba(0, 0, 0, 0.5);
        }

        .card__logo { margin-bottom: 32px; }
        .card__logo img { max-height: 72px; width: auto; filter: grayscale(1); opacity: 0.4; }

        .card__icon {
            width: 56px;
            height: 56px;
            border-radius: 50%;
            border: 2px solid #e0e0e0;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 24px;
            color: #bbb;
        }

        .card__title {
            font-family: "Baskerville Old Face", "Baskerville", Georgia, serif;
            font-size: 1.35rem;
            font-weight: normal;
            color: #161616;
            margin-bottom: 16px;
        }

        .card__message {
            font-size: 0.9rem;
            line-height: 1.65;
            color: #888;
            margin-bottom: 32px;
        }

        .card__message strong {
            display: block;
            font-size: 0.95rem;
            color: #555;
            margin-bottom: 8px;
        }

        .card__legal {
            font-size: 0.75rem;
            color: #ccc;
            line-height: 1.5;
            border-top: 1px solid #f0f0f0;
            padding-top: 20px;
            margin-top: 20px;
        }
    </style>
</head>
<body>

    <div class="card" role="main">

        <div class="card__logo">
            <img src="/assets/images/duvin-logo-red-transparent.png" alt="Duvin" />
        </div>

        <div class="card__icon" aria-hidden="true">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none"
                 stroke="currentColor" stroke-width="1.5" stroke-linecap="round"
                 width="26" height="26">
                <circle cx="12" cy="12" r="10"/>
                <line x1="4.93" y1="4.93" x2="19.07" y2="19.07"/>
            </svg>
        </div>

        <h1 class="card__title">Truy cập bị từ chối</h1>

        <div class="card__message">
            <strong>Bạn chưa đủ tuổi để truy cập trang này.</strong>
            Truy cập bị tạm khóa. Website Duvin chỉ dành cho người từ đủ 18 tuổi trở lên theo quy định của pháp luật Việt Nam về kinh doanh rượu.
        </div>

        <p class="card__legal">
            Chấp hành Nghị định số 105/2017/NĐ-CP về kinh doanh rượu.<br />
            Duvin không bán sản phẩm có cồn cho người dưới 18 tuổi.
        </p>

    </div>

</body>
</html>
