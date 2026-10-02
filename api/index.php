<?php
// Chuyển hướng thư mục làm việc ra ngoài thư mục gốc để các đường dẫn include không bị hỏng
chdir(__DIR__ . '/../');
// Gọi file index.php gốc của hệ thống MVC
require 'index.php';