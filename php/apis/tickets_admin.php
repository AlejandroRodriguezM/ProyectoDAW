<?php
session_start();
include_once '../inc/header.inc.php';
$email_user = $_SESSION['email'];
$data = obtener_datos_usuario($email_user);
$id_user = $data['IDuser'];
$nombre_user = $data['userName'];
// Consulta para obtener los tickets

$tickets = datos_tickets();

// Verificar si hay tickets
if (!empty($tickets)) {
  // Recorrer los resultados y mostrar la información del ticket
  foreach ($tickets as $ticket) {
    $id_user = $ticket['user_id'];
    $data = obtener_datos_usuario($id_user);
    $ticket_id =  $ticket['ticket_id'];
    $nombre_user = $data['userName'];
    $asunto = $ticket['asunto_ticket'];
    $mensaje = $ticket['mensaje'];
    $fecha = $ticket['fecha_ticket'];
    $status = $ticket['status'];
    $foto_perfil = './assets/img/admin_ticket.jpg';
    echo "<div class='mensaje'>";
    echo "<h2 class='mensaje-header' id='mensaje-header-" . $ticket['ticket_id'] . "'><img src='$foto_perfil' style='width: 80px; height: 80px;'><span class='nombre-destinatario'><span class='nombre-destinatario'></a>Ticket numero #$ticket_id</span><span class='arrow'>&#9654;</span></h2>";
    echo "<div class='mensaje-info' id='mensaje-info-" . $ticket['ticket_id'] . "' style='display: none;'>";
    echo "<p style='font-size:25px'><strong>Ticket abierto por: </strong><a href='admin_info_usuario.php?id_usuario=$id_user'>" . $nombre_user . "</a></p>";
    echo "<p><strong>Asunto: </strong>" . $asunto . "</p>";
    echo "<p><strong>Mensaje: </strong>" . $mensaje . "</p>";
    echo "<p><strong>Fecha: </strong>" . $fecha . "</p>";
    echo "<p><strong>Status: </strong>" . $status . "</p>";

    // Aquí incluirías el código para obtener y mostrar la conversación del ticket

    $conversations = getTickets($ticket['ticket_id']);
    // Verificar si hay conversación
    if (!empty($conversations)) {
      // Recorrer los resultados y mostrar la conversación
      foreach ($conversations as $conversation) {
        if ($conversation['user_id_admin'] == $id_user) {
          $messageClass = 'user-message';
        } else {
          $messageClass = 'other-message';
        }
        $messageText = htmlspecialchars($conversation['respuesta_ticket'], ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
        $messageTime = htmlspecialchars($conversation['fecha_respuesta'], ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');

        echo "<div class='message-container'>";
        echo "<p class='$messageClass'>$messageText<br><small>$messageTime</small></p>";
        echo "</div>";
      }
    } else {
      echo "<p>No hay conversación para este ticket</p>";
    }
    echo "<input type='hidden' id='ticket_id_" . $ticket['ticket_id'] . "' value='" . $ticket['ticket_id'] . "'>";
    echo "<input type='hidden' id='user_id_" . $ticket['ticket_id'] . "' value='" . $ticket['user_id'] . "'>";
    //echo select, abierto o cerrado
    echo "<select id='estado_" . $ticket['ticket_id'] . "' onchange='cambiar_status(" . $ticket['ticket_id'] . "); return false;'>";
    if ($ticket['status'] == 'abierto') {
      echo "<option value='abierto' selected>Abierto</option>";
      echo "<option value='cerrado'>Cerrado</option>";
    } else {
      echo "<option value='abierto'>Abierto</option>";
      echo "<option value='cerrado' selected>Cerrado</option>";
    }
    echo '<div class="comment-box">';
    echo '<textarea id="respuesta_' . $ticket['ticket_id'] . '" name="mensaje_usuario_enviar" placeholder="Escribe aquí tu mensaje..." data-valor="' . $ticket['ticket_id'] . '"></textarea>
          <button style="margin-top:10px" type="button" onclick="mandar_mensaje_actualizacion(' . $ticket['ticket_id'] . '); return false;">Enviar</button>';
    echo "</div>
          </div>
          </div>
          </div>";
  }
}
