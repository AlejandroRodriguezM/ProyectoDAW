<style>

</style>
<?php
include_once '../inc/header.inc.php';
global $conection;
$id_pag = $_GET['id_comic'];
$opiniones =  mostrar_opiniones($id_pag);
if (num_opiniones($id_pag) > 0) {
    echo '<ul class="comments-list">';
    while ($data_opinion = $opiniones->fetch(PDO::FETCH_ASSOC)) {
        $id_comic = $data_opinion['id_comic'];
        $id_opinion = $data_opinion['id_opinion'];
        $id_user = $data_opinion['id_usuario'];
        $opinion = $data_opinion['opinion'];
        $puntuacion = $data_opinion['puntuacion'];
        $data_user = obtener_datos_usuario($id_user);
        $foto_perfil = $data_user['userPicture'];
        $nombre_user = $data_user['userName'];
    
        echo '<li class="comment" style="width: 50vw; margin-bottom: 10px;">';
        echo '<div class="d-flex flex-row p-3" style="margin-left:-20px">
            <img src="' . $foto_perfil . '" style="width:40px;height:40px;" class="rounded-circle mr-3">
            <div class="d-flex align-items-center">
                <span class="mr-2" style="margin-left:10px">' . $nombre_user . '</span>
                <div class="rating-php d-flex align-items-center">';
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
            <p class="text-justify comment-text mb-0">' . $opinion . '</p>
            <div class="d-flex flex-row align-items-center mr-2"  id="rating">
                <div class="rating-lectura" style="margin-right:10px"></div>
            </div>';
        echo '</li>';
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
