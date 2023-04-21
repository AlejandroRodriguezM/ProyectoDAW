<?php
session_start();
include_once 'php/inc/header.inc.php';


if (isset($_SESSION['email'])) {
    $email = $_SESSION['email'];
    guardar_ultima_conexion($email);
    $userData = obtener_datos_usuario($email);
    $userPrivilege = $userData['privilege'];
    $mi_id = $userData['IDuser'];
    $id_usuario = $_GET['id_usuario'];
    $numero_comics = get_total_guardados($id_usuario);
    //echo "<input type='hidden' id='num_comics' value='$numero_comics'>";
    if (checkStatus($email)) {
        header("Location: usuario_bloqueado.php");
    }
} else {
    header('Location: index.php');
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
    <link rel="stylesheet" href="./assets/style/novedades.css">
    <link rel="stylesheet" href="./assets/style/parallax.css">
    <link rel="stylesheet" href="./assets/style/media_recomendaciones.css">
    <link rel="stylesheet" href="./assets/style/media_videos.css">
    <link rel="stylesheet" href="./assets/style/media_barra_principal.css">
    <link rel="stylesheet" href="./assets/style/sesion_caducada.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.3.0/css/font-awesome.min.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.3/font/bootstrap-icons.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js" integrity="sha384-oBqDVmMz9ATKxIep9tiCxS/Z9fNfEXiDAYTujMAeBAsjFuCZSmKbSSUnQlmh/jp3" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>

            <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link rel="stylesheet" href="./assets/style/iconos_notificaciones.css">

    <script src="./assets/js/functions.js"></script>
    <script src="./assets/js/appLogin.js"></script>
    <script src="./assets/js/sweetalert2.all.min.js"></script>
    <script src="./assets/js/temporizador.js"></script>
    <title>Mis listas de comics</title>

    <style>

        .row {
            display: flex;
            flex-wrap: wrap;
        }

        #wrapper.home div.comments {
            padding-right: 20px;
            line-height: 140%;
        }

        .link-grey:hover {
            color: #00913b;
        }

        .last-pubs2 {
            position: relative;
            padding: 20px;
            /* background-color: #fff; */
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
            border-radius: 5px;
        }

        .ver-mas-btn {
            position: absolute;
            bottom: 260px;
            left: 10px;
            background-color: #3498DB;
            border: none;
            color: #fff;
            padding: 10px 20px;
            border-radius: 5px;
            text-decoration: none;
            font-size: 18px;
            transition: all 0.3s ease;
            text-align: center;
        }

        .ver-mas-btn:hover {
            background-color: #2980B9;
            cursor: pointer;
        }

        .desactivate {
            background-color: white !important;
            color: #00c9b7;
            border: none;
            padding: 0;
            text-align: center;
            text-decoration: none;
            display: inline-block;
            font-size: 16px;
            border-radius: 5px;
            width: 150px;
            height: 50px;
        }

        .activate {
            color: white;
            background-color: #00c9b7 !important;
            display: block;
            position: relative;
            margin-top: 6px;
            width: 100%;
            height: 34px;
            background-color: transparent;
            border: solid 1px #00c9b7;
            border-radius: 4px;
        }

        .activate>.sp-icon {
            background-image: url('assets/img/tick_white.png') !important;
            background-repeat: no-repeat !important;
            background-position: center !important;
            background-size: 20px !important;
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
            display: inline-block;
            vertical-align: top;
            margin: 100px 5px;
            text-align: center;
            box-shadow: 0px 0px 20px 0px rgba(0, 0, 0, 0.75);
        }


        .card-category-3 {
            font-family: sans-serif;
            margin-bottom: 45px;
            text-align: center;
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
    <div id="session-expiration">
        <div id="session-expiration-message">
            <p>Su sesión está a punto de caducar. ¿Desea continuar conectado?</p>
            <button id="session-expiration-continue-btn">Continuar</button>
            <button id="session-expiration-logout-btn">Cerrar sesión</button>
        </div>
    </div>
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

                            if ($userPrivilege == 'admin') {
                                echo "<li><a class='dropdown-item' href='admin_panel_usuario.php' style='cursor:url(https://cdn.custom-cursor.com/db/cursor/32/Infinity_Gauntlet_Cursor.png) , default!important'><i class='bi bi-person-circle p-1'></i>Administracion</a></li>";
                                echo "<li><a class='dropdown-item' href='infoPerfil.php' style='cursor:url(https://cdn.custom-cursor.com/db/cursor/32/Infinity_Gauntlet_Cursor.png) , default!important'><i class='bi bi-person-circle p-1'></i>Mi perfil</a></li>";
                                echo "<li><a class='dropdown-item' href='panel_tickets_admin.php' style='cursor:url(https://cdn.custom-cursor.com/db/cursor/32/Infinity_Gauntlet_Cursor.png) , default!important'><i class='bi bi-person-circle p-1'></i>Ver tickets</a></li>";
                            } else {
                                echo "<li><a class='dropdown-item' href='infoPerfil.php' style='cursor:url(https://cdn.custom-cursor.com/db/cursor/32/Infinity_Gauntlet_Cursor.png) , default!important'><i class='bi bi-person-circle p-1'></i>Mi perfil</a></li>";
                                echo "<li><button type='button' class='dropdown-item' data-bs-toggle='modal' data-bs-target='#crear_ticket' style='cursor:url(https://cdn.custom-cursor.com/db/cursor/32/Infinity_Gauntlet_Cursor.png) , default!important'><i class='bi bi-person-circle p-1'></i>Crear ticket</button></li>";
                            }

                            ?>
                            <li>
                                <a class="dropdown-item" href="about.php" style='cursor:url(https://cdn.custom-cursor.com/db/cursor/32/Infinity_Gauntlet_Cursor.png) , default!important'><i class="bi bi-newspaper p-1"></i>
                                    Sobre WebComics</a>
                            </li>

                            <li>
                                <a class="dropdown-item" href="escribir_comentario_pagina.php" style='cursor:url(https://cdn.custom-cursor.com/db/cursor/32/Infinity_Gauntlet_Cursor.png) , default!important'><i class="bi bi-newspaper p-1"></i>
                                    Escribe tu opinión</a>
                            </li>

                            <div class="dropdown-divider"></div>
                            <li>
                                <button class="dropdown-item" onclick="closeSesion()" name="closeSesion" style='cursor:url(https://cdn.custom-cursor.com/db/cursor/32/Infinity_Gauntlet_Cursor.png) , default!important'><i class="bi bi-box-arrow-right p-1"></i>Cerrar sesion</a>
                            </li>

                        </ul>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" aria-current="page" href="index.php" style='cursor:url(https://cdn.custom-cursor.com/db/cursor/32/Infinity_Gauntlet_Cursor.png) , default!important'>Inicio</a>
                    </li>

                    <li class="nav-item">

                        <a class="nav-link" href="mi_coleccion.php" style='cursor:url(https://cdn.custom-cursor.com/db/cursor/32/Infinity_Gauntlet_Cursor.png) , default!important'>Mi colección</a>

                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="novedades.php" style='cursor:url(https://cdn.custom-cursor.com/db/cursor/32/Infinity_Gauntlet_Cursor.png) , default!important'>Novedades</a>
                    </li>
                    <li class="nav-item">
                        <?php
                        // Obtener el número de mensajes sin leer
                        $num_solicitudes = obtener_numero_notificaciones_amistad_sin_leer($mi_id);

                        // Imprimir el enlace con el número de mensajes sin leer
                        echo "<a class='nav-link' href='solicitudes_amistad.php'>";
                        if ($num_solicitudes > 0) {
                            echo "<span class='material-icons shaking'>notifications</span>";
                            //echo "<span class='num_notificaciones'>$num_solicitudes</span>";
                        } else {
                            echo "<span class='material-icons '>notifications</span>";
                        }
                        echo "</a>";
                        ?>
                    </li>
                    <li class="nav-item">
                        <?php
                        // Obtener el número de mensajes sin leer
                        $num_mensajes = obtener_numero_mensajes_sin_leer($mi_id);

                        // Imprimir el enlace con el número de mensajes sin leer
                        echo "<a class='nav-link' href='mensajes_usuario.php'>";
                        if ($num_mensajes > 0) {
                            echo "<span class='material-icons shaking'>mark_email_unread</span>";
                            //echo "<span class='num_mensajes'>$num_mensajes</span>";
                        } else {
                            echo "<span class='material-icons'>mark_email_unread</span>";
                        }
                        echo "</a>";
                        ?>
                    </li>
                </ul>
            </div>

            <div class="d-flex" role="search" style="margin-right: 15px;">
                <form class="form-inline my-2 my-lg-0" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" onsubmit="return false;">
                    <!-- <label class="search-click-label" style="display: flex !important;justify-content: center !important;align-items: center !important;cursor:url(https://cdn.custom-cursor.com/db/cursor/32/Infinity_Gauntlet_Cursor.png) , default!important"> -->
                    <input type="text" class="search-click mr-sm-3" name="search" placeholder="Buscador" id="search-data" style='cursor:url(https://cdn.custom-cursor.com/db/cursor/32/Infinity_Gauntlet_Cursor.png) , default!important' />
                    <!-- </label> -->
                </form>
            </div>

            <div class="dropdown" id="navbar-user" style="left: 2px !important;">
                <?php
                if (isset($_SESSION['email'])) {
                    $picture = pictureProfile($email);
                    echo "<img src='$picture' id='avatar' alt='Avatar' class='avatarPicture' onclick='pictureProfileAvatar()' style='cursor:url(https://cdn.custom-cursor.com/db/cursor/32/Infinity_Gauntlet_Cursor.png) , default!important'>";
                } else {
                    echo "<img src='assets/pictureProfile/default/default.jpg' id='avatar' alt='Avatar' class='avatarPicture' onclick='pictureProfileAvatar()' style='cursor:url(https://cdn.custom-cursor.com/db/cursor/32/Infinity_Gauntlet_Cursor.png) , default!important'>";
                }
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
                        echo "<div class='dropdown-divider'></div>";
                        echo "<li> <button class='dropdown-item' onclick='closeSesion()' name='closeSesion' style='cursor:url(https://cdn.custom-cursor.com/db/cursor/32/Infinity_Gauntlet_Cursor.png) , default!important'> <i class='bi bi-box-arrow-right p-1'></i>Cerrar sesion</button> </i>";
                    } else {
                        echo "<li><button class='dropdown-item' onclick='iniciar_sesion()'> <i class='bi bi-person-circle p-1'></i>Iniciar sesion</button></li>";
                    }
                    ?>
                </ul>
            </div>
        </div>
    </nav>



    <!-- AQUI VA EL CONTENIDO DE LA PAGINA -->
    <div class="card-footer text-muted">
        Design by Alejandro Rodriguez 2022
    </div>
    <div class="bgimg-1">
        <div class="caption">

            <div class="card-category-3">
                <ul>
                    <?php
                    $listas = get_listas($id_usuario);

                    $i = -4;
                    foreach ($listas as $lista) {
                        $id_lista = $lista['id_lista'];
                        $nombre_lista = $lista['nombre_lista'];
                        $num_listas = num_listas_user($id_usuario);
                        $num_comics = get_total_contenido($id_lista);
                        echo "<li class='card-item'>";
                        echo "<a href='contenido_lista_amigo.php?id_lista=$id_lista'>";
                        echo "<div class='ioverlay-card io-card-2'>";
                        echo "<div class='card-content'>";
                        echo "<span class='card-title'>$nombre_lista</span>";
                        echo "<p class='card-text'>Total: $num_comics Comics</p>";
                        echo "</div>";
                        echo "<img src='assets/img/comic2.jpg' />";
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

</body>

</html>