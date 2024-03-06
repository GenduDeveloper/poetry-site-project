<html>
<head>
    <meta charset="UTF-8">
    <title>Список стихотворений</title>
    <link rel="stylesheet" href="/css/style.css">
</head>
<body>
<h1>Список стихотворений</h1>
<div class="link">
    <a href="?page=index_admin">Вернуться на главную</a>
</div>
<hr>

<ul>
    <?php

    $fileName = dirname(__DIR__) . '/articlesData/articles.txt';
    $poemsArray = []; // явно определяем


    if (filesize($fileName) == null) {
        echo "Файл пуст";
    } else {
        $poemsJson = file_get_contents($fileName); // если файл не пустой, то читаем его в строку
    }


    if (file_exists($fileName)) {
        $poemsArray = json_decode(file_get_contents($fileName), true); // преобразовали строку json в массив
    }

    if ($poemsArray !== null) {
        foreach ($poemsArray as $key => $poem) {
            $id = $key + 1;
            echo <<<php
            <li>
                <a href="page.php?page=list_number_poems&key={$id}">
                    <strong>Название стихотворения:</strong> {$poem['title_poem']}
                </a>
            </li>
            <li><strong>Автор:</strong> {$poem['author_poem']}</li><br><hr>
php;
        }
    }
    ?>
</ul>

</body>
</html>