<?php
    require_once 'Service.php';

if (!empty($_SERVER['REQUEST_URI'])) {
    $aUri = explode('/', $_SERVER['REQUEST_URI']);
    $aUri = array_diff($aUri, ['']);
    if (!empty($aUri)) {
        $aUri = explode('?', $aUri[1]);
        $aUri = array_values($aUri);

        if (!file_exists($aUri[0] . '.php')) {
            require_once '404.php';
        } else {
            require_once $aUri[0] . '.php';
        }
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Delivery</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <form class="form">
        <div id="form">
            <div class="form-item title">Если не указать тип доставки, </div>
            <div class="form-item title">выведется информация обо всех</div>
            <div class="form-item"><label for="source">Откуда</label></div>
            <div class="form-item"><input type="text" id="source"></div>
            <div class="form-item"><label for="target">Куда</label></div>
            <div class="form-item"><input type="text" id="target"></div>
            <div class="form-item"><label for="weight">Вес</label></div>
            <div class="form-item"><input type="text" id="weight"></div>
            <div class="form-item"><label for="type">Тип доставки</label></div>
            <div class="form-item">
                <select id="type">
                    <option disabled selected>Выберите тип</option>
                    <option value="1">Быстрая</option>
                    <option value="2">Медленная</option>
                </select>
            </div>
            <div class="form-item"><button id="count">Посчитать</button></div>
        </div>
    </form>
    <script src="app.js"></script>
</body>
</html>