<?php
if (session_status() !== PHP_SESSION_ACTIVE) session_start();

require_once 'libs/Csrf.php';
require_once 'models/UserModel.php';

$userModel = new UserModel();

// Chỉ xử lý khi POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Kiểm tra CSRF token
    csrf_verify_or_die();

    if (!empty($_POST['id'])) {
        $id = (int)$_POST['id'];
        $userModel->deleteUserById($id);
    }
}

header('Location: list_users.php');
exit;
