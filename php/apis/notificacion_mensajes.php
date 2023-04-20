<?php
session_start();
include_once '../inc/header.inc.php';
$email = $_SESSION['email'];
$userData = obtener_datos_usuario($email);
$id_usuario = $userData['IDuser'];
// Obtener el número de mensajes sin leer
$num_mensajes = obtener_numero_mensajes_sin_leer($id_usuario);

// Imprimir el enlace con el número de mensajes sin leer
echo "<a class='nav-link' href='mensajes_usuario.php'>";
if ($num_mensajes > 0) {
    echo "<span class='material-icons shaking'>mark_email_unread</span>";
    echo "<span class='num_mensajes'>$num_mensajes</span>";
} else {
    echo "<span class='material-icons'>mark_email_unread</span>";
}
echo "</a>";
