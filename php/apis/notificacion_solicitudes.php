<?php
session_start();
include_once '../inc/header.inc.php';
$email = $_SESSION['email'];
$userData = obtener_datos_usuario($email);
$id_usuario = $userData['IDuser'];
// Obtener el número de mensajes sin leer
$num_solicitudes = obtener_numero_notificaciones_amistad_sin_leer($id_usuario);

// Imprimir el enlace con el número de mensajes sin leer
echo "<a class='nav-link' href='solicitudes_amistad.php'>";
if ($num_solicitudes > 0) {
    echo "<span class='material-icons shaking'>notifications</span>";
    echo "<span class='num_notificaciones'>$num_solicitudes</span>";
} else {
    echo "<span class='material-icons '>notifications</span>";
}
echo "</a>";
?>
