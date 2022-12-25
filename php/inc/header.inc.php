<?php

date_default_timezone_set('Europe/Madrid');
setlocale (LC_TIME, "es_ES");
require_once "functions.inc.php";
require_once "functions_dataBase.inc.php";

try{
    $conection = new PDO('mysql:host=localhost;dbname=webcomics', 'root', '1234');
    $conection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
}
catch(PDOException $e){
    $error_Code = $e->getCode();
	$message = $e->getMessage();
	die("Code: " . $error_Code . "\nMessage: " . $message);
}

?>