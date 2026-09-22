<?php
// Если вы не используете специальную библиотеку (типа vlucas/phpdotenv),
// то параметры нужно прописать в PDO напрямую:

$host = '127.0.0.1';
$db   = 'mobile'; // Имя вашей базы данных из файла настроек
$user = 'root';
$pass = 'mysecretpassword';
$charset = 'utf8mb4';

$dsn = "mysql:host=$host;dbname=$db;charset=$charset;port=3306";
$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES   => false,
];

try {
     $conn = new PDO($dsn, $user, $pass, $options);
} catch (\PDOException $e) {
     throw new \PDOException($e->getMessage(), (int)$e->getCode());
}
