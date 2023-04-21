<?php
session_start();
include_once '../inc/header.inc.php';
$id_lista = $_POST['id_lista'];

?>
<br>
<div class="contenedor mt-5" style="background-color: white;margin-left:10px;border-radius: 5px">
    <nav class="side-menu">
        <ul class="nav">
            <li class="dropdown" onclick="toggleDropdown(this)">
                <a href="#" style='color:black;font-size:25px'><span class="fa fa-cog"></span>Escritores</a>
                <div class="dropdown-content" id="dropdownContent1">
                    <input type="text" name="buscador_navegacion" id="searchInput1" onkeyup="searchData(1)">
                    <?php
                    $tabla_escritores = getScreenwriters_lista($id_lista);
                    mostrar_datos($tabla_escritores);
                    ?>
                </div>
            </li>

            <li class="dropdown dropdown-sibling" onclick="toggleDropdown(this)">
                <a href="#" style='color:black;font-size:25px'><span class="fa fa-cog"></span>Artistas</a>
                <div class="dropdown-content" id="dropdownContent2">
                    <input type="text" name="buscador_navegacion" id="searchInput2" onkeyup="searchData(2)">
                    <?php
                    $tabla_escritores = getArtists_lista($id_lista);
                    mostrar_datos($tabla_escritores);
                    ?>
                </div>
            </li>

            <li class="dropdown" onclick="toggleDropdown(this)">
                <a href="#" style='color:black;font-size:25px'><span class="fa fa-cog"></span>Portadas</a>
                <div class="dropdown-content" id="dropdownContent3">
                    <input type="text" name="buscador_navegacion" id="searchInput3" onkeyup="searchData(3)">
                    <?php
                    $tabla_escritores = getPortadas_lista($id_lista);
                    mostrar_datos($tabla_escritores);
                    ?>
                </div>
            </li>

            <li class="dropdown dropdown-sibling" onclick="toggleDropdown(this)" style="border-radius: 20px">
                <a href="#" style='color:black;font-size:25px'><span class="fa fa-cog"></span>Editorial</a>
                <div class="dropdown-content" id="dropdownContent4">
                    <input type="text" id="searchInput4" onkeyup="searchData(4)">
                    <?php
                    $tabla_editorial = getEditorial_lista($id_lista);
                    mostrar_datos($tabla_editorial);
                    ?>
                </div>
            </li>
        </ul>
    </nav>
</div>