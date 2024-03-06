<?php
/**
 * @param $fileName
 * @param $dataPoem
 * @return void
 *
 * Сохраняет стихотворение в файл
 */
function savePoemToFile($fileName, $dataPoem): void
{
    $dataPoemString = []; // считываем как строку

    if (file_exists($fileName)) {
        $dataPoemString = json_decode(file_get_contents($fileName), true); // декодируем обратно в массив
    }

    $dataPoemString[] = $dataPoem; // добавляем новую статью в массив

    file_put_contents($fileName, json_encode($dataPoemString, JSON_UNESCAPED_UNICODE));
}

/**
 * @return array
 *
 * Добавляет стихотворение в файл при отправке POST запроса
 */
function addPoem(): array
{

    $imageFileName = '';


    if ($_SERVER['REQUEST_METHOD'] == 'POST') { // проверяем, что метод отправки POST
        if (!empty($_POST['title_poem']) && !empty($_POST['author_poem']) && !empty($_POST['text_poem'])) { // проверяем, что значения заполнены и не равны нулю
            $dataPoem = [
                'title_poem' => $_POST['title_poem'],
                'author_poem' => $_POST['author_poem'],
                'text_poem' => $_POST['text_poem'],
                'image_file' => $_FILES['image']
            ]; // сохраняем в массив

            $imageFile = $_FILES["image"];

            if (!isset($imageFile)) {
                die('Файл не был загружен');
            }

            move_uploaded_file(
                $imageFile["tmp_name"],
                dirname(__DIR__) . '/public/images/' . $imageFile["name"]
            );

            $imageFileName = $imageFile["name"];

            $fileName = dirname(__DIR__) . '/articlesData/articles.txt';
            savePoemToFile($fileName, $dataPoem);

        } else {
            echo "Не все поля были заполнены";
        }
    }

    return ['imageFileName' => $imageFileName];
}


addPoem();

?>

<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Добавление стихотворения</title>
    <link rel="stylesheet" href="/css/style.css">
</head>
<body>
<h1>Добавление стихотворений</h1>
<div class="link">
    <a href="?page=index_admin">Вернуться на главную</a>
</div>
<hr>

<!--Форма для добавления стихотворений методом POST -->

<form method="post" enctype="multipart/form-data">
    <label for="title_poem">Название стихотворения:</label><br>
    <input type="text" id="title_poem" name="title_poem" placeholder="введите название"><br><br>

    <label for="author_poem">Автор стихотворения:</label><br>
    <input type="text" id="author_poem" name="author_poem" placeholder="введите автора"><br><br>

    <label for="text_poem">Текст стихотворения:</label><br>
    <textarea id="text_poem" name="text_poem" cols="50" rows="4" placeholder="введите текст"></textarea><br><br>

    <!-- Загрузка изображения -->

    <input type="file" name="image" accept="image/*"><br><br>

    <input type="submit" value="Добавить стихотворение">

</form>
</body>
</html>
