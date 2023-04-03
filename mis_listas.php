<?php
session_start();
include_once 'php/inc/header.inc.php';
checkCookiesUser();
destroyCookiesUserTemporal();
$email = $_SESSION['email'];
guardar_ultima_conexion($email);
$userData = obtener_datos_usuario($email);
$userPrivilege = $userData['privilege'];
$id_user = $userData['IDuser'];

if ($userPrivilege == 'guest') {
    header("Location: inicio.php");
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="shortcut icon" href="./assets/img/webico.ico" type="image/x-icon">
    <link rel="stylesheet" href="./assets/style/styleProfile.css">
    <link rel="stylesheet" href="./assets/style/stylePicture.css">
    <link rel="stylesheet" href="./assets/style/style.css">
    <link rel="stylesheet" href="./assets/style/bandeja_comics.css">
    <link rel="stylesheet" href="./assets/style/footer_style.css">
    <link rel="stylesheet" href="./assets/style/parallax.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.3.0/css/font-awesome.min.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.3/font/bootstrap-icons.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>


    <title>Mis listas de comics</title>
    <style>
        .navbar {
            position: fixed;
            top: 0;
            width: 100%;
            z-index: 1000;
        }

        .row {
            display: flex;
            flex-wrap: wrap;
        }

        /*******************************
*** CARDS INSETAR Y GESTIONAR***
*******************************/
        .card-category-3 ul li.card-item:hover {
            cursor: pointer;
            box-shadow: 0px 0px 10px 5px rgba(0, 0, 0, 0.1);
        }

        .card-category-3 ul li {
            list-style-type: none;
            float: left;
            /* Modificado */
            margin: 20px 2.5px;
            /* Modificado */
            text-align: center;
            box-shadow: 0px 0px 20px 0px rgba(0, 0, 0, 0.75);
        }


        .card-category-3 {
            font-family: sans-serif;
            margin-bottom: 45px;
            text-align: center;
            overflow: auto;
            display: flex;
            justify-content: center;
            /* Agregado para evitar que se solapen los elementos */
        }

        .ioverlay-card {
            position: relative;
            text-align: left;
        }

        .ioverlay-card img {
            height: 300px;
            width: 300px;
            border-radius: 8px;
        }

        .ioverlay-card .card-content {
            position: absolute;
            top: 25px;
            left: 20px;
        }

        .io-card-2 .card-content {
            color: #fff;
            text-shadow: black 0.1em 0.1em 0.2em;
        }

        .io-card-2 .card-content .card-title {
            font-size: 25px;
        }

        .io-card-2 .card-content .card-text {
            line-height: 1.5;
            padding-bottom: 10px;
            text-shadow: black 0.1em 0.1em 0.2em;
        }

        .io-card-2 .card-link {
            position: absolute;
            bottom: 30px;
            left: 20px;
        }

        .io-card-2 .card-link a {
            background-color: white;
            color: #333;
            text-decoration: none;
            padding: 10px;
            border: 1px solid #333;
            border-radius: 4px;

            -webkit-transition: all 0.4s;
            -moz-transition: all 0.4s;
            -o-transition: all 0.4s;
            transition: all 0.4s;
        }

        .io-card-2 .card-link a:hover {
            color: #e91e63;
            border: 1px solid #e91e63;
            background-color: rgb(255, 225, 170);
        }


        .ver-mas-btn {
            background-color: #3498DB;
            border: none;
            color: #fff;
            padding: 10px 20px;
            border-radius: 5px;
            text-decoration: none;
            font-size: 18px;
            transition: all 0.3s ease;
            margin-left: 1026px !important;
            text-align: right;
            margin-top: 20px;
            margin-bottom: 20px;
        }

        .ver-mas-btn:hover {
            background-color: #2980B9;
            cursor: pointer;
        }

        .card-item {
            position: relative;
        }

        .delete-button {
            position: absolute;
            top: 220px;
            left: 190px;
            padding: 5px 10px;
            border: none;
            background-color: #f44336;
            color: white;
            font-size: 14px;
            cursor: pointer;
        }

        .edit-button {
            position: absolute;
            top: 245px;
            right: 205px;
            padding: 5px 10px;
            border: none;
            background-color: #f44336;
            color: white;
            font-size: 14px;
            cursor: pointer;
            text-decoration: none;
        }
    </style>
</head>

<body onload="checkSesionUpdate();showSelected();">
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark" style="background-color: #343a40 !important;cursor:url(https://cdn.custom-cursor.com/db/cursor/32/Infinity_Gauntlet_Cursor.png) , default!important">
        <div class="container-fluid" style="background-color: #343a40;">
            <div class="collapse navbar-collapse" id="navbarNavDropdown">
                <ul class="navbar-nav">
                    <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="fa fa-bars"></i>
                    </a>
                    <li>
                        <ul class="dropdown-menu">
                            <?php
                            if (isset($_SESSION['email'])) {
                                $userData = obtener_datos_usuario($email);
                                $userPrivilege = $userData['privilege'];
                                if ($userPrivilege == 'guest') {
                                    echo "<li><button class='dropdown-item' onclick='closeSesion()'> <i class='bi bi-person-circle p-1'></i>Iniciar sesion</button></li>";
                                } elseif ($userPrivilege == 'admin') {
                                    echo "<li><a class='dropdown-item' href='admin_panel_usuario.php' style='cursor:url(https://cdn.custom-cursor.com/db/cursor/32/Infinity_Gauntlet_Cursor.png) , default!important'><i class='bi bi-person-circle p-1'></i>Administracion</a></li>";
                                    echo "<li><a class='dropdown-item' href='infoPerfil.php' style='cursor:url(https://cdn.custom-cursor.com/db/cursor/32/Infinity_Gauntlet_Cursor.png) , default!important'><i class='bi bi-person-circle p-1'></i>Mi perfil</a></li>";
                                    echo "<li><a class='dropdown-item' href='panel_tickets_admin.php' style='cursor:url(https://cdn.custom-cursor.com/db/cursor/32/Infinity_Gauntlet_Cursor.png) , default!important'><i class='bi bi-person-circle p-1'></i>Ver tickets</a></li>";
                                } else {
                                    echo "<li><a class='dropdown-item' href='infoPerfil.php' style='cursor:url(https://cdn.custom-cursor.com/db/cursor/32/Infinity_Gauntlet_Cursor.png) , default!important'><i class='bi bi-person-circle p-1'></i>Mi perfil</a></li>";
                                    echo "<li><button type='button' class='dropdown-item' data-bs-toggle='modal' data-bs-target='#crear_ticket' style='cursor:url(https://cdn.custom-cursor.com/db/cursor/32/Infinity_Gauntlet_Cursor.png) , default!important'><i class='bi bi-person-circle p-1'></i>Crear ticket</button></li>";
                                }
                            }
                            ?>
                            <li>
                                <a class="dropdown-item" href="about.php" style='cursor:url(https://cdn.custom-cursor.com/db/cursor/32/Infinity_Gauntlet_Cursor.png) , default!important'><i class="bi bi-newspaper p-1"></i>
                                    Sobre WebComics</a>
                            </li>
                            <?php
                            if ($userPrivilege != 'guest') {
                            ?>
                                <li>
                                    <a class="dropdown-item" href="escribir_comentario_pagina.php" style='cursor:url(https://cdn.custom-cursor.com/db/cursor/32/Infinity_Gauntlet_Cursor.png) , default!important'><i class="bi bi-newspaper p-1"></i>
                                        Escribe tu opinión</a>
                                </li>
                            <?php
                            }
                            ?>
                            <div class="dropdown-divider"></div>
                            <li><button class="dropdown-item" onclick="closeSesion()" name="closeSesion" style='cursor:url(https://cdn.custom-cursor.com/db/cursor/32/Infinity_Gauntlet_Cursor.png) , default!important'><i class="bi bi-box-arrow-right p-1"></i>Cerrar sesion</a></li>
                        </ul>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" aria-current="page" href="inicio.php" style='cursor:url(https://cdn.custom-cursor.com/db/cursor/32/Infinity_Gauntlet_Cursor.png) , default!important'>Inicio</a>
                    </li>

                    <?php
                    if ($userPrivilege == 'guest') {
                    ?>
                        <a class="nav-link" href="logOut.php" style='cursor:url(https://cdn.custom-cursor.com/db/cursor/32/Infinity_Gauntlet_Cursor.png) , default!important'>Mi colección</a>
                    <?php
                    } else {
                    ?>
                        <a class="nav-link" href="mi_coleccion.php" style='cursor:url(https://cdn.custom-cursor.com/db/cursor/32/Infinity_Gauntlet_Cursor.png) , default!important'>Mi colección</a>

                    <?php
                    }
                    ?>
                    <li class="nav-item">
                        <a class="nav-link" href="novedades.php" style='cursor:url(https://cdn.custom-cursor.com/db/cursor/32/Infinity_Gauntlet_Cursor.png) , default!important'>Novedades</a>
                    </li>
                </ul>
            </div>

            <div class="d-flex" role="search" style="margin-right: 15px;">
                <form class="form-inline my-2 my-lg-0" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" onsubmit="return false;">
                    <input type="text" class="search-click mr-sm-3" name="search" placeholder="Buscador" id="search-data" style='cursor:url(https://cdn.custom-cursor.com/db/cursor/32/Infinity_Gauntlet_Cursor.png) , default!important' />
                </form>
            </div>

            <div class="dropdown" id="navbar-user" style="left: 2px !important;">
                <?php
                $picture = pictureProfile($email);
                echo "<img src='$picture' id='avatar' alt='Avatar' class='avatarPicture' onclick='pictureProfileAvatar()' style='cursor:url(https://cdn.custom-cursor.com/db/cursor/32/Infinity_Gauntlet_Cursor.png) , default!important'>";
                ?>

                <!-- imagen de perfil  -->
                <button class="btn btn-dark dropdown-toggle" id="user" type="button" data-bs-toggle="dropdown" aria-expanded="false" style="margin-right: 20px;" style='cursor:url(https://cdn.custom-cursor.com/db/cursor/32/Infinity_Gauntlet_Cursor.png) , default!important'> </button>
                </button>
                <ul class="dropdown-menu">
                    <?php
                    if (isset($_SESSION['email'])) {
                        if ($userPrivilege == 'admin') {
                            echo "<li><a class='dropdown-item' href='admin_panel_usuario.php' style='cursor:url(https://cdn.custom-cursor.com/db/cursor/32/Infinity_Gauntlet_Cursor.png) , default!important'><i class='bi bi-person-circle p-1'></i>Administracion</a></i>";
                            echo "<li><a class='dropdown-item' href='infoPerfil.php' style='cursor:url(https://cdn.custom-cursor.com/db/cursor/32/Infinity_Gauntlet_Cursor.png) , default!important'><i class='bi bi-person-circle p-1'></i>Mi perfil</a></i>";
                        } elseif ($userPrivilege == 'user') {
                            echo "<li><a class='dropdown-item' href='infoPerfil.php' style='cursor:url(https://cdn.custom-cursor.com/db/cursor/32/Infinity_Gauntlet_Cursor.png) , default!important'><i class='bi bi-person-circle p-1'></i>Mi perfil</a></i>";
                            echo "<li><a class='dropdown-item' href='#' style='cursor:url(https://cdn.custom-cursor.com/db/cursor/32/Infinity_Gauntlet_Cursor.png) , default!important'><i class='bi bi-person-circle p-1'></i>Enviar un ticket</a></i>";
                        } else {
                            echo "<li><button class='dropdown-item' onclick='closeSesion()'> <i class='bi bi-person-circle p-1'></i>Iniciar sesion</button></li>";
                        }
                    }
                    echo "<div class='dropdown-divider'></div>";
                    echo "<li> <button class='dropdown-item' onclick='closeSesion()' name='closeSesion' style='cursor:url(https://cdn.custom-cursor.com/db/cursor/32/Infinity_Gauntlet_Cursor.png) , default!important'> <i class='bi bi-box-arrow-right p-1'></i>Cerrar sesion</button> </i>";
                    ?>
                </ul>
            </div>
        </div>
    </nav>

    <!-- The Modal -->
    <div id="myModal" class="modal modal_img" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <img class="modal-content_img" id="img01">
    </div>

    <!-- FORMULARIO INSERTAR -->
    <div id="crear_ticket" class="modal" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <form method="post" id="form_ticket" onsubmit="return false;">
                        <h4 class="modal-title">Crear un ticket para administradores</h4>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label>Asunto</label>
                        <input type="text" id="asunto_usuario" class="form-control">
                    </div>
                    <div class="form-group">
                        <label>Mensaje</label>
                        <textarea class="form-control" id="mensaje_usuario" style="resize:none;"></textarea>
                        <?php
                        if (isset($_SESSION['email'])) {
                            $userData = obtener_datos_usuario($email);
                            $id_user = $userData['IDuser'];
                            echo "<input type='hidden' id='id_user_ticket' value='$id_user'>";
                        }
                        ?>
                    </div>
                </div>
                <div class="modal-footer">
                    <input type="button" class="btn btn-default" data-dismiss="modal" value="Cancelar">
                    <input type="submit" class="btn btn-info" value="Enviar ticket" onclick="mandar_ticket()">
                </div>
                </form>
            </div>
        </div>
    </div>

    <!-- FORMULARIO nueva lista -->
    <div id="nueva_lista" class="modal" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <form method="post" id="form_lista" onsubmit="return false;">
                        <h4 class="modal-title">Crea una lista de lectura</h4>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label>Nombre de la lista</label>
                        <input type="text" id="nombre_lista" class="form-control">
                        <?php
                        if (isset($_SESSION['email'])) {
                            $userData = obtener_datos_usuario($email);
                            $id_user = $userData['IDuser'];
                            echo "<input type='hidden' id='id_user' value='$id_user'>";
                        }
                        ?>
                    </div>
                </div>
                <div class="modal-footer">
                    <input type="button" class="btn btn-default" data-dismiss="modal" value="Cancelar">
                    <input type="submit" class="btn btn-info" value="Crear lista" onclick="nueva_lista()">
                </div>
                </form>
            </div>
        </div>
    </div>

    <!-- FORMULARIO modificar lista -->
    <div id="modificar_lista" class="modal" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Modificar lista de lectura</h4>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="nombre_lista_modificar">Nuevo nombre de la lista:</label>
                        <input type="text" class="form-control" id="nombre_lista_modificar">
                        <input type="hidden" id="id_lista_modificar">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="button" class="btn btn-primary" onclick="modificar_lista()">Guardar cambios</button>
                </div>
            </div>
        </div>
    </div>

    <div class="card-footer text-muted">
        Design by Alejandro Rodriguez 2022
    </div>

    <!-- AQUI VA EL CONTENIDO DE LA PAGINA -->

    <div class="bgimg-1">
        <div class="caption">

            <div class="card-category-3">
                <ul>
                    <li class="card-item">
                        <div class="ioverlay-card io-card-2">
                            <a href='#' data-bs-toggle='modal' data-bs-target='#nueva_lista'>
                                <div class="card-content">
                                    <span class="card-title">Nueva lista</span>
                                    <p class="card-text">
                                        Crea una nueva lista
                                    </p>
                                </div>
                                <img src="assets/img/comic3.jpg" />
                            </a>
                        </div>
                    </li>

                    <?php
                    $listas = get_listas($id_user);

                    $i = -4;
                    foreach ($listas as $lista) {
                        $id_lista = $lista['id_lista'];
                        $nombre_lista = $lista['nombre_lista'];
                        $num_listas = num_listas_user($id_user);
                        $num_comics = get_total_contenido($id_lista);
                        echo "<li class='card-item'>";
                        echo "<a href='contenido_lista.php?id_lista=$id_lista'>";
                        echo "<div class='ioverlay-card io-card-2'>";
                        echo "<div class='card-content'>";
                        echo "<span class='card-title'>$nombre_lista</span>";
                        echo "<p class='card-text'>Total: $num_comics Comics</p>";
                        echo "<button class='delete-button' data-lista-id='$id_lista' id='delete-button-$id_lista' onclick='confirmar_eliminacion($id_lista,$id_user); return false;'>Eliminar</button>";
                        echo "</div>";
                        echo "<img src='assets/img/comic2.jpg' />";
                        echo "<a href='#' data-bs-toggle='modal' data-bs-target='#modificar_lista' data-lista-id='$id_lista' data-nombre-lista='$nombre_lista' class='edit-button' onclick='abrir_modal_modificar($id_lista); return false;'>Modificar</a>";
                        echo "</div>";
                        echo "</a>";
                        echo "</li>";

                        $i++;
                        if ($i % 5 == 0) {
                            echo "<div class='clearfix'></div>";
                        }
                    }



                    // Asegurarse de que se añade clearfix si el número total de listas es divisible por 3
                    if ($i % 3 != 0) {
                        echo "<div class='clearfix'></div>";
                    }
                    ?>

                </ul>
            </div>


            <div class="container mt-5">
                <div style="display: flex; justify-content: center;">
                    <div class="last-pubs">
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

                                    for ($i = 0; $i < 8; $i++) {
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
                                            echo "<button data-item-id='yXwd2' class='rem' >
                                        <span class='sp-icon'>Lo tengo</span>
                                    </button>";
                                        } else {
                                            echo "<button data-item-id='yXwd2' class='add' >
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



            <div class="bgimg-2">
                <div id="footer-lite">
                    <div class="content">
                        <p class="helpcenter">
                            <a href="http://www.example.com/help">Ayuda</a>
                        </p>
                        <p class="legal">
                            <a href="https://www.hoy.es/condiciones-uso.html?ref=https%3A%2F%2Fwww.google.com%2F" style="color:black">Condiciones de uso</a>
                            <span>·</span>
                            <a href="https://policies.google.com/privacy?hl=es" style="color:black">Política de privacidad</a>
                            <span>·</span>
                            <a class="cookies" href="https://www.doblemente.com/modelo-de-ejemplo-de-politica-de-cookies/" style="color:black">Mis cookies</a>
                            <span>·</span>
                            <a href="about.php" style="color:black">Quiénes somos</a>
                        </p>
                        <!-- add social media with icons -->
                        <p class="social">
                            <a href="https://github.com/AlejandroRodriguezM"><img src="./assets/img/github.png" alt="Github" width="50" height="50" target="_blank"></a>
                            <a href="http://www.infojobs.net/alejandro-rodriguez-mena.prf"><img src="https://brand.infojobs.net/downloads/ij-logo_reduced/ij-logo_reduced.svg" alt="infoJobs" width="50" height="50" target="_blank"></a>

                        </p>
                        <p class="copyright" style="color:black">©2023 Alejandro Rodriguez</p>
                    </div>
                </div>
            </div>
        </div>
        <script>
            (function() {
                const buttonsAdd = document.querySelectorAll('.add');
                buttonsAdd.forEach(function(button) {
                    button.addEventListener('click', function() {
                        if (button.classList.contains('add')) {
                            button.classList.remove('add');
                            button.classList.add('rem');
                            const id_comic = button.previousElementSibling.value;
                            guardar_comic(id_comic);
                        } else if (button.classList.contains('rem')) {
                            button.classList.remove('rem');
                            button.classList.add('add');
                            const id_comic = button.previousElementSibling.value;
                            quitar_comic(id_comic);
                        }
                    });
                });

                const buttonsRem = document.querySelectorAll('.rem');
                buttonsRem.forEach(function(button) {
                    button.addEventListener('click', function() {
                        if (button.classList.contains('rem')) {
                            button.classList.remove('rem');
                            button.classList.add('add');
                            const id_comic = button.previousElementSibling.value;
                            quitar_comic(id_comic);
                        } else if (button.classList.contains('add')) {
                            button.classList.remove('add');
                            button.classList.add('rem');
                            const id_comic = button.previousElementSibling.value;
                            guardar_comic(id_comic);

                        }
                    });
                });
            })();
        </script>

        <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js" integrity="sha384-oBqDVmMz9ATKxIep9tiCxS/Z9fNfEXiDAYTujMAeBAsjFuCZSmKbSSUnQlmh/jp3" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>

        <script src="./assets/js/appLogin.js"></script>
        <script src="./assets/js/sweetalert2.all.min.js"></script>
        <script src="./assets/js/functions.js"></script>
</body>

</html>