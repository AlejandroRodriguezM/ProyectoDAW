<?php
session_start();
include_once 'php/inc/header.inc.php';
checkCookiesAdmin();
destroyCookiesUserTemporal();
if (isset($_SESSION['email'])) {
    $email = $_SESSION['email'];
    guardar_ultima_conexion($email);
    $userData = obtener_datos_usuario($email);
    $userPrivilege = $userData['privilege'];
    $id_user = $userData['IDuser'];
    $numero_comics = get_total_guardados($id_user);
    echo "<input type='hidden' id='num_comics' value='$numero_comics'>";
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
    <link rel="stylesheet" href="./assets/style/parallax.css">
    <link rel="stylesheet" href="./assets/style/media_recomendaciones.css">
    <link rel="stylesheet" href="./assets/style/media_videos.css">
    <link rel="stylesheet" href="./assets/style/media_barra_principal.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.3.0/css/font-awesome.min.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.3/font/bootstrap-icons.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js" integrity="sha384-oBqDVmMz9ATKxIep9tiCxS/Z9fNfEXiDAYTujMAeBAsjFuCZSmKbSSUnQlmh/jp3" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>

    <script src="./assets/js/functions.js"></script>
    <script src="./assets/js/appLogin.js"></script>
    <script src="./assets/js/sweetalert2.all.min.js"></script>

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

        .navbar {
            position: fixed;
            top: 0;
            width: 100%;
            z-index: 1000;
        }
    </style>
</head>

<?php
if (isset($_COOKIE['loginUser']) && isset($_COOKIE['passwordUser'])) {
    $emailUser = $_COOKIE['loginUserTemp'];
    $IDuser = $_COOKIE['idTemp'];
    $password = $_COOKIE['passwordUserTemp'];
    $dataUser = obtener_datos_usuario($emailUser);
    $nameUser = $dataUser['userName'];
} else {
    $emailUser = $_POST['email'];
    $nameUser = $_POST['name'];
    $IDuser = $_POST['IDuser'];
    $password = $_POST['password'];
}

if (isset($_POST['adminPanel'])) {
    destroyCookiesUserTemporal();
    header('Location: admin_panel_usuario.php');
}
?>

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
                        <a class="nav-link active" aria-current="page" href="inicio.php" style='cursor:url(https://cdn.custom-cursor.com/db/cursor/32/Infinity_Gauntlet_Cursor.png) , default!important'>Inicio</a>
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
            <div class="contenedor mt-5">
                <div class="view-account" style="width:90%;justify-content: center;margin: 0 auto;">
                    <section class="module">
                        <div class="module-inner">
                            <div class="side-bar">
                                <div class="user-info">
                                    <?php
                                    $dataUser = obtener_datos_usuario($emailUser);
                                    $profilePicture = $dataUser['userPicture'];
                                    echo "<img class='img-profile img-circle img-responsive center-block' id='avatarUser' alt='Avatar' src='$profilePicture' onclick='pictureProfileUser()'; style='width:100%; height: 100%;' />";
                                    ?>
                                    <ul class="meta list list-unstyled">
                                        <li class="name"><label for="" style="font-size: 0.8em;">Nombre:</label>
                                            <?php
                                            $dataUser = obtener_datos_usuario($emailUser);
                                            $userName = $dataUser['userName'];
                                            echo "$userName";
                                            ?>
                                        </li>
                                        <li class="email"><label for="" style="font-size: 0.8em;">Mail: </label>
                                            <?php
                                            $dataUser = obtener_datos_usuario($emailUser);
                                            $email = $dataUser['email'];
                                            echo " " . "<span style='font-size: 0.7em'>$emailUser</span>";
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
                                        <li><a href="admin_info_usuario.php"><span class="fa fa-user"></span>Perfil</a></li>
                                        <li class="active"><a href="admin_actualizar_usuario.php"><span class="fa fa-cog"></span>Updating user data</a></li>
                                    </ul>
                                </nav>
                            </div>
                            <div class="content-panel">
                                <form class="form-horizontal" id="formUpdate" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                                    <fieldset class="fieldset">
                                        <h3 class="fieldset-title">Información</h3>
                                        <div class="form-group avatar" style="width: 420px;">
                                            <figure>
                                                <?php
                                                $dataUser = obtener_datos_usuario($emailUser);
                                                $profilePicture = $dataUser['userPicture'];
                                                ?>
                                                <div class="image-upload">
                                                    <label for="file-input"></label>
                                                    <?php
                                                    echo "<img class='chosenUserProfile mb-2' id='output' src='$profilePicture' style='cursor:url(https://cdn.custom-cursor.com/db/pointer/32/Infinity_Gauntlet_Pointer.png) , pointer!important '/>";
                                                    ?>
                                            </figure>
                                            <div class="form-inline col-md-10 col-sm-9 col-xs-12">
                                                <input class="form-control" type="file" name="files" id="files" accept=".jpg, .png" onchange="loadFile(event)" style="cursor:url(https://cdn.custom-cursor.com/db/pointer/32/Infinity_Gauntlet_Pointer.png) , pointer!important ">
                                            </div>
                                        </div>
                                        <?php
                                        $IDuser = $dataUser['IDuser'];
                                        $infoUser = getInfoAboutUser($IDuser);
                                        $infoCuenta = obtener_datos_usuario($IDuser);
                                        $nombre_cuenta = $infoCuenta['userName'];
                                        $nameUser = $infoUser['nombreUser'];
                                        $lastName = $infoUser['apellidoUser'];
                                        ?>
                                        <div class="form-group" style="margin-top: 5px;">
                                            <label class="col-md-2 col-sm-3 col-xs-12 control-label" style="width: 350px;">Nombre de usuario:</label>
                                            <div class="col-md-10 col-sm-9 col-xs-12" style="width: 350px;">
                                                <input type="text" class="form-control" name="name" id="name" value="<?php echo $nombre_cuenta ?>" style="cursor:url(https://cdn.custom-cursor.com/db/pointer/32/Infinity_Gauntlet_Pointer.png) , pointer!important ">
                                            </div>
                                        </div>

                                        <div class="form-group" style="margin-top: 5px;">
                                            <label class="col-md-2 col-sm-3 col-xs-12 control-label">Nombre:</label>
                                            <div class="col-md-10 col-sm-9 col-xs-12" style="width: 350px;">

                                                <input type="text" class="form-control" id="nameUser" value="<?php echo $nameUser ?>" placeholder="Enter your name" style="cursor:url(https://cdn.custom-cursor.com/db/pointer/32/Infinity_Gauntlet_Pointer.png) , pointer!important ">
                                            </div>
                                        </div>

                                        <div class="form-group" style="margin-top: 5px;">
                                            <label class="col-md-2 col-sm-3 col-xs-12 control-label">Apellido:</label>
                                            <div class="col-md-10 col-sm-9 col-xs-12" style="width: 350px;">
                                                <input type="text" class="form-control" id="lastnameUser" value="<?php echo $lastName ?>" placeholder="Enter your name" style="cursor:url(https://cdn.custom-cursor.com/db/pointer/32/Infinity_Gauntlet_Pointer.png) , pointer!important ">
                                            </div>
                                        </div>

                                        <div class="form-group" style="margin-top: 5px;">
                                            <label class="col-md-2 col-sm-3 col-xs-12 control-label">Email</label>
                                            <div class="col-md-10 col-sm-9 col-xs-12" style="width: 350px;">
                                                <input type="text" class="form-control" name="email" id="email" value="<?php echo $emailUser ?>" style="cursor:url(https://cdn.custom-cursor.com/db/pointer/32/Infinity_Gauntlet_Pointer.png) , pointer!important ">
                                                <input type="hidden" class="form-control" name="password" id="password" value="<?php $password ?>">
                                                <input type="hidden" class="form-control" name="IDuser" id="IDuser" value="<?php $IDuser ?>">
                                            </div>
                                        </div>
                                    </fieldset>
                                    <hr>


                                </form>
                            </div>
                        </div>
                    </section>
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

</body>

</html>