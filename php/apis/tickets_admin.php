<?php
include_once './php/inc/header.inc.php';
// Conexión a la base de datos (asumiendo que ya está establecida)
global $conection;
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
    echo "<div class='ticket'>";
    echo "<h2 class='ticket-header' id='ticket-header-$ticket_id'>Ticket #$ticket_id Asunto: $asunto<span class='arrow'>&#9654;</span></h2>";
    echo "<div class='ticket-info' id='ticket-info-$ticket_id' style='display: none;'>";
    echo "<p><strong>Ticket abierto por:</strong>$nombre_user</p>";
    echo "<p><strong>Asunto:</strong>$mensaje</p>";
    echo "<p><strong>Descripción:</strong>$mensaje</p>";
    echo "<p><strong>Fecha enviado:</strong>$fecha</p>";
    echo "<p><strong>Estado:</strong>$status</p>";
    // Aquí incluirías el código para obtener y mostrar la conversación del ticket

    $conversations = getTickets($ticket['ticket_id']);
    // Verificar si hay conversación
    if (!empty($conversations)) {
      // Recorrer los resultados y mostrar la conversación
      foreach ($conversations as $conversation) {
        if ($conversation['privilegio_user'] == 'admin') {
          echo "<p style='color: blue'><strong>Tu mensaje: </strong>" . $conversation['respuesta_ticket'] . "<br> - Hora de mensaje: " . $conversation['fecha_respuesta'] . "</p>";
        } else {
          echo "<p style='color: red'><strong>Mensaje del usuario: </strong>" . $conversation['respuesta_ticket'] . "<br> - Hora de mensaje: " . $conversation['fecha_respuesta'] . "</p>";
        }
      }
    } else {
      echo "<p>No hay conversación para este ticket</p>";
    }
    if ($ticket['status'] == 'cerrado') {
      echo "<p>Este ticket está cerrado</p>";
    } else {
      echo "<button id='open-modal' type='button' class='btn-open-modal' data-toggle='modal' data-target='#modal-form-" . $ticket['ticket_id'] . "'>Abrir formulario</button>";
    }
    echo "<div class='modal modal-form' id='modal-form-" . $ticket['ticket_id'] . "'>
        <div class='modal-content'>
          <div class='modal-header-" . $ticket['ticket_id'] . "'>
            <h2>Responder ticket</h2>
          </div>
          <form action='#' id='form_ticket_respond' method='post'>
            <input type='hidden' id='ticket_id_" . $ticket['ticket_id'] . "' name='ticket_id' value='" . $ticket['ticket_id'] . "'>
            <input type='hidden' id='user_id_" . $ticket['ticket_id'] . "' name='user_id' value='" . $ticket['user_id'] . "'>
            <label for='estado'>Estado:</label>
            <select name='estado' id='estado_" . $ticket['ticket_id'] . "'>
              <option value='abierto' " . ($ticket['status'] == 'abierto' ? 'selected' : '') . ">Abierto</option>
              <option value='cerrado' " . ($ticket['status'] == 'cerrado' ? 'selected' : '') . ">Cerrado</option>
            </select>
            <label for='respuesta'>Respuesta:</label>
            <textarea name='respuesta' id='respuesta_" . $ticket['ticket_id'] . "'></textarea>
            <div class='modal-footer'>
              <input type='button' name='responder' value='Enviar respuesta' onclick='responder_ticket(" . $ticket['ticket_id'] . "); return false;'>
            </div>
          </form>
            </div>
        </div>
        </div>
</div>";
  }
} else {
  echo "<p>No hay tickets disponibles</p>";
}
