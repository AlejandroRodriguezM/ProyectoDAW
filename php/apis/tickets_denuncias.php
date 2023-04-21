<?php
session_start();
include_once '../inc/header.inc.php';
$email_user = $_SESSION['email'];
$data = obtener_datos_usuario($email_user);
$id_user = $data['IDuser'];
$nombre_user = $data['userName'];
$privilegio = $data['privilege'];

// Consulta para obtener los tickets

$tickets = datos_tickets_denuncias();
$num_tickets = obtener_numero_denuncias_usuarios();

// Verificar si hay tickets
if ($num_tickets > 0) {
  // Recorrer los resultados y mostrar la información del ticket
  foreach ($tickets as $ticket) {
    $id_denuncia = $ticket['id_denuncia'];
    $id_usuario_denunciante = $ticket['id_usuario_denunciante'];
    $id_usuario_denunciado = $ticket['id_usuario_denunciado'];
    $mensaje = $ticket['motivo_denuncia'];
    $asunto = $ticket['contexto_denuncia'];
    $estado_denuncia = $ticket['estado_denuncia'];
    $datos_denunciante = obtener_datos_usuario($id_usuario_denunciante);
    $nombre_denunciante = $datos_denunciante['userName'];

    $datos_denunciado = obtener_datos_usuario($id_usuario_denunciado);
    $nombre_denunciado = $datos_denunciado['userName'];
    $foto_perfil = './assets/img/admin_ticket.jpg';

    $datos_denuncia = obtener_denuncias_usuarios($id_denuncia);
    echo "<div class='mensaje'>";
    echo "<h2 class='mensaje-header' id='mensaje-header-" . $id_denuncia . "'><img src='$foto_perfil' style='width: 80px; height: 80px;'><span class='nombre-destinatario'><span class='nombre-destinatario'></a>Denuncia numero #$id_denuncia</span><span class='arrow'>&#9654;</span></h2>";
    echo "<div class='mensaje-info' id='mensaje-info-" . $id_denuncia . "' style='display: none;'>";
    echo "<p style='font-size:25px'><strong>Ticket abierto por: </strong><a href='admin_info_usuario.php?id_usuario=$id_usuario_denunciante'>" . $nombre_denunciante . "</a></p>";
    echo "<p><strong>Denunciante: </strong>$nombre_denunciante</p>";
    echo "<p><strong>Denunciado: </strong>$nombre_denunciado</p>";
    echo "<p><strong>Motivo de denuncia: </strong>$asunto</p>";
    echo "<p><strong>Estado: </strong>$estado_denuncia</p>";
    echo "<p><strong>Mensaje: </strong>$mensaje</p>";
    echo "<p><strong>Fecha de creación: </strong>" . $ticket['fecha_denuncia'] . "</p>";

    // Aquí incluirías el código para obtener y mostrar la conversación del ticket
    if ($ticket['estado_denuncia'] == 'rechazado') {
      echo "<p>Este ticket está cerrado</p>";
    }

    $conversations = respuestas_denuncias($id_denuncia);
    // Verificar si hay conversación
    if (!empty($conversations)) {
      // Recorrer los resultados y mostrar la conversación
      foreach ($conversations as $conversation) {
        if ($conversation['id_admin'] == $id_user) {
          $messageClass = 'user-message';
        } else {
          $messageClass = 'other-message';
        }
        $messageText = htmlspecialchars($conversation['respuesta_denuncia'], ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
        $messageTime = htmlspecialchars($conversation['fecha_respuesta'], ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');

        echo "<div class='message-container'>";
        echo "<p class='$messageClass'>$messageText<br><small>$messageTime</small></p>";
        echo "</div>";
      }
    } else {
      echo "<p>No hay conversación para este ticket</p>";
    }

    if($privilegio == 'admin'){
    echo "<select id='estado_" . $id_denuncia . "' onchange='cambiar_status(" . $id_denuncia . "); return false;'>";
    if ($ticket['estado_denuncia'] == 'aceptada') {
      echo "<option value='aceptada' selected>Aceptada</option>";
      echo "<option value='rechazada'>Rechazada</option>";
    } else {
      echo "<option value='aceptada'>Aceptada</option>";
      echo "<option value='rechazada' selected>rechazada</option>";
    }
    }

    echo "<input type='hidden' id='id_admin_" . $id_denuncia . "' value='" . $id_user . "'>";
    echo "<input type='hidden' id='id_usuario_" . $id_denuncia . "' value='" . $id_usuario_denunciante . "'>";
    echo "<input type='hidden' id='id_denuncia_" . $id_denuncia . "' value='" . $id_denuncia . "'>";
    echo '<div class="comment-box">';
    echo '<textarea id="respuesta_' . $id_denuncia . '" name="mensaje_usuario_enviar" placeholder="Escribe aquí tu mensaje..." data-valor="' . $id_denuncia . '"></textarea>
          <button style="margin-top:10px" type="button" onclick="mandar_mensaje_actualizacion(' . $id_denuncia . '); return false;">Enviar</button>';
    echo "</div>
          </div>
          </div>
          </div>";
  }
} else {
  echo "<p>No hay denuncias actualmente</p>";
}
