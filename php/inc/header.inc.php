<?php

// Establecer la zona horaria predeterminada
date_default_timezone_set('Europe/Madrid');

// Establecer la configuración regional para mostrar fechas y horas en español
setlocale(LC_TIME, "es_ES");

// Incluir los archivos de funciones necesarios
require_once "functions.inc.php";
require_once "functions_dataBase.inc.php";

try {
    // Establecer la conexión a la base de datos
    // $conection = new PDO('mysql:host=localhost;port=3306;dbname=webcomics', 'root', '1234');
    $conection = new PDO('mysql:host=PMYSQL170.dns-servicio.com;port=3306;dbname=9851730_webcomics', 'misterioRojo', '%2P3wud43');
    $conection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    $error_Code = $e->getCode();
    $message = $e->getMessage();
    die("Code: " . $error_Code . "\nMessage: " . $message);
}

