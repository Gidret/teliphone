<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] !== 'POST') { 
    http_response_code(405);
    exit;
}

$login    = trim($_POST['login'] ?? '');
$password = $_POST['password'] ?? '';

if (empty($login) || empty($password)) {
    $_SESSION['message'] = 'Заполните все поля';
    header('Location: ../authPage.php?stat=err');
    exit;
}

require_once '../db/conn.php';

$InDb = $conn->prepare('SELECT id, password, role FROM users WHERE login = :login');
$InDb->execute([':login' => $login]);
$arrDb = $InDb->fetch(PDO::FETCH_ASSOC);

if (!$arrDb || !password_verify($password, $arrDb['password'])) {
    $_SESSION['message'] = 'Неверный логин или пароль!';
    header('Location: ../authPage.php?stat=err');
    exit;
}

// Записываем ID пользователя в сессию СРАЗУ для всех
$_SESSION['user_id'] = $arrDb['id'];

if ($arrDb['role'] == 'admin') {
    header("Location: ../admin.php");
    exit;
}

header('Location: ../home.php');
exit;
?>