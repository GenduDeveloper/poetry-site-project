<?php

/**
 * @param $listNumberPoem
 * @return mixed|void|null
 *
 * Чтение данных стихотворения
 */
function readingDataPoems($listNumberPoem)
{
    $fileName = dirname(__DIR__) . '/articlesData/articles.txt';

    if (file_exists($fileName)) { // проверка, что файл существует
        $jsonArticles = file_get_contents($fileName); // читаем содержимое файла в строку
        $listNumberPoemString = json_decode($jsonArticles, true); // декодируем обратно в массив

        return $listNumberPoemString[$listNumberPoem - 1] ?? null;
    }

    return 'Файл не найден';
}

/**
 * @param $selectedPoem
 * @return void
 *
 * Вывод стихотворения на экран
 */
function outputDataPoems($selectedPoem): void
{

if ($selectedPoem && isset($selectedPoem['title_poem'], $selectedPoem['author_poem'], $selectedPoem['text_poem'])) {
    echo <<<php
        <strong>Название:</strong> {$selectedPoem['title_poem']}<br>
        <strong>Автор:</strong> {$selectedPoem['author_poem']}<br>
        <strong>Текст:</strong> {$selectedPoem['text_poem']}<br>
php;

    if (!empty($selectedPoem['image_file'])) {
        echo '<img src="/public/images/' . $selectedPoem['image_file']['name'] .'" alt="Изображение стихотворения" width="300" height="200">';
    }

    } else {
        echo "Стихотворение с указанным номер не найдено. Попробуйте еще раз.";
    }
}

?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Вывод стихотворения по номеру</title>
    <link rel="stylesheet" href="/css/style.css">
</head>
<body>
<h1>Вывод стихотворения по его номеру из файла</h1>
<div class="link">
    <a href="?page=index_admin">Вернуться на главную</a>
</div>
<hr>

<!--Форма для вывода стихотворения по номеру методом GET -->

<form method="get" action="listNumberPoems.php">
    <label for="list_number_poems">Номер стихотворения:</label><br>
    <input type="text" name="key" placeholder="введите номер для вывода"><br><br>

    <input type="submit" value="Вывести">
</form>
<hr>

<?php

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $listNumberPoem = $_GET['key'] ?? 0;

    // Проверяем, что значение 'key' является числом и больше 0
    if (is_numeric($listNumberPoem) && $listNumberPoem > 0) {
        // Получаем данные стихотворения по указанному номеру
        $selectedPoem = readingDataPoems($listNumberPoem);

        // Если данные стихотворения найдены, выводим их
        if ($selectedPoem) {
            outputDataPoems($selectedPoem);
        } else {
            echo "Стихотворение с указанным номером не найдено. Попробуйте еще раз.";
        }
    } else {
        echo 'Данные не корректны';
    }
}
?>

</body>
</html>