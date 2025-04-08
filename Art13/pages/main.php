<?php
	$base="genshinart";	$user="root"; $pswd=""; $host="localhost";
	$conn=new PDO("mysql:host=".$host.";dbname=".$base,$user,$pswd);
	$conn->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );
	$conn->prepare("set character_set_client='utf8'")->execute(); 
	$conn->prepare("set character_set_results='utf8'")->execute();
	$conn->prepare("set collation_connection='utf8_general_ci'")->execute();
	$prepstmnt=$conn->prepare("SELECT i.id, i.name artifact, i.description, i.img, i.set_id set_id, s.name set_name, s.sources FROM item i JOIN set_artifact s ON i.set_id = s.id ORDER BY i.id");
	$prepstmnt->execute();
	$all_rows = $prepstmnt->fetchAll(PDO::FETCH_ASSOC);
?>
<body>
        <div class="row col-12">
            <div class="col-9">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th scope="col">№</th>
                            <th scope="col">Название</th>
                            <th scope="col">Изображение</th>
                            <th scope="col">Описание</th>
                            <th scope="col">Набор</th>
                            <th scope="col">Источники</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        foreach ($all_rows as $row)
                        {
                            echo '<tr>';
                                echo '<th scope="row">'.$row['id'].'</th>';
                                echo '<td><a href="item_search.php?item_id='.$row['id'].'">'.$row['artifact'].'</a></td>';
                                echo '<td><a href="item_search.php?item_id='.$row['id'].'"><img src="'.$row['img'].'" width="100" alt = "Артефакт"></a></td>';
                                echo '<td>'.$row['description'].'</td>';
                                echo '<td><a href="set_search.php?set_id='.$row['set_id'].'">'.$row['set_name'].'</a></td>';
                                echo '<td><a href="'.$row['sources'].'">'.$row['sources'].'</a></td>';
                            echo '</tr>';
                        }
                        ?>
                    </tbody>
                </table>
            </div>
            <div class = "col-3">
                <div class="desc">
                    <p>Артефакты — это экипируемое снаряжение, повышающее характеристики персонажей. Существует пять слотов артефактов разного типа:</p> 
                    <ul>
                        <li>Цветок жизни</li>
                        <li>Перо смерти</li>
                        <li>Пески времени</li>
                        <li>Кубок пространства</li>
                        <li>Корона разума</li>
                    </ul>
                    <p>Экипировка определенного количества артефактов из одного набора активирует бонусы комплекта артефактов.</p>
                </div>
            </div>
        </div>
    </body>