<?php
session_start();
include_once '../inc/header.inc.php';

// Inicializar el array de respuesta
$validate['success'] = array('success' => false, 'message' => "", "userName" => "");

// Establecer la respuesta de éxito para el usuario invitado
$validate['success'] = true;
$validate['message'] = 'Bienvenido y curiosea, usuario Invitado!';
$validate['userName'] = "Invitado";
header("HTTP/1.1 200 OK");

// Establecer el encabezado y devolver la respuesta en formato JSON
header('Content-type: application/json');
echo json_encode($validate);


