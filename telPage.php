<?php
session_start();
$whiteList = ['ok', 'err'];
$status = $_GET['stat'] ?? '';
$class = in_array($status, $whiteList) ? $status : '';

require_once 'db/conn.php';

// Узнаем роль текущего пользователя
$user_role = 'user';
if (isset($_SESSION['user_id'])) {
    $u_stmt = $conn->prepare('SELECT role FROM users WHERE id = ?');
    $u_stmt->execute([$_SESSION['user_id']]);
    $user_role = $u_stmt->fetchColumn() ?: 'user';
}

// Получаем все объявления
$query = $conn->query('
    SELECT ads.*, users.fio, users.tel 
    FROM ads 
    JOIN users ON ads.user_id = users.id 
    ORDER BY ads.created_at DESC
');
$all_ads = $query->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/style.css">
    <title>Объявления о продаже</title>
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
    
    <main class="ads-main-container">
        
        <?php if (!empty($_SESSION['message'])): ?>
            <p class="session-alert <?=$class?>">
                <?= htmlspecialchars($_SESSION['message']) ?>
            </p>
            <?php unset($_SESSION['message']); ?>
        <?php endif; ?>

        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 30px;">
            <h2 class="section-subtitle" style="margin-bottom: 0;">Свежие объявления</h2>
            <!-- Кнопка перехода на страницу создания -->
            <a href="create_ad.php" class="btn-create-ad-link" style="text-decoration: none; background-color: #0037ff; color: white; padding: 10px 20px; border-radius: 8px; font-weight: bold; font-size: 14px;">+ Продать телефон</a>
        </div>

        <div class="ads-list">
            <?php if (empty($all_ads)): ?>
                <p class="no-ads-text">Объявлений пока нет. Станьте первым продавцом!</p>
            <?php else: ?>
                <?php foreach ($all_ads as $ad): ?>
                    <div class="ad-card">
                        <div class="ad-card-body">
                            <?php if (!empty($ad['photo'])): ?>
                                <div class="ad-image-wrap">
                                    <img src="uploads/<?= htmlspecialchars($ad['photo']) ?>" alt="Фото телефона">
                                </div>
                            <?php endif; ?>

                            <div class="ad-content-wrap">
                                <div class="ad-card-header">
                                    <h3 class="ad-phone-title"><?= htmlspecialchars($ad['phone_model']) ?></h3>
                                    <strong class="ad-price-tag"><?= number_format($ad['price'], 2, ',', ' ') ?> руб.</strong>
                                </div>
                                <p class="ad-description-text"><?= nl2br(htmlspecialchars($ad['description'])) ?></p>
                                <div class="ad-meta-info">
                                    <span>Продавец: <strong><?= htmlspecialchars($ad['fio']) ?></strong></span>
                                    <span>Тел: <strong><?= htmlspecialchars($ad['tel']) ?></strong></span>
                                    <span>Дата: <?= date('d.m.Y H:i', strtotime($ad['created_at'])) ?></span>
                                </div>
                            </div>
                        </div>

                        <?php if (isset($_SESSION['user_id']) && ($ad['user_id'] == $_SESSION['user_id'] || $user_role === 'admin')): ?>
                            <div class="ad-delete-container">
                                <form action="php/delete.php" method="POST" onsubmit="return confirm('Вы уверены, что хотите удалить это объявление?');">
                                    <input type="hidden" name="ad_id" value="<?= $ad['id'] ?>">
                                    <input type="submit" class="btn-delete-ad" value="Удалить объявление">
                                </form>
                            </div>
                        <?php endif; ?>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </main>
    <footer></footer>
</body>
</html>
