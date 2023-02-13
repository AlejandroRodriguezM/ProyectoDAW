<?php
session_start();
include_once '../inc/header.inc.php';

$validate['success'] = array('success' => false, 'message' => "");

if($_POST){
    $id_user = $_POST['idUser'];
    $id_comic = $_POST['idComic'];
    $opinion = $_POST['opinion'];
    $puntuacion = $_POST['puntuacion'];
    if(agregar_opinion($id_user,$id_comic,$opinion,$puntuacion)){
        $validate['success'] = true;
        $validate['message'] = 'The opinion save correctly';
    } else {
        $validate['success'] = false;
        $validate['message'] = 'ERROR. The opinion dont save correctly';
    }
} else {
    $validate['success'] = false;
    $validate['message'] = 'ERROR. The opinion is not save in database';
}

echo json_encode($validate);