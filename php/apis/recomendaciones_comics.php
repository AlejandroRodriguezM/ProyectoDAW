<?php
session_start();
include_once '../inc/header.inc.php';
global $conection;
if (isset($_SESSION['email'])) {
    $email = $_SESSION['email'];
    $userData = obtener_datos_usuario($email);
    $id_user = $userData['IDuser'];
    echo "<input type='hidden' id='id_user' value='$id_user'>";

}

if (isset($_GET['num_comics'])) {
    $num_comics = intval($_GET['num_comics']);
    $numero_comics = get_total_comics();
} else {
    header("Location: ../../index.php");
}



?>

<h2 class="text-center text-uppercase py-3 bg-warning mb-5">Recomendaciones</h2>
<br>
<div class="my-4"></div>
<a href="#" class="mt-3">
    <button id="ver-mas-btn" class="btn btn-primary ver-mas-btn" onclick="comics_recomendados()">Recargar
        comics</button>
</a>

<div class="scrollable-h comic-full">
    <div class="scrollable-h-content d-flex justify-content-center">
        <ul id="recomendaciones" class="v2-cover-list list-unstyled d-flex flex-wrap">
            <?php
            $total_comics = numComics();
            for ($i = 0; $i < $num_comics; $i++) {
                $numero = randomComic();
                $data_comic = getDataComic($numero);
                $id_comic = $data_comic['IDcomic'];
                $titulo = $data_comic['nomComic'];
                $numComic = $data_comic['numComic'];
                $variante = $data_comic['nomVariante'];
                $cover = $data_comic['Cover'];
                echo "<li id='comicyXwd2' class='get-it col-6 col-md-4 col-lg-3'>
                            <a href='infoComic.php?IDcomic=$id_comic' title='$titulo - Variante: $variante / $numComic' class='title d-flex flex-column align-items-center'>
                            <span class='cover mb-2'>
                              <img src='$cover' alt='$titulo - $variante / #$numComic' class='img-fluid'>
                            </span>
                            <strong class='text-center h6'>$titulo</strong>
                            <span class='issue-number issue-number-l1 h6'>$numComic</span>
                          </a>
                          <input type='hidden' name='id_grapa' id='id_grapa' value='$id_comic'>
                          
                          ";
                if (isset($_SESSION['email'])) {
                    if (check_guardado($id_user, $id_comic)) {
                        echo "<button id='id-recomendacion' data-item-id='yXwd2' class='activate btn btn-success'>
                      <span class='sp-icon'>Lo tengo</span>
                    </button>";
                    } else {
                        echo "<button id='id-recomendacion' data-item-id='yXwd2' class='desactivate btn btn-danger'>
                      <span class='sp-icon'>Lo tengo</span>
                    </button>";
                    }
                }
                echo "</li>";
            }
            ?>
        </ul>
    </div>
</div>



<script>
    (function() {
        const buttons = document.querySelectorAll('.activate, .desactivate');

        buttons.forEach(function(button) {
            const id_comic = button.previousElementSibling.value;

            if (id_comic) {
                button.addEventListener('click', function() {

                    if (button.classList.contains('desactivate')) {
                        guardar_comic(id_comic, function() {
                            $('.new-comic-list').html('');
                            button.classList.toggle('activate');
                            button.classList.toggle('desactivate');
                        }, button);
                    } else if (button.classList.contains('activate')) {
                        quitar_comic(id_comic, function() {
                            $('.new-comic-list').html('');

                            button.classList.toggle('activate');
                            button.classList.toggle('desactivate');

                        }, button);
                    }

                    function safeLoadComics() {
                        if (typeof loadComics === 'function') {
                            loadComics(offset);
                        }
                    }

                    // Call safeLoadComics() instead of loadComics()
                    safeLoadComics();
                });
            }
        });
    })();

    function posicionarBotonVerMas() {
        var numComics = $("#recomendaciones li").length;
        var anchoContenedor = $("#recomendaciones").width();
        var anchoBoton = $(".ver-mas-btn").width();
        var margenDerecho = 20;
        var espacioLibre = anchoContenedor - (anchoBoton + margenDerecho);
        var posicionIzquierda = espacioLibre + "px";
        $(".ver-mas-btn").css("margin-left", posicionIzquierda);
    }

    $(document).ready(function() {
        posicionarBotonVerMas();
        $(window).resize(posicionarBotonVerMas);
    });
</script>