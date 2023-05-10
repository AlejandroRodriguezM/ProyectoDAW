<?php
session_start();
include_once '../inc/header.inc.php';
$id_lista = $_POST['id_lista'];

?>
<br>
<div class="container mt-5" style="background-color: white; margin-left: 10px;">
    <div class="accordion" id="accordionExample">
        <div class="accordion-item">
            <h2 class="accordion-header" id="headingOne">
                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="false" aria-controls="collapseOne">
                    Escritores
                </button>
            </h2>
            <div id="collapseOne" class="accordion-collapse collapse" aria-labelledby="headingOne" data-bs-parent="#accordionExample">
                <div class="accordion-body">
                    <div class="overflow-auto" style="max-height: 200px; overflow-x: auto;">
                        <ul class="list-group">
                            <?php
                            $tabla_escritores = getScreenwriters_lista($id_lista);
                            foreach ($tabla_escritores as $key => $value) {
                                echo "<li class='list-group-item'>
                                $key
                                <input type='checkbox' id='comic' name='comic' value='$key' onclick='handleCheckboxChange();'>
                                <input type='hidden' name='comic_value' value='$key'>
                                </li>";
                            }
                            ?>
                        </ul>
                    </div>
                </div>
            </div>
        </div>

        <div class="accordion-item">
            <h2 class="accordion-header" id="headingTwo">
                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                    Artistas
                </button>
            </h2>
            <div id="collapseTwo" class="accordion-collapse collapse" aria-labelledby="headingTwo" data-bs-parent="#accordionExample">
                <div class="accordion-body">
                    <div class="overflow-auto" style="max-height: 200px; overflow-x: auto;">
                        <ul class="list-group">
                            <?php
                            $tabla_artistas = getArtists_lista($id_lista);
                            foreach ($tabla_artistas as $key => $value) {
                                echo "<li class='list-group-item'>
                                $key
                                <input type='checkbox' id='comic' name='comic' value='$key' onclick='handleCheckboxChange();'>
                                <input type='hidden' name='comic_value' value='$key'>
                                </li>";
                            }
                            ?>
                        </ul>
                    </div>
                </div>
            </div>
        </div>

        <div class="accordion-item">
            <h2 class="accordion-header" id="headingThree">
                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                    Portadas
                </button>
            </h2>
            <div id="collapseThree" class="accordion-collapse collapse" aria-labelledby="headingThree" data-bs-parent="#accordionExample">
                <div class="accordion-body">
                    <div class="overflow-auto" style="max-height: 200px; overflow-x: auto;">
                        <ul class="list-group">
                            <?php
                            $tabla_portadas = getPortadas_lista($id_lista);
                            foreach ($tabla_portadas as $key => $value) {
                                echo "<li class='list-group-item'>
                      $key
                      <input type='checkbox' id='comic' name='comic' value='$key' onclick='handleCheckboxChange();'>
                      <input type='hidden' name='comic_value' value='$key'>
                    </li>";
                            }
                            ?>
                        </ul>
                    </div>
                </div>
            </div>
        </div>

        <div class="accordion-item">
            <h2 class="accordion-header" id="headingFour">
                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseFour" aria-expanded="false" aria-controls="collapseThree">
                    Editorial
                </button>
            </h2>
            <div id="collapseFour" class="accordion-collapse collapse" aria-labelledby="headingFour" data-bs-parent="#accordionExample">
                <div class="accordion-body">
                    <div class="overflow-auto" style="max-height: 200px; overflow-x: auto;">
                        <ul class="list-group">
                            <?php
                            $tabla_portadas = getEditorial_lista($id_lista);
                            foreach ($tabla_portadas as $key => $value) {
                                echo "<li class='list-group-item'>
                      $key
                      <input type='checkbox' id='comic' name='comic' value='$key' onclick='handleCheckboxChange();'>
                      <input type='hidden' name='comic_value' value='$key'>
                    </li>";
                            }
                            ?>
                        </ul>
                    </div>
                </div>
            </div>
        </div>

    </div>