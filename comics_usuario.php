<?php
session_start();
include_once 'php/inc/header.inc.php';


if (isset($_SESSION['email'])) {
    $email = $_SESSION['email'];
    $picture = pictureProfile($email);
    guardar_ultima_conexion($email);
    $userData = obtener_datos_usuario($email);
    $userPrivilege = $userData['privilege'];
    $mi_id = $userData['IDuser'];
    $id_usuario = $_GET['id_usuario'];
    $datos_usuario = obtener_datos_usuario($id_usuario);
    $nombre_usuario = $datos_usuario['userName'];

    $numero_comics = get_total_guardados($id_usuario);
    // 
    if (checkStatus($email)) {
        header("Location: usuario_bloqueado.php");
    }
    if(!comprobar_activacion($nombre_usuario)){
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
    <link rel="stylesheet" href="./assets/style/bandeja_comics.css">
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
    <link rel="stylesheet" href="./assets/style/style.css">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link rel="stylesheet" href="./assets/style/iconos_notificaciones.css">

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js" integrity="sha384-oBqDVmMz9ATKxIep9tiCxS/Z9fNfEXiDAYTujMAeBAsjFuCZSmKbSSUnQlmh/jp3" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>

    <script src="./assets/js/functions.js"></script>
    <script src="./assets/js/appLogin.js"></script>
    <script src="./assets/js/sweetalert2.all.min.js"></script>
    <script src="./assets/js/temporizador.js"></script>
    <title>Comics de <?php echo $nombre_usuario ?></title>
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

        .last-pubs2 {
            position: relative;
            padding: 10px;
            /* background-color: #fff; */
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
            border-radius: 5px;
        }

        .ver-mas-btn {
            position: absolute;
            bottom: 60%;
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

        .container {
            padding: 30px;
        }
        body {
            margin: 0 !important;
            padding: 0 !important;
            height: 100% !important;
            overflow-y: scroll !important; /* Habilita el scroll vertical */

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
            <div class="caption">
                <div class='filtrado_comics sticky-top '>
                    <!-- Aquí irían los acordeones -->
                </div>
            </div>
            <input type='hidden' id='num_comics' value='<?php echo $numero_comics ?>'>
            <div style="display: flex; justify-content: center;">
                <div class="container mt-5">
                    <div class="last-pubs1">
                        <br>
                        <div class="titulo" style="border-radius:10px">
                            <h2 style='text-align: center'>Mis comics</h2>
                        </div>
                        <br>
                    </div>
                </div>
            </div>

                        <div class="container mt-5">
                <div class="d-flex justify-content-center">
                    <div class="last-pubs2 comics">
                    </div>
                </div>
            </div>

            </div>

            <div class="container mt-5">
                <div class="titulo">
                    <h2>Videos de interes</h2>
                </div>
                <hr>
                <div class="video-container">
                    <iframe width="560" height="315" src="https://www.youtube.com/embed/1Rx_p3NW7gQ" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                    <iframe width="560" height="315" src="https://www.youtube.com/embed/rYy0o-J0x20" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                    <iframe width="560" height="315" src="https://www.youtube.com/embed/1Rx_p3NW7gQ" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                </div>
            </div>
            <!-- <div class="bgimg-2"> -->
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
        var limit = 8;
        var offset = 0;
        var totalComics = 0;
        var checkboxChecked = null;
        const num_comics = document.querySelector("#num_comics").value;

        $('input[type=checkbox]').on('change', function() {
            if ($(this).prop('checked') != true) {
                checkboxChecked = null;

            }
        });
        loadComics(offset);


        function loadComics(offset = 0) {
            var selectedCheckboxes = $("input[type='checkbox']:checked").map(function() {

                return encodeURIComponent(this.value);
            }).get();

            var data = {
                limit: limit,
                offset: offset
            };

            if (selectedCheckboxes.length > 0) {
                data.checkboxChecked = selectedCheckboxes.join(",");
            }

            $.ajax({
                url: "php/apis/comics_otro_usuario.php",
                data: data,
                success: function(data) {
                    totalComics = $(data).filter("#total-comics").val();
                    if (offset == 0) {
                        $('.new-comic-list').html('');
                    }
                    $('<div class="new-comic-list"><ul class="v2-cover-list" id="comics-list">' + data + '</ul></div>').appendTo('.last-pubs1');
                }
            });
        }
    </script>

    </main>
</body>

</html>