<?php
if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}

function csrf_token(): string {
    if (empty($_SESSION['_csrf_token'])) {
        $_SESSION['_csrf_token'] = bin2hex(random_bytes(32));
    }
    return $_SESSION['_csrf_token'];
}

function csrf_field(): string {
    $t = htmlspecialchars(csrf_token(), ENT_QUOTES, 'UTF-8');
    return '<input type="hidden" name="_csrf" value="'.$t.'">';
}

function csrf_verify_or_die(): void {
    $method = $_SERVER['REQUEST_METHOD'] ?? 'GET';
    if (!in_array($method, ['POST','PUT','PATCH','DELETE'], true)) {
        return;
    }

    $sent = $_POST['_csrf'] ?? $_SERVER['HTTP_X_CSRF_TOKEN'] ?? '';
    $sess = $_SESSION['_csrf_token'] ?? '';

    if (!is_string($sent) || !is_string($sess) || $sess === '' || !hash_equals($sess, $sent)) {
        http_response_code(419);
        header('Content-Type: text/plain; charset=utf-8');
        echo "CSRF verification failed";
        exit;
    }
}

function csrf_rotate(): void {
    unset($_SESSION['_csrf_token']);
    csrf_token();
}
