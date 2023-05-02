<?php
session_start();
include_once 'php/inc/header.inc.php';


if (isset($_SESSION['email'])) {
    $email = $_SESSION['email'];
    guardar_ultima_conexion($email);
    $userData = obtener_datos_usuario($email);
    $userPrivilege = $userData['privilege'];
    $id_usuario = $userData['IDuser'];
    $picture = $userData['userPicture'];
    $userName = $userData['userName'];
    $numero_comics = get_total_guardados($id_usuario);
    //echo "<input type='hidden' id='num_comics' value='$numero_comics'>";
    if (checkStatus($email)) {
        header("Location: usuario_bloqueado.php");
    }
    if(!comprobar_activacion($userName)){
        header("Location: usuario_no_activado.php");
    }
} else {
    header('Location: index.php');
}

if ($userPrivilege == 'user') {
    header('Location: panel_tickets_user.php');
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="shortcut icon" href="./assets/img/webico.ico" type="image/x-icon">
    <link rel="shortcut icon" href="./assets/img/webico.ico" type="image/x-icon">
    <link rel="stylesheet" href="./assets/style/styleProfile.css">
    <link rel="stylesheet" href="./assets/style/stylePicture.css">
    <link rel="stylesheet" href="./assets/style/style.css">
    <!-- <link rel="stylesheet" href="./assets/style/bandeja_comics.css"> -->
    <link rel="stylesheet" href="./assets/style/mensajes_style.css">
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
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js" integrity="sha384-oBqDVmMz9ATKxIep9tiCxS/Z9fNfEXiDAYTujMAeBAsjFuCZSmKbSSUnQlmh/jp3" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link rel="stylesheet" href="./assets/style/iconos_notificaciones.css">

    <script src="./assets/js/functions.js"></script>
    <script src="./assets/js/appLogin.js"></script>
    <script src="./assets/js/sweetalert2.all.min.js"></script>
    <script src="./assets/js/temporizador.js"></script>
    <title>Denuncias de usuarios</title>
    <style>
        .contenedor {
            width: 80% !important;
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

                            <li><a class='dropdown-item' href='admin_panel_usuario.php' style='cursor:url(https://cdn.custom-cursor.com/db/cursor/32/Infinity_Gauntlet_Cursor.png) , default!important'><i class='bi bi-person-circle p-1'></i>Administracion</a></li>
                            <li><a class='dropdown-item' href='infoPerfil.php' style='cursor:url(https://cdn.custom-cursor.com/db/cursor/32/Infinity_Gauntlet_Cursor.png) , default!important'><i class='bi bi-person-circle p-1'></i>Mi perfil</a></li>
                            <li><a class='dropdown-item' href='panel_tickets_admin.php' style='cursor:url(https://cdn.custom-cursor.com/db/cursor/32/Infinity_Gauntlet_Cursor.png) , default!important'><i class='bi bi-person-circle p-1'></i>Ver tickets</a></li>
                            <li>
                                <a class="dropdown-item" href="about.php" style='cursor:url(https://cdn.custom-cursor.com/db/cursor/32/Infinity_Gauntlet_Cursor.png) , default!important'><i class="bi bi-newspaper p-1"></i>
                                    Sobre WebComics</a>
                            </li>
                            <li>
                                <a class="dropdown-item" href="escribir_comentario_pagina.php" style='cursor:url(https://cdn.custom-cursor.com/db/cursor/32/Infinity_Gauntlet_Cursor.png) , default!important'><i class="bi bi-newspaper p-1"></i>
                                    Escribe tu opinión</a>
                            </li>

                            <div class="dropdown-divider"></div>
                            <li>
                                <button class="dropdown-item" onclick="closeSesion()" name="closeSesion" style='cursor:url(https://cdn.custom-cursor.com/db/cursor/32/Infinity_Gauntlet_Cursor.png) , default!important'><i class="bi bi-box-arrow-right p-1"></i>Cerrar sesion</a>
                            </li>
                        </ul>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" aria-current="page" href="index.php" style='cursor:url(https://cdn.custom-cursor.com/db/cursor/32/Infinity_Gauntlet_Cursor.png) , default!important'>Inicio</a>
                    </li>

                    <li class="nav-item">

                        <a class="nav-link" href="mi_coleccion.php" style='cursor:url(https://cdn.custom-cursor.com/db/cursor/32/Infinity_Gauntlet_Cursor.png) , default!important'>Mi colección</a>
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
                    <input type="text" class="search-click mr-sm-3" name="search" placeholder="Buscador" id="search-data" style='cursor:url(https://cdn.custom-cursor.com/db/cursor/32/Infinity_Gauntlet_Cursor.png) , default!important' />
                </form>
            </div>

            <div class="dropdown" id="navbar-user" style="left: 2px !important;">
                <?php

                echo "<img src='$picture' id='avatar' alt='Avatar' class='avatarPicture' onclick='pictureProfileAvatar()' style='cursor:url(https://cdn.custom-cursor.com/db/cursor/32/Infinity_Gauntlet_Cursor.png) , default!important'>";

                ?>

                <!-- imagen de perfil  -->
                <button class="btn btn-dark dropdown-toggle" id="user" type="button" data-bs-toggle="dropdown" aria-expanded="false" style="margin-right: 20px;" style='cursor:url(https://cdn.custom-cursor.com/db/cursor/32/Infinity_Gauntlet_Cursor.png) , default!important'> </button>
                </button>
                <ul class="dropdown-menu">

                    <li><a class='dropdown-item' href='admin_panel_usuario.php' style='cursor:url(https://cdn.custom-cursor.com/db/cursor/32/Infinity_Gauntlet_Cursor.png) , default!important'><i class='bi bi-person-circle p-1'></i>Administracion</a></i>
                    <li><a class='dropdown-item' href='infoPerfil.php' style='cursor:url(https://cdn.custom-cursor.com/db/cursor/32/Infinity_Gauntlet_Cursor.png) , default!important'><i class='bi bi-person-circle p-1'></i>Mi perfil</a></i>
                        <div class='dropdown-divider'></div>
                    <li>
                        <button class='dropdown-item' onclick='closeSesion()' name='closeSesion' style='cursor:url(https://cdn.custom-cursor.com/db/cursor/32/Infinity_Gauntlet_Cursor.png) , default!important'> <i class='bi bi-box-arrow-right p-1'></i>Cerrar sesion</button> </i>

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
                                        <li class="name">
                                            <label for="" style="font-size: 0.8em;">Nombre:</label>
                                            <?php
                                            echo $userName;
                                            ?>
                                        </li>
                                    </ul>
                                </div>
                                <nav class="side-menu">
                                    <ul class="nav">
                                        <li><a href="admin_panel_usuario.php"><span class="fa fa-user"></span>Lista de usuarios</a></li>
                                        <li><a href="admin_panel_peticiones_comic.php"><span class="fa fa-cog"></span>Peticiones de comics</a></li>
                                        <li><a href="admin_panel_peticiones_comic_aceptadas.php"><span class="fa fa-cog"></span>Comics aceptados</a></li>
                                        <li><a href="admin_panel_peticiones_comic_canceladas.php"><span class="fa fa-cog"></span>Comics cancelados</a></li>
                                        <li><a href="admin_panel_block.php"><span class="fa fa-cog"></span>Usuarios bloqueados</a></li>
                                        <li><a href="panel_tickets_admin.php"><span class="fa fa-cog"></span>Panel de mensajes</a></li>
                                        <li class="active"><a href="admin_mensajes_denuncias.php"><span class="fa fa-cog"></span>Denuncias de usuarios</a></li>
                                    </ul>
                                </nav>
                            </div>
                            <div class="content-panel">
                                <form class="form-horizontal" id="formUpdate" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                                    <fieldset class="fieldset">
                                        <h3 class="fieldset-title">Tickets de usuarios</h3>
                                        <div id="mensajes-container"></div>
                                    </fieldset>
                                </form>
                            </div>
                        </div>
                    </section>
                </div>
            </div>

            <!-- The Modal -->
            <div id="myModal" class="modal modal_img" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                <img class="modal-content_img" id="img01">
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
        function actualizarMensajes(ticket_id, id_usuario) {
            $.ajax({
                url: "php/apis/tickets_denuncias.php",
                method: 'POST',
                data: {
                    id_usuario_destinatario: ticket_id,
                    mensaje: ''
                },
                success: function(data) {
                    $('#mensaje-info-' + ticket_id).html(data);
                    $("#mensajes-container").html(data);
                    $('#mensaje-info-' + ticket_id).css('display', 'block');
                }
            });
        }
        $(document).ready(function() {
            actualizarMensajes(0);
        });
        // Enviar mensaje mediante AJAX
        const mandar_mensaje_actualizacion = async (ticket_id) => {
            var id_denuncia = document.querySelector("#id_denuncia_" + ticket_id).value;
            var id_admin = document.querySelector("#id_admin_" + ticket_id).value;
            var id_usuario = document.querySelector("#id_usuario_" + ticket_id).value;
            var respuesta = document.querySelector("#respuesta_" + ticket_id).value;

            if (respuesta.trim() === '') {
                Swal.fire({
                    icon: "error",
                    title: "ERROR.",
                    text: "No puedes enviar un mensaje vacío.",
                    footer: "Web Comics"
                })
                return;
            }

            //insert to data base in case of everything go correct.
            const data = new FormData();
            data.append('id_denuncia', id_denuncia);
            data.append('id_admin', id_admin);
            data.append('id_usuario', id_usuario);
            data.append("mensaje", respuesta);

            //pass data to php file
            var respond = await fetch("php/apis/respuesta_denuncia.php", {
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
                $('#mensaje-info-' + ticket_id).html(result.data);
                // Esperar a que el contenido de mensaje-info-<id_conversacion> haya sido agregado al DOM
                // y luego llamar a la función toggleTicketInfo() con el id de conversación correspondiente.
                actualizarMensajes(ticket_id, id_usuario);
            }
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

</body>

</html>