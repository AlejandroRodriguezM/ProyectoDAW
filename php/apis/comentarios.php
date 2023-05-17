<?php
include_once '../inc/header.inc.php'; // Incluye un archivo de cabecera común.
global $conection; // Permite acceder a la conexión de la base de datos.

if(isset($_GET['id_comic'])){
    $id_pag = $_GET['id_comic']; // Obtiene el ID del cómic de la URL.
}else{
    header("Location: ../../index.php");
}

$opiniones = mostrar_opiniones($id_pag); // Obtiene las opiniones del cómic.
if (num_opiniones($id_pag) > 0) {
    echo '<ul class="comments-list">';
    while ($data_opinion = $opiniones->fetch(PDO::FETCH_ASSOC)) {
        // Recorre cada opinión obtenida.

        $id_comic = $data_opinion['id_comic'];
        $id_opinion = $data_opinion['id_opinion'];
        $id_user = $data_opinion['id_usuario'];
        $opinion = $data_opinion['opinion'];
        $puntuacion = $data_opinion['puntuacion'];

        $data_user = obtener_datos_usuario($id_user);
        // Obtiene los datos del usuario basados en el ID de usuario de la opinión.
        $foto_perfil = $data_user['userPicture'];
        $nombre_user = $data_user['userName'];
        $privilegio = $data_user['privilege'];
        $fecha_opinion = $data_opinion['fecha_comentario'];

        $empty_stars = 5 - $puntuacion;

        echo '<li class="comment" style="width: 50vw; margin-bottom: 10px;">';
        echo '<div class="d-flex flex-row p-3" style="margin-left:-20px">
            <img src="' . $foto_perfil . '" style="width:40px;height:40px;" class="rounded-circle mr-3">
            <div class="d-flex align-items-center">
                <span class="mr-2" style="margin-left:10px">' . $nombre_user . '</span>
                <div class="rating d-flex align-items-center">';
        for ($i = 0; $i < $empty_stars; $i++) {
            // Muestra estrellas vacías.
            echo '<i class="far fa-star"></i>';
        }
        for ($i = 0; $i < $puntuacion; $i++) {
            // Muestra estrellas llenas.
            echo '<i class="fas fa-star"></i>';
        }
        echo '</div>
            </div>
        </div>
        <p class="text-justify comment-text mb-0">' . $opinion . '</p>
        <div class="d-flex flex-row align-items-center mr-2"  id="rating">
            <div class="rating-lectura" style="margin-right:10px"></div>
            <div class="ml-auto">';
        echo '<small>' . $fecha_opinion . '</small>';

        if (isset($_SESSION['email'])) {
            if ($privilegio == 'admin') {
                // Si el usuario es administrador, muestra un botón para eliminar el comentario.
                echo '<button type="button" class="btn btn-danger btn-sm mt-2" style="display: block;" onclick="eliminar_comentario_comic(' . $id_opinion . ')">Eliminar</button>';
            }
        }
        echo '</div>
            </div>

        </li>';
    }
    echo '</ul>';
} else {
    echo '<div class="mt-2"><div class="d-flex flex-row p-3">';
    echo '<div class="w-100"><div class="d-flex justify-content-between align-items-center" style="margin-left: 10px;">';
    echo '<div class="d-flex flex-row align-items-center"><span class="mr-2">No hay opiniones</span>
    </div>
    </div>
    </div>
    </div>
    </div>';
}
