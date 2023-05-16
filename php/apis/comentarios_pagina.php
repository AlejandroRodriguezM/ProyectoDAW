<?php
include_once '../inc/header.inc.php'; // Incluye un archivo de cabecera común.
global $conection; // Permite acceder a la conexión de la base de datos.

$opiniones = mostrar_opiniones_pagina(); // Obtiene las opiniones de la página.
if (numero_opiniones_pagina() > 0) {
    // Verifica si hay opiniones disponibles en la página.
    while ($data_opinion = $opiniones->fetch(PDO::FETCH_ASSOC)) {
        // Recorre cada opinión obtenida.

        $id_opinion = $data_opinion['id_opinion'];
        $id_user = $data_opinion['id_usuario'];
        $opinion = $data_opinion['comentario'];
        $opinion = $data_opinion['fecha_comentario'];

        $data_user = obtener_datos_usuario($id_user);
        // Obtiene los datos del usuario basados en el ID de usuario de la opinión.
        $foto_perfil = $data_user['userPicture'];
        $nombre_user = $data_user['userName'];

        echo '<div class="mt-2">
        <div class="d-flex flex-row p-3">
            <img src=" ' . $foto_perfil . '" width="40" height="40" class="rounded-circle mr-3">
            <div class="w-100">
                <div class="d-flex justify-content-between align-items-center" style="margin-left: 10px;">
                    <div class="d-flex flex-row align-items-center">
                        <span class="mr-2">' . $nombre_user . '</span>
                    </div>
                </div>
                <p class="text-justify comment-text mb-0" style="margin-left: 10px;">' . $opinion . '</p>
                <div class="d-flex flex-row align-items-center mr-2" id="rating">
                    <div class="rating-lectura" style="margin-left:5px">';
        echo '</div>
        </div>

    </div>
    </div>
    </div>';
    }
} else {
    // Si no hay opiniones disponibles en la página, se muestra un mensaje de que no hay opiniones.
    echo '<div class="mt-2"><div class="d-flex flex-row p-3">';
    echo '<div class="w-100"><div class="d-flex justify-content-between align-items-center" style="margin-left: 10px;">';
    echo '<div class="d-flex flex-row align-items-center"><span class="mr-2">No hay opiniones</span>
    </div>
    </div>
    </div>
    </div>
    </div>';
}
