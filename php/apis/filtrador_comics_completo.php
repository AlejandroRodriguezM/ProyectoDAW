<?php
session_start();
include_once '../inc/header.inc.php';
$email = $_SESSION['email'];
$userData = obtener_datos_usuario($email);
$id_user = $userData['IDuser'];
?>
<br>
<div class="container mt-5" style="background-color: white;margin-left:10px">
    <nav class="side-menu">
        <ul class="nav">
            <li class="dropdown" onclick="toggleDropdown(this)">
                <a href="#" style='color:black;font-size:25px'><span class="fa fa-cog"></span>Escritores</a>
                <div id="dropdownContent1" class="dropdown-content" onclick="closeDropdown(this)">
                    <input type="text" name="buscador_navegacion" id="searchInput1" onkeyup="searchData(1)">
                    <?php
                    $tabla_escritores = getScreenwriters();
                    mostrar_datos($tabla_escritores);
                    ?>
                </div>
            </li>

            <li class="dropdown dropdown-sibling" onclick="toggleDropdown(this)">
                <a href="#" style='color:black;font-size:25px'><span class="fa fa-cog"></span>Artistas</a>
                <div id="dropdownContent2" class="dropdown-content" onclick="closeDropdown(this)">
                    <input type="text" name="buscador_navegacion" id="searchInput2" onkeyup="searchData(2)">
                    <?php
                    $tabla_escritores = getArtists();
                    mostrar_datos($tabla_escritores);
                    ?>
                </div>
            </li>

            <li class="dropdown" onclick="toggleDropdown(this)">
                <a href="#" style='color:black;font-size:25px'><span class="fa fa-cog"></span>Portadas</a>
                <div id="dropdownContent3" class="dropdown-content" onclick="closeDropdown(this)">
                    <input type="text" name="buscador_navegacion" id="searchInput3" onkeyup="searchData(3)">
                    <?php
                    $tabla_escritores = getPortadas();
                    mostrar_datos($tabla_escritores);
                    ?>
                </div>
            </li>

            <li class="dropdown dropdown-sibling" onclick="toggleDropdown(this)">
                <a href="#" style='color:black;font-size:25px'><span class="fa fa-cog"></span>Editorial</a>
                <div id="dropdownContent4" class="dropdown-content" onclick="closeDropdown(this)">
                    <input type="text" id="searchInput4" onkeyup="searchData(4)">
                    <?php
                    $tabla_editorial = getEditorial();
                    mostrar_datos($tabla_editorial);
                    ?>
                </div>
            </li>
        </ul>
    </nav>
</div>