
<?php
session_start();
include_once '../inc/header.inc.php';


if (isset($_GET['id_usuario'])) {
  $id_usuario = $_GET['id_usuario'];
  $mensajes = get_mensajes($id_usuario);
}

// Verificar si hay mensajes

if (!empty($mensajes)) {
  // Recorrer los resultados y mostrar la información del ticket
  foreach ($mensajes as $mensaje) {
    $id_conversacion = $mensaje['id_conversacion'];

    $id_destinatario = $mensaje['id_usuario_destinatario'];
    $id_remitente = $mensaje['id_usuario_remitente'];

    if ($id_remitente == $id_usuario) {
      $id_usuario = $id_remitente;
    } else {
      $id_usuario = $id_destinatario;
      $id_destinatario = $id_remitente;
    }

    $data = obtener_datos_usuario($id_destinatario);
    $nombre_destinatario = $data['userName'];
    $foto_perfil = $data['userPicture'];

    echo "<div class='mensaje'>";
    echo "<h2 class='mensaje-header' id='mensaje-header-" . $mensaje['id_conversacion'] . "'><a href='infoUser.php?userName=$nombre_destinatario'><img src='$foto_perfil' style='width: 80px; height: 80px;'><span class='nombre-destinatario'></a>$nombre_destinatario</span><span class='arrow'>&#9654;</span></h2>";
    echo "<div class='mensaje-info' id='mensaje-info-" . $mensaje['id_conversacion'] . "' style='display: none;'>";
    $conversations = get_conversacion($id_conversacion);
    // Verificar si hay conversación
    if (!empty($conversations)) {
      // Recorrer los resultados y mostrar la conversación
      foreach ($conversations as $conversation) {
        if ($conversation['id_usuario_envio'] == $id_usuario) {
          $messageClass = 'user-message';
        } else {
          $messageClass = 'other-message';
        }
        $messageText = htmlspecialchars($conversation['mensaje_usuario'], ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
        $messageTime = htmlspecialchars($conversation['fecha_envio_mensaje'], ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');

        echo "<div class='message-container'>";
        echo "<p class='$messageClass'>$messageText<br><small>$messageTime</small></p>";
        echo "</div>";
      }
      // echo "<input type='hidden' id='". $mensaje['id_respuesta_mensaje'] ."' value='". $mensaje['id_respuesta_mensaje'] ."'>";
      // cambiar_estado_mensajes($mensaje['id_conversacion'],$id_usuario);
    } else {
      echo "<p>No hay conversación para este ticket</p>";
    }
    echo "</div>"; // cierra ticket-info
    echo "</div>"; // cierra ticket

  }
}
