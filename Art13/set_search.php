<!DOCTYPE html>
<html lang="ru">
<?php
    if (is_numeric($_GET["set_id"]) == true) 
    {
        $set_id = $_GET["set_id"];
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
        $prepstmnt=$conn->prepare("SELECT s.id, s.name set_name, s.description, s.sources FROM set_artifact s WHERE s.id = :set_id"); //?
        $prepstmnt->execute(array("set_id"=>$set_id)); ////$prepstmnt->execute(array($set_id)); - если ?
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
        <?php echo $row["set_name"] ?>
    </title>
</head>
<body>
    <h1 class="text-center">
        <?php echo $row["set_name"] ?>
    </h1>
    <div class="text-center">
        <h2>Набор:
            <?php echo $row["set_name"]?>
        </h2>
        <p><b>Описание:</b></p>
        <p>
            <?php echo $row["description"]?> 
        </p>
        <p><b>Источники:</b></p>
        <p>
            <?php echo
            '<a href="'.$row["sources"].'">'.$row["sources"].'</a>' ?>
        </p>
    </div>
    <a href="index.php">
        <img class="float-end" src="img/PAIMON.png" width="100" alt="На главную">
    </a>
</body>
<?php
    require_once("pages/footer.php");
?>
