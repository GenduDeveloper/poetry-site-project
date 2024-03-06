<?php

if (isset($_SESSION['isAdmin'])) {
    echo getLogoutLink();
} else {
    if ($_SERVER['REQUEST_METHOD'] === 'GET') {
        echo getForm();
    } // если пришли get-ом, то вызываем форму авторизации

    if ($_SERVER['REQUEST_METHOD'] === 'POST') { // если пришли post-ом, то пытаемся авторизоваться
        login();
    }
}


/**
 * Вывод формы авторизации
 *
 * @return string
 */
function getForm(): string
{
    $formAuthorization = <<<formAuth
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Авторизация</title>
    <link rel="stylesheet" href="/css/style.css">
</head>
<body>

<h1>Авторизация</h1>
<div class="link">
    <a href="?page=index">Вернуться на главную</a>
</div>
<hr>

<form method="post">
    <label for="login">Введите логин:</label><br>
    <input type="text" name="login" placeholder="логин"><br><br>

    <label for="password">Введите пароль:</label><br>
    <input type="password" name="password" placeholder="пароль"><br><br>

    <input type="submit" value="Войти">
</form>

</body>
</html>
formAuth;

    if (isset($_GET['error'])) {
        $formAuthorization .= '<br>Неверный логин или пароль';
    }

    return $formAuthorization;
}

/**
 * Производит авторизацию
 *
 * @return void
 */
function login(): void
{
    $login = $_POST['login'];
    $password = $_POST['password'];

    $usersDataFile = dirname(__DIR__) . '/usersData/users.txt'; // файл с данными

    $usersDataString = file_get_contents($usersDataFile); // считываем файл как строку
    $userData = json_decode($usersDataString, true); // декодируем в ассоциативный массив

    if ($login === $userData['login'] && md5($password) === $userData['password']) { // проверяем, что значения совпадают с файлом (users.txt)
        $_SESSION = [
            'login' => $userData['login'],
            'isAdmin' => true
        ];
        header('Location: ?page=index_admin');
        exit;
    } else {
        header('Location: ?page=authorization&error=1'); // если логин или пароль неправильный
    }
}

/**
 *
 * Форма для выхода авторизированного пользователя
 *
 * @return string
 */
function getLogoutLink(): string
{
    return <<<formLogout
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Выход из системы</title>
    <link rel="stylesheet" href="/css/style.css">
</head>
<body>

<h1>Выход из системы</h1>
<div class="link">
    <a href="?page=index_admin">Вернуться на главную</a>
</div>
<hr>

<a href="?page=logout">Выйти из системы</a>

</body>
</html>
formLogout;
}


