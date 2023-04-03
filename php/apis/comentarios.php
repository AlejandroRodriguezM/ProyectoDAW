<?php
include_once '../inc/header.inc.php';
global $conection;
$id_pag = $_GET['id_comic'];
$opiniones =  mostrar_opiniones($id_pag);
if (num_opiniones($id_pag) > 0) {
    while ($data_opinion = $opiniones->fetch(PDO::FETCH_ASSOC)) {

        $id_comic = $data_opinion['id_comic'];
        $id_opinion = $data_opinion['id_opinion'];
        $id_user = $data_opinion['id_usuario'];
        $opinion = $data_opinion['opinion'];
        $puntuacion = $data_opinion['puntuacion'];
        $data_user = obtener_datos_usuario($id_user);
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

        for ($i = 5; $i >= 1; $i--) {
            if ($i == $puntuacion) {
                echo '<input type="radio" name="rating-' . $id_opinion . '" value="' . $i . '" id="' . $i . '" checked disabled>
                              <label for="' . $i . '">☆</label>';
            } else {
                echo '<input type="radio" name="rating-' . $id_opinion . '" value="' . $i . '" id="' . $i . '" disabled>
                              <label for="' . $i . '">☆</label>';
            }
        }
        echo '</div>
        </div>
    </div>
    </div>
    </div>';
    }
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
