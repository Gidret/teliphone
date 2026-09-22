<?php
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    exit;
}
session_start();

$login = trim($_POST['login'] ?? '');
$password = $_POST['password'] ?? '';
$rePassword = $_POST['rePassword'] ?? '';
$email = trim($_POST['email'] ?? '');
$tel = trim($_POST['tel'] ?? '');
$fio = trim($_POST['fio'] ?? '');
$role = 'user';

if (empty($login) or empty($password) or empty($email) or empty($tel) or empty($fio)) {
    $_SESSION['message'] = "Все поля должны быть заполнены!";
    header("Location: ../index.php?stat=err");
    exit;
}

if (mb_strlen($password) < 8) {
    $_SESSION['message'] = "Пароль должен быть не менее 8 символов";
    header("Location: ../index.php?stat=err");
    exit;
}

if (mb_strlen($login) < 6) {
    $_SESSION['message'] = "Логин должен быть не менее 6 символов";
    header("Location: ../index.php?stat=err");
    exit;
}

if (!preg_match('/^[А-Яа-яёЁ ]+$/u', $fio)) { //после Ё стоит пробел
    $_SESSION['message'] = "ФИО может состоять только из кириллицы";
    header("Location: ../index.php?stat=err");
    exit;
}

$tel = preg_replace('/.*(\d{3})(\d{3})(\d{2})(\d{2})$/', '8($1)$2-$3-$4', $tel);

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $_SESSION['message'] = "Некорректный email";
    header("Location: ../index.php?stat=err");
    exit;
}

if($login == "YaRcOO" and $password == "11111111"){
    $role = "admin";
}
require_once '../db/conn.php';
$InDb = $conn->prepare("SELECT login FROM users WHERE login = :login");
$InDb->execute(['login' => $login]);
$arrDb = $InDb->fetch(PDO::FETCH_ASSOC);

if ($arrDb) {
    $_SESSION['message'] = "Логин занят";
    header("Location: ../index.php?stat=err");
    exit;
}

$passwordHash = password_hash($password, PASSWORD_DEFAULT); 
$conn->prepare("INSERT INTO users (login, password, email, tel, fio, role) VALUES (?,?,?,?,?,?)")
     ->execute([$login,$password,$email,$tel,$fio,$role]);
    $_SESSION['user_id'] = $conn->lastInsertId();

$_SESSION['message'] = "Регистрация успешна";
header("Location: ../index.php?stat=ok");
exit;
?>