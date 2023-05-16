<?php
session_start();
include_once '../inc/header.inc.php';

// Obtiene el correo electrónico del usuario de la sesión
$email = $_SESSION['email'];

// Obtiene los datos del usuario
$userData = obtener_datos_usuario($email);
$userPrivilege = $userData['privilege'];
$id_usuario = $userData['IDuser'];

// Inicializa el array de respuesta
$validate['success'] = array('success' => false, 'message' => "");

// Verifica si el usuario tiene los privilegios adecuados
if ($userPrivilege != 'guest') {
    // Obtiene los datos del formulario
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
        // Verifica y confirma la solicitud de datos del cómic
        if (confirmar_solicitud_datos_comic($id_comic_peticion, $nombre_comic, $nombre_variante, $numero, $formato, $editorial, $fecha_con_formato, $guionista, $procedencia, $descripcion, $dibujante, $portada_comic)) {
            // Obtiene el ID del cómic recién creado
            $id_comic = ultimo_id_comic($nombre_tabla_peticiones);

            // Asigna las portadas confirmadas al cómic
            portadas_confirmadas($portada_comic, $id_comic, $id_comic_peticion);

            // Actualiza la dirección de la imagen del cómic
            direccion_imagen_comic($id_comic, $nombre_tabla_peticiones);

            // Cambia el estado de la petición a confirmado
            cambiar_estado_peticion_confirmado($id_comic_peticion);

            $validate['success'] = true;
            $validate['message'] = 'Se ha confirmado la petición del cómic';
            header("HTTP/1.1 200 OK");
        } else {
            $validate['success'] = false;
            $validate['message'] = 'ERROR. No se ha podido enviar la solicitud';
            header("HTTP/1.1 400 Bad Request");
        }
    }
} else {
    $validate['success'] = false;
    $validate['message'] = 'ERROR. No tienes permisos para realizar esta acción';
    header("HTTP/1.1 401 Unauthorized");
}
header('Content-type: application/json');
// Devuelve la respuesta en formato JSON
echo json_encode($validate);
