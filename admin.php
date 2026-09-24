<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/style.css">

    <link rel="stylesheet" href="css/about.css">
    <title>О нас — Магазин телефонов</title>
</head>
<body>
    <header>
        <div class="headLogo">
            <h1>Магазин телефонов</h1>
        </div>
        <div class="headHav">
            <a href="home.php">О нас</a>
            <a href="telPage.php">Объявления</a>
            <a href="createPage.php">Создать объявление</a>
            <a href="profile.php">Профиль</a>
        </div>
    </header>

    <main class="about-container">
        <section class="about-hero">
            <h2>О нашем проекте</h2>
            <p class="about-subtitle">Современная платформа для покупки и продажи мобильных устройств</p>
        </section>

        <section class="about-content">
            <div class="about-block">
                <h3>Кто мы такие?</h3>
                <p><strong>Магазин телефонов</strong> — это не просто каталог мобильных устройств, а полноценная интерактивная площадка, объединяющая покупателей и продавцов. Мы создали удобное пространство, где каждый может найти себе надёжный гаджет или быстро продать свой старый телефон.</p>
            </div>

            <div class="about-block">
                <h3>Что мы предлагаем?</h3>
                <ul class="about-features-list">
                    <li><strong>Актуальный каталог:</strong> Просматривайте флагманы от ведущих мировых брендов, таких как Apple, Google Pixel и Xiaomi.</li>
                    <li><strong>Доска объявлений:</strong> Прошли простую регистрацию? Вы уже можете создать собственное объявление, загрузить реальное фото смартфона и указать свои контакты для связи.</li>
                    <li><strong>Прямой контакт:</strong> Никаких скрытых комиссий и посредников. Покупатели связываются с продавцами напрямую по указанному телефону.</li>
                    <li><strong>Безопасность и контроль:</strong> Мы ценим чистоту нашей платформы. Система модерации позволяет авторам и администраторам оперативно управлять объявлениями и удалять неактуальные предложения.</li>
                </ul>
            </div>

            <div class="about-block text-center">
                <h3>Присоединяйтесь к нам!</h3>
                <p>Ищете новый смартфон или хотите освободить место на полке, продав прошлый девайс? Начните прямо сейчас!</p>
                <div class="about-actions">
                    <a href="telPage.php" class="btn-about-primary">Смотреть объявления</a>
                    <?php if (!isset($_SESSION['user_id'])): ?>
                        <a href="index.php" class="btn-about-secondary">Создать аккаунт</a>
                    <?php else: ?>
                        <a href="createPage.php" class="btn-about-secondary">Продать телефон</a>
                    <?php endif; ?>
                </div>
            </div>
        </section>
    </main>

    <footer></footer>
</body>
</html>
