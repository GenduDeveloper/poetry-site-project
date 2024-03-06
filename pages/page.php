<?php
session_start(); // запускаем сессию

$page = ''; // инициализируем переменную

if (isset($_GET['page'])) {
    $page = $_GET['page'];
} // проверка наличия get параметра


if ($page === 'index_admin' && empty($_SESSION['isAdmin'])) {
    header('Location: ?page=index');
    exit;
} // если пользователь не admin, то перекидывать на index

switch ($page) {
    case 'index':
        include dirname(__DIR__) . '/public/index.php'; // главная страница
        break;
    case 'index_admin':
        include dirname(__DIR__) . '/private/admin.php' ; // страница администратора
        break;
    case 'authorization':
        include __DIR__ . '/authorization.php'; // авторизация
        break;
    case 'add_poem':
        include __DIR__ . '/addPoem.php'; // страница для добавления стихотворений
        break;
    case 'list_poems':
        include __DIR__ . '/listPoems.php'; // страница со списком стихотворений
        break;
    case 'list_number_poems':
        include __DIR__ . '/listNumberPoems.php'; // страница с выводом стихотворения по его номеру
        break;
    case 'logout':
        include __DIR__ . '/logout.php'; // выход из системы
        break;
    default:
        echo <<<notFound
            <strong>Такой страницы не существует</strong><br><br>

            <a style="text-decoration: none" href="/public/index.php">Вернуться на главную</a>
notFound;


}
