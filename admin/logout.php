<?php
declare(strict_types=1);

require __DIR__ . '/../cms/bootstrap.php';
cms_start_session();
$_SESSION = [];
session_destroy();
header('Location: login.php');
exit;
