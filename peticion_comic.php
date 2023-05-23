<?php
session_start();
include_once 'php/inc/header.inc.php';


if (isset($_SESSION['email'])) {
    $email = $_SESSION['email'];
    $picture = pictureProfile($email);
    guardar_ultima_conexion($email);
    $userData = obtener_datos_usuario($email);
    $userPrivilege = $userData['privilege'];
    $userName = $userData['userName'];
    $id_usuario = $userData['IDuser'];
    $numero_comics = get_total_guardados($id_usuario);
    if (checkStatus($email)) {
        header("Location: usuario_bloqueado.php");
    }
    if (!comprobar_activacion($userName)) {
        header("Location: usuario_no_activado.php");
    }
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
    <!-- <link rel="stylesheet" href="./assets/style/footer_style.css"> -->
    <link rel="stylesheet" href="./assets/style/novedades.css">

    <!-- <link rel="stylesheet" href="./assets/style/media_barra_principal.css"> -->
    <link rel="stylesheet" href="./assets/style/sesion_caducada.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.3.0/css/font-awesome.min.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.3/font/bootstrap-icons.css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.14.0/css/all.css" integrity="sha384-HzLeBuhoNPvSl5KYnjx0BT+WB0QEEqLprO+NBkkk5gbc67FTaL7XIGa2w1L0Xbgc" crossorigin="anonymous">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link rel="stylesheet" href="./assets/style/iconos_notificaciones.css">

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js" integrity="sha384-oBqDVmMz9ATKxIep9tiCxS/Z9fNfEXiDAYTujMAeBAsjFuCZSmKbSSUnQlmh/jp3" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
    <script src="./assets/js/ajaxFunctions.js"></script>
    <script src="./assets/js/sweetalert2.all.min.js"></script>


    <script src="./assets/js/funciones_utilidades.js"></script>
    <script src="./assets/js/temporizador.js"></script>
    <title>Formulario peticion</title>
    <style>
                .container {
            padding: 30px;
        }
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

        .bgimg-1::before {
            content: "";
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-image: url('<?php echo $picture ?>');
            filter: blur(5px);
            z-index: -1;
            background-attachment: fixed;
            background-position: center center;
            background-repeat: no-repeat;
            background-size: cover;
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

        /* .comment {
            border: 1px solid #ccc;
            padding: 10px;
            margin-bottom: 10px;
            display: block;
            clear: both;
        }

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
            padding: 0;
            height: 100% !important;
            background-color: rgba(0, 0, 0, 0);

        }

        main {

            height: 100% !important;
        }

        /* Estilos generales para el footer */
        #footer-lite {
            background-color: #f5f5f5;
            padding: 20px 0;
            text-align: center;
        }

        /* Estilos para los enlaces */
        #footer-lite a {
            color: #444;
        }

        #footer-lite a:hover {
            color: #007bff;
            text-decoration: none;
        }

        /* Estilos para los íconos de redes sociales */
        #footer-lite .social a img {
            margin-right: 10px;
        }

        /* Estilos para el texto del copyright */
        #footer-lite .copyright {
            font-size: 14px;
            margin-top: 10px;
        }
    </style>
</head>

<body class="d-flex flex-column min-vh-100" onload="checkSesionUpdate();showSelected();">
    <main class="flex-shrink-0">
        <?php
        if (isset($_SESSION['email'])) {
            echo '
        <div id="session-expiration">
            <div id="session-expiration-message">
                <p>Su sesión está a punto de caducar. ¿Desea continuar conectado?</p>
                <button id="session-expiration-continue-btn">Continuar</button>
                <button id="session-expiration-logout-btn">Cerrar sesión</button>
            </div>
        </div>';
        ?>
        <?php
        }
        ?>
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
                                echo "<div class='fw-bold'>$userName</div>";
                                echo '
                                    </div>
                                    </li>';
                                echo '<li><a class="dropdown-item" href="infoPerfil.php" >Mi perfil</a></li>';
                                echo '<li><a class="dropdown-item" href="panel_tickets_admin.php">Panel tickets</a></li>';
                            } elseif ($userPrivilege == 'user') {
                                echo '<li class="list-group-item list-group-item-action">
                                            <div class="d-flex align-items-center">';
                                echo "<img src=$picture id='avatar' alt='Avatar' class='avatarPicture me-2' style='cursor:url(https://cdn.custom-cursor.com/db/cursor/32/Infinity_Gauntlet_Cursor.png) , default!important;'>";
                                echo "<div class='fw-bold'>$userName</div>";
                                echo '
                                    </div>
                                    </li>';
                                echo '<li><a class="dropdown-item" href="infoPerfil.php" >Mi perfil</a></li>';
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

        <div class="card-footer text-muted" style="background-color:white">
            Creado por Alejandro Rodriguez ©2023
        </div>

                <!--Canvas imagen de perfil-->
                <div class="offcanvas offcanvas-end offcanvas-static text-bg-dark w-50" tabindex="-1" id="offcanvasNavbarDark" aria-labelledby="offcanvasNavbarDarkLabel" aria-modal="true" role="dialog">
            <div class="offcanvas-header">
                <?php
                if (isset($_SESSION['email'])) {
                ?>
                    <h5 class="offcanvas-title" id="offcanvasNavbarDarkLabel offcanvasScrollingLabel"><?php echo $userName ?></h5>
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
                            echo '<li class="list-group-item list-group-item-action">
                                            <div class="d-flex align-items-center">';
                            echo "<img src=$picture id='avatar' alt='Avatar' class='avatarPicture me-2' style='cursor:url(https://cdn.custom-cursor.com/db/cursor/32/Infinity_Gauntlet_Cursor.png) , default!important;'>";
                            echo "<div class='fw-bold'>$userName</div>";
                            echo '
                                    </div>
                                    </li>';
                            echo '<li class="list-group-item list-group-item-action"><a class="list-group-item-action active" href="infoPerfil.php" ><i class="fa fa-cog fa-fw"></i>Mi perfil</a></li>';
                            echo '<li class="list-group-item list-group-item-action"><a class="list-group-item-action active" href="panel_tickets_admin.php"><i class="fa fa-cog fa-fw"></i>Panel tickets</a></li>';
                            echo '<li class="list-group-item list-group-item-action"><button class="list-group-item-action active" onclick="closeSesion()"><i class="fa fa-cog fa-fw"></i>Cerrar sesion</button></li>';
                        } elseif ($userPrivilege == 'user') {
                            echo '<li class="list-group-item list-group-item-action">
                                            <div class="d-flex align-items-center">';
                            echo "<img src=$picture id='avatar' alt='Avatar' class='avatarPicture me-2' style='cursor:url(https://cdn.custom-cursor.com/db/cursor/32/Infinity_Gauntlet_Cursor.png) , default!important;'>";
                            echo "<div class='fw-bold'>$userName</div>";
                            echo '
                                    </div>
                                    </li>';
                            echo '<li>
                            <a class="dropdown-item" href="infoPerfil.php">
                            <i class="fa fa-cog fa-fw"></i>Mi perfil
                            </a>
                            </li>';
                            echo '<li>
                            <a class="dropdown-item" href="#">
                            <i class="fa fa-cog fa-fw"></i>Enviar un ticket
                            </a>
                            </li>';
                            echo '<li class="list-group-item list-group-item-action">
                            <a class="list-group-item-action active" href="logOut.php">
                            <i class="bi bi-person-circle p-1"></i>Cerrar sesion
                            </a>
                            </li>';
                        } else {
                            echo '<li class="list-group-item list-group-item-action">
                            <a class="list-group-item-action active" href="logOut.php"><i class="bi bi-person-circle p-1"></i>Iniciar sesión
                            </a>
                            </li>';
                        }
                    } else {

                        echo '<li class="list-group-item list-group-item-action">
                                <div class="d-flex align-items-center">';
                        echo "<img src='assets/pictureProfile/default/default.jpg' id='avatar' alt='Avatar' class='avatarPicture me-2' style='cursor:url(https://cdn.custom-cursor.com/db/cursor/32/Infinity_Gauntlet_Cursor.png) , default!important;'>";
                        echo '
                            <div>
                            <div class="fw-bold">Invitado</div>
                            </div>
                        </div>
                        </li>';
                        echo "<hr class='dropdown-divider'>";
                        echo '<li class="list-group-item list-group-item-action"><a class="list-group-item-action active" href="about.php"><i class="bi bi-person-circle p-1"></i>Sobre WebComics</a></li>';
                        echo '<li class="list-group-item list-group-item-action"><a class="list-group-item-action active" href="logOut.php"><i class="bi bi-person-circle p-1"></i>Iniciar sesión</a></li>';
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
                    <h5 class="offcanvas-title" id="offcanvas-menu-Label offcanvasScrollingLabel"><?php echo $userName ?></h5>
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
                    <li class="list-group-item list-group-item-action"><a class="list-group-item-action active" href="about.php"><i class="bi bi-person-circle p-1"></i>Sobre WebComics</a></li>


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


                    <form class="d-flex" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" role="search" onsubmit="searchData(); return false;">
                        <input type="search" class="form-control me-2" name="search" id="search" placeholder="Buscador" id="search-data" style='cursor:url(https://cdn.custom-cursor.com/db/cursor/32/Infinity_Gauntlet_Cursor.png) , default!important' />
                        <button type="submit" class="btn btn-outline-success" id="search-boton" name="search-boton">Buscar</button>
                    </form>
                    <li class="list-group-item list-group-item-action">
                        <a class="list-group-item-action active" aria-current="page" href="index.php"><i class="fa fa-home fa-fw"></i>Inicio</a>
                    </li>
                    <li class="list-group-item list-group-item-action">
                        <?php
                        if (isset($_SESSION['email'])) {
                        ?>
                    </li>
                    <li class="nav-item"><a class="list-group-item-action active" href="mi_coleccion.php" style="cursor:url(https://cdn.custom-cursor.com/db/cursor/32/Infinity_Gauntlet_Cursor.png) , default!important"><i class="bi bi-newspaper p-1"></i>Mi coleccion</li>
                <?php
                        } else {
                ?>
                    <li class="nav-item"><a class="list-group-item-action active" href="#" onclick="no_logueado()"><i class="bi bi-newspaper p-1"></i>Mi colección</a></li>
                <?php
                        }
                ?>
                <?php
                if (isset($_SESSION['email'])) {
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
                    <a class="list-group-item-action active" href="novedades.php"><i class='bi bi-person-circle p-1'></i>Novedades</a>
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
                        echo "Notificaciones</a>";
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
                        echo "Mensajes</a>";
                    }
                    ?>
                </li>
                </ul>

                <!-- <div class="d-flex" role="search"> -->

                <?php
                echo '<li class="list-group-item list-group-item-action"><a class="list-group-item-action active" href="about.php"><i class="bi bi-person-circle p-1"></i>Sobre WebComics</a></li>';
                if (isset($_SESSION['email'])) {
                    echo '<div style="border-bottom: 1px solid #e6e6e6;"></div>';
                    echo '<li class="list-group-item list-group-item-action">
                    <a class="list-group-item-action active" href="logOut.php"><i class="bi bi-person-circle p-1"></i>Cerrar sesion</button></a>';
                    echo '</li>';
                }
                ?>

                <script>
                    function searchData() {
                        const searchData = document.getElementById("search").value;
                        window.location.href = "search_data.php?search=" + encodeURIComponent(searchData);
                    }
                </script>
                <!-- </div> -->
            </div>
        </div>
        <div class="bg-image bg-attachment-fixed" style="background-image: url('assets/img/img_parallax.jpg');opacity: 0.8;">
            <br>
            <div class="container mt-5" style="margin-top:auto !important;background-color:#ffffff88">
                <div class="row">
                    <div class="col-md-3 side-bar">
                        <form id="form-peticion" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">

                            <div class="user-info">
                                <img class='img-profile img-circle img-fluid w-100 h-auto comic_portada' id='output' alt='Avatar' src='./assets/img/portada-predeterminada.jpg' onclick='pictureProfileUser()' />
                                <label for="portada_comic" class="btn btn-primary">
                                    <span>Seleccionar archivo</span>
                                </label>
                                <input class="d-none" type="file" name="portada_comic" id="portada_comic" accept=".jpg, .png" onchange="loadFile(event)" style="cursor: url(https://cdn.custom-cursor.com/db/pointer/32/Infinity_Gauntlet_Pointer.png), pointer !important; font-size: 16px; height: 40px;color: transparent;margin-left:-10px">

                            </div>
                            <script>
                                function handleFileSelect(evt) {
                                    var f = evt.target.files[0]; // FileList object
                                    var reader = new FileReader();
                                    // Closure to capture the file information.
                                    reader.onload = (function(theFile) {
                                        return function(e) {
                                            var binaryData = e.target.result;
                                            //Converting Binary Data to base 64
                                            var base64String = window.btoa(binaryData);
                                            //save into var globally string
                                            image = base64String;
                                        };
                                    })(f);
                                    // Read in the image file as a data URL
                                    reader.readAsBinaryString(f);
                                }
                                document.getElementById('portada_comic').addEventListener('change', handleFileSelect, false);
                            </script>
                    </div>
                    <div class="col-md-9">
                        <div class="row justify-content-center">
                            <div class="view-account bg-light" style="border-radius:20px">
                                <fieldset class="fieldset">
                                    <h3 class="fieldset-title">Comic Info</h3>
                                    <div class="form-group avatar">
                                        <table class='table'>
                                            <tbody>
                                                <tr>
                                                    <td>
                                                        <label class='comic-label' for='nombre_comic'>Nombre del comic:<span class='required'>*</span></label></label>
                                                        <input class='comic-value' id='nombre_comic' type='text' name='nombre_comic' />
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <label class='comic-label' for='numero_comic'>Numero:<span class='required'>*</span></label></label>
                                                        <input class='comic-value' id='numero_comic' type='number' name='numero_comic' />
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <label class='comic-label' for='variante_comic'>Variante:<span class='required'>*</span></label></label>
                                                        <input class='comic-value' id='variante_comic' type='text' name='variante_comic' />
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <label class='comic-label' for='formato_comic'>Formato:<span class='required'>*</span></label></label>
                                                        <input class='comic-value' id='formato_comic' type='text' name='formato_comic' />
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <label class='comic-label' for='fecha_comic'>Fecha de creacion:<span class='required'>*</span></label></label>
                                                        <input class='comic-value' id='fecha_comic' type='date' name='fecha_comic' />
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <label class='comic-label' for='editorial_comic'>Editorial:<span class='required'>*</span></label></label>
                                                        <input class='comic-value' id='editorial_comic' type='text' name='editorial_comic' />
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <label class='comic-label' for='guionista_comic'>Guionista:<span class='required'>*</span></label></label>
                                                        <input class='comic-value' id='guionista_comic' type='text' name='guionista_comic' />
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <label class='comic-label' for='dibujante_comic'>Dibujante:<span class='required'>*</span></label></label>
                                                        <input class='comic-value' id='dibujante_comic' type='text' name='dibujante_comic' />
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <label class='comic-label' for='procedencia_comic'>Procedencia:<span class='required'>*</span></label></label>
                                                        <input class='comic-value' id='procedencia_comic' type='text' name='procedencia_comic' />
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </fieldset>

                                <label class='comic-label' for='procedencia_comic'>Descripción del comic:<span class='required'>*</span></label></label>
                                <fieldset class="fieldset">
                                    <legend class="fieldset-title mb-3">Descripción del cómic</legend>
                                    <div class="form-group bg-light p-3 rounded">
                                        <textarea style='resize: none' class="descripcion-comic form-control" id='descripcion_comic' rows="5"></textarea>
                                        <button class='btn btn-primary' type='button' style='margin-top:20px' onclick='peticion_comic_formulario()'>Mandar petición</button>
                                    </div>
                                </fieldset>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div id="footer-lite" class="mt-5">
                <div class="container">
                    <p class="helpcenter">
                        <a href="http://www.example.com/help">Ayuda</a>
                    </p>
                    <p class="footer-title">
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
    </main>
</body>

</html>