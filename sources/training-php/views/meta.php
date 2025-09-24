<?php
if (session_status() !== PHP_SESSION_ACTIVE) session_start();
require_once __DIR__ . '/../libs/Csrf.php';

$__csrf = htmlspecialchars(csrf_token(), ENT_QUOTES, 'UTF-8');
?>
<!-- Meta -->
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="csrf-token" content="<?= $__csrf ?>">
<link rel="stylesheet" type="text/css" href="public/css/styles.css">
<link rel="stylesheet" type="text/css" href="public/css/bootstrap.min-3.3.7.css">
<link rel="stylesheet" type="text/css" href="public/css/font-awesome.min-4.6.3.css">

<script type="text/javascript" src="public/js/jquery-2.1.4.min.js"></script>
<script type="text/javascript" src="public/js/bootstrap.min-3.3.7.js"></script>