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
    $numero_comics = get_total_guardados($id_usuario);
    $userName = $userData['userName'];
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
$userData = obtener_datos_usuario($email);
$id_usuario = $userData['IDuser'];
$id_lista = $_GET['id_lista'];
$data_lista =  get_nombre_lista($id_lista);
$nombre_lista = $data_lista['nombre_lista'];

if (!check_lista_user($id_usuario, $id_lista)) {
    header("Location: mis_listas.php");
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
    <!-- <link rel="stylesheet" href="./assets/style/parallax.css"> -->
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
    <title>Lista <?php echo $nombre_lista ?></title>
    <style>
        .custom-table {
            width: 300px;
            margin: 20px auto;
            border-collapse: collapse;
        }

        .custom-table th,
        .custom-table td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }

        .custom-table th {
            background-color: #ddd;
        }

        .expand-row {
            height: 0;
            overflow: hidden;
            transition: all 0.5s ease;
        }

        .custom-table tr:hover {
            background-color: #f5f5f5;
        }

        input[name='buscador_navegacion'] {
            width: 300px;
            height: 35px;
            padding: 5px;
            font-size: 16px;
            border-radius: 5px;
            border: 1px solid #ccc;
            margin-top: 20px;
            margin-left: 10px;
        }

        .side-bar {
            position: fixed;
            margin-top: -30px;
            color: black;
        }

        .view-account {
            position: fixed !important;
            top: 50px;
            z-index: 100;
            margin-top: 30px;
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



        .navigation-buttons button,
        .navigation-buttons_agregar button {
            background-color: #4CAF50;
            /* Fondo verde */
            color: white;
            /* Letras blancas */
            border: none;
            /* Sin borde */
            padding: 10px 16px;
            /* Espacio alrededor del texto */
            font-size: 16px;
            /* Tamaño de fuente */
            cursor: pointer;
            /* Cambia el cursor al pasar sobre el botón */
            margin-right: 10px;
            /* Margen entre botones */
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

<body class="d-flex flex-column min-vh-100" onload="checkSesionUpdate();showSelected();">
    <main class="flex-shrink-0">
        <div id="session-expiration">
            <div id="session-expiration-message">
                <p>Su sesión está a punto de caducar. ¿Desea continuar conectado?</p>
                <button id="session-expiration-continue-btn">Continuar</button>
                <button id="session-expiration-logout-btn">Cerrar sesión</button>
            </div>
        </div>

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
                                    <a class="nav-link active" aria-current="page" href="index.php" style='cursor:url(https://cdn.custom-cursor.com/db/cursor/32/Infinity_Gauntlet_Cursor.png) , default!important'>Inicio</a>
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
                                    <input type="text" class="search-click mr-sm-3" name="search" placeholder="Buscador" id="search-data" style='cursor:url(https://cdn.custom-cursor.com/db/cursor/32/Infinity_Gauntlet_Cursor.png) , default!important' />
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

                <!--Canvas imagen de menu-->
                <div class="offcanvas offcanvas-start offcanvas-static w-50 text-bg-dark" tabindex="-1" id="offcanvasExample" aria-labelledby="offcanvasExampleLabel">
                    <div class="offcanvas-header">
                        <h5 class="offcanvas-title" id="offcanvasExampleLabel">Menú</h5>
                        <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
                    </div>
                    <div class="offcanvas-body">
                        <ul class="navbar-nav justify-content-end flex-grow-1 pe-3">
                            <li>
                                <a class="dropdown-item" aria-current="page" href="index.php">Inicio</a>
                            </li>
                            <li>
                                <?php
                                if (isset($_SESSION['email'])) {
                                ?>
                                    <a class="dropdown-item" href="mi_coleccion.php">Mi colección</a>
                                <?php
                                } else {
                                ?>
                                    <a class="dropdown-item" href="#" onclick="no_logueado()">Mi colección</a>
                                <?php
                                }
                                ?>
                            </li>
                            <li>
                                <a class="dropdown-item" href="novedades.php">Novedades</a>
                            </li>
                            <li>
                                <?php
                                if (isset($_SESSION['email'])) {
                                    // Obtener el número de mensajes sin leer
                                    $num_solicitudes = obtener_numero_notificaciones_amistad_sin_leer($id_usuario);

                                    // Imprimir el enlace con el número de mensajes sin leer
                                    echo "<a class='dropdown-item' href='solicitudes_amistad.php'>";
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
                            <li>
                                <?php
                                if (isset($_SESSION['email'])) {
                                    // Obtener el número de mensajes sin leer
                                    $num_mensajes = obtener_numero_mensajes_sin_leer($id_usuario);

                                    // Imprimir el enlace con el número de mensajes sin leer
                                    echo "<a class='dropdown-item' href='mensajes_usuario.php'>";
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
                                <input type="text" class="search-click mr-sm-3" name="search" placeholder="Buscador" id="search-data" style='cursor:url(https://cdn.custom-cursor.com/db/cursor/32/Infinity_Gauntlet_Cursor.png) , default!important' />
                            </form>
                        </div>
                    </div>
                </div>

                <!-- The Modal -->
                <div id="myModal" class="modal modal_img" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                    <img class="modal-content_img" id="img01">
                </div>

                <div class="bg-image bg-attachment-fixed" style="background-image: url('assets/img/img_parallax.jpg');opacity: 0.8;">
                    <div class="caption">
                        <div class='filtrado_comics sticky-top '>
                            <!-- Aquí irían los acordeones -->
                        </div>
                    </div>

                    <div style="display: flex; justify-content: center;">
                        <div class="container mt-5">
                            <div class="last-pubs-1">
                                <br>
                                <div class="titulo" style="border-radius:10px">
                                    <input type='hidden' name='id_lista' id='id_lista' value='<?php echo $id_lista ?>'>
                                    <h2 style='text-align: center'>Lista <?php echo $nombre_lista  ?></h2>
                                </div>
                                <br>
                            </div>
                        </div>
                    </div>



                    <?php

                    if (get_total_guardados($id_usuario) > 0) {
                    ?>
                        <div style="display: flex; justify-content: center;">
                            <div class="container mt-5">
                                <div class="last-pubs-2">
                                    <br>
                                    <div class="titulo" style="border-radius:10px">
                                        <h2 style='text-align: center'>Mis comics</h2>
                                        <input type='hidden' name='id_lista' id='id_lista' value='<?php echo $id_lista ?>'>
                                    </div>
                                    <br>
                                </div>
                            </div>
                        </div>

                    <?php
                    } else {
                    ?>
                        <div class='recomendaciones'>

                        </div>
                    <?php
                    }
                    ?>

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
                    var limit_agregar = 16;
                    var offset_agregar = 0;

                    var limit_lista = 16;
                    var offset_lista = 0;

                    var totalComics;
                    var checkboxChecked = null;
                    actualizar_filtrado()
                    $('input[type=checkbox]').on('change', function() {
                        if ($(this).prop('checked') != true) {
                            checkboxChecked = null;
                        }
                    });

                    $(document).ready(function() {
                        loadComics();
                        addComic();
                        comics_recomendados()
                    });
                    var id_lista = document.querySelector('#id_lista').value;


                    function loadComics(offset_lista = 0) {

                        var selectedCheckboxes = $("input[type='checkbox']:checked").map(function() {
                            return encodeURIComponent(this.value);
                        }).get();

                        var data = {
                            limit: limit_lista,
                            offset: offset_lista,
                            id_lista: id_lista
                        };

                        if (selectedCheckboxes.length > 0) {
                            data.checkboxChecked = selectedCheckboxes.join(",");
                        }
                        $.ajax({

                            url: "php/apis/comics_lista.php",
                            data: data,
                            success: function(data) {
                                totalComics = $(data).filter("#total-comics").val();

                                // Elimina la lista anterior antes de agregar la nueva
                                if (offset_lista == 0) {
                                    // $('.new-comic-list').html('');
                                    $('.comic-list').html('');
                                    addComic()
                                }
                                $('<div class="comic-list"><ul class="v2-cover-list" id="comics-list">' + data + '</ul></div>').appendTo('.last-pubs-1');
                            }
                        });
                    }

                    function addComic(offset_agregar = 0) {
                        // offset = offset;

                        var selectedCheckboxes = $("input[type='checkbox']:checked").map(function() {
                            return encodeURIComponent(this.value);
                        }).get();

                        var data = {
                            limit: limit_agregar,
                            offset: offset_agregar,
                            id_lista: id_lista
                        };

                        if (selectedCheckboxes.length > 0) {
                            data.checkboxChecked = selectedCheckboxes.join(",");
                        }

                        $.ajax({
                            url: "php/apis/comics_user_agregar.php",
                            data: data,
                            success: function(data) {
                                totalComics = $(data).filter("#total-comics").val();

                                // Elimina la lista anterior antes de agregar la nueva
                                if (offset_agregar == 0) {
                                    $('.new-comic-list').html('');

                                    // loadComics()
                                }
                                $('<div class="new-comic-list" id="contenido"><ul class="v2-cover-list" id="comics-list">' + data + '</ul></div>').appendTo('.last-pubs-2');
                            }
                        });
                    }

                    var resizeTimer;

                    function comics_recomendados() {
                        // Obtener ancho de la ventana y calcular el número de cómics que se mostrarán
                        var width = $(window).width();
                        var num_comics = Math.max(3, Math.min(8, Math.floor(width / 300))); // Suponiendo que cada cómic tiene un ancho de 300px y se muestra un máximo de 8 cómics

                        var data = {
                            num_comics: num_comics
                        };
                        $.ajax({
                            url: "php/apis/recomendaciones_comics.php",
                            data: data,
                            success: function(data) {
                                // Calcular el ancho del contenedor "container mt-5" y establecerlo
                                var container_width = Math.max(300 * num_comics, 960); // Establecer un ancho mínimo de 960px
                                $('.container.mt-5').css('width', container_width + 'px');

                                totalComics = $(data).filter("#total-comics").val();

                                // Elimina la lista anterior antes de agregar la nueva
                                $('.recomendaciones').html('');
                                $(data).appendTo('.recomendaciones');
                            }
                        });
                    }
                    // Actualiza los comics recomendados cuando cambia el tamaño de la pantalla
                    $(window).on('resize', function() {
                        clearTimeout(resizeTimer);
                        resizeTimer = setTimeout(comics_recomendados, 100);
                    });
                </script>
                <script>
                    function toggleDropdown(element) {
                        var dropdownContent1 = document.getElementById("dropdownContent1");
                        var dropdownContent2 = document.getElementById("dropdownContent2");
                        var dropdownContent3 = document.getElementById("dropdownContent3");
                        var dropdownContent4 = document.getElementById("dropdownContent4");

                        if (element.querySelector(".dropdown-content").style.display === "block" && event.target.tagName !== 'INPUT') {
                            dropdownContent1.style.display = "none";
                            dropdownContent2.style.display = "none";
                            dropdownContent3.style.display = "none";
                            dropdownContent4.style.display = "none";
                        } else {
                            dropdownContent1.style.display = "none";
                            dropdownContent2.style.display = "none";
                            dropdownContent3.style.display = "none";
                            dropdownContent4.style.display = "none";
                            element.querySelector(".dropdown-content").style.display = "block";
                        }
                    }

                    function closeDropdown(dropdownContent) {
                        dropdownContent.style.display = "none";
                    }

                    document.addEventListener("click", function(event) {
                        var dropdowns = document.getElementsByClassName("dropdown-content");
                        for (var i = 0; i < dropdowns.length; i++) {
                            var dropdown = dropdowns[i];
                            if (event.target.closest(".dropdown") !== dropdown.parentNode && event.target !== dropdown.parentNode) {
                                dropdown.style.display = "none";
                            }
                        }
                    });
                </script>

                <script>
                    function searchData(id) {
                        let input, filter, table, tr, td, i, txtValue;
                        input = document.getElementById("searchInput" + id);
                        filter = input.value.toUpperCase();
                        table = document.getElementById("dropdownContent" + id);
                        tr = table.getElementsByTagName("tr");
                        for (i = 0; i < tr.length; i++) {
                            td = tr[i].getElementsByTagName("td")[0];
                            if (td) {
                                txtValue = td.textContent || td.innerText;
                                if (txtValue.toUpperCase().indexOf(filter) > -1) {
                                    tr[i].style.display = "";
                                } else {
                                    tr[i].style.display = "none";
                                }
                            }
                        }
                    }
                </script>




            </main>
        </body>

</html>