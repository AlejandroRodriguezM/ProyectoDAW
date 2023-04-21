<?php
session_start();
include_once '../inc/header.inc.php';
$email = $_SESSION['email'];
$userData = obtener_datos_usuario($email);
$userPrivilege = $userData['privilege'];
$id_usuario = $userData['IDuser'];

$validate['success'] = array('success' => false, 'message' => "");
if ($userPrivilege != 'guest') {
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
    $nombre_tabla_peticiones = 'peticiones_nuevos_comics';
    if ($_POST) {
        if (enviar_solicitud_datos_comic($nombre_comic,$nombre_variante,$numero,$formato,$editorial,$fecha_con_formato,$guionista,$procedencia,$descripcion,$dibujante,$portada_comic,$id_usuario)) {
            $id_comic = ultimo_id_comic($nombre_tabla_peticiones);
            portadas_peticiones($portada_comic,$id_comic);
            $tabla = 'peticiones_nuevos_comics';
            direccion_imagen_comic($id_comic,$tabla);
            $validate['success'] = true;
            $validate['message'] = 'Solicitud enviada';
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
