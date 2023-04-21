<?php
session_start();
include_once '../inc/header.inc.php';
$email = $_SESSION['email'];
$userData = obtener_datos_usuario($email);
$id_user = $userData['IDuser'];
$userPrivilege = $userData['privilege'];

$validate['success'] = array('success' => false, 'message' => "");
if (isset($email)) {
    if ($_POST) {
        $id_usuario_denunciado = $_POST['id_usuario_denunciado'];
        $id_usuario_denunciante = $_POST['id_usuario_denunciante'];
        $mensaje_usuario = $_POST['mensaje'];
        $motivo_denuncia = $_POST['motivo_denuncia'];
// fecha en formato dd/mm/yyyy
        $reservedWords = reservedWords();
        if (in_array(strtolower($mensaje_usuario), $reservedWords)) {
            header("HTTP/1.1 400 Bad Request"); // Bad Request
            $validate['success'] = false;
            $validate['message'] = 'ERROR. El mensaje contiene palabras reservadas';
        } else {

            if (nueva_denuncia($id_usuario_denunciado, $id_usuario_denunciante, $mensaje_usuario, $motivo_denuncia)) {
                $validate['success'] = true;
                $validate['message'] = 'Denuncia enviada correctamente';
            } else {
                header("HTTP/1.1 400 Bad Request"); // Bad Request
                $validate['success'] = false;
                $validate['message'] = 'ERROR. No se ha podido enviar la denuncia';
            }
        }
    }
} else {
    header("HTTP/1.1 401 Unauthorized"); // Unauthorized
    $validate['success'] = false;
    $validate['message'] = 'ERROR. No se ha podido enviar la denuncia';
}
echo json_encode($validate);
