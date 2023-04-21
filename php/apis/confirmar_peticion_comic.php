<?php
session_start();
include_once '../inc/header.inc.php';
$email = $_SESSION['email'];
$userData = obtener_datos_usuario($email);
$userPrivilege = $userData['privilege'];
$id_usuario = $userData['IDuser'];

$validate['success'] = array('success' => false, 'message' => "");
if ($userPrivilege != 'guest') {
    $id_comic_peticion = $_POST['id_comic_peticion'];
    $nombre_comic = $_POST['nombre_comic'];
    $nombre_variante = $_POST['nombre_variante'];
    $numero = $_POST['numero'];
    $formato = $_POST['formato'];
    $editorial = $_POST['editorial'];
    $fecha = $_POST['fecha']; // fecha en formato yyyy-mm-dd
    $fecha_con_formato = date('d/m/Y', strtotime($fecha)); // fecha en formato dd/mm/yyyy
    $guionista = $_POST['guionista'];
    $procedencia = $_POST['procedencia'];
    $dibujante = $_POST['dibujante'];
    $descripcion = $_POST['descripcion'];
    $portada_comic = $_POST['portada_comic'];
    $nombre_tabla_peticiones = 'comics';
    if ($_POST) {
        if (confirmar_solicitud_datos_comic($id_comic_peticion,$nombre_comic,$nombre_variante,$numero,$formato,$editorial,$fecha_con_formato,$guionista,$procedencia,$descripcion,$dibujante,$portada_comic)) {
            $id_comic = ultimo_id_comic($nombre_tabla_peticiones);
            portadas_confirmadas($portada_comic,$id_comic,$id_comic_peticion);

            direccion_imagen_comic($id_comic,$nombre_tabla_peticiones);
            cambiar_estado_peticion_confirmado($id_comic_peticion);
            $validate['success'] = true;
            $validate['message'] = 'Se ha confirmado la peticion del comic';
            header("HTTP/1.1 200 OK");
        } else {
            header("HTTP/1.1 400 Bad Request");
            $validate['success'] = false;
            $validate['message'] = 'ERROR. No se ha podido enviar la solicitud';
        }
    }
}else {
    header("HTTP/1.1 401 Unauthorized");
    $validate['success'] = false;
    $validate['message'] = 'ERROR. No tienes permisos para realizar esta acción';
}

echo json_encode($validate);
