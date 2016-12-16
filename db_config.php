<?php 
try{
	$db = new PDO('mysql:host=localhost;dbname=we500_demo;charset=utf8mb4', 'root', '');
	$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	$db->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
} catch(PDOException $exception){
	echo $exception->getMessage();
	die();
}