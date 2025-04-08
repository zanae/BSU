<?php
    $base="genshinart";	$user="root"; $pswd=""; $host="localhost";
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
    $maxi=$conn->prepare("SELECT MAX(id) m FROM item");
	$maxi->execute();
	$num = $maxi->fetch(PDO::FETCH_ASSOC);
    if ($_GET["del_id"])
    {
        $del_id = $_GET["del_id"];
        
        $del_stmnt = $conn->prepare("DELETE FROM item WHERE id = :del_id");
        $del_stmnt->bindParam(":del_id", $del_id);
        $del_stmnt->execute();
        print_r("Строка ".$del_id." удалена. \n");
        if ($del_id == $num['m'])
        {
            //может быть так, что нет равной нуму строки, но она типа удалена и сет автоинк. Низя
            // но мы вроде только-только удалили его, так что норм
            if ($conn->query("ALTER TABLE item AUTO_INCREMENT=".$del_id))
                echo "\n Автоинкремент изменён.";
        }
    }
    else
        print_r("Эх, что-то пошло не так :(");
?>