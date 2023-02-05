<?php
session_start();
include_once 'php/inc/header.inc.php';

checkCookiesUser();
destroyCookiesUserTemporal();;
$email = $_SESSION['email'];
$userData = getUserData($email);
$userPrivilege = $userData['privilege'];
if ($userPrivilege == 'guest') {
    header('Location: logOut.php');
}

if ($userPrivilege == 'admin') {
    header('Location: panel_tickets_admin.php');
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
    <link rel="stylesheet" href="./assets/style/ticket_style.css">
    <link rel="stylesheet" href="./assets/style/bandeja_style.css">
    <link rel="stylesheet" href="./assets/style/footer_style.css">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.3.0/css/font-awesome.min.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.3/font/bootstrap-icons.css">
    <title>Tickets de usuario</title>
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
                                $userData = getUserData($email);
                                $userPrivilege = $userData['privilege'];
                                if ($userPrivilege == 'guest') {
                                    echo "<li><button class='dropdown-item' onclick='closeSesion()'> <i class='bi bi-person-circle p-1'></i>Iniciar sesion</button></li>";
                                } elseif ($userPrivilege == 'admin') {
                                    echo "<li><a class='dropdown-item' href='adminPanelUser.php' style='cursor:url(https://cdn.custom-cursor.com/db/cursor/32/Infinity_Gauntlet_Cursor.png) , default!important'><i class='bi bi-person-circle p-1'></i>Administracion</a></li>";
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
                            <div class="dropdown-divider"></div>
                            <li><button class="dropdown-item" onclick="closeSesion()" name="closeSesion" style='cursor:url(https://cdn.custom-cursor.com/db/cursor/32/Infinity_Gauntlet_Cursor.png) , default!important'><i class="bi bi-box-arrow-right p-1"></i>Cerrar sesion</a></li>
                        </ul>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="inicio.php" style='cursor:url(https://cdn.custom-cursor.com/db/cursor/32/Infinity_Gauntlet_Cursor.png) , default!important'>Inicio</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#" style='cursor:url(https://cdn.custom-cursor.com/db/cursor/32/Infinity_Gauntlet_Cursor.png) , default!important'>Mi colección</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="novedades.php" style='cursor:url(https://cdn.custom-cursor.com/db/cursor/32/Infinity_Gauntlet_Cursor.png) , default!important'>Novedades</a>
                    </li>
                </ul>
            </div>

            <div class="d-flex" role="search" style="margin-right: 15px;">
                <button class="btn btn-outline-success" type="submit" onclick="toggleFieldset()" style='cursor:url(https://cdn.custom-cursor.com/db/cursor/32/Infinity_Gauntlet_Cursor.png) , default!important'>
                    Buscar
                    <i class="bi bi-search"></i>
                </button>
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
                            echo "<li><a class='dropdown-item' href='adminPanelUser.php' style='cursor:url(https://cdn.custom-cursor.com/db/cursor/32/Infinity_Gauntlet_Cursor.png) , default!important'><i class='bi bi-person-circle p-1'></i>Administracion</a></i>";
                            echo "<li><a class='dropdown-item' href='infoPerfil.php' style='cursor:url(https://cdn.custom-cursor.com/db/cursor/32/Infinity_Gauntlet_Cursor.png) , default!important'><i class='bi bi-person-circle p-1'></i>Mi perfil</a></i>";
                        } else {
                            echo "<li><a class='dropdown-item' href='infoPerfil.php' style='cursor:url(https://cdn.custom-cursor.com/db/cursor/32/Infinity_Gauntlet_Cursor.png) , default!important'><i class='bi bi-person-circle p-1'></i>Mi perfil</a></i>";
                            echo "<li><a class='dropdown-item' href='#' style='cursor:url(https://cdn.custom-cursor.com/db/cursor/32/Infinity_Gauntlet_Cursor.png) , default!important'><i class='bi bi-person-circle p-1'></i>Enviar un ticket</a></i>";
                        }
                    }
                    echo "<div class='dropdown-divider'></div>";
                    echo "<li> <button class='dropdown-item' onclick='closeSesion()' name='closeSesion' style='cursor:url(https://cdn.custom-cursor.com/db/cursor/32/Infinity_Gauntlet_Cursor.png) , default!important'> <i class='bi bi-box-arrow-right p-1'></i>Cerrar sesion</button> </i>";
                    ?>
                </ul>
            </div>
    </nav>

    <fieldset class='searchFieldset' id="searchFieldset" style="display: none;cursor:url(https://cdn.custom-cursor.com/db/cursor/32/Infinity_Gauntlet_Cursor.png) , default!important">
        <a href='inicio.php' class='btn-close btn-lg' aria-label='Close' role='button' style='cursor:url(https://cdn.custom-cursor.com/db/cursor/32/Infinity_Gauntlet_Cursor.png) , default!important'></a>
        <legend class='info-search'>Búsqueda</legend>
        <div class="d-flex justify-content-center">
            <form class="form-inline my-2 my-lg-0" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" onsubmit="return false;">
                <label class="search-click-label" style="display: flex !important;justify-content: center !important;align-items: center !important;cursor:url(https://cdn.custom-cursor.com/db/cursor/32/Infinity_Gauntlet_Cursor.png) , default!important">
                    <input type="text" class="search-click mr-sm-3" name="search" placeholder="Buscador" id="search-data" style='cursor:url(https://cdn.custom-cursor.com/db/cursor/32/Infinity_Gauntlet_Cursor.png) , default!important' />
                    <!-- <script>
                        const input = document.getElementById('search-data');
                        input.addEventListener('input', () => autocomplete(input));
                    </script> -->
                </label>
            </form>
        </div>

        <!-- botones para clasificar que ver  -->
        <div class="d-flex justify-content-center" style='cursor:url(https://cdn.custom-cursor.com/db/cursor/32/Infinity_Gauntlet_Cursor.png) , default!important'>
            <span id="span1" style="cursor: pointer; display: inline-block;padding: 8px 16px;margin: 8px;border: 1px solid #ccc;border-radius: 4px;cursor:url(https://cdn.custom-cursor.com/db/cursor/32/Infinity_Gauntlet_Cursor.png) , default!important">Todo</span>
            <span id="span2" style="cursor: pointer; display: inline-block;padding: 8px 16px;margin: 8px;border: 1px solid #ccc;border-radius: 4px;cursor:url(https://cdn.custom-cursor.com/db/cursor/32/Infinity_Gauntlet_Cursor.png) , default!important">Usuarios</span>
            <span id="span3" style="cursor: pointer; display: inline-block;padding: 8px 16px;margin: 8px;border: 1px solid #ccc;border-radius: 4px;cursor:url(https://cdn.custom-cursor.com/db/cursor/32/Infinity_Gauntlet_Cursor.png) , default!important">Comics</span>
        </div>

        <div style="margin-left: auto; margin-right: auto; width: 80%; display: none;cursor:url(https://cdn.custom-cursor.com/db/cursor/32/Infinity_Gauntlet_Cursor.png) , default!important" id="show_information">
            <form class="table table-hover" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                <div id="search-result"></div>
            </form>
        </div>
    </fieldset>

    <div class="container">
        <div class="view-account">
            <section class="module">
                <div class="module-inner">
                    <div class="side-bar">
                        <div class="user-info">
                            <?php
                            $dataUser = getUserData($email);
                            $profilePicture = $dataUser['userPicture'];
                            echo "<img class='img-profile img-circle img-responsive center-block' id='avatarUser' alt='Avatar' src='$profilePicture' onclick='pictureProfileUser()'; style='width:100%; height: 100%;' />";
                            ?>
                            <ul class="meta list list-unstyled">
                                <li class="name"><label for="" style="font-size: 0.8em;">Nombre:</label>
                                    <?php
                                    $dataUser = getUserData($email);
                                    $userName = $dataUser['userName'];
                                    echo "$userName";
                                    ?>
                                </li>
                                <li class="email"><label for="" style="font-size: 0.8em;">Mail: </label>
                                    <?php
                                    $dataUser = getUserData($email);
                                    $email = $dataUser['email'];
                                    // echo with style font size 
                                    echo " " . "<span style='font-size: 0.7em'>$email</span>";
                                    ?>
                                </li>
                                <li class="activity"><label for="" style="font-size: 0.8em;">Logged in: </label>
                                    <?php
                                    $hora = $_SESSION['hour'];
                                    echo "$hora";
                                    ?>
                                </li>
                            </ul>
                        </div>
                        <nav class="side-menu">
                            <ul class="nav">
                                <li><a href="infoPerfil.php"><span class="fa fa-user"></span> Profile</a></li>
                                <li><a href="modificarPerfil.php"><span class="fa fa-cog"></span> Settings</a></li>
                                <li class='active'><a href='panel_tickets_user.php'><span class='fa fa-cog'></span>Tickets enviados</a></li>
                            </ul>
                        </nav>
                    </div>
                    <div class="content-panel">
                        <!-- AQUI VA EL CONTENIDO DE LOS TICKETS -->
                        <form class="form-horizontal" id="formUpdate" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                            <fieldset class="fieldset">
                                <h3 class="fieldset-title">Mensajes</h3>
                                <?php include 'php/user/tickets_user.php'; ?>

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

    <!-- FORMULARIO INSERTAR -->
    <div id="crear_ticket" class="modal modal_ticket" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content modal-content_ticket">
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
                            $userData = getUserData($email);
                            $id_user = $userData['IDuser'];
                            echo "<input type='hidden' id='id_user_ticket' value='$id_user'>";
                        }
                        ?>
                    </div>
                </div>
                <div class="modal-footer modal-footer_ticket">
                    <input type="button" class="btn btn-default" data-dismiss="modal" value="Cancelar">
                    <input type="submit" class="btn btn-info" value="Enviar ticket" onclick="mandar_ticket()">
                </div>
                </form>
            </div>
        </div>
    </div>
    <div id="footer-lite">
        <div class="content">
            <p class="helpcenter"><a href="http://www.example.com/help">Ayuda</a></p>
            <p class="legal"><a href="https://www.hoy.es/condiciones-uso.html?ref=https%3A%2F%2Fwww.google.com%2F">Condiciones de uso</a><span>·</span><a href="https://policies.google.com/privacy?hl=es">Política de privacidad</a><span>·</span><a class="cookies" href="https://www.doblemente.com/modelo-de-ejemplo-de-politica-de-cookies/">Mis cookies</a><span>·</span><a href="about.php">Quiénes somos</a></p>
            <!-- add social media with icons -->
            <p class="social">
                <a href="https://github.com/AlejandroRodriguezM"><img src="./assets/img/github.png" alt="Github" width="50" height="50"></a>
                <a href="http://www.infojobs.net/alejandro-rodriguez-mena.prf"><img src="https://brand.infojobs.net/downloads/ij-logo_reduced/ij-logo_reduced.svg" alt="infoJobs" width="50" height="50"></a>
            </p>
            <p class="copyright">
                © 2023 Web Comics</p>
        </div>
    </div>
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


    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js" integrity="sha384-oBqDVmMz9ATKxIep9tiCxS/Z9fNfEXiDAYTujMAeBAsjFuCZSmKbSSUnQlmh/jp3" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>

    <script src="./assets/js/appLogin.js"></script>
    <script src="./assets/js/sweetalert2.all.min.js"></script>
    <script src="./assets/js/functions.js"></script>
</body>

</html>