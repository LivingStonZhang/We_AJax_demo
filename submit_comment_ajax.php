<?php 
require_once 'db_config.php';
$requiredFields = array(
		"name"=>"Name",
		"content"=>"Content"
); //associated array

//loop
foreach($requiredFields as $key=>$value) {
	if(empty($_POST[$key])) {
		echo ($value." is requred");
		die();
	}
}

$stmt = $db->prepare("INSERT INTO comments(`news_id`, `name`,`content`) VALUES(?, ?,?)");
$stmt->execute(array($_POST["nid"], $_POST["name"], $_POST["content"]));
echo "s";
