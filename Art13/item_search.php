<!DOCTYPE html>
<html lang="ru">
<?php
    if (is_numeric($_GET["item_id"]) == true) 
    {
        $item_id = $_GET["item_id"];
        // Подключение к базе данных
        $base="genshinart";
        $user="root";
        $pswd="";
        $host="localhost";
        try {
            $conn=new PDO("mysql:host=".$host.";dbname=".$base,$user,$pswd);
        } catch (PDOException $e) {
            echo 'Проблемы с подключением: ' . $e->getMessage();
            exit;
        }
        $conn->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );
        $conn->prepare("set character_set_client='utf8'")->execute();
        $conn->prepare("set character_set_results='utf8'")->execute();
        $conn->prepare("set collation_connection='utf8_general_ci'")->execute();
        $prepstmnt=$conn->prepare("SELECT i.id, i.name artifact, i.description, i.img, s.name set_name, s.sources 
    FROM item i JOIN set_artifact s ON i.set_id = s.id WHERE i.id = :item_id"); //?
        $prepstmnt->execute(array("item_id"=>$item_id)); ////$prepstmnt->execute(array($item_id)); - если ?
        $row = $prepstmnt->fetch(PDO::FETCH_ASSOC);
        if (!$row) 
        {
            echo "Нет данных для указанного id.";
            return;
        }
    }
    else {
        echo "ID - целое число";
        return;
    }
?>
<head>
    <meta charset="UTF-8">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>
        <?php echo $row["artifact"] ?>
    </title>
</head>
<body>
    <h1 class="text-center">
        <?php echo $row["artifact"] ?>
    </h1>
    <div class="text-center">
        <h2>Набор:
            <?php echo $row["set_name"]?>
        </h2>
        <p><b>Описание:</b></p>
        <p>
            <?php echo $row["description"]?> 
        </p>
        <p><b>Изображение:</b></p>
            <?php echo '<img src="'.$row['img'].'" alt = "Артефакт">'?>
        <p><b>Источники:</b></p>
        <p>
            <?php echo $row["sources"] ?>
        </p>
    </div>
    <a href="index.php">
        <img class="float-end" src="img/PAIMON.png" width="100" alt="На главную">
    </a>
</body>
<?php
    require_once("pages/footer.php");
?>
