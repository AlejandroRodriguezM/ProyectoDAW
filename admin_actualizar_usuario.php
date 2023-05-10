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
    if ($userPrivilege == 'admin') {
        $id_usuario = $userData['IDuser'];
        $numero_comics = get_total_guardados($id_usuario);

        $privilegio_admin = $userData['privilege'];
        //echo "<input type='hidden' id='num_comics' value='$numero_comics'>";
    } else {
        header('Location: logOut.php');
    }
    if (!comprobar_activacion($userName)) {
        header("Location: usuario_no_activado.php");
    }
} else {
    header('Location: logOut.php');
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
    <link rel="stylesheet" href="./assets/style/style.css">
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
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js" integrity="sha384-oBqDVmMz9ATKxIep9tiCxS/Z9fNfEXiDAYTujMAeBAsjFuCZSmKbSSUnQlmh/jp3" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>

    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link rel="stylesheet" href="./assets/style/iconos_notificaciones.css">

    <script src="./assets/js/functions.js"></script>
    <script src="./assets/js/appLogin.js"></script>
    <script src="./assets/js/sweetalert2.all.min.js"></script>
    <script src="./assets/js/temporizador.js"></script>
    <title>Editar datos usuario</title>

    <style>
        .contenedor {
            width: 50% !important;
            overflow-x: auto;
            margin: 0 auto;
            padding-top: 30px;
            padding-bottom: 30px;
            border-radius: 30px;
        }

        .botones {
            display: flex;
            margin-bottom: 15px;
            font-size: 1.2em;
            line-height: 1.5em;
            /* margin-right:30px; */
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

<?php
if (isset($_GET['id_usuario'])) {
    $id_usuario = $_GET['id_usuario'];
    $dataUser = obtener_datos_usuario($id_usuario);
    $emailUser = $dataUser['email'];
    $picture = $dataUser['userPicture'];
    $usuario_nick = $dataUser['userName'];
    $userPrivilege = $dataUser['privilege'];
    $infoUser = getInfoAboutUser($id_usuario);
    $nombre_usuario = $infoUser['nombreUser'];
    $apellido_usuario = $infoUser['apellidoUser'];
} else {
    $emailUser = $_POST['email'];
    $nameUser = $_POST['name'];
    $id_usuario = $_POST['IDuser'];
    $password = $_POST['password'];
}

if (isset($_POST['adminPanel'])) {
    header('Location: admin_panel_usuario.php');
}
?>

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
                            echo '<li class="list-group-item list-group-item-action">
                                            <div class="d-flex align-items-center">';
                            echo "<img src=$picture id='avatar' alt='Avatar' class='avatarPicture me-2' style='cursor:url(https://cdn.custom-cursor.com/db/cursor/32/Infinity_Gauntlet_Cursor.png) , default!important;'>";
                            echo "<div class='fw-bold'>$userName</div>";
                            echo '
                                    </div>
                                    </li>';
                            echo '<li class="list-group-item list-group-item-action"><a class="list-group-item-action active" href="infoPerfil.php" ><i class="fa fa-cog fa-fw"></i>Mi perfil</a></li>';
                            echo '<li class="list-group-item list-group-item-action"><a class="list-group-item-action active" href="#">Enviar un ticket</a></li>';
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

        <div class="bg-image bg-attachment-fixed" style="background-image: url('assets/img/img_parallax.jpg');opacity: 0.8;">
            <br>
            <div class="contenedor mt-5">
                <div class="view-account" style="width:90%;justify-content: center;margin: 0 auto;">
                    <section class="module">
                        <div class="module-inner">
                            <div class="side-bar">
                                <div class="user-info">
                                    <?php

                                    echo "<img class='img-profile img-circle img-responsive center-block' id='avatarUser' alt='Avatar' src='$picture' onclick='pictureProfileUser()'; style='width:100%; height: 100%;' />";
                                    ?>
                                    <ul class="meta list list-unstyled">
                                        <li class="name"><label for="" style="font-size: 0.8em;">Nombre:</label>
                                            <?php

                                            echo $usuario_nick;
                                            ?>
                                        </li>
                                        <li class="email"><label for="" style="font-size: 0.8em;">Mail: </label>
                                            <?php
                                            echo " " . "<span style='font-size: 0.7em'>$emailUser</span>";
                                            ?>
                                        </li>
                                        <li class="activity"><label for="" style="font-size: 0.8em;">Ultima conexion: </label>
                                            <?php
                                            echo comprobar_ultima_conexion($id_usuario);
                                            ?>
                                        </li>
                                    </ul>
                                </div>
                                <nav class="side-menu">
                                    <ul class="nav">
                                        <li onclick="window.location.href='admin_info_usuario.php?id_usuario=<?php echo $id_usuario ?>'; return false;"><a href="#"><span class="fa fa-user"></span>Perfil</a></li>
                                        <li class='active' onclick="window.location.href='admin_actualizar_usuario.php?id_usuario=<?php echo $id_usuario ?>'; return false;"><a href="#"><span class="fa fa-cog"></span>Editar</a></li>
                                        <li onclick="window.location.href='admin_mensajes_usuarios.php?id_usuario=<?php echo $id_usuario ?>'; return false;"><a href="#"><span class="fa fa-envelope"></span>Mensajes</a></li>
                                    </ul>
                                </nav>
                            </div>
                            <div class="content-panel">
                                <form class="form-horizontal" id="formUpdate" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                                    <fieldset class="fieldset">
                                        <h3 class="fieldset-title">Información</h3>
                                        <div class="form-group avatar" style="width: 420px;">
                                            <figure>

                                                <div class="image-upload">
                                                    <label for="file-input"></label>
                                                    <?php
                                                    echo "<img class='chosenUserProfile mb-2' id='output' src='$picture' style='cursor:url(https://cdn.custom-cursor.com/db/pointer/32/Infinity_Gauntlet_Pointer.png) , pointer!important '/>";
                                                    ?>
                                            </figure>
                                            <div class="form-inline col-md-10 col-sm-9 col-xs-12">
                                                <input class="form-control" type="file" name="file-input" id="file-input" accept=".jpg, .png" onchange="loadFile(event)" style="cursor:url(https://cdn.custom-cursor.com/db/pointer/32/Infinity_Gauntlet_Pointer.png) , pointer!important ">
                                            </div>
                                        </div>
                                        <?php
                                        $id_usuario = $dataUser['IDuser'];
                                        ?>
                                        <div class="form-group" style="margin-top: 5px;">
                                            <label class="col-md-2 col-sm-3 col-xs-12 control-label" style="width: 350px;">Nombre de usuario:</label>
                                            <div class="col-md-10 col-sm-9 col-xs-12" style="width: 350px;">
                                                <input type="text" class="form-control" name="nombre_cuenta" id="nombre_cuenta" value="<?php echo $usuario_nick ?>" style="cursor:url(https://cdn.custom-cursor.com/db/pointer/32/Infinity_Gauntlet_Pointer.png) , pointer!important ">
                                            </div>
                                        </div>

                                        <div class="form-group" style="margin-top: 5px;">
                                            <label class="col-md-2 col-sm-3 col-xs-12 control-label">Nombre:</label>
                                            <div class="col-md-10 col-sm-9 col-xs-12" style="width: 350px;">

                                                <input type="text" class="form-control" id="nombre_usuario" value="<?php echo $nombre_usuario ?>" placeholder="Enter your name" style="cursor:url(https://cdn.custom-cursor.com/db/pointer/32/Infinity_Gauntlet_Pointer.png) , pointer!important ">
                                            </div>
                                        </div>

                                        <div class="form-group" style="margin-top: 5px;">
                                            <label class="col-md-2 col-sm-3 col-xs-12 control-label">Apellido:</label>
                                            <div class="col-md-10 col-sm-9 col-xs-12" style="width: 350px;">
                                                <input type="text" class="form-control" id="apellido_usuario" value="<?php echo $apellido_usuario ?>" placeholder="Enter your name" style="cursor:url(https://cdn.custom-cursor.com/db/pointer/32/Infinity_Gauntlet_Pointer.png) , pointer!important ">
                                            </div>
                                        </div>

                                        <div class="form-group" style="margin-top: 5px;">
                                            <label class="col-md-2 col-sm-3 col-xs-12 control-label">Email</label>
                                            <div class="col-md-10 col-sm-9 col-xs-12" style="width: 350px;">
                                                <input type="text" class="form-control" name="email" id="email_usuario" value="<?php echo $emailUser ?>" style="cursor:url(https://cdn.custom-cursor.com/db/pointer/32/Infinity_Gauntlet_Pointer.png) , pointer!important ">
                                                <input type='hidden' name='id_usuario' id='id_usuario' value='<?php echo $id_usuario ?>' ; </div>
                                            </div>
                                    </fieldset>
                                    <hr>
                                    <div class="mb-3">
                                        <div class="col-md-5 col-sm-9 col-xs-12 col-md-push-2 col-sm-push-3 col-xs-push-0 botones">
                                            <input type='hidden' name='email_usuario' id='email_usuario' value='<?php echo $email ?>'>
                                            <input class="btn btn-primary" type="button" onclick="modificar_usuario_administrador();" value="Actualizar perfil" style="cursor:url(https://cdn.custom-cursor.com/db/pointer/32/Infinity_Gauntlet_Pointer.png) , pointer!important;margin-right:10px;">

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
                                                document.getElementById('file-input').addEventListener('change', handleFileSelect, false);
                                            </script>
                                        </div>
                                        <?php
                                        if ($userPrivilege != 'admin') {
                                            echo '<input class="btn btn-danger" type="button" value="Desactivar usuario" style="cursor:url(https://cdn.custom-cursor.com/db/pointer/32/Infinity_Gauntlet_Pointer.png), pointer!important;">';
                                        } else {
                                            echo '<input class="btn btn-danger" type="button" value="Desactivar usuario" style="cursor:url(https://cdn.custom-cursor.com/db/pointer/32/Infinity_Gauntlet_Pointer.png), pointer!important;" disabled>';
                                        }
                                        ?>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </section>
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
        </div>

    </main>
</body>

</html>