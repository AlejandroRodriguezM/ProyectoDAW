<?php
session_start();
include_once 'php/inc/header.inc.php';


if (isset($_SESSION['email'])) {
    $email = $_SESSION['email'];
    guardar_ultima_conexion($email);
    $userData = obtener_datos_usuario($email);
    $userPrivilege = $userData['privilege'];
    $nombre_usuario = $userData['userName'];
    $id_user = $userData['IDuser'];
    $numero_comics = get_total_guardados($id_user);
}

$id_comic = $_GET['IDcomic'];
$data_comic = getDataComic($id_comic);
$profilePicture = $data_comic['Cover'];
$descripcion = get_descripcion($id_comic)['descripcion_comics'];
echo "<input type='hidden' id='num_comics' value=''>";

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
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.14.0/css/all.css" integrity="sha384-HzLeBuhoNPvSl5KYnjx0BT+WB0QEEqLprO+NBkkk5gbc67FTaL7XIGa2w1L0Xbgc" crossorigin="anonymous">

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js" integrity="sha384-oBqDVmMz9ATKxIep9tiCxS/Z9fNfEXiDAYTujMAeBAsjFuCZSmKbSSUnQlmh/jp3" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
    <script src="./assets/js/appLogin.js"></script>
    <script src="./assets/js/sweetalert2.all.min.js"></script>
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
        }

        span,
        label,
        a {
            color: black;
        }

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
            background-image: url('<?php echo $profilePicture ?>');
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

        .comment {
            border: 1px solid #ccc;
            padding: 10px;
            margin-bottom: 10px;
            display: block;
            clear: both;
        }

        .comment-info {
            max-width: 500px;
            /* o el ancho que desees */
        }

        .comment:not(:last-child) {
            border-bottom: none;
        }

        .comic_portada{
            margin-top: 20px;
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
                            if (isset($_SESSION['email'])) {
                                $userData = obtener_datos_usuario($email);
                                $userPrivilege = $userData['privilege'];
                                if ($userPrivilege == 'admin') {
                                    echo "<li><a class='dropdown-item' href='admin_panel_usuario.php' style='cursor:url(https://cdn.custom-cursor.com/db/cursor/32/Infinity_Gauntlet_Cursor.png) , default!important'><i class='bi bi-person-circle p-1'></i>Administracion</a></li>";
                                    echo "<li><a class='dropdown-item' href='infoPerfil.php' style='cursor:url(https://cdn.custom-cursor.com/db/cursor/32/Infinity_Gauntlet_Cursor.png) , default!important'><i class='bi bi-person-circle p-1'></i>Mi perfil</a></li>";
                                    echo "<li><a class='dropdown-item' href='panel_tickets_admin.php' style='cursor:url(https://cdn.custom-cursor.com/db/cursor/32/Infinity_Gauntlet_Cursor.png) , default!important'><i class='bi bi-person-circle p-1'></i>Ver tickets</a></li>";
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
                            if (isset($_SESSION['email'])) {
                            ?>
                                <li>
                                    <a class="dropdown-item" href="escribir_comentario_pagina.php" style='cursor:url(https://cdn.custom-cursor.com/db/cursor/32/Infinity_Gauntlet_Cursor.png) , default!important'><i class="bi bi-newspaper p-1"></i>
                                        Escribe tu opinión</a>
                                </li>
                            <?php
                            }
                            ?>


                            <?php
                            if (isset($_SESSION['email'])) {
                            ?>
                                <div class="dropdown-divider"></div>
                                <li>
                                    <button class="dropdown-item" onclick="closeSesion()" name="closeSesion" style='cursor:url(https://cdn.custom-cursor.com/db/cursor/32/Infinity_Gauntlet_Cursor.png) , default!important'><i class="bi bi-box-arrow-right p-1"></i>Cerrar sesion</a>
                                </li>
                            <?php
                            } else {
                            ?>
                                <li>
                                    <button class="dropdown-item" onclick="iniciar_sesion()" name="loginSesion" style='cursor:url(https://cdn.custom-cursor.com/db/cursor/32/Infinity_Gauntlet_Cursor.png) , default!important'><i class="bi bi-box-arrow-right p-1"></i>Iniciar sesion</a>
                                </li>
                            <?php
                            }
                            ?>
                        </ul>
                    </li>

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
                        <?php
                        if (isset($_SESSION['email'])) {
                        ?>
                            <a class="nav-link" href="novedades.php" style='cursor:url(https://cdn.custom-cursor.com/db/cursor/32/Infinity_Gauntlet_Cursor.png) , default!important'>Novedades</a>
                        <?php
                        } else {
                        ?>
                            <a class="nav-link" href="#" onclick="no_logueado()" style='cursor:url(https://cdn.custom-cursor.com/db/cursor/32/Infinity_Gauntlet_Cursor.png) , default!important'>Novedades</a>
                        <?php
                        }
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
                    $avatar = pictureProfile($email);

                    echo "<img src='$avatar' id='avatar' alt='Avatar' class='avatarPicture' onclick='pictureProfileAvatar()' style='cursor:url(https://cdn.custom-cursor.com/db/cursor/32/Infinity_Gauntlet_Cursor.png) , default!important'>";
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

    <div class="bgimg-1" style="background-image: url(<?php echo $profilePicture ?>);background-size: cover !important;">
        <br>
        <div class="caption">
            <div class="container mt-5" style="margin-top:auto !important;background-color:#ffffff88">
                <div class="view-account" style="background-color:#ffffff88">
                    <section class="module">
                        <div class="module-inner">
                            <div class="side-bar ">

                                <div class="user-info">
                                    <?php

                                    echo "<input type='hidden' id='id_comic' value='$id_comic'>";
                                    echo "<img class='img-profile img-circle img-responsive center-block comic_portada' id='avatarUser' alt='Avatar' src='$profilePicture' onclick='pictureProfileUser()'; style='width:120%; height: 120%;margin-left:-15px;' />";
                                    ?>

                                    <?php
                                    if (isset($_SESSION['email'])) {
                                        if (check_guardado($id_user, $id_comic)) {
                                            echo "<button id='myButton' class='active'></button>";
                                        }
                                    }
                                    // else {
                                    //     echo "<button id='myButton'></button>";
                                    // }
                                    ?>

                                </div>
                            </div>
                            <div class="content-panel ">
                                <fieldset class="fieldset">
                                    <h3 class="fieldset-title">Comic Info</h3>
                                    <div class="form-group avatar" style="background-color: grey">
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
                                        echo "<div class='comic-details'>";
                                        echo "  <div class='comic-detail'>";
                                        echo "    <label class='comic-label'>Nombre del comic: </label>";
                                        echo "    <span class='comic-value'><a href='search_data.php?search=" . $nombre . "'>$nombre</a></span>";
                                        echo "  </div>";
                                        echo "  <div class='comic-detail'>";
                                        echo "    <label class='comic-label'>Numero: </label>";
                                        echo "    <span class='comic-value'>$numero</span>";
                                        echo "  </div>";
                                        echo "  <div class='comic-detail'>";
                                        echo "    <label class='comic-label'>Variante: </label>";
                                        echo "    <span class='comic-value'>";
                                        $variantes = explode("-", $variante);
                                        foreach ($variantes as $variante) {
                                            echo "<a href='search_data.php?search=" . $variante . "'>$variante</a>";
                                        }
                                        echo "</span>";
                                        echo "  </div>";
                                        echo "  <div class='comic-detail'>";
                                        echo "    <label class='comic-label'>Formato: </label>";
                                        echo "    <span class='comic-value'><a href='search_data.php?search=" . $formato . "'>$formato</a></span>";
                                        echo "  </div>";
                                        echo "  <div class='comic-detail'>";
                                        echo "    <label class='comic-label'>Fecha de creacion: </label>";
                                        echo "    <span class='comic-value'><a href='search_data.php?search=" . $fechaCreacion . "'>$fechaCreacion</a></span>";
                                        echo "  </div>";
                                        echo "  <div class='comic-detail'>";
                                        echo "    <label class='comic-label'>Editorial: </label>";
                                        echo "    <span class='comic-value'><a href='search_data.php?search=" . $editorial . "'>$editorial</a></span>";
                                        echo "  </div>";
                                        echo "  <div class='comic-detail'>";
                                        echo "    <label class='comic-label'>Autor: </label>";
                                        echo "<span class='comic-value'>";
                                        $autores = explode("-", $autor);
                                        foreach ($autores as $autor) {
                                            echo "<a href='search_data.php?search=" . $autor . "'>$autor</a>";
                                        }
                                        echo "</span>";
                                        echo "  </div>";
                                        echo "  <div class='comic-detail'>";
                                        echo "    <label class='comic-label'>Dibujante: </label>";
                                        echo "<span class='comic-value'>";
                                        $dibujantes = explode("-", $dibujante);
                                        foreach ($dibujantes as $dibujante) {
                                            echo "<a href='search_data.php?search=" . $dibujante . "'>$dibujante</a>";
                                        }
                                        echo "</span>";
                                        echo "  </div>";
                                        echo "  <div class='comic-detail'>";
                                        echo "    <label class='comic-label'>Procedencia: </label>";
                                        echo "    <span class='comic-value'><a href='search_data.php?search=" . $procedencia . "'>$procedencia</a></span>";
                                        echo "  </div>";
                                        echo "  <div class='comic-detail'>";
                                        echo "    <label class='comic-label'>Valoracion media: </label>";
                                        $full_stars = floor($valoracion_media);
                                        $half_star = $valoracion_media - $full_stars >= 0.5 ? 1 : 0;
                                        $empty_stars = 5 - $full_stars - $half_star;
                                        for ($i = 0; $i < $full_stars; $i++) {
                                            echo '<i class="fas fa-star"></i>';
                                        }
                                        if ($half_star) {
                                            echo '<i class="fas fa-star-half-alt"></i>';
                                        }
                                        for ($i = 0; $i < $empty_stars; $i++) {
                                            echo '<i class="far fa-star"></i>';
                                        }
                                        echo "  </div>";
                                        echo "</div>";

                                        ?>
                                </fieldset>

                                <fieldset class="fieldset">
                                    <legend class="fieldset-title" style="font-size: 1.5em; font-weight: bold; margin-bottom: 10px;">Descripción del cómic</legend>
                                    <div class="form-group avatar" style="background-color: #ECECEC; border-radius: 10px; padding: 20px;">
                                        <div class="d-flex flex-column align-items-center">
                                            <p style="color: #4A4A4A; font-family: Comic Sans MS, cursive, sans-serif; font-size: 1.5em; line-height: 1.5em; text-align: justify;"><?php echo $descripcion ?></p>
                                        </div>
                                    </div>
                                </fieldset>

                                <div class="card">
                                    <div class="p-3">
                                        <h6>Opiniones</h6>
                                    </div>
                                    <form action="" method='POST' id='form_opinion' onsubmit="return false;" style="width:auto">
                                        <div class="d-flex flex-column form-color p-3">
                                            <div class="d-flex flex-wrap align-items-center">
                                                <?php
                                                if (isset($_SESSION['email'])) {
                                                    echo "<img src='" . $avatar . "' id='avatar' alt='Avatar' class='avatarPicture' onclick='pictureProfileAvatar()' style='cursor:url(https://cdn.custom-cursor.com/db/cursor/32/Infinity_Gauntlet_Cursor.png) , default!important'>";
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
                                                    echo "<input type='hidden' id='id_user_opinion' value='" . $id_user . "'>";
                                                    echo "<input type='hidden' id='id_comic' value='" . $id_comic . "'>";
                                                    echo "<button type='submit' class='btn btn-primary boton-enviar' onclick='nueva_opinion()'>Enviar</button>";
                                                    echo "</div>";
                                                }
                                                ?>

                                            </div>
                                        </div>
                                    </form>
                                    <div class="comentarios"></div>

                                </div>

                            </div>

                        </div>

                    </section>

                </div>

            </div>

            <div class='recomendaciones' id="index"></div>


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

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>

    <script>
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
        comics_recomendados();
        // Actualiza los comics recomendados cuando cambia el tamaño de la pantalla
        $(window).on('resize', function() {
            clearTimeout(resizeTimer);
            resizeTimer = setTimeout(comics_recomendados, 100);
        });
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
        const button = document.querySelector("#myButton");

        button.addEventListener("click", function() {
            const id_comic = document.querySelector("#id_comic").value;
            console.log(id_comic);

            if (button.classList.contains("active")) {
                // El botón está activo
                button.classList.remove("active");
                quitar_comic(id_comic);
            } else {
                // El botón está inactivo
                button.classList.add("active");
                guardar_comic(id_comic);
            }
        });
    </script>

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

</body>

</html>