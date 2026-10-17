<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="robots" content="noindex">
    <title><?= (int) $status ?> | Duvin</title>
</head>
<body>
    <h1><?= (int) $status ?> — <?= $status === 404 ? 'Trang không tồn tại' : 'Phương thức không được hỗ trợ' ?></h1>
    <p><a href="/">Về trang chủ Duvin</a></p>
</body>
</html>
