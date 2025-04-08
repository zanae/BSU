<!doctype html>

<html lang="ru">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

    <title>
        Арт
    </title>
</head>

<body>
    <h1 class="text-center">База данных артефактов</h1>
    <div class="form text-center">
        <h2>Поиск объекта в базе</h2>
        <form action="item_search.php" method="GET">
            <p><input type="text" name="item_id" placeholder="Введите id арта" /></p>
            <button class="submit">Поиск</button>
        </form>
        <h2>Поиск справочника в базе</h2>
        <form action="set_search.php" method="GET">
            <p><input type="text" name="set_id" placeholder="Введите id набора" /></p>
            <button class="submit">Поиск</button>
        </form>
    </div>
</body>

</html>