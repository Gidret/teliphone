<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    exit;
}

// Защита: неавторизованные не могут удалять
if (!isset($_SESSION['user_id'])) {
    header('Location: ../authPage.php');
    exit;
}

$ad_id = intval($_POST['ad_id'] ?? 0);

if ($ad_id <= 0) {
    $_SESSION['message'] = 'Неверный ID объявления.';
    header('Location: ../telPage.php?stat=err');
    exit;
}

require_once '../db/conn.php';

// Сначала достаем объявление, чтобы проверить права и узнать имя файла картинки
$stmt = $conn->prepare('SELECT ads.user_id, ads.photo, users.role FROM ads JOIN users ON users.id = :current_user WHERE ads.id = :ad_id');
$stmt->execute([':ad_id' => $ad_id, ':current_user' => $_SESSION['user_id']]);
$ad = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$ad) {
    $_SESSION['message'] = 'Объявление не найдено.';
    header('Location: ../telPage.php?stat=err');
    exit;
}

// Проверка прав: текущий user_id совпадает с автором ИЛИ у текущего юзера роль admin
if ($ad['user_id'] == $_SESSION['user_id'] || $ad['role'] === 'admin') {
    
    // Удаляем файл картинки с сервера, если он был
    if (!empty($ad['photo'])) {
        $file_path = '../uploads/' . $ad['photo'];
        if (file_exists($file_path)) {
            unlink($file_path);
        }
    }
    
    // Удаляем саму запись из базы
    $del_stmt = $conn->prepare('DELETE FROM ads WHERE id = ?');
    $del_stmt->execute([$ad_id]);
    
    $_SESSION['message'] = 'Объявление успешно удалено!';
    header('Location: ../telPage.php?stat=ok');
} else {
    $_SESSION['message'] = 'У вас нет прав на удаление этого объявления!';
    header('Location: ../telPage.php?stat=err');
}
exit;
?>
