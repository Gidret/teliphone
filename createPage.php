<?php
session_start();
$whiteList = ['ok', 'err'];
$status = $_GET['stat'] ?? '';
$class = in_array($status, $whiteList) ? $status : '';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/style.css">
    <title>Подать объявление</title>
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

    <main class="regContainer">
        <div class="formWrap">
            
            <?php if (isset($_SESSION['user_id'])): ?>
                
                <form action="php/create.php" method="POST" enctype="multipart/form-data" class="ad-form">
                    <h2>Новое объявление</h2>    

                    <?php if (!empty($_SESSION['message'])): ?>
                        <p class="session-alert <?=$class?>">
                            <?= htmlspecialchars($_SESSION['message']) ?>
                        </p>
                        <?php unset($_SESSION['message']); ?>
                    <?php endif; ?>

                    <label for="phone_model">Модель телефона</label>
                    <input type="text" required name="phone_model" placeholder="Например: iPhone 15, Redmi Note 13" id="phone_model">

                    <label for="price">Цена (руб)</label>
                    <input type="text" required name="price" placeholder="Укажите цену" id="price">

                    <label for="description">Описание состояния</label>
                    <textarea required name="description" placeholder="Опишите состояние, комплектность, дефекты..." id="description" class="ad-textarea"></textarea>

                    <label for="photo" class="ad-file-label">
                        <span>Добавить фотографию</span>
                        <input type="file" name="photo" id="photo" accept="image/*" class="ad-file-input">
                    </label>

                    <input type="submit" value="Опубликовать">
                    
                    <div class="forgetPassword back-to-ads">
                        <a href="telPage.php">← Вернуться к объявлениям</a>
                    </div>
                </form>

            <?php else: ?>
                <div class="ad-access-denied">
                    <h2>Доступ ограничен</h2>
                    <p>Чтобы выставить мобильный телефон на продажу, вам необходимо войти в свою учетную запись.</p>
                    <a href="authPage.php" class="btn-auth-redirect">Войти в аккаунт</a>
                    <br><br>
                    <a href="telPage.php" class="link-back-secondary">Назад к списку</a>
                </div>
            <?php endif; ?>

        </div>
    </main>

    <footer></footer>
</body>
</html>
