<?php

// PDO connect *********
function connect() {
    return new PDO('mysql:host=localhost;dbname=giep-master-databass', 'root', '58Lj9pqJNHAabK9O', array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION, PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));
}

$pdo = connect();
$keyword = '%'.$_POST['keyword'].'%';
$sql = "SELECT * FROM agents WHERE name LIKE (:keyword) OR first_name LIKE (:keyword) ORDER BY name ASC ";
$query = $pdo->prepare($sql);
$query->bindParam(':keyword', $keyword, PDO::PARAM_STR);
$query->execute();
$queryrow = $query->rowCount();
if ($queryrow == 0 ) {	
	echo"aucune données";
}elseif ($keyword === '%%') {	
	echo"";
}else{
	$list = $query->fetchAll();
	foreach ($list as $rs) {
		// put in bold the written text
		$name = str_replace($_POST['keyword'], '<b>'.$_POST['keyword'].'</b>', $rs['name']." ".$rs['first_name']);
		// add new option
    	echo '<li class="border bg-white" style="list-style-type: none;" onclick="set_item(\''.$rs['name']." ".$rs['first_name'].'\');set_name(\''.$rs['id'].'\'); set_poles(\''.$rs['poles_services_id'].'\')">'.$name.'</li> ';
	}
}

?>