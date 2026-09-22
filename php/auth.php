<?php
if ($_SERVER['REQUEST_METHOD'] !== 'POST') { 
    http_response_code(405);
    exit;
}

session_start();
$login    = trim($_POST['login']) ?? '';
$password = $_POST['password'] ?? '';


if (empty($login) or empty($password)) {
    $_SESSION['message'] = 'Заполните все поля';
    header('Location: ../authPage.php?stat=err');
    exit;
}

require_once '../db/conn.php';

$InDb = $conn->prepare('SELECT id,password,role FROM users WHERE login = :login');
$InDb->execute([':login' => $login]);
$arrDb = $InDb->fetch(PDO::FETCH_ASSOC);

if (!$arrDb or !password_verify($password, $arrDb['password'])) {
    $_SESSION['message'] = 'Неверный логин или пароль!';
    header('Location: ../authPage.php?stat=err');
    exit;
}
if($arrDb['role'] == 'admin'){
    $_SESSION['user_id'] = $arrDb['id'];
    header("location:../admin.php");
    exit;
}
header('Location: ../home.php');
$_SESSION['user_id'] = $arrDb['id'];
exit;
?>
?>  