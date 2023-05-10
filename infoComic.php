<?php
session_start();
include_once 'php/inc/header.inc.php';


if (isset($_SESSION['email'])) {
    $email = $_SESSION['email'];
    $picture = pictureProfile($email);
    guardar_ultima_conexion($email);
    $userData = obtener_datos_usuario($email);
    $userPrivilege = $userData['privilege'];
    $nombre_usuario = $userData['userName'];
    $id_usuario = $userData['IDuser'];
    $numero_comics = get_total_guardados($id_usuario);
    if (checkStatus($email)) {
        header("Location: usuario_bloqueado.php");
    }
    if (!comprobar_activacion($nombre_usuario)) {
        header("Location: usuario_no_activado.php");
    }
}

if (isset($_GET['IDcomic'])) {
    $id_comic = $_GET['IDcomic'];
    $data_comic = getDataComic($id_comic);
    $cover_imagen = $data_comic['Cover'];
    $descripcion = get_descripcion($id_comic)['descripcion_comics'];
} else {
    header("Location: index.php");
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

    <link rel="stylesheet" href="./assets/style/media_barra_principal.css">
    <link rel="stylesheet" href="./assets/style/sesion_caducada.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.3.0/css/font-awesome.min.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.3/font/bootstrap-icons.css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.14.0/css/all.css" integrity="sha384-HzLeBuhoNPvSl5KYnjx0BT+WB0QEEqLprO+NBkkk5gbc67FTaL7XIGa2w1L0Xbgc" crossorigin="anonymous">

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js" integrity="sha384-oBqDVmMz9ATKxIep9tiCxS/Z9fNfEXiDAYTujMAeBAsjFuCZSmKbSSUnQlmh/jp3" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
    <script src="./assets/js/appLogin.js"></script>
    <script src="./assets/js/sweetalert2.all.min.js"></script>
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link rel="stylesheet" href="./assets/style/iconos_notificaciones.css">

    <script src="./assets/js/functions.js"></script>
    <script src="./assets/js/temporizador.js"></script>
    <title>Informacion del comic</title>
    <style>
        .rating {
            display: flex;
            flex-direction: row-reverse;
            /* Cambiado de row a row-reverse */
            align-items: center;
        }

        .rating input {
            display: none;
        }

        .rating label {
            display: inline-block;
            cursor: pointer;
            width: 20px;
            height: 20px;
            margin: 0;
            padding: 0;
            font-size: 20px;
            line-height: 20px;
            text-align: center;
            color: #ccc;
            transition: color 0.3s;
        }

        .rating label.active {
            color: #ff9f1c;
        }

        .rating label:hover,
        .rating label:hover~label,
        .rating input:checked~label {
            color: #ff9f1c;
        }

        /* Estilo para las estrellas generadas por PHP */

        .rating-php {
            display: flex;
            flex-direction: row-reverse;
            /* Cambiado de row a row-reverse */
            align-items: center;
        }

        .rating-php input {
            display: none;
        }

        .rating-php label {
            font-size: 20px;
            display: inline-block;
            margin: 0;
            padding: 0;
            width: 20px;
            height: 20px;
            color: #ccc;
            text-align: center;
            transition: color 0.3s;
        }

        .rating-php label:hover,
        .rating-php label:hover~label,
        .rating-php input:checked~label {
            color: #ff9f1c;
        }

        .rating-php input:checked+label {
            color: #ff9f1c;
        }

        .comic-details {
            display: flex;
            flex-wrap: wrap;
            justify-content: space-between;
            padding: 10px;
            margin-bottom: 20px;
            border: 1px solid lightgray;
            border-radius: 5px;
        }

        .comic-detail {
            width: 48%;
            padding: 5px;
            box-sizing: border-box;
        }

        .card {
            width: 100%;
        }

        .comic-label {
            font-weight: bold;
        }

        .comic-value {
            color: blue;
        }

        /*
        .row {
            display: flex;
            flex-wrap: wrap;
        }

        .titulo {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100px;
            background-color: #FFC107;
            box-shadow: 0px 10px 20px rgba(0, 0, 0, 0.1);
        }

        .titulo h2 {
            color: white;
            font-size: 36px;
            text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.3);
        }

        .side-bar {
            position: fixed;
            margin-top: -30px;
            color: black;
        }

        .view-account {
            top: 50px;
            z-index: 100;
            margin-top: auto;
        } */

        #myButton {
            background-color: white;
            border: none;
            color: green;
            padding: 0;
            text-align: center;
            text-decoration: none;
            display: inline-block;
            font-size: 16px;
            border-radius: 5px;
            width: 150px;
            height: 50px;
        }

        #myButton:before {
            content: "No lo tengo";
            font-size: 25px;
            display: inline-block;
            vertical-align: middle;
            line-height: normal;
        }

        #myButton.active {
            background-color: green;
            color: white;
        }

        #myButton.active:before {
            content: "Lo tengo";
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

        .comment {
            border: 1px solid #ccc;
            padding: 10px;
            margin-bottom: 10px;
            display: block;
            clear: both;
        }

        /*
        .comment-info {
            max-width: 500px;
            /* o el ancho que desees 
        }*/

        .comment:not(:last-child) {
            border-bottom: none;
        }

        /* .comic_portada {
            margin-top: 20px;
        } */

        .form-group {
            flex-wrap: wrap;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
            resize: none;
            width: 100%;
        }

        .comic-details {
            display: flex;
            flex-wrap: wrap;
            justify-content: space-between;
            align-items: center;
            width: 100%;
            padding: 20px;
            border-radius: 10px;
            background-color: grey;
        }

        .comic-detail {
            flex-basis: 30%;
            margin-bottom: 20px;
        }

        .comic-label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
            font-size: 14px;
        }

        .comic-value {
            display: block;
            width: 100%;
            padding: 8px;
            border-radius: 5px;
            border: none;
            background-color: white;
            font-size: 14px;
            font-family: 'Roboto', sans-serif;
        }

        .comic-value:focus {
            outline: none;
            box-shadow: 0px 0px 5px #3f3f3f;
        }

        button.nav-link.dropdown-toggle {
            border: none;
            background-color: transparent;
            color: #fff;
            font-size: 24px;
            cursor: pointer;
        }

        button.nav-link.dropdown-toggle:hover {
            color: #ccc;
        }

        body {
            margin: 0 !important;
            padding: 0 !important;
            height: 100% !important;
            overflow-y: scroll !important;
            /* Habilita el scroll vertical */

        }

        main {
            min-height: 100vh !important;
        }
    </style>
</head>

<body class="d-flex flex-column min-vh-100" onload="showSelected();">
    <main class="flex-shrink-0">
        <div id="session-expiration">
            <div id="session-expiration-message">
                <p>Su sesión está a punto de caducar. ¿Desea continuar conectado?</p>
                <button id="session-expiration-continue-btn">Continuar</button>
                <button id="session-expiration-logout-btn">Cerrar sesión</button>
            </div>
        </div>
        <nav class="navbar navbar-expand-lg navbar-dark bg-dark sticky-top" style="background-color: #343a40 !important;cursor:url(https://cdn.custom-cursor.com/db/cursor/32/Infinity_Gauntlet_Cursor.png) , default!important">
            <div class="container-fluid" style="background-color: #343a40;">

                <button class="navbar-toggler navbar-toggler-sm ms-4" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasExample" aria-controls="offcanvasExample" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav me-auto mb-2 mb-lg-0">

                        <li class="nav-item">
                            <!-- Offcanvas boton para menu para dispositivos con pantalla grande  -->
                            <button class="btn btn-primary" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvas-menu" aria-controls="offcanvas-menu" aria-expanded="false" aria-label="Toggle navigation">
                                <i class="fa fa-bars"></i>
                            </button>
                        </li>
                        <li class="nav-item">
                            <a href="index.php" class="nav-link logo-web">
                                <strong>
                                    <span>Comic Web</span>
                                </strong>
                            </a>
                        </li>

                        <li class="nav-item">
                            <?php
                            if (isset($_SESSION['email'])) {
                            ?>
                                <a class="nav-link" href="mi_coleccion.php" style='cursor:url(https://cdn.custom-cursor.com/db/cursor/32/Infinity_Gauntlet_Cursor.png) , default!important'>Mi colección</a>

                            <?php
                            } else {
                            ?>
                                <a class="nav-link" href="#" onclick="no_logueado()" style='cursor:url(https://cdn.custom-cursor.com/db/cursor/32/Infinity_Gauntlet_Cursor.png) , default!important'>Mi colección</a>
                            <?php
                            }
                            ?>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link" href="novedades.php" style='cursor:url(https://cdn.custom-cursor.com/db/cursor/32/Infinity_Gauntlet_Cursor.png) , default!important'>Novedades</a>
                        </li>
                        <li class="nav-item">
                            <?php
                            if (isset($_SESSION['email'])) {
                                // Obtener el número de mensajes sin leer
                                $num_solicitudes = obtener_numero_notificaciones_amistad_sin_leer($id_usuario);

                                // Imprimir el enlace con el número de mensajes sin leer
                                echo "<a class='nav-link' href='solicitudes_amistad.php'>";
                                if ($num_solicitudes > 0) {
                                    echo "<span class='material-icons shaking'>notifications</span>";
                                    //echo "<span class='num_notificaciones'>$num_solicitudes</span>";
                                } else {
                                    echo "<span class='material-icons '>notifications</span>";
                                }
                                echo "</a>";
                            }
                            ?>
                        </li>
                        <li class="nav-item">
                            <?php
                            if (isset($_SESSION['email'])) {
                                // Obtener el número de mensajes sin leer
                                $num_mensajes = obtener_numero_mensajes_sin_leer($id_usuario);

                                // Imprimir el enlace con el número de mensajes sin leer
                                echo "<a class='nav-link' href='mensajes_usuario.php'>";
                                if ($num_mensajes > 0) {
                                    echo "<span class='material-icons shaking'>mark_email_unread</span>";
                                    //echo "<span class='num_mensajes'>$num_mensajes</span>";
                                } else {
                                    echo "<span class='material-icons'>mark_email_unread</span>";
                                }
                                echo "</a>";
                            }
                            ?>
                        </li>
                    </ul>


                    <div class="d-flex" role="search">
                        <form class="form-inline me-2" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" onsubmit="return false;">
                            <input type="text" class="search-click mr-sm-3" name="search" placeholder="Buscador..." id="search-data" style='cursor:url(https://cdn.custom-cursor.com/db/cursor/32/Infinity_Gauntlet_Cursor.png) , default!important' />
                        </form>
                    </div>
                </div>
                <div class="btn-group">
                    <?php
                    if (isset($_SESSION['email'])) {
                        echo "
                            <a id='user-avatar' href='#' role='button' data-bs-toggle='dropdown' aria-expanded='false' style='background-color: transparent;'>
                                <img src=$picture id='avatar' alt='Avatar' class='avatarPicture me-2' style='cursor:url(https://cdn.custom-cursor.com/db/cursor/32/Infinity_Gauntlet_Cursor.png) , default!important;'>
                            </a>";
                    } else {
                        echo "
                            <a id='user-avatar' href='#' role='button' data-bs-toggle='dropdown' aria-expanded='false' style='background-color: transparent;position-absolute'>
                                <img src='assets/pictureProfile/default/default.jpg' id='avatar' alt='Avatar'  style='cursor:url(https://cdn.custom-cursor.com/db/cursor/32/Infinity_Gauntlet_Cursor.png) , default!important;'>
                            </a>";
                    }
                    ?>

                    <script>
                        $(document).ready(function() {
                            var viewportWidth = $(window).width();
                            if (viewportWidth < 992) {
                                $('#user-avatar').attr('data-bs-toggle', 'offcanvas');
                                $('#user-avatar').attr('data-bs-target', '#offcanvasNavbarDark');
                            } else {
                                $('#user-avatar').attr('data-bs-toggle', 'dropdown');
                                $('#user-avatar').removeAttr('data-bs-target');
                            }
                        });

                        $(window).resize(function() {
                            var viewportWidth = $(window).width();
                            if (viewportWidth < 992) {
                                $('#user-avatar').attr('data-bs-toggle', 'offcanvas');
                                $('#user-avatar').attr('data-bs-target', '#offcanvasNavbarDark');
                            } else {
                                $('#user-avatar').attr('data-bs-toggle', 'dropdown');
                                $('#user-avatar').removeAttr('data-bs-target');
                            }
                        });
                    </script>


                    <ul class="dropdown-menu dropdown-menu-lg-end" aria-labelledby="dropdownMenuButton">
                        <?php
                        if (isset($_SESSION['email'])) {
                            if ($userPrivilege == 'admin') {
                                echo '<li>
                                            <div class="d-flex align-items-center">';
                                echo "<img src=$picture id='avatar' alt='Avatar' class='avatarPicture me-2' style='cursor:url(https://cdn.custom-cursor.com/db/cursor/32/Infinity_Gauntlet_Cursor.png) , default!important;'>";
                                echo "<div class='fw-bold'>$nombre_usuario</div>";
                                echo '
                                    </div>
                                    </li>';
                                echo '<li><a class="dropdown-item" href="infoPerfil.php" >Mi perfil</a></li>';
                                echo '<li><a class="dropdown-item" href="panel_tickets_admin.php">Panel tickets</a></li>';
                            } elseif ($userPrivilege == 'user') {
                                echo '<li>
                                            <div class="d-flex align-items-center">';
                                echo "<img src=$picture id='avatar' alt='Avatar' class='avatarPicture me-2' style='cursor:url(https://cdn.custom-cursor.com/db/cursor/32/Infinity_Gauntlet_Cursor.png) , default!important;'>";
                                echo "<div class='fw-bold'>$nombre_usuario</div>";

                                echo '<div>
                                        <div class="fw-bold">Nombre de usuario</div>
                                        <a href="infoPerfil.php" class="text-muted">Mi perfil</a>
                                        </div>
                                    </div>
                                    </li>';
                                echo '<li><a class="dropdown-item" href="#">Enviar un ticket</a></li>';
                            } else {
                                echo '<li><button class="dropdown-item" onclick="closeSesion()">Iniciar sesión</button></li>';
                            }

                            echo '<li><a class="dropdown-item" href="escribir_comentario_pagina.php">Escribe tu opinión</a></li>';
                            echo '<li><a class="dropdown-item" href="about.php">Sobre WebComics</a></li>';
                            echo '<hr class="dropdown-divider">';
                            echo '<li><button class="dropdown-item" onclick="closeSesion()" name="closeSesion">Cerrar sesión</button></li>';
                        } else {

                            echo '<li>
                                <div class="d-flex align-items-center">';
                            echo "<img src='assets/pictureProfile/default/default.jpg' id='avatar' alt='Avatar' class='avatarPicture me-2' style='cursor:url(https://cdn.custom-cursor.com/db/cursor/32/Infinity_Gauntlet_Cursor.png) , default!important;'>";
                            echo '
                            <div>
                            <div class="fw-bold">Invitado</div>
                            </div>
                        </div>
                        </li>';
                            echo "<hr class='dropdown-divider'>";
                            echo '<li><a class="dropdown-item" href="about.php">Sobre WebComics</a></li>';
                            echo '<li><button class="dropdown-item" onclick="iniciar_sesion()">Iniciar sesión</button></li>';
                        }
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
        <?php
        if (isset($_SESSION['email'])) {
        ?>
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
                                    echo "<input type='hidden' id='id_user_ticket' value='$id_usuario'>";
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
        <?php
        }
        ?>

        <div class="card-footer text-muted">
            Design by Alejandro Rodriguez 2022
        </div>

        <!--Canvas imagen de perfil-->
        <div class="offcanvas offcanvas-end offcanvas-static text-bg-dark w-50" tabindex="-1" id="offcanvasNavbarDark" aria-labelledby="offcanvasNavbarDarkLabel" aria-modal="true" role="dialog">
            <div class="offcanvas-header">
                <?php
                if (isset($_SESSION['email'])) {
                ?>
                    <h5 class="offcanvas-title" id="offcanvasNavbarDarkLabel offcanvasScrollingLabel"><?php echo $userPrivilege ?></h5>
                <?php
                } else {
                    echo '<h5 class="offcanvas-title" id="offcanvasNavbarDarkLabel offcanvasScrollingLabel" >Invitado</h5>';
                }
                ?>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="offcanvas" aria-label="Close"></button>
            </div>
            <div class="offcanvas-body">
                <ul class="navbar-nav justify-content-end flex-grow-1 pe-3">
                    <?php
                    if (isset($_SESSION['email'])) {
                        if ($userPrivilege == 'admin') {
                            echo '<li>
                                            <div class="d-flex align-items-center">';
                            echo "<img src=$picture id='avatar' alt='Avatar' class='avatarPicture me-2' style='cursor:url(https://cdn.custom-cursor.com/db/cursor/32/Infinity_Gauntlet_Cursor.png) , default!important;'>";
                            echo "<div class='fw-bold'>$nombre_usuario</div>";
                            echo '
                                    </div>
                                    </li>';
                            echo '<li><a class="dropdown-item" href="infoPerfil.php" >Mi perfil</a></li>';
                            echo '<li><a class="dropdown-item" href="panel_tickets_admin.php">Panel tickets</a></li>';
                        } elseif ($userPrivilege == 'user') {
                            echo '<li>
                                    <div class="d-flex align-items-center">
                                        <img src="ruta-a-imagen.jpg" alt="Avatar del usuario" class="me-2" style="width: 30px; height: 30px;">
                                        <div>
                                        <div class="fw-bold">Nombre de usuario</div>
                                        <a href="infoPerfil.php" class="text-muted">Mi perfil</a>
                                        </div>
                                    </div>
                                    </li>';
                            echo '<li><a class="dropdown-item" href="#">Enviar un ticket</a></li>';
                        } else {
                            echo '<li><button class="dropdown-item" onclick="closeSesion()">Iniciar sesión</button></li>';
                        }
                    } else {

                        echo '<li>
                                <div class="d-flex align-items-center">';
                        echo "<img src='assets/pictureProfile/default/default.jpg' id='avatar' alt='Avatar' class='avatarPicture me-2' style='cursor:url(https://cdn.custom-cursor.com/db/cursor/32/Infinity_Gauntlet_Cursor.png) , default!important;'>";
                        echo '
                            <div>
                            <div class="fw-bold">Invitado</div>
                            </div>
                        </div>
                        </li>';
                        echo "<hr class='dropdown-divider'>";
                        echo '<li><a class="dropdown-item" href="about.php">Sobre WebComics</a></li>';
                        echo '<li><button class="dropdown-item" onclick="iniciar_sesion()">Iniciar sesión</button></li>';
                    }
                    ?>
                </ul>
            </div>


        </div>
        <!--Canvas menu-->
        <div class="offcanvas offcanvas-start text-bg-dark w-20" data-bs-backdrop="static" tabindex="-1" id="offcanvas-menu" aria-labelledby="offcanvas-menu-Label">
            <div class="offcanvas-header">
                <?php
                if (isset($_SESSION['email'])) {
                ?>
                    <h5 class="offcanvas-title" id="offcanvas-menu-Label offcanvasScrollingLabel"><?php echo $userPrivilege ?></h5>
                <?php
                } else {
                    echo '<h5 class="offcanvas-title" id="offcanvas-menu-Label offcanvasScrollingLabel" >Invitado</h5>';
                }
                ?>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="offcanvas" aria-label="Close"></button>
            </div>
            <div class="offcanvas-body">
                <ul class="navbar-nav justify-content-end flex-grow-1 pe-3">
                    <li class="nav-item">
                        <a class="dropdown-item" href="index.php" style="cursor:url(https://cdn.custom-cursor.com/db/cursor/32/Infinity_Gauntlet_Cursor.png) , default!important"><i class="fa fa-home fa-fw"></i>Inicio
                    </li>

                    <?php
                    if (isset($_SESSION['email'])) {
                        echo '<li class="nav-item"><a class="list-group-item-action active" href="mi_coleccion.php" style="cursor:url(https://cdn.custom-cursor.com/db/cursor/32/Infinity_Gauntlet_Cursor.png) , default!important"><i class="bi bi-newspaper p-1"></i>Mi coleccion</li>';
                        if ($userPrivilege == 'admin') {
                            echo "<li><a class='list-group-item-action active' href='admin_panel_usuario.php' style='cursor:url(https://cdn.custom-cursor.com/db/cursor/32/Infinity_Gauntlet_Cursor.png) , default!important'><i class='bi bi-person-circle p-1'></i>Administracion</a></li>";
                            echo "<li><a class='list-group-item-action active' href='infoPerfil.php' style='cursor:url(https://cdn.custom-cursor.com/db/cursor/32/Infinity_Gauntlet_Cursor.png) , default!important'><i class='bi bi-person-circle p-1'></i>Mi perfil</a></li>";
                            echo "<li><a class='list-group-item-action active' href='panel_tickets_admin.php' style='cursor:url(https://cdn.custom-cursor.com/db/cursor/32/Infinity_Gauntlet_Cursor.png) , default!important'><i class='bi bi-person-circle p-1'></i>Ver tickets</a></li>";
                        } else {
                            echo "<li><a class='list-group-item-action active' href='infoPerfil.php' style='cursor:url(https://cdn.custom-cursor.com/db/cursor/32/Infinity_Gauntlet_Cursor.png) , default!important'><i class='bi bi-person-circle p-1'></i>Mi perfil</a></li>";
                            echo "<li><button type='button' class='list-group-item-action active' data-bs-toggle='modal' data-bs-target='#crear_ticket' style='cursor:url(https://cdn.custom-cursor.com/db/cursor/32/Infinity_Gauntlet_Cursor.png) , default!important'><i class='bi bi-person-circle p-1'></i>Crear ticket</button></li>";
                        }
                    }
                    ?>
                    <li>
                        <a class='list-group-item-action active' href="novedades.php" style='cursor:url(https://cdn.custom-cursor.com/db/cursor/32/Infinity_Gauntlet_Cursor.png) , default!important'><i class="fa fa-book fa-fw"></i>
                            Novedades</a>
                    </li>
                    <li>
                        <a class='list-group-item-action active' href="about.php" style='cursor:url(https://cdn.custom-cursor.com/db/cursor/32/Infinity_Gauntlet_Cursor.png) , default!important'><i class="fa fa-pencil fa-fw"></i>
                            Sobre WebComics</a>
                    </li>
                    <?php
                    if (isset($_SESSION['email'])) {
                    ?>
                        <li>
                            <a class='list-group-item-action active' href="escribir_comentario_pagina.php" style='cursor:url(https://cdn.custom-cursor.com/db/cursor/32/Infinity_Gauntlet_Cursor.png) , default!important'><i class="bi bi-newspaper p-1"></i>
                                Escribe tu opinión</a>
                        </li>
                    <?php
                    }
                    ?>


                    <?php
                    if (isset($_SESSION['email'])) {
                    ?>
                        <div style="border-bottom: 1px solid #e6e6e6;"></div>
                        <li>
                            <button class="dropdown-item" onclick="closeSesion()" name="closeSesion" style='cursor:url(https://cdn.custom-cursor.com/db/cursor/32/Infinity_Gauntlet_Cursor.png) , default!important'><i class="bi bi-box-arrow-right p-1"></i>Cerrar sesion</a>
                        </li>
                    <?php
                    } else {
                    ?>
                        <div style="border-bottom: 1px solid #e6e6e6;"></div>

                        <li>
                            <button class="dropdown-item" onclick="iniciar_sesion()" name="loginSesion" style='cursor:url(https://cdn.custom-cursor.com/db/cursor/32/Infinity_Gauntlet_Cursor.png) , default!important'><i class="bi bi-box-arrow-right p-1"></i>Iniciar sesion</a>
                        </li>
                    <?php
                    }
                    ?>
                </ul>
            </div>
            <div class="offcanvas-footer">
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

                <!--Canvas menu movil-->
        <div class="offcanvas offcanvas-top text-bg-dark" tabindex="-1" id="offcanvasExample" aria-labelledby="offcanvasExampleLabel">
            <div class="offcanvas-header">

                <h5 class="offcanvas-title" id="offcanvasExampleLabel">Menú</h5>
                <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
            </div>
            <div class="offcanvas-body">
                <ul class="navbar-nav justify-content-end flex-grow-1 pe-3">
                    <li class="list-group-item list-group-item-action">
                        <a class="list-group-item-action active" aria-current="page" href="index.php">Inicio</a>
                    </li>
                    <li class="list-group-item list-group-item-action">
                        <?php
                        if (isset($_SESSION['email'])) {
                        ?>
                            <a class="list-group-item-action active" href="mi_coleccion.php">Mi colección</a>
                        <?php
                        } else {
                        ?>
                            <a class="list-group-item-action active" href="#" onclick="no_logueado()">Mi colección</a>
                        <?php
                        }
                        ?>
                    </li>
                    <?php
                    if (isset($_SESSION['email'])) {
                        echo '<li class="nav-item"><a class="list-group-item-action active" href="mi_coleccion.php" style="cursor:url(https://cdn.custom-cursor.com/db/cursor/32/Infinity_Gauntlet_Cursor.png) , default!important"><i class="bi bi-newspaper p-1"></i>Mi coleccion</li>';
                        if ($userPrivilege == 'admin') {
                            echo "<li><a class='list-group-item-action active' href='admin_panel_usuario.php' style='cursor:url(https://cdn.custom-cursor.com/db/cursor/32/Infinity_Gauntlet_Cursor.png) , default!important'><i class='bi bi-person-circle p-1'></i>Administracion</a></li>";
                            echo "<li><a class='list-group-item-action active' href='infoPerfil.php' style='cursor:url(https://cdn.custom-cursor.com/db/cursor/32/Infinity_Gauntlet_Cursor.png) , default!important'><i class='bi bi-person-circle p-1'></i>Mi perfil</a></li>";
                            echo "<li><a class='list-group-item-action active' href='panel_tickets_admin.php' style='cursor:url(https://cdn.custom-cursor.com/db/cursor/32/Infinity_Gauntlet_Cursor.png) , default!important'><i class='bi bi-person-circle p-1'></i>Ver tickets</a></li>";
                        } else {
                            echo "<li><a class='list-group-item-action active' href='infoPerfil.php' style='cursor:url(https://cdn.custom-cursor.com/db/cursor/32/Infinity_Gauntlet_Cursor.png) , default!important'><i class='bi bi-person-circle p-1'></i>Mi perfil</a></li>";
                            echo "<li><button type='button' class='list-group-item-action active' data-bs-toggle='modal' data-bs-target='#crear_ticket' style='cursor:url(https://cdn.custom-cursor.com/db/cursor/32/Infinity_Gauntlet_Cursor.png) , default!important'><i class='bi bi-person-circle p-1'></i>Crear ticket</button></li>";
                        }
                    }
                    ?>
                    <li class="list-group-item list-group-item-action">
                        <a class="list-group-item-action active" href="novedades.php">Novedades</a>
                    </li>
                    <li class="list-group-item list-group-item-action">
                        <?php
                        if (isset($_SESSION['email'])) {
                            // Obtener el número de mensajes sin leer
                            $num_solicitudes = obtener_numero_notificaciones_amistad_sin_leer($id_usuario);

                            // Imprimir el enlace con el número de mensajes sin leer
                            echo "<a class='list-group-item-action active' href='solicitudes_amistad.php'>";
                            if ($num_solicitudes > 0) {
                                echo "<span class='material-icons shaking'>notifications</span>";
                                //echo "<span class='num_notificaciones'>$num_solicitudes</span>";
                            } else {
                                echo "<span class='material-icons '>notifications</span>";
                            }
                            echo "</a>";
                        }
                        ?>
                    </li>
                    <li class="list-group-item list-group-item-action">
                        <?php
                        if (isset($_SESSION['email'])) {
                            // Obtener el número de mensajes sin leer
                            $num_mensajes = obtener_numero_mensajes_sin_leer($id_usuario);

                            // Imprimir el enlace con el número de mensajes sin leer
                            echo "<a class='list-group-item-action active' href='mensajes_usuario.php'>";
                            if ($num_mensajes > 0) {
                                echo "<span class='material-icons shaking'>mark_email_unread</span>";
                                //echo "<span class='num_mensajes'>$num_mensajes</span>";
                            } else {
                                echo "<span class='material-icons'>mark_email_unread</span>";
                            }
                            echo "</a>";
                        }
                        ?>
                    </li>
                </ul>

                <!-- <div class="d-flex" role="search"> -->
                <form class="d-flex" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" role="search" onsubmit="searchData(); return false;">
                    <input type="search" class="form-control me-2" name="search" id="search" placeholder="Buscador" id="search-data" style='cursor:url(https://cdn.custom-cursor.com/db/cursor/32/Infinity_Gauntlet_Cursor.png) , default!important' />
                    <button type="submit" class="btn btn-outline-success" id="search-boton" name="search-boton">Buscar</button>
                </form>

                <script>
                    function searchData() {
                        const searchData = document.getElementById("search").value;
                        window.location.href = "search_data.php?search=" + encodeURIComponent(searchData);
                    }
                </script>
                <!-- </div> -->
            </div>
        </div>



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
                                echo "<input type='hidden' id='id_user_ticket' value='$id_usuario'>";
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

        <div class="bg-image bg-attachment-fixed" style="background-image: url('assets/img/img_parallax.jpg');opacity: 0.8;">
            <br>
            <div class="container mt-5" style="margin-top:auto !important;background-color:#ffffff88">
                <div class="row">
                    <div class="col-md-3 side-bar">

                        <div class="user-info">
                            <img class='img-profile img-circle img-fluid w-100 h-auto comic_portada' id='output' alt='Avatar' src='<?php echo $cover_imagen ?>' onclick='pictureProfileUser()' />
                            <?php
                            if (isset($_SESSION['email'])) {
                                if (check_guardado($id_usuario, $id_comic)) {
                                    echo "<button id='myButton' class='active'></button>";
                                } else {
                                    echo "<button id='myButton'></button>";
                                }


                                if ($userPrivilege == 'admin') {
                                    echo '<div class="ml-auto">
                                        <button type="button" class="btn btn-danger btn-sm mt-2" style="display: block;" onclick="eliminar_comic(' . $id_comic . ')">Eliminar comic</button>
                                        </div>';
                                }
                                echo "<script>
                                function handleButtonClick() {
                                    const button = document.querySelector('#myButton');
                    
                                    if (button.classList.contains('active')) {
                                        button.classList.remove('active');
                                        quitar_comic($id_comic);
                                    } else {
                                        button.classList.add('active');
                                        guardar_comic($id_comic);
                                    }
                                }
                    
                                const button = document.querySelector('#myButton');
                                if (button) {
                                    button.addEventListener('click', handleButtonClick);
                                }
                              </script>";
                            }
                            ?>
                        </div>

                    </div>
                    <div class="col-md-9">
                        <div class="row justify-content-center">
                            <div class="view-account bg-light" style="border-radius:20px">
                                <fieldset class="fieldset">
                                    <h3 class="fieldset-title">Comic Info</h3>
                                    <div class="form-group avatar">
                                        <?php
                                        $fechaCreacion = $data_comic['date_published'];
                                        $nombre = $data_comic['nomComic'];
                                        $variante = $data_comic['nomVariante'];
                                        $editorial = $data_comic['nomEditorial'];
                                        $autor = $data_comic['nomGuionista'];
                                        $dibujante = $data_comic['nomDibujante'];
                                        $procedencia = $data_comic['Procedencia'];
                                        $numero = $data_comic['numComic'];
                                        $formato = $data_comic['Formato'];
                                        $valoracion_media = valoracion_media($id_comic);
                                        ?>
                                        <table class='table'>
                                            <tbody>
                                                <tr>
                                                    <td><label class='comic-label'>Nombre del comic:</label></td>
                                                    <td><span class='comic-value'><a href='search_data.php?search=$nombre'><?php echo $nombre ?></a></span></td>
                                                    <input type='hidden' id='id_comic' value='<?php echo $id_comic ?>'>
                                                </tr>
                                                <tr>
                                                    <td><label class='comic-label'>Numero:</label></td>
                                                    <td><span class='comic-value'><?php echo $numero ?></span></td>
                                                </tr>
                                                <tr>
                                                    <td><label class='comic-label'>Variante:</label></td>
                                                    <td>
                                                        <span class='comic-value'>
                                                            <?php
                                                            $variantes = explode("-", $variante);
                                                            foreach ($variantes as $variante) {
                                                                echo "<li><a href='search_data.php?search=$variante'>$variante</a></li>";
                                                            }
                                                            ?>
                                                        </span>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td><label class='comic-label'>Formato:</label></td>
                                                    <td><span class='comic-value'><a href='search_data.php?search=$formato'><?php echo $formato ?></a></span></td>
                                                </tr>
                                                <tr>
                                                    <td><label class='comic-label'>Fecha de creacion:</label></td>
                                                    <td><span class='comic-value'><a href='search_data.php?search=$fechaCreacion'><?php echo $fechaCreacion ?></a></span></td>
                                                </tr>
                                                <tr>
                                                    <td><label class='comic-label'>Editorial:</label></td>
                                                    <td><span class='comic-value'><a href='search_data.php?search=$editorial'><?php echo $editorial ?></a></span></td>
                                                </tr>
                                                <tr>
                                                    <td><label class='comic-label'>Autor:</label></td>
                                                    <td>
                                                        <span class='comic-value'>
                                                            <?php
                                                            $autores = explode("-", $autor);
                                                            foreach ($autores as $autor) {
                                                                echo "<li><a href='search_data.php?search=$autor'>$autor</a></li>";
                                                            }
                                                            ?>
                                                        </span>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td><label class='comic-label'>Dibujante:</label></td>
                                                    <td>
                                                        <span class='comic-value'>
                                                            <?php
                                                            $dibujantes = explode("-", $dibujante);
                                                            foreach ($dibujantes as $dibujante) {
                                                                echo "<li><a href='search_data.php?search=$dibujante'>$dibujante</a></li>";
                                                            }
                                                            ?>
                                                        </span>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td><label class='comic-label'>Procedencia:</label></td>
                                                    <td><span class='comic-value'><a href='search_data.php?search=$procedencia'><?php echo $procedencia ?></a></span></td>
                                                </tr>
                                                <tr>
                                                    <td><label class='comic-label'>Valoracion media:</label></td>
                                                    <td>
                                                        <div class='valoracion-media'>
                                                            <?php
                                                            $full_stars = floor($valoracion_media);
                                                            $half_star = $valoracion_media - $full_stars >= 0.5 ? 1 : 0;
                                                            $empty_stars = 5 - $full_stars - $half_star;
                                                            echo "<div class='row'>";
                                                            echo "  <div class='col-md-6'>";
                                                            echo "    <span class='comic-value'><a href='search_data.php?search=" . $procedencia . "'>$procedencia</a></span>";
                                                            echo "  </div>";
                                                            echo "  <div class='col-md-6'>";
                                                            echo "<tr>";
                                                            echo "<td>";
                                                            echo "    <label class='comic-label'>Valoracion media: </label>";
                                                            echo "    <div class='valoracion-media'>";
                                                            for ($i = 0; $i < $full_stars; $i++) {
                                                                echo '<i class="fas fa-star"></i>';
                                                            }
                                                            if ($half_star) {
                                                                echo '<i class="fas fa-star-half-alt"></i>';
                                                            }
                                                            for ($i = 0; $i < $empty_stars; $i++) {
                                                                echo '<i class="far fa-star"></i>';
                                                            }
                                                            echo "    </div>";
                                                            echo "</tr>";
                                                            echo "</td>";
                                                            echo "  </div>";
                                                            echo "</div>"; // end of row div
                                                            ?>
                                                        </div>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </fieldset>

                                <label class='comic-label' for='procedencia_comic'>Descripción del comic:<span class='required'>*</span></label>
                                <fieldset class="fieldset">
                                    <legend class="fieldset-title mb-3">Descripción del cómic</legend>
                                    <div class="form-group bg-light p-3 rounded">
                                        <p><?php echo $descripcion ?></p>
                                    </div>
                                </fieldset>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <br>

            <div class="container mt-5" style="margin-top:auto !important;background-color:white">
                <div class="row">
                    <form action="" method='POST' id='form_opinion' onsubmit="return false;">
                        <div class="d-flex flex-column form-color p-3">
                            <div class="d-flex flex-wrap align-items-center">
                                <?php
                                if (isset($_SESSION['email'])) {
                                    echo "<img src='" . $picture . "' id='avatar' alt='Avatar' class='avatarPicture' onclick='pictureProfileAvatar()' style='cursor:url(https://cdn.custom-cursor.com/db/cursor/32/Infinity_Gauntlet_Cursor.png) , default!important'>";
                                    echo "<div class='pr-2'>";
                                    echo "<h6 class='mb-0' style='margin-left:10px'>" . $nombre_usuario . "</h6>";
                                    echo "</div>";
                                    echo "<textarea id='opinion' class='form-control mt-2' placeholder='Pon tu comentario...' style='width: 100% !important; height: 110px !important; resize: none !important;'></textarea>";
                                    echo "<div class='d-flex flex-row align-items-center mr-2' id='rating'>";
                                    echo "<label for='rating' class='mr-2'>Valoracion:</label>";
                                    echo "<div class='rating' style='margin-left:5px'>";
                                    echo "<label for='5'>★</label>";
                                    echo "<input type='radio' name='rating' value='5' id='5'>";
                                    echo "<label for='4'>★</label>";
                                    echo "<input type='radio' name='rating' value='4' id='4'>";
                                    echo "<label for='3'>★</label>";
                                    echo "<input type='radio' name='rating' value='3' id='3'>";
                                    echo "<label for='2'>★</label>";
                                    echo "<input type='radio' name='rating' value='2' id='2'>";
                                    echo "<label for='1'>★</label>";
                                    echo "<input type='radio' name='rating' value='1' id='1'>";
                                    echo "</div>";
                                    echo "<div class='boton-enviar d-flex flex-wrap align-items-center justify-content-end'>";
                                    echo "<input type='hidden' id='id_user_opinion' value='" . $id_usuario . "'>";
                                    echo "<input type='hidden' id='id_comic' value='" . $id_comic . "'>";
                                    echo "<button type='submit' class='btn btn-primary boton-enviar' onclick='nueva_opinion()'>Enviar</button>";
                                    echo "</div></div>";

                                ?>
                                    <script>
                                        const rating = document.querySelector('.rating');
                                        const ratingLabels = rating.querySelectorAll('label');

                                        ratingLabels.forEach((label) => {
                                            label.addEventListener('click', () => {
                                                // Añadir clase active al label seleccionado
                                                label.classList.add('active');

                                                // Eliminar clase active de los demás labels
                                                ratingLabels.forEach((otherLabel) => {
                                                    if (otherLabel !== label) {
                                                        otherLabel.classList.remove('active');
                                                    }
                                                });
                                            });
                                        });
                                    </script>
                                <?php
                                }
                                ?>

                        </div>
                    </form>
                </div>
                <div class="comentarios"></div>
            </div>
        </div>

        <div class="container mt-5">
            <div class="d-flex justify-content-center">
                <div class="last-pubs2 comics">
                </div>
            </div>
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

        <script>
            var resizeTimer;

            function comics_recomendados() {
                // Obtener ancho de la ventana y calcular el número de cómics que se mostrarán
                var width = $(window).width();
                var num_comics = Math.max(3, Math.min(8, Math.floor(width / 150))); // Suponiendo que cada cómic tiene un ancho de 300px y se muestra un máximo de 8 cómics

                var data = {
                    num_comics: num_comics
                };
                $.ajax({
                    url: "php/apis/recomendaciones_comics.php",
                    data: data,
                    success: function(data) {
                        totalComics = $(data).filter("#total-comics").val();
                        $('.comics').html('');
                        $(data).appendTo('.comics');
                    }
                });
            }

            comics_recomendados();
            // Actualiza los comics recomendados cuando cambia el tamaño de la pantalla
            $(window).on('resize', function() {
                clearTimeout(resizeTimer);
                resizeTimer = setTimeout(comics_recomendados, 100);
            });

            var myOffcanvas1 = document.getElementById('offcanvasExample')
            var myOffcanvas1 = new bootstrap.Offcanvas(myOffcanvas1)

            var myOffcanvas2 = document.getElementById('offcanvasNavbarDark')
            var myOffcanvas2 = new bootstrap.Offcanvas(myOffcanvas2)
        </script>
        <script>
            $(document).ready(function() {
                $('input[type="radio"]').click(function() {
                    var index = $(this).val();
                    $('input[type="radio"]').each(function(i) {
                        if (i < index) {
                            $(this).next().addClass('checked');
                        } else {
                            $(this).next().removeClass('checked');
                        }
                    });
                });
            });
        </script>
        <script>
            $(document).ready(function() {
                var id_comic = $("#id_comic").val(); // get the id_comic value here
                loadComentarios(id_comic);
            });

            function loadComentarios(id_comic) {
                var data = {
                    id_comic: id_comic,
                };

                $.ajax({
                    url: "php/apis/comentarios.php",
                    data: data,
                    success: function(data) {
                        $('<div class="mt-2"> <div class = "d-flex flex-row p-3" > ' + data + ' </div> </div> </div> </div>').appendTo('.comentarios');
                    }
                });
            }
        </script>
        <script>
            // const button = document.querySelector("#myButton");

            // button.addEventListener("click", function() {
            //     const id_comic = document.querySelector("#id_comic").value;

            //     if (button.classList.contains("active")) {
            //         // El botón está activo
            //         button.classList.remove("active");
            //         quitar_comic(id_comic);
            //     } else {
            //         // El botón está inactivo
            //         button.classList.add("active");
            //         guardar_comic(id_comic);
            //     }
            // });
        </script>


    </main>
</body>

</html>