<?php
if (session_status() !== PHP_SESSION_ACTIVE) session_start();

// Kết nối Redis
$redis = new Redis();
$redis->connect('web-redis', 6379);

// Xoá session trong Redis nếu tồn tại
if (isset($_SESSION['session_id'])) {
    $sessionId = $_SESSION['session_id'];
    $redis->del("session:$sessionId");
}

// Xoá cookie nếu có
if (isset($_COOKIE['session_id'])) {
    setcookie('session_id', '', time() - 3600, "/", "", false, true);
}

// Xoá toàn bộ PHP session
session_unset();
session_destroy();

// Quay về trang login
header('Location: login.php');
exit;
