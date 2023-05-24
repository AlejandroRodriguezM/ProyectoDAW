<?php
session_start();
include_once 'php/inc/header.inc.php';;
if (isset($_SESSION['email'])) {
    $email = $_SESSION['email'];
    $picture = pictureProfile($email);
    guardar_ultima_conexion($email);
    $userData = obtener_datos_usuario($email);
    $userName = $userData['userName'];
    $userPrivilege = $userData['privilege'];
    $id_usuario = $userData['IDuser'];
    $tipo_perfil = $userData['tipo_perfil'];

    $numero_comics = get_total_guardados($id_usuario);
    if (checkStatus($email)) {
        header("Location: usuario_bloqueado.php");
    }
    if (!comprobar_activacion($userName)) {
        header("Location: usuario_no_activado.php");
    }
    //echo "<input type='hidden' id='num_comics' value='$numero_comics'>";
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
    <link rel="stylesheet" href="./assets/style/sesion_caducada.css">
    <!-- <link rel="stylesheet" href="./assets/style/footer_style.css"> -->
    <link rel="stylesheet" href="./assets/style/novedades.css">
    <!-- <link rel="stylesheet" href="./assets/style/parallax.css"> -->
    <!-- <link rel="stylesheet" href="./assets/style/media_recomendaciones.css"> -->
    <link rel="stylesheet" href="./assets/style/media_videos.css">
    <!-- <link rel="stylesheet" href="./assets/style/media_barra_principal.css"> -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.3.0/css/font-awesome.min.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.3/font/bootstrap-icons.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js" integrity="sha384-oBqDVmMz9ATKxIep9tiCxS/Z9fNfEXiDAYTujMAeBAsjFuCZSmKbSSUnQlmh/jp3" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>

    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link rel="stylesheet" href="./assets/style/iconos_notificaciones.css">

    <script src="./assets/js/funciones_utilidades.js"></script>
    <script src="./assets/js/ajaxFunctions.js"></script>
    <script src="./assets/js/sweetalert2.all.min.js"></script>
    <script src="./assets/js/temporizador.js"></script>
    <title>Mis amigos</title>
    <style>
        .contenedor {
            width: 50% !important;
            overflow-x: auto;
            margin: 0 auto;
            padding-top: 30px;
            padding-bottom: 30px;
            border-radius: 30px;
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
                            <a class="nav-link" href="valoracion_comics.php" style='cursor:url(https://cdn.custom-cursor.com/db/cursor/32/Infinity_Gauntlet_Cursor.png) , default!important'>Mas populares</a>
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
                    <a class="list-group-item-action active" href="valoracion_comics.php"><i class='bi bi-person-circle p-1'></i>Mas populares</a>
                </li>
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
            <div class="container" style="background-color: #00000000">
                <div class="row justify-content-center">
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
                                                            <a href="lista_amigos.php" class="nav-link active ">
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
                                                            <a href="mensajes_usuario.php" class="nav-link link-dark">
                                                                <span class="fa fa-cog"></span>Mis mensajes</a>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-8">
                                        <!-- AQUI VA EL CONTENIDO DE LOS TICKETS -->
                                        <fieldset class="fieldset">
                                            <h3 class="fieldset-title">Lista de amigos</h3>
                                            <?php
                                            $num_usuarios_bloqueados = num_usuarios_bloqueados($id_usuario);
                                            $num_amigos = num_amigos($id_usuario);
                                            if ($num_usuarios_bloqueados > 0 || $num_amigos > 0) {
                                            ?>
                                                <div class="card-body">
                                                    <table class="table table-hover">
                                                        <thead class="table-dark">
                                                            <tr>
                                                                <td>Imagen de perfil</td>
                                                                <td>Nombre</td>
                                                                <td>Accion</td>
                                                                <td>Accion</td>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                        <?php
                                                        if ($num_usuarios_bloqueados > 0) {
                                                            $usuarios_bloqueados = usuarios_bloqueados($id_usuario);
                                                            foreach ($usuarios_bloqueados as $usuario_bloqueado) {
                                                                echo "<tr>";
                                                                $id_usuario_bloqueado = $usuario_bloqueado['id_usuario_bloqueado'];
                                                                $usuario_bloqueado_data = obtener_datos_usuario($id_usuario_bloqueado);
                                                                $email_user = $usuario_bloqueado_data['email'];
                                                                $imagen_usuario_bloqueado = $usuario_bloqueado_data['userPicture'];
                                                                $nombre_usuario_bloqueado = $usuario_bloqueado_data['userName'];
                                                                echo "<td><a href='infoUser.php?userName=$nombre_usuario_bloqueado'><img src='$imagen_usuario_bloqueado' style='width: 50px; height: 50px;'></a></td>";
                                                                echo "<td>$nombre_usuario_bloqueado</td>";
                                                                echo "<td><button class='btn btn-success' name='aceptar' onclick='desbloquear_usuario($id_usuario,$id_usuario_bloqueado); return false;'> <i class='bi bi-pencil-square p-1'></i>Desbloquear</button></td>";
                                                                echo "</tr>";
                                                            }
                                                        }


                                                        if ($num_amigos > 0) {
                                                            $amigos = amigos($id_usuario);
                                                            foreach ($amigos as $amigo) {
                                                                echo "<tr>";
                                                                $id_solicitante = $amigo['id_amigo'];
                                                                $dato_usuario = obtener_datos_usuario($id_solicitante);
                                                                $email_user = $dato_usuario['email'];
                                                                $nombre_solicitante = $dato_usuario['userName'];
                                                                $imagen_solicitante = $dato_usuario['userPicture'];

                                                                echo "<td><a href='infoUser.php?userName=$nombre_solicitante'><img src='$imagen_solicitante' style='width: 50px; height: 50px;'></a></td>";
                                                                echo "<td>$nombre_solicitante</td>";
                                                                echo "<td><button class='btn btn-success' name='aceptar' onclick='bloquear_usuario($id_usuario,$id_solicitante); return false;'> <i class='bi bi-pencil-square p-1'></i>Bloquear</button></td>";
                                                                echo "<td><button class='btn btn-danger' name='rechazar' onclick='eliminar_amigo($id_solicitante,$id_usuario); return false;'> <i class='bi bi-trash p-1'></i>Eliminar</button></td>";
                                                                echo "</tr>";
                                                            }
                                                        }
                                                    }
                                                        ?>

                                                        </tbody>
                                                    </table>
                                                </div>
                                        </fieldset>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- <div class="bgimg-2"> -->
            <script>
                // Función para mostrar y ocultar la conversación al hacer clic en el ticket
                function toggleTicketInfo(id) {
                    var header = document.getElementById('ticket-header-' + id);
                    var info = document.getElementById('ticket-info-' + id);
                    var arrow = header.querySelector('.arrow');
                    if (info.style.display === 'block') {
                        info.style.display = 'none';
                        arrow.innerHTML = '&#9654;';
                    } else {
                        info.style.display = 'block';
                        arrow.innerHTML = '&#9660;';
                    }
                }

                // Asignar la función a los eventos de clic de los headers de los tickets
                var headers = document.querySelectorAll('.ticket-header');
                for (var i = 0; i < headers.length; i++) {
                    headers[i].addEventListener('click', function() {
                        toggleTicketInfo(this.id.replace('ticket-header-', ''));
                    });
                }
            </script>
            <script>
                // Función para abrir el modal
                function openModal(modalId) {
                    var modal = document.querySelector('.modal-form' + modalId);
                    modal.style.display = "block";
                }

                // Función para cerrar el modal
                function closeModal(modalId) {
                    var modal = document.getElementById(modalId);
                    modal.style.display = "none";
                }

                // Botón para abrir el modal
                var btns = document.querySelectorAll(".btn-open-modal");
                btns.forEach(function(btn) {
                    btn.addEventListener("click", function() {
                        var modalId = btn.dataset.target;
                        openModal(modalId);
                    });
                });

                // Botón para cerrar el modal
                var closeBtns = document.querySelectorAll(".close-modal");
                closeBtns.forEach(function(closeBtn) {
                    closeBtn.addEventListener("click", function() {
                        var modalId = closeBtn.dataset.target;
                        closeModal(modalId);
                    });
                });

                // Cerrar el modal al hacer clic en cualquier parte de la pantalla
                var modals = document.querySelectorAll(".modal");
                modals.forEach(function(modal) {
                    window.addEventListener("click", function(event) {
                        if (event.target === modal) {
                            modal.style.display = "none";
                        }
                    });
                });
            </script>
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