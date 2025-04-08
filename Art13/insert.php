<?php
    $base="genshinart";	$user="root"; $pswd=""; $host="localhost";
    $conn=new PDO("mysql:host=".$host.";dbname=".$base,$user,$pswd);
    $conn->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );
    $conn->prepare("set character_set_client='utf8'")->execute(); 
    $conn->prepare("set character_set_results='utf8'")->execute();
    $conn->prepare("set collation_connection='utf8_general_ci'")->execute();
    if (isset($_POST["ItemName"]) && isset($_POST["SetName"]) && ($_POST["ItemName"])!= "") {
        // Подключение к базе данных
        $artifact = $_POST["ItemName"];
        $set_id = $_POST["SetName"];
        $description = $_POST["Descr"];
        $img = $_POST["Img"];

        $insert_stmnt = $conn->prepare("INSERT INTO item (name, description, img, set_id) VALUES (:artifact, :description, :img, :set_id)");
        $insert_stmnt->bindParam(":artifact", $artifact);
        $insert_stmnt->bindParam(":description", $description);
        $insert_stmnt->bindParam(":img", $img);
        $insert_stmnt->bindParam(":set_id", $set_id);
        if ($insert_stmnt->execute())
            print_r("Поздравляю, вы вставили строку!");
        else 
            print_r("Эх, что-то пошло не так :(");
    } else
        echo "Введены некорректные данные!";
?>