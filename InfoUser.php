<?php
session_start();
include_once 'php/inc/header.inc.php';

checkCookiesUser();
$nombre_otro_usuario = $_GET['userName'];
$email = $_SESSION['email'];
guardar_ultima_conexion($email);
$userData = obtener_datos_usuario($nombre_otro_usuario);
$id_user = $userData['IDuser'];

if (isset($_POST['edit'])) {
    $email_user_edit = $_POST['emailUser'];
    $IDuser = $_POST['IDuser'];
    $passwordUser = obtain_password($email_user_edit);
    cookiesUserTemporal($email_user_edit, $passwordUser, $IDuser);
    header("Location: admin_actualizar_usuario.php");
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
    <link rel="stylesheet" href="./assets/style/footer_style.css">
    <link rel="stylesheet" href="./assets/style/parallax.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.3.0/css/font-awesome.min.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.3/font/bootstrap-icons.css">
    <title>Perfil de usuario</title>

    <style>
        .contenedor {
            width: 50% !important;
            overflow-x: auto;
            margin: 0 auto;
            padding-top: 30px;
            padding-bottom: 30px;
            border-radius: 30px;
        }

        .navbar {
            position: fixed;
            top: 0;
            width: 100%;
            z-index: 1000;
        }

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

        .solicitud_enviada {
            border-radius: 10px;
            margin-top: -10px;
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
                                    echo "<li><a class='dropdown-item' href='infoPerfil.php' style='cursor:url(https://cdn.custom-cursor.com/db/cursor/32/Infinity_Gauntlet_Cursor.png) , default!important'><i class='bi bi-person-circle p-1'></i>Ver tickets</a></li>";
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
                    <!-- <label class="search-click-label" style="display: flex !important;justify-content: center !important;align-items: center !important;cursor:url(https://cdn.custom-cursor.com/db/cursor/32/Infinity_Gauntlet_Cursor.png) , default!important"> -->
                    <input type="text" class="search-click mr-sm-3" name="search" placeholder="Buscador" id="search-data" style='cursor:url(https://cdn.custom-cursor.com/db/cursor/32/Infinity_Gauntlet_Cursor.png) , default!important' />
                    <!-- </label> -->
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
    <div class="card-footer text-muted">
        Design by Alejandro Rodriguez 2022
    </div>
    <div class="bgimg-1">
        <div class="caption">
            <br>
            <div class="contenedor mt-5">
                <div class="view-account" style="width:90%;justify-content: center;margin: 0 auto;">
                    <section class="module">
                        <div class="module-inner">
                            <div class="side-bar">
                                <div class="user-info">
                                    <?php
                                    $dataUser = obtener_datos_usuario($nombre_otro_usuario);
                                    $id_otro_usuario = $dataUser['IDuser'];
                                    $profilePicture = $dataUser['userPicture'];
                                    echo "<img class='img-profile img-circle img-responsive center-block' id='avatarUser' alt='Avatar' src='$profilePicture' onclick='pictureProfileUser()'; style='width:100%; height: 100%;' />";
                                    ?>

                                    <ul class="meta list list-unstyled">
                                        <li class="name"><label for="" style="font-size: 0.8em;">Nombre de usuario:</label>
                                            <?php
                                            $userName = $dataUser['userName'];
                                            echo "@$userName";
                                            ?>
                                        </li>
                                        <li class="activity">
                                            <label for="" style="font-size: 0.8em;">Ultima conexion: </label>
                                            <?php
                                            echo comprobar_ultima_conexion($id_otro_usuario);
                                            ?>
                                        </li>
                                    </ul>
                                </div>
                                <nav class="side-menu">
                                    <ul class="nav">
                                        <li class="active"><a href="infoPerfil.php"><span class="fa fa-user"></span>Perfil</a></li>
                                    </ul>
                                </nav>
                            </div>
                            <div class="content-panel">
                                <fieldset class="fieldset">

                                    <h3 class="fieldset-title">Información
                                        <?php
                                        // Verificar si el usuario actual está bloqueado por el usuario que está viendo el perfil
                                        if (comprobar_bloqueo($id_user, $id_otro_usuario)) {
                                            echo "<button class='btn btn-danger solicitud_enviada' onclick='' style='float:right;margin-right:10px'>Estás bloqueado</button>";
                                        } else {
                                            // Código para enviar solicitudes y mostrar el estado de la amistad
                                            if (comprobar_amistad($id_otro_usuario, $id_user)) {
                                                echo "<button class='btn btn-success solicitud_enviada amistad' onclick='eliminar_amigo($id_otro_usuario,$id_user)' style='float:right'><span>Ya sois amigos</span></button>";
                                            } elseif (estado_solicitud($id_otro_usuario, $id_user) == 'cancelada') {
                                                echo '<button class="btn btn-primary solicitud_enviada" style="float:right">Te ha rechazado</button>';
                                            } elseif (!comprobar_bloqueo($id_otro_usuario, $id_user) && estado_solicitud($id_otro_usuario, $id_user) == 'en espera') {
                                                echo "<button class='btn btn-secondary solicitud_enviada cancelar' onclick='cancelar_solicitud($id_otro_usuario,$id_user)' style='float:right'><span>Solicitud enviada</span></button>";
                                            } else {
                                                if (estado_solicitud($id_user, $id_otro_usuario) == 'en espera') {
                                                    echo "<button class='btn btn-danger solicitud_enviada' onclick='rechazar_solicitud($id_otro_usuario,$id_user)' style='float:right'><span>Rechazar solicitud</span></button>";
                                                    echo "<button class='btn btn-primary solicitud_enviada' onclick='aceptar_solicitud($id_otro_usuario,$id_user)' style='float:right;margin-right:10px'><span>Aceptar solicitud</span></button>";
                                                } else if (!comprobar_bloqueo($id_otro_usuario, $id_user)) {
                                                    echo "<button class='btn btn-primary solicitud_enviada' onclick='enviar_solicitud($id_otro_usuario,$id_user)' style='float:right;margin-right:10px'>Enviar solicitud</button>";
                                                }
                                            }

                                            // Código para bloquear o desbloquear al usuario
                                            if (!comprobar_bloqueo($id_otro_usuario, $id_user)) {
                                                echo "<button class='btn btn-danger solicitud_enviada' onclick='bloquear_usuario($id_user,$id_otro_usuario)' style='float:right;margin-right:10px'><span>Bloquear usuario</span></button>";
                                            } else {
                                                echo "<button class='btn btn-warning solicitud_enviada' onclick='desbloquear_usuario($id_user,$id_otro_usuario)' style='float:right;margin-right:10px'><span>Desbloquear usuario</span></button>";
                                            }
                                        }
                                        if ($userPrivilege == 'admin') {
                                        ?>
                                            <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" style='float:right'>
                                            <?php
                                            echo "<button class='btn btn-danger solicitud_enviada' name='edit' id='edit' style='float:right;margin-right:10px;'><span>Editar usuario</span></button>";
                                            echo "<td><input type='hidden' name='IDuser' id='IDuser' value='$id_otro_usuario'></td>";
                                            echo "<td><input type='hidden' name='nameUser' id='nameUser' value='$userName'></td>";
                                            echo "<td><input type='hidden' name='emailUser' id='emailUser' value='$nombre_otro_usuario'></td>";
                                            echo "</form>";
                                        }
                                            ?>
                                    </h3>

                                    <div class="form-group avatar">
                                    </div>

                                    <div class="form-group">
                                        <?php
                                        $userName = $dataUser['userName'];
                                        echo "<label>Nombre de usuario: </label>";
                                        echo " " . "<span>$userName</span>";
                                        ?>
                                    </div>
                                    <?php
                                    // comprobar si el usuario actual está bloqueado por el usuario a mostrar
                                    if (comprobar_bloqueo($id_otro_usuario, $id_user)) {
                                        echo "<p>Este usuario te ha bloqueado</p>";
                                    }
                                    // comprobar si la cuenta del usuario a mostrar es privada y si el usuario actual no es amigo
                                    elseif (tipo_privacidad($id_otro_usuario) == 'privado' && !comprobar_amistad($id_otro_usuario, $id_user)) {
                                        echo "<p>Este usuario tiene la cuenta privada</p>";
                                    }
                                    // si no está bloqueado y la cuenta no es privada o si es amigo, mostrar la información
                                    else {
                                        $infoUser = getInfoAboutUser($id_otro_usuario);
                                        $nombre = $infoUser['nombreUser'];
                                        $apellidos = $infoUser['apellidoUser'];
                                        $fechaCreacion = $infoUser['fechaCreacion'];
                                        $sobreUser = $infoUser['infoUser'];

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
                                    }
                                    ?>
                                </fieldset>
                                <hr>
                                <div class="comics-lists">
                                    <?php
                                    // comprobar si el usuario actual está bloqueado por el usuario a mostrar
                                    if (comprobar_bloqueo($id_otro_usuario, $id_user)) {
                                        echo "<p>Este usuario te ha bloqueado</p>";
                                    }
                                    // comprobar si la cuenta del usuario a mostrar es privada y si el usuario actual no es amigo
                                    elseif (tipo_privacidad($id_otro_usuario) == 'privado' && !comprobar_amistad($id_otro_usuario, $id_user)) {
                                        echo "<p>Este usuario tiene la cuenta privada</p>";
                                    }
                                    // si no está bloqueado y la cuenta no es privada o si es amigo, mostrar la información
                                    else {
                                    ?>
                                        <p>Numero de amigos: <?php echo num_amistades($id_otro_usuario) ?></p>
                                        <p><img class="icon" src="./assets/img/comic_usuario.png"> <?php echo get_total_guardados($id_otro_usuario); ?> comics guardados</p>
                                        <p><img class="icon" src="./assets/img/libreria.png"> <?php echo num_listas_user($id_otro_usuario); ?> listas</p>
                                    <?php
                                    }
                                    ?>

                                </div>
                    </section>
                </div>
            </div>


            <div class="bgimg-2">
                <div id="footer-lite">
                    <div class="content">
                        <p class="helpcenter"><a href="http://www.example.com/help">Ayuda</a></p>
                        <p class="legal"><a href="https://www.hoy.es/condiciones-uso.html?ref=https%3A%2F%2Fwww.google.com%2F">Condiciones de uso</a><span>·</span><a href="https://policies.google.com/privacy?hl=es">Política de privacidad</a><span>·</span><a class="cookies" href="https://www.doblemente.com/modelo-de-ejemplo-de-politica-de-cookies/">Mis cookies</a><span>·</span><a href="about.php">Quiénes somos</a></p>
                        <!-- add social media with icons -->
                        <p class="social">
                            <a href="https://github.com/AlejandroRodriguezM"><img src="./assets/img/github.png" alt="Github" width="50" height="50" target="_blank"></a> <a href="http://www.infojobs.net/alejandro-rodriguez-mena.prf"><img src="https://brand.infojobs.net/downloads/ij-logo_reduced/ij-logo_reduced.svg" alt="infoJobs" width="50" height="50" target="_blank"></a>

                        </p>
                        <p class="copyright">©2023 Alejandro Rodriguez</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js" integrity="sha384-oBqDVmMz9ATKxIep9tiCxS/Z9fNfEXiDAYTujMAeBAsjFuCZSmKbSSUnQlmh/jp3" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
    <script src="./assets/js/appLogin.js"></script>
    <script src="./assets/js/sweetalert2.all.min.js"></script>
    <script src="./assets/js/functions.js"></script>
</body>

</html>