<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] !== 'POST') { 
    http_response_code(405);
    exit;
}

if (!isset($_SESSION['user_id'])) {
    $_SESSION['message'] = 'Для создания объявления нужно авторизоваться!';
    header('Location: ../authPage.php?stat=err');
    exit;
}

$phone_model = trim($_POST['phone_model'] ?? '');
$price       = trim($_POST['price'] ?? '');
$description = trim($_POST['description'] ?? '');
$photo_name  = null;

if (empty($phone_model) || empty($price) || empty($description)) {
    $_SESSION['message'] = 'Заполните все текстовые поля объявления!';
    header('Location: ../createPage.php?stat=err');
    exit;
}

// ---- ЛОГИКА ЗАГРУЗКИ ФОТО ----
if (isset($_FILES['photo']) && $_FILES['photo']['error'] === UPLOAD_ERR_OK) {
    $fileTmpPath = $_FILES['photo']['tmp_name'];
    $fileName = $_FILES['photo']['name'];
    $fileExtension = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
    
    // Разрешенные форматы
    $allowedExtensions = ['jpg', 'jpeg', 'png', 'webp'];
    
    if (in_array($fileExtension, $allowedExtensions)) {
        // Генерируем уникальное имя файла, чтобы картинки не перезаписывали друг друга
        $photo_name = md5(time() . $fileName) . '.' . $fileExtension;
        $uploadFileDir = '../uploads/';
        $dest_path = $uploadFileDir . $photo_name;
        
        if (!move_uploaded_file($fileTmpPath, $dest_path)) {
            $_SESSION['message'] = 'Ошибка при перемещении файла на сервере.';
            header('Location: ../cratePage.php?stat=err');
            exit;
        }
    } else {
        $_SESSION['message'] = 'Недопустимый формат фото (разрешены: JPG, PNG, WEBP).';
        header('Location: ../createPage.php?stat=err');
        exit;
    }
}

require_once '../db/conn.php';

$sql = 'INSERT INTO ads (user_id, phone_model, price, description, photo) VALUES (:user_id, :phone_model, :price, :description, :photo)';
$stmt = $conn->prepare($sql);
$success = $stmt->execute([
    ':user_id'     => $_SESSION['user_id'],
    ':phone_model' => $phone_model,
    ':price'       => $price,
    ':description' => $description,
    ':photo'       => $photo_name
]);

if ($success) {
    $_SESSION['message'] = 'Объявление успешно опубликовано!';
    header('Location: ../telPage.php?stat=ok');
} else {
    $_SESSION['message'] = 'Ошибка при добавлении записи в БД.';
    header('Location: ../createPage.php?stat=err');
}
exit;
?>
