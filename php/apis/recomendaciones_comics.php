<?php
session_start();
include_once '../inc/header.inc.php';
global $conection;
$email = $_SESSION['email'];
$userData = obtener_datos_usuario($email);
$id_user = $userData['IDuser'];

$num_comics = intval($_GET['num_comics']);
$numero_comics = get_total_guardados($id_user);
echo "<input type='hidden' class='num_comics' id='num_comics' value='$numero_comics'>";
echo "<input type='hidden' id='id_user' value='$id_user'>";

?>
<div class="container mt-5">
    <div style="display: flex; justify-content: center;">
        <div class="last-pubs2">
            <div class="titulo">
                <h2>Recomendaciones</h2>
            </div>
            <a href='novedades.php'>
                <button class="ver-mas-btn">Ver más</button>
            </a>
            <div class="scrollable-h comic-full">
                <div class="scrollable-h-content">
                    <ul class="v2-cover-list">
                        <?php
                        $total_comics = numComics();
                        echo "<input type='hidden' id='id_user' value='$id_user'>";
                        for ($i = 0; $i < $num_comics; $i++) {
                            $numero = randomComic();
                            $data_comic = getDataComic($numero);
                            $id_comic = $data_comic['IDcomic'];
                            $titulo = $data_comic['nomComic'];
                            $numComic = $data_comic['numComic'];
                            $variante = $data_comic['nomVariante'];
                            $cover = $data_comic['Cover'];
                            echo "<li id='comicyXwd2' class='get-it'>
                            <a href='infoComic.php?IDcomic=$id_comic' title='$titulo - Variante: $variante / $numComic' class='title'>
                            <span class='cover'>
                            <img src='$cover' alt='$titulo - $variante / #$numComic'>
                            </span>
                            <strong><?php echo $titulo ?></strong>
                            <span class='issue-number issue-number-l1'>$numComic</span>
                        </a>
                        <input type='hidden' name='id_grapa' id='id_grapa' value='$id_comic'>";

                            if (check_guardado($id_user, $id_comic)) {
                                echo "<button data-item-id='yXwd2' class='activate' >
                            <span class='sp-icon'>Lo tengo</span>
                        </button>";
                            } else {
                                echo "<button data-item-id='yXwd2' class='desactivate' >
                            <span class='sp-icon'>Lo tengo</span>
                            </button>";
                            }
                            echo "</li>";
                        }

                        ?>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    (function() {
        const buttons = document.querySelectorAll('.activate, .desactivate');

        buttons.forEach(function(button) {
            const id_comic = button.previousElementSibling.value;

            if (id_comic) {
                button.addEventListener('click', function() {

                    if (!button.classList.contains('invisible')) {
                        button.classList.add('invisible');

                        if (button.classList.contains('desactivate')) {
                            guardar_comic(id_comic, function() {
                                console.log('guardar');
                                button.classList.remove('invisible');
                                button.classList.toggle('activate');
                                button.classList.toggle('desactivate');
                            });
                        } else {
                            quitar_comic(id_comic, function() {
                                console.log('eliminar');
                                button.classList.remove('invisible');
                                button.classList.toggle('activate');
                                button.classList.toggle('desactivate');

                            });
                        }

                    }
                    loadComics();
                });
            }
        });
    })();
</script>