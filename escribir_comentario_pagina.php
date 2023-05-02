<?php
session_start();
include_once 'php/inc/header.inc.php';


if (isset($_SESSION['email'])) {
    $email = $_SESSION['email'];
    guardar_ultima_conexion($email);
    $userData = obtener_datos_usuario($email);
    $userPrivilege = $userData['privilege'];
    $id_usuario = $userData['IDuser'];
    $name = $userData['userName'];

    $numero_comics = get_total_guardados($id_usuario);
    //echo "<input type='hidden' id='num_comics' value='$numero_comics'>";
    if (checkStatus($email)) {
        header("Location: usuario_bloqueado.php");
    }
    if(!comprobar_activacion($name)){
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
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="shortcut icon" href="./assets/img/webico.ico" type="image/x-icon">
    <link rel="stylesheet" href="./assets/style/styleProfile.css">
    <link rel="stylesheet" href="./assets/style/stylePicture.css">
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
    <link rel="stylesheet" href="./assets/style/style.css">

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js" integrity="sha384-oBqDVmMz9ATKxIep9tiCxS/Z9fNfEXiDAYTujMAeBAsjFuCZSmKbSSUnQlmh/jp3" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>

    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link rel="stylesheet" href="./assets/style/iconos_notificaciones.css">

    <script src="./assets/js/functions.js"></script>
    <script src="./assets/js/appLogin.js"></script>
    <script src="./assets/js/sweetalert2.all.min.js"></script>
    <script src="./assets/js/temporizador.js"></script>
    <title>Escribe tu comentario</title>
    <style>
        .row {
            display: flex;
            flex-wrap: wrap;
        }

        #wrapper.home div.comments {
            padding-right: 20px;
            line-height: 140%;
        }

        .link-grey:hover {
            color: #00913b;
        }

        .last-pubs2 {
            position: relative;
            padding: 20px;
            background-color: #B5B2B2;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
            border-radius: 5px;
            margin-bottom: 70px;
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
                        <a class="nav-link" aria-current="page" href="index.php" style='cursor:url(https://cdn.custom-cursor.com/db/cursor/32/Infinity_Gauntlet_Cursor.png) , default!important'>Inicio</a>
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
                        ?>
                    </li>
                    <li class="nav-item">
                        <?php
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
                    $picture = pictureProfile($email);
                    echo "<img src='$picture' id='avatar' alt='Avatar' class='avatarPicture' onclick='pictureProfileAvatar()' style='cursor:url(https://cdn.custom-cursor.com/db/cursor/32/Infinity_Gauntlet_Cursor.png) , default!important'>";
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
    <div class="card-footer text-muted">
        Design by Alejandro Rodriguez 2022
    </div>
    <div class="bgimg-1">
        <div class="caption">
            <br>
            <div class="container mt-5">
                <div style="display: flex; justify-content: center;">
                    <div class="last-pubs2 col-md-8">
                        <div class="headings ">
                            <h6>Escribe tu opinión</h6>
                        </div>
                        <form action="" method='POST' id='form_opinion' onsubmit="return false;" style="width:auto">
                            <div class="d-flex flex-column form-color p-3">
                                <div class="d-flex flex-wrap align-items-center">
                                    <img src='<?php echo $picture ?>' id='avatar' alt='Avatar' class='avatarPicture' onclick='pictureProfileAvatar()' style='cursor:url(https://cdn.custom-cursor.com/db/cursor/32/Infinity_Gauntlet_Cursor.png) , default!important'>
                                    <div class="pr-2">
                                        <h6 class="mb-0" style="margin-left:10px"><?php echo $name ?></h6>
                                    </div>
                                    <textarea id='opinion' class="form-control mt-2" placeholder="Pon tu comentario..." style="width: 100% !important; height: 110px !important; resize: none !important;"></textarea>
                                    <div class="boton-enviar d-flex flex-wrap align-items-center justify-content-end">
                                        <input type="hidden" id='id_user_opinion' value='<?php echo $id_usuario ?>'>
                                        <button type="submit" class="btn btn-primary boton-enviar" style="margin-top:10px" onclick="nueva_opinion_pagina()">Enviar</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="container mt-5">
                <div style="display: flex; justify-content: center;">
                    <div class="last-pubs2 col-md-8">
                        <div class="headings ">
                            <div class="titulo">
                                <h2 style="color: black">Opiniones de los usuarios</h2>
                            </div>
                        </div>

                        <?php
                        $opiniones = mostrar_opiniones_pagina();
                        if (numero_opiniones_pagina() > 0) {
                            while ($data_opinion = $opiniones->fetch(PDO::FETCH_ASSOC)) {

                                $id_opinion = $data_opinion['id_opinion'];
                                $id_usuario = $data_opinion['id_user'];
                                $opinion = $data_opinion['comentario'];
                                $fecha_opinion = $data_opinion['fecha_comentario'];
                                $data_user = obtener_datos_usuario($id_usuario);
                                $foto_perfil = $data_user['userPicture'];
                                $nombre_user = $data_user['userName'];
                                $email_user = $data_user['email'];

                                echo '<div class="card p-4 mt-1">
                                        <div class="d-flex justify-content-between align-items-center">';
                        ?>
                                <a href="infoUser.php?userName=<?php echo $email_user ?>">
                            <?php
                                echo '<img src="' . $foto_perfil . '" width="50" height="50" class="rounded-circle mr-3">
                                        </a>
                                        <div class="w-100">
                                                <div class="d-flex justify-content-between align-items-center">
                                                    <div class="d-flex flex-row align-items-center">
                                                    <span class="mr-2" style="font-weight:bold;;margin-left:10px">Nombre de usuario: ' . $nombre_user . '</span>
                                                </div>
                                                <small>' . $fecha_opinion . '</small>
                                            </div>
                                            <p class="text-justify comment-text mb-0" style="margin-top:5px;margin-left:10px">' . $opinion . '</p>
                                            <div class="d-flex flex-row align-items-center mr-2" id="rating">
                                                <div class="rating-lectura" style="margin-left:5px">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>';
                            }
                        } else {
                            echo '<div class="card p-3 mt-2"><div class="d-flex justify-content-between align-items-center">';
                            echo '<div class="user d-flex flex-row align-items-center"><span class="font-weight-bold text-primary">No hay opiniones</span></div>';
                            echo '</div></div>';
                        }
                            ?>
                    </div>
                </div>
            </div>



            <div class="container mt-5">
                <div style="display: flex; justify-content: center;">
                    <div class="last-pubs2 col-md-8">
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
                                    $userData = obtener_datos_usuario($email);
                                    $id_usuario = $userData['IDuser'];
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
    <!-- <script>
        $(document).ready(function() {
            var id_comic = $("#id_comic").val(); // get the id_comic value here
            loadComentarios(id_comic);
        });

        function loadComentarios(id_comic) {
            var data = {
                id_comic: id_comic,
            };

            $.ajax({
                url: "php/apis/comentarios_pagina.php",
                data: data,
                success: function(data) {
                    $('<div class="mt-2"> <div class = "d-flex flex-row p-3" > ' + data + ' </div> </div> </div> </div>').appendTo('.comentarios');
                }
            });
        }
    </script> -->

</body>

</html>