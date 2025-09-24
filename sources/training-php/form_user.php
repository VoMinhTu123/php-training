<?php
// Start the session (an toàn khi include lặp)
if (session_status() !== PHP_SESSION_ACTIVE) session_start();

require_once 'models/UserModel.php';
require_once 'libs/Csrf.php'; // dùng csrf_field() & csrf_verify_or_die()

$userModel = new UserModel();

$user = null;   // dữ liệu user khi sửa
$_id  = null;

// Nếu có id => lấy user để hiển thị form sửa
if (!empty($_GET['id'])) {
    $_id  = (int) $_GET['id'];
    $user = $userModel->findUserById($_id);
}

// Xử lý submit
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit'])) {

    // 1) Kiểm tra CSRF trước
    csrf_verify_or_die();

    // 2) Gọi insert/update
    if (!empty($_POST['id'])) {
        $userModel->updateUser($_POST);
    } else {
        $userModel->insertUser($_POST);
    }

    // 3) Điều hướng và kết thúc hẳn tiến trình để tránh "headers already sent"
    header('Location: list_users.php');
    exit;
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>User form</title>
    <?php include 'views/meta.php'; // meta.php có thể gọi csrf_token() cho JS ?>
</head>
<body>
<?php include 'views/header.php'; ?>
<div class="container">

    <?php if ($user || !isset($_id)) { ?>
        <div class="alert alert-warning" role="alert">User form</div>

        <form method="POST" action="">
            <?= csrf_field() ?> <!-- CSRF hidden -->

            <input type="hidden" name="id" value="<?= htmlspecialchars($_id ?? '', ENT_QUOTES, 'UTF-8') ?>">

            <div class="form-group">
                <label for="name">Name</label>
                <input class="form-control" name="name" placeholder="Name"
                       value="<?= !empty($user[0]['name']) ? htmlspecialchars($user[0]['name'], ENT_QUOTES, 'UTF-8') : '' ?>">
            </div>

            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" name="password" class="form-control" placeholder="Password">
            </div>

            <button type="submit" name="submit" value="submit" class="btn btn-primary">Submit</button>
        </form>

    <?php } else { ?>
        <div class="alert alert-success" role="alert">User not found!</div>
    <?php } ?>

</div>
</body>
</html>
