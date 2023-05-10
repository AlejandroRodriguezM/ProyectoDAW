<?php
session_start();
include_once 'php/inc/header.inc.php';

if (isset($_SESSION['email'])) {
    $email = $_SESSION['email'];
    $picture = pictureProfile($email);
    guardar_ultima_conexion($email);
    $userData = obtener_datos_usuario($email);
    $userPrivilege = $userData['privilege'];
    $id_usuario = $userData['IDuser'];
    $userName = $userData['userName'];
    $numero_comics = get_total_guardados($id_usuario);
    //echo "<input type='hidden' id='num_comics' value='$numero_comics'>";
    if (checkStatus($email)) {
        header("Location: usuario_bloqueado.php");
    }
    if (!comprobar_activacion($userName)) {
        header("Location: usuario_no_activado.php");
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
    <!-- <link rel="stylesheet" href="./assets/style/bandeja_comics.css"> -->
    <link rel="stylesheet" href="./assets/style/mensajes_style.css">
    <link rel="stylesheet" href="./assets/style/footer_style.css">
    <link rel="stylesheet" href="./assets/style/novedades.css">
    <!-- <link rel="stylesheet" href="./assets/style/parallax.css"> -->
    <!-- <link rel="stylesheet" href="./assets/style/media_recomendaciones.css"> -->
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
    <title>Mensajes de usuarios</title>
    <style>
        .contenedor {
            width: 50% !important;
            overflow-x: auto;
            margin: 0 auto;
            padding-top: 30px;
            padding-bottom: 30px;
            border-radius: 30px;
        }

        .message-container {
            display: flex;
            flex-direction: column;
            align-items: flex-start;
            margin-bottom: 10px;
        }

        .message-container p {
            display: inline-block;
            padding: 5px 10px;
            border-radius: 20px;
            max-width: 70%;
            margin-bottom: 5px;
            word-break: break-word;
        }

        .user-message {
            background-color: #3498db;
            color: #fff;
            align-self: flex-end;
        }

        .other-message {
            background-color: #ecf0f1;
            color: #000;
            align-self: flex-start;
        }

        /* Estilo para los mensajes del usuario actual */
        .current-user .user-message {
            background-color: #F0F8FF;
        }

        /* Estilo para los mensajes del otro usuario */
        .current-other .other-message {
            background-color: #E0FFFF;
        }

        .comment-box {
            margin-top: 20px;
            padding: 10px;
            border: 1px solid #ddd;
            background-color: #f9f9f9;

            display: flex;
            flex-direction: column;
            align-items: center;
        }

        .comment-box form[id^="form_mensaje-"] {
            display: flex;
            flex-direction: row;
            align-items: center;
        }

        .comment-box textarea[id^="mensaje_usuario_enviar-"] {
            flex: 1;
            height: 60px;
            margin-right: 10px;
            border: 1px solid #ccc;
            resize: none;
            font-size: 16px;
            line-height: 1.5;
            width: 100%;
            padding: 10px;
            margin-bottom: 10px;
        }

        .comment-box button {
            display: inline-block;
            padding: 10px;
            background-color: #4CAF50;
            color: white;
            border: none;
            font-size: 16px;
            cursor: pointer;
        }

        .comment-box button:hover {
            background-color: #3e8e41;
        }

        .nombre-destinatario {
            font-size: 16px;
            font-weight: bold;
            margin-left: 10px;
        }

        .arrow {
            background-color: #333;
            color: #fff;
            padding: 5px;
            border-radius: 20%;
            font-size: 18px;
        }

        .mensaje-header img {
            border-radius: 50%;
            border: 2px solid #fff;
            transition: all 0.3s ease;
        }

        .mensaje-header img:hover {
            opacity: 0.8;
            border-color: #333;
        }

        textarea {
            width: 100%;
            height: 100px;
            padding: 12px 20px;
            box-sizing: border-box;
            border: 2px solid #ccc;
            border-radius: 4px;
            background-color: #f8f8f8;
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

<body class="d-flex flex-column min-vh-100" onload="checkSesionUpdate();showSelected();">
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

                <!-- <a data-bs-toggle='offcanvas' data-bs-target='#offcanvasNavbarDark' aria-controls='offcanvasNavbarDark' href='#offcanvasExample' role='button' style='background-color: transparent;'>
                    <button class="navbar-toggler navbar-toggler-sm ms-4" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon navbar-dark"></span>
                    </button>
                </a> -->

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
                                    <span>Comic web </span>
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
                                echo '<li>
                                            <div class="d-flex align-items-center">';
                                echo "<img src=$picture id='avatar' alt='Avatar' class='avatarPicture me-2' style='cursor:url(https://cdn.custom-cursor.com/db/cursor/32/Infinity_Gauntlet_Cursor.png) , default!important;'>";
                                echo "<div class='fw-bold'>$userName</div>";

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
                            echo '<li><a class="dropdown-item" href="about.php">Sobre Comic web</a></li>';
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
                            echo '<li><a class="dropdown-item" href="about.php">Sobre Comic web</a></li>';
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
                        echo '<li><a class="dropdown-item" href="about.php">Sobre Comic web</a></li>';
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
                            Sobre Comic web</a>
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

        <div class="bg-image bg-attachment-fixed" style="background-image: url('assets/img/img_parallax.jpg');opacity: 0.8;">
            <br>
<div class="container" style="background-color: #00000000">                <div class="row justify-content-center">
                    <div class="col-lg-8 col-md-10">
                        <div class="card">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="user-info">
                                            <?php
                                            $dataUser = obtener_datos_usuario($email);
                                            $picture = $dataUser['userPicture'];
                                            $id_usuario = $dataUser['IDuser'];
                                            echo "<img class='img-profile img-circle img-responsive center-block w-100 h-auto' id='avatarUser' alt='Avatar' src='$picture' onclick='pictureProfileUser()'; />";
                                            ?>
                                            <ul class="meta list list-unstyled">
                                                <li class="name">
                                                    <label for="" style="font-size: 0.8em;">Nombre:</label>
                                                    <?php
                                                    $dataUser = obtener_datos_usuario($email);
                                                    $userName = $dataUser['userName'];
                                                    echo "$userName";
                                                    ?>
                                                </li>
                                                <li class="email">
                                                    <label for="" style="font-size: 0.8em;">Mail: </label>
                                                    <?php
                                                    $dataUser = obtener_datos_usuario($email);
                                                    $email = $dataUser['email'];
                                                    echo " " . "<span style='font-size: 0.7em'>$email</span>";
                                                    ?>
                                                </li>
                                                <li class="activity">
                                                    <label for="" style="font-size: 0.8em;">Ultima conexion: </label>
                                                    <?php
                                                    echo comprobar_ultima_conexion($id_usuario);
                                                    ?>
                                                </li>
                                            </ul>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-4">
                                                <div class="d-flex flex-column flex-shrink-0 p-3 bg-light" style="width: 280px;">
                                                    <ul class="nav nav-pills flex-column mb-auto">
                                                        <li class="nav-item">
                                                            <a href="infoPerfil.php" class="nav-link link-dark" aria-current="page">
                                                                <span class="fa fa-user"></span>&nbsp;Perfil</a>
                                                        </li>
                                                        <li>
                                                            <a href="solicitudes_amistad.php" class="nav-link link-dark">
                                                                <span class='fa fa-user'></span>&nbsp;Solicitudes de amistad</a>
                                                        </li>
                                                        <li>
                                                            <a href="lista_amigos.php" class="nav-link link-dark">
                                                                <span class='fa fa-user'></span>&nbsp;Mis amigos</a>
                                                        </li>
                                                        <li>
                                                            <a href="modificar_perfil.php" class="nav-link link-dark">
                                                                <span class="fa fa-cog"></span>&nbsp;Opciones</a>
                                                            </a>
                                                        </li>
                                                        <?php
                                                        if ($userPrivilege == 'user') {
                                                            echo '<li>
                                                            <a href="panel_tickets_user.php" class="nav-link link-dark">
                                                                <span class="fa fa-cog"></span>Tickets enviados</a>
                                                        </li>';
                                                        }
                                                        ?>
                                                        <li>
                                                            <a href="mensajes_usuario.php" class="nav-link active">
                                                                <span class="fa fa-cog"></span>Mis mensajes</a>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-8">
                                        <fieldset class="fieldset">
                                            <!-- AQUI VA EL CONTENIDO DE LOS MENSAJES -->
                                            <form class="form-horizontal" onsubmit="return false;" id="form-mensajes" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                                                <h3 class="fieldset-title">Mensajes</h3>
                                                <div id="mensajes-container"></div>
                                        </fieldset>
                                        </form>
                                        </fieldset>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
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
        </div>
        <script>
            $(document).ready(function() {
                $("#notificacion_mensajes").load("php/apis/notificacion_mensajes.php");
            });

            var procesando_mensaje = false;
            var mensaje_abierto_id = null;

            function toggleTicketInfo(id) {
                var header = document.getElementById('mensaje-header-' + id);
                var info = document.getElementById('mensaje-info-' + id);
                var arrow = header.querySelector('.arrow');
                modificar_estado_mensaje(id);
                $(document).ready(function() {
                    $("#notificacion_mensajes").load("php/apis/notificacion_mensajes.php");
                });
                if (mensaje_abierto_id && mensaje_abierto_id !== id) {
                    var headerAnterior = document.getElementById('mensaje-header-' + mensaje_abierto_id);
                    var infoAnterior = document.getElementById('mensaje-info-' + mensaje_abierto_id);
                    var arrowAnterior = headerAnterior.querySelector('.arrow');

                    infoAnterior.style.display = 'none';
                    arrowAnterior.innerHTML = '&#9654;';
                }

                if (info.style.display === 'block') {
                    // Si el elemento está abierto y hay un mensaje enviado, mantener la clase en block
                    if (document.querySelector(`#mensaje-info-${id} .mensaje-enviado`)) {
                        arrow.innerHTML = '&#9660;';
                        return;
                    }
                    // Si no hay mensaje enviado, ocultar el elemento
                    info.style.display = 'none';
                    arrow.innerHTML = '&#9654;';
                    mensaje_abierto_id = null;

                } else {
                    // Si el elemento está cerrado, mostrarlo
                    info.style.display = 'block';
                    arrow.innerHTML = '&#9660;';
                    mensaje_abierto_id = id;
                }
            }

            // Asignar la función a los eventos de clic de los headers de los tickets
            if (document.getElementById('mensajes-container')) {
                document.getElementById('mensajes-container').addEventListener('click', function(event) {
                    if (procesando_mensaje) return; // evitar que se ejecute el evento mientras se procesa un mensaje
                    var arrow = event.target.closest('.arrow');
                    if (arrow) {
                        var header = arrow.closest('.mensaje-header');
                        var id = header.id.replace('mensaje-header-', '');
                        toggleTicketInfo(id);

                    }
                });
            }
        </script>
        <script>
            function actualizarMensajes(id_conversacion, id_usuario_remitente) {
                $.ajax({
                    url: "php/apis/ver_mensajes_usuario.php",
                    method: 'POST',
                    data: {
                        id_usuario_destinatario: id_conversacion,
                        mensaje: ''
                    },
                    success: function(data) {
                        $('#mensaje-info-' + id_conversacion).html(data);
                        $("#mensajes-container").html(data);
                        $('#mensaje-info-' + id_conversacion).css('display', 'block');
                    }
                });
            }
            $(document).ready(function() {
                actualizarMensajes(0);
            });
            // Enviar mensaje mediante AJAX
            const mandar_mensaje_actualizacion = async (id_conversacion) => {
                var id_usuario_destinatario = document.querySelector("#id_usuario_destinatario-" + id_conversacion).value;
                var id_usuario_remitente = document.querySelector("#id_usuario_remitente-" + id_conversacion).value;
                var id_conversacion = document.querySelector("#id_conversacion-" + id_conversacion).value;
                var mensaje = document.querySelector("#mensaje_usuario_enviar-" + id_conversacion).value;

                if (mensaje.trim() === '') {
                    Swal.fire({
                        icon: "error",
                        title: "ERROR.",
                        text: "You have to fill all the camps",
                        footer: "Web Comics"
                    })
                    return;
                }

                //insert to data base in case of everything go correct.
                const data = new FormData();
                data.append('id_usuario_destinatario', id_usuario_destinatario);
                data.append("id_usuario_remitente", id_usuario_remitente);
                data.append("mensaje", mensaje);

                //pass data to php file
                var respond = await fetch("php/apis/new_mensaje.php", {
                    method: 'POST',
                    body: data
                });

                var result = await respond.json();

                if (result.success == false) {
                    document.querySelector('#form_mensaje').reset();
                    setTimeout(() => {
                        window.location.reload();
                    }, 2000);
                } else {
                    // Actualizar la lista de mensajes
                    $('#mensaje_usuario_enviar').val('');
                    $('#mensaje-info-' + id_conversacion).html(result.data);
                    // Esperar a que el contenido de mensaje-info-<id_conversacion> haya sido agregado al DOM
                    // y luego llamar a la función toggleTicketInfo() con el id de conversación correspondiente.
                    actualizarMensajes(id_conversacion, id_usuario_remitente);
                }
            }
        </script>


    </main>
</body>

</html>