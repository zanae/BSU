<?php
	$base="genshinart";
	$user="root";
	$pswd="";
	$host="localhost";
	$conn=new PDO("mysql:host=".$host.";dbname=".$base,$user,$pswd);
	$conn->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );
	$conn->prepare("set character_set_client='utf8'")->execute(); 
	$conn->prepare("set character_set_results='utf8'")->execute();
	$conn->prepare("set collation_connection='utf8_general_ci'")->execute();

	$prepstmnt=$conn->prepare("SELECT i.id, i.name artifact, i.description, s.name set_name, s.sources FROM item i JOIN set_artifact s ON i.set_id = s.id");
	$prepstmnt->execute();
	$all_rows = $prepstmnt->fetchAll(PDO::FETCH_ASSOC);
	// print_r($all_rows);
	foreach ($all_rows as $row)
	{
		echo "<b>".$row['id']."</b>".") ".$row['artifact']."<br>";
		echo "<b>Набор:</b> ".$row['set_name']."<br>";
		echo "<b>Описание:</b> ".$row['description']."<br>";
		echo "<b>Источники:</b> ".$row['sources']."<br>";
		echo "<hr>";
	}

	// while($row = $prepstmnt->fetch()){
	// 	echo "<b>".$row['id']."</b>".") ".$row['artifact']."<br>";
	// 	echo "<b>Набор:</b> ".$row['set_name']."<br>";
	// 	echo "<b>Описание:</b> ".$row['description']."<br>";
	// 	echo "<b>Источники:</b> ".$row['sources']."<br>";
	// 	echo "<hr>";
	// }
?>