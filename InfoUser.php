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

    if (checkStatus($email)) {
        header("Location: usuario_bloqueado.php");
    }
    if (!comprobar_activacion($userName)) {
        header("Location: usuario_no_activado.php");
    }
}

if (isset($_GET['userName'])) {
    $nombre_otro_usuario = $_GET['userName'];
    $data_otro_usuario = obtener_datos_usuario($nombre_otro_usuario);
    $id_otros_usuario = $data_otro_usuario['IDuser'];
    $numero_comics_otro_usuario = get_total_guardados($id_otros_usuario);
    $nombre_otro_usuario = $data_otro_usuario['userName'];
    $numero_listas_otro_usuario = num_listas_user($id_otros_usuario);
    $picture_otro_usuario = $data_otro_usuario['userPicture'];
} else {
    header("Location: index.php");
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="./assets/img/webico.ico" type="image/x-icon">
    <link rel="stylesheet" href="./assets/style/styleProfile.css">
    <link rel="stylesheet" href="./assets/style/stylePicture.css">
    <!-- <link rel="stylesheet" href="./assets/style/footer_style.css"> -->

    <link rel="stylesheet" href="./assets/style/sesion_caducada.css">
    <link rel="stylesheet" href="./assets/style/style.css">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link rel="stylesheet" href="./assets/style/iconos_notificaciones.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.3.0/css/font-awesome.min.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.3/font/bootstrap-icons.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js" integrity="sha384-oBqDVmMz9ATKxIep9tiCxS/Z9fNfEXiDAYTujMAeBAsjFuCZSmKbSSUnQlmh/jp3" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
    <script src="./assets/js/appLogin.js"></script>
    <script src="./assets/js/sweetalert2.all.min.js"></script>


    <script src="./assets/js/functions.js"></script>
    <script src="./assets/js/temporizador.js"></script>
    <title>Perfil de usuario</title>

    <style>
        .comics-lists {
            /* display: flex; */
            align-items: center;
        }

        .comics-lists p {
            display: block;
            margin: 0 10px;
            margin-bottom: 15px;
            font-size: 1.2em;
            line-height: 1.5em;
        }

        .comics-lists p:first-child {
            padding-left: 0;
        }

        .comics-lists p i {
            font-size: 1.5em;
            margin-right: 5px;
        }

        .icon {
            width: 70px;
            height: 70px;
        }

        .cancelar:hover {
            background-color: red !important;
            border-color: #ffc107 !important;
            color: white !important;
        }

        .cancelar:hover span {
            content: "";
            display: none;
        }

        .cancelar:hover:before {
            content: "Cancelar solicitud";
        }

        .cancelar:hover:after {
            content: "";
        }

        .amistad:hover {
            /* text-transform: uppercase; */
            background-color: red !important;
            border-color: #ffc107 !important;
            color: white !important;
        }

        .amistad:hover span {
            content: "";
            display: none;
        }

        .amistad:hover:before {
            content: "Dejar de ser amigo";

        }

        .amistad:hover:after {
            content: "";
        }

        .bloqueado:hover {
            /* text-transform: uppercase; */
            background-color: blue !important;
            border-color: #ffc107 !important;
            color: white !important;
        }

        .bloqueado:hover span {
            content: "";
            display: none;
        }

        .bloqueado:hover:before {
            content: "Desbloquear";

        }

        .bloqueado:hover:after {
            content: "";
        }

        html,
        body {
            margin: 0 !important;
            padding: 0 ;
            height: 100% !important;

        }

        main {

            min-height: 100vh !important;
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
                                    echo '
                                    </div>
                                    </li>';
                                    echo '<li><a class="dropdown-item" href="infoPerfil.php" class="text-muted">Mi perfil</a></li>';

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

            <div id="mensaje_privado" class="modal" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <form method="post" id="form_ticket" onsubmit="return false;">

                                <h4 class="modal-title">Mensaje para usuario <?php echo $nombre_otro_usuario ?></h4>
                        </div>
                        <div class="modal-body">
                            <div class="form-group">
                                <label>Mensaje</label>
                                <textarea class="form-control" id="mensaje_usuario_enviar" style="resize:none;"></textarea>
                                <?php
                                if (isset($_SESSION['email'])) {
                                    echo "<input type='hidden' id='id_usuario_remitente' value='$id_usuario'>";
                                    echo "<input type='hidden' id='id_usuario_destinatario' value='$id_otros_usuario'>";
                                }
                                ?>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <input type="button" class="btn btn-default" data-dismiss="modal" value="Cancelar">
                            <input type="submit" class="btn btn-info" value="Enviar ticket" onclick="mandar_mensaje()">
                        </div>
                        </form>
                    </div>
                </div>
            </div>
            <div id="denunciar_usuario" class="modal" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <form method="post" id="form_ticket" onsubmit="return false;">

                                <h4 class="modal-title">Denunciar usuario</h4>
                        </div>
                        <div class="modal-body">
                            <div class="form-group">
                                <label>Motivo de la denuncia</label>
                                <select class="form-control" id="motivo_denuncia">
                                    <option value="">Selecciona un motivo</option>
                                    <option value="acoso">Acoso</option>
                                    <option value="spam">Spam</option>
                                    <option value="contenido inapropiado">Contenido inapropiado</option>
                                    <option value="insultos">Insultos</option>
                                    <option value="otro">Otro motivo</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label>Añade mas contexto</label>
                                <textarea class="form-control" id="contexto_denuncia_usuario" style="resize:none;"></textarea>

                                <?php
                                echo "<input type='hidden' id='id_usuario_denunciante' value='$id_usuario'>";
                                echo "<input type='hidden' id='id_usuario_denunciado' value='$id_otros_usuario'>";
                                ?>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <input type="button" class="btn btn-default" data-dismiss="modal" value="Cancelar">
                            <input type="submit" class="btn btn-info" value="Enviar ticket" onclick="mandar_denuncia()">
                        </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="bg-image bg-attachment-fixed" style="background-image: url('assets/img/img_parallax.jpg');opacity: 0.8;">
                <br>
                <div class="container" style="background-color: #00000000">
                    <div class="row justify-content-center no-gutters row-cols-1">
                        <div class="col-lg-8 col-md-10">
                            <div class="card">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="user-info">
                                                <?php
                                                echo "<img class='img-profile img-circle img-responsive center-block w-100 h-auto' id='avatarUser' alt='Avatar' src='$picture_otro_usuario' onclick='pictureProfileUser()'; />";
                                                ?>
                                                <ul class="meta list list-unstyled">
                                                    <li class="name">
                                                        <label for="" style="font-size: 0.8em;">Nombre:</label>
                                                        <?php
                                                        echo $nombre_otro_usuario;
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
                                                            <li>
                                                                <a href="admin_info_usuario.php?id_usuario=<?php echo $id_usuario ?>" class="nav-link active">
                                                                    <span class='fa fa-user'></span>&nbsp;Perfil</a>
                                                            </li>
                                                            <li>
                                                                <a href="admin_actualizar_usuario.php?id_usuario=<?php echo $id_usuario ?>" class="nav-link link-dark">
                                                                    <span class='fa fa-user'></span>&nbsp;Editar</a>
                                                            </li>
                                                            <li>
                                                                <a href="admin_mensajes_usuarios.php?id_usuario=<?php echo $id_usuario ?>" class="nav-link link-dark ">
                                                                    <span class="fa fa-cog"></span>&nbsp;Mensajes</a>
                                                                </a>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-8">
                                            <fieldset class="fieldset">
                                                <h3 class="fieldset-title">Información
                                                    <div class="mb-3 d-flex flex-wrap justify-content-between align-items-center">
                                                        <div class="col-12 col-sm-4 col-md-2 mb-3 mb-sm-0">

                                                            <?php
                                                            if (isset($_SESSION['email'])) {
                                                                // Verificar si el usuario actual está bloqueado por el usuario que está viendo el perfil
                                                                if (comprobar_bloqueo($id_usuario, $id_otros_usuario)) {
                                                                    echo "<button class='btn btn-danger solicitud_enviada' onclick='' style='float:right;margin-right:10px'>Estás bloqueado</button>";
                                                                } else {
                                                                    // Código para enviar solicitudes y mostrar el estado de la amistad
                                                                    if (comprobar_amistad($id_otros_usuario, $id_usuario)) {
                                                                        echo "<button class='btn btn-success solicitud_enviada amistad' onclick='eliminar_amigo($id_otros_usuario,$id_usuario)' style='float:right'><span>Ya sois amigos</span></button>";
                                                                    } elseif (estado_solicitud($id_otros_usuario, $id_usuario) == 'cancelada') {
                                                                        echo '<button class="btn btn-primary solicitud_enviada" style="float:right">Te ha rechazado</button>';
                                                                    } elseif (!comprobar_bloqueo($id_otros_usuario, $id_usuario) && estado_solicitud($id_otros_usuario, $id_usuario) == 'en espera') {
                                                                        echo "<button class='btn btn-secondary solicitud_enviada cancelar' onclick='cancelar_solicitud($id_otros_usuario,$id_usuario)' style='float:right'><span>Solicitud enviada</span></button>";
                                                                    } else {
                                                                        if (estado_solicitud($id_usuario, $id_otros_usuario) == 'en espera') {
                                                                            echo "<button class='btn btn-danger solicitud_enviada' onclick='rechazar_solicitud($id_otros_usuario,$id_usuario)' style='float:right'><span>Rechazar solicitud</span></button>";
                                                                            echo "<button class='btn btn-primary solicitud_enviada' onclick='aceptar_solicitud($id_otros_usuario,$id_usuario)' style='float:right;margin-right:10px'><span>Aceptar solicitud</span></button>";
                                                                        } else if (!comprobar_bloqueo($id_otros_usuario, $id_usuario)) {
                                                                            echo "<button class='btn btn-primary solicitud_enviada' onclick='enviar_solicitud($id_otros_usuario,$id_usuario)' style='float:right;margin-right:10px'>Enviar solicitud</button>";
                                                                        }
                                                                    }
                                                                    echo "</div>";
                                                                    // Código para bloquear o desbloquear al usuario
                                                                    if (!comprobar_bloqueo($id_otros_usuario, $id_usuario)) {
                                                                        echo "<button class='btn btn-danger solicitud_enviada' onclick='bloquear_usuario($id_usuario,$id_otros_usuario)' style='float:right;margin-right:10px'><span>Bloquear usuario</span></button>";
                                                                    } else {
                                                                        echo "<button class='btn btn-warning solicitud_enviada' onclick='desbloquear_usuario($id_usuario,$id_otros_usuario)' style='float:right;margin-right:10px'><span>Desbloquear usuario</span></button>";
                                                                    }
                                                                }
                                                                echo "<button type='button' class='btn btn-warning solicitud_enviada' data-bs-toggle='modal' data-bs-target='#denunciar_usuario' style='cursor:url(https://cdn.custom-cursor.com/db/cursor/32/Infinity_Gauntlet_Cursor.png) , default!important;float:right;margin-right:10px'><span>Denunciar usuario</span></button>";
                                                            }
                                                            ?>
                                                        </div>

                                                </h3>

                                                <div class="form-group">
                                                    <?php
                                                    echo "<label>Nombre de usuario: </label>";
                                                    echo " " . "<span>$nombre_otro_usuario</span>";
                                                    ?>
                                                </div>
                                                <?php
                                                if (isset($_SESSION['email'])) {

                                                    // comprobar si el usuario actual está bloqueado por el usuario a mostrar
                                                    if (comprobar_bloqueo($id_otros_usuario, $id_usuario)) {
                                                        echo "<p>Este usuario te ha bloqueado</p>";
                                                    }
                                                    // comprobar si la cuenta del usuario a mostrar es privada y si el usuario actual no es amigo
                                                    elseif (tipo_privacidad($id_otros_usuario) == 'privado' && !comprobar_amistad($id_otros_usuario, $id_usuario)) {
                                                        echo "<p>Este usuario tiene la cuenta privada</p>";
                                                    }
                                                }
                                                // si no está bloqueado y la cuenta no es privada o si es amigo, mostrar la información
                                                else {
                                                    $infoUser = getInfoAboutUser($id_otros_usuario);
                                                    $nombre = $infoUser['nombreUser'];
                                                    $apellidos = $infoUser['apellidoUser'];
                                                    $fechaCreacion = $infoUser['fechaCreacion'];
                                                    $sobreUser = $infoUser['infoUser'];
                                                    echo '<div class="form-group">';
                                                    echo "<label>Nombre: </label>";
                                                    echo " " . "<span>$nombre</span>";
                                                    echo "<br>";
                                                    echo "<label>Apellidos: </label>";
                                                    echo " " . "<span>$apellidos</span>";
                                                    echo "<br>";
                                                    echo "<label>Fecha de creacion: </label>";
                                                    echo " " . "<span>$fechaCreacion</span>";
                                                    echo "<br>";
                                                    echo "<label>Sobre mi:</label><br>";
                                                    echo "<div class='col-xs-12'>";
                                                    echo "<textarea class='form-control' rows='4' style='resize:none; width:50%' readonly>$sobreUser</textarea>";
                                                    echo "</div>";
                                                    echo "</div>";
                                                }
                                                ?>
                                            </fieldset>
                                            <hr>
                                            <div class="comics-lists">
                                                <?php
                                                if (isset($_SESSION['email'])) {
                                                    // comprobar si el usuario actual está bloqueado por el usuario a mostrar
                                                    if (comprobar_bloqueo($id_otros_usuario, $id_usuario)) {
                                                        echo "<p>Este usuario te ha bloqueado</p>";
                                                    }
                                                    // comprobar si la cuenta del usuario a mostrar es privada y si el usuario actual no es amigo
                                                    elseif (tipo_privacidad($id_otros_usuario) == 'privado' && !comprobar_amistad($id_otros_usuario, $id_usuario)) {
                                                        echo "<p>Este usuario tiene la cuenta privada</p>";
                                                    }
                                                    // si no está bloqueado y la cuenta no es privada o si es amigo, mostrar la información
                                                    else {
                                                        if (comprobar_mensaje($id_otros_usuario, $id_usuario)) {
                                                            echo '<button class="btn btn-primary" onclick="location.href=\'./mensajes_usuario.php\'">Ver mensaje privado</button>';
                                                        } else {
                                                            // echo '<button class="btn btn-primary"></button>';
                                                            echo "<button type='button' class='btn btn-primary' data-bs-toggle='modal' data-bs-target='#mensaje_privado' style='cursor:url(https://cdn.custom-cursor.com/db/cursor/32/Infinity_Gauntlet_Cursor.png) , default!important'>Enviar mensaje privado</button>";
                                                        }
                                                ?>
                                                        <!-- boton para mandar mensaje privado  -->
                                                        <p>Numero de amigos: <?php echo num_amistades($id_otros_usuario) ?></p>
                                                        <a href='#' onclick="window.location.href='comics_usuario.php?id_usuario=<?php echo $id_otros_usuario ?>'; return false;">
                                                            <p><img class="icon" src="./assets/img/comic_usuario.png"><?php echo $numero_comics_otro_usuario; ?> comics guardados</p>
                                                        </a>
                                                        <a href='#' onclick="window.location.href='listas_usuarios.php?id_usuario=<?php echo $id_otros_usuario ?>'; return false;">
                                                            <p><img class="icon" src="./assets/img/libreria.png"><?php echo $numero_listas_otro_usuario; ?> listas</p>
                                                        </a>
                                                <?php
                                                    }
                                                }
                                                ?>

                                            </div>

                                        </div>
                                    </div>
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