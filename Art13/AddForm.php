<?php
	$base="genshinart";	$user="root"; $pswd=""; $host="localhost";
	$conn=new PDO("mysql:host=".$host.";dbname=".$base,$user,$pswd);
	$conn->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );
	$conn->prepare("set character_set_client='utf8'")->execute(); 
	$conn->prepare("set character_set_results='utf8'")->execute();
	$conn->prepare("set collation_connection='utf8_general_ci'")->execute();
	$prepstmnt=$conn->prepare("SELECT id, set_artifact.name set_name FROM set_artifact");
	$prepstmnt->execute();
	$all_sets = $prepstmnt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="ru">
    <head>
        <meta charset="utf-8">
        <!-- <link rel="stylesheet" href="../css/AddForm.css"> -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <style>
            <?php include 'css/AddForm.css'; ?>
        </style>
        <title>Add Form</title>
    </head>
    <body>
        <h1 class="gensheader">Form for artifact</h1>
        <div class="addform">
            <form action="insert.php" method="post" name="item_form"> 
                <ol>
                    <li>
                        <label for="ItemName">Название</label>
                        <input type="text" id="ItemName" name="ItemName" size="50" placeholder="Имя артефакта">
                    </li>
                    <li>
                        <label for="SetName">Набор артефактов</label>
                        <select id="SetName" name="SetName">
                            <?php foreach ($all_sets as $row)
                                echo '<option value="'.$row['id'].'">'.$row['set_name'].'</option>';
                            ?>
                        </select>
                    </li>
                    <li>
                        <label for="Descr">Описание</label>
                        <textarea id="Descr" name="Descr" cols="50" rows="5" placeholder="Описание артефакта"></textarea>
                    </li>
                    <li>
                        <label for="Img">Картинка</label>
                        <input type="file" id="Img" name="Img" accept="image/*">
                    </li>
                </ol>
                <button type="submit">Сохранить</button>
                <!-- <button type="submit" onClick="AddElement(); return false">Сохранить</button> -->
                <!-- <button onClick="Clear(); return false">Очистить</button> -->
            </form>
        </div>
        <hr> 
        <div>
            <h1 class="gensheader">Delete artifact</h1>
            <form action="delete.php" method="GET" name="item_form"> 
                <p><input type="text" name="del_id" placeholder="Введите id артефакта, который нужно удалить" /></p>
                <button class="submit">Удалить</button>
            </form>
        </div> 
        <div id = "DemoElems"> </div>
        <p id="copywrite">&copy; 2022. &laquo;Cognosphere&raquo;. Все права защищены </p>
    </body>
</html>