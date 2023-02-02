<?php
session_start();
include_once 'php/inc/header.inc.php';

checkCookiesAdmin();
$email = $_COOKIE['adminUser'];
$emailUser = $_COOKIE['loginUserTemp'];
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
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.3/font/bootstrap-icons.css">
    <title>Perfil de usuario</title>
</head>

<body onload="checkSesionUpdate()">
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark" style="background-color: #343a40 !important;">
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
                                    echo "<li><a class='dropdown-item' href='adminPanelUser.php'><i class='bi bi-person-circle p-1'></i>Administracion</a></li>";
                                    echo "<li><a class='dropdown-item' href='infoPerfil.php'><i class='bi bi-person-circle p-1'></i>Mi perfil</a></li>";
                                } else {
                                    echo "<li><a class='dropdown-item' href='infoPerfil.php'><i class='bi bi-person-circle p-1'></i>Mi perfil</a></li>";
                                    echo "<li><button type='button' class='dropdown-item' data-bs-toggle='modal' data-bs-target='#crear_ticket'></li>";
                                    echo "<li><i class='bi bi-person-circle p-1'></i>Enviar un ticket</button></li>";
                                    echo "<li></button></li>";
                                }
                            }
                            ?>
                            <li>
                                <a class="dropdown-item" href="about.php"><i class="bi bi-newspaper p-1"></i>
                                    Sobre WebComics</a>
                            </li>
                            <div class="dropdown-divider"></div>
                            <li><button class="dropdown-item" onclick="closeSesion()" name="closeSesion"><i class="bi bi-box-arrow-right p-1"></i>Cerrar sesion</a></li>
                        </ul>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="inicio.php">Inicio</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Mi colección</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Novedades</a>
                    </li>
                </ul>
            </div>

            <div class="d-flex" role="search" style="margin-right: 15px;">
                <button class="btn btn-outline-success" type="submit" onclick="toggleFieldset()">
                    Buscar
                    <i class="bi bi-search"></i>
                </button>
            </div>

            <div class="dropdown" id="navbar-user" style="left: 2px !important;">
                <?php
                $picture = pictureProfile($email);
                echo "<img src='$picture' id='avatar' alt='Avatar' class='avatarPicture' onclick='pictureProfileAvatar()'>";
                ?>

                <!-- imagen de perfil  -->
                <button class="btn btn-dark dropdown-toggle" id="user" type="button" data-bs-toggle="dropdown" aria-expanded="false" style="margin-right: 20px;"> </button>
                </button>
                <ul class="dropdown-menu">
                    <?php
                    if (isset($_SESSION['email'])) {
                        if ($userPrivilege == 'admin') {
                            echo "<li><a class='dropdown-item' href='adminPanelUser.php'><i class='bi bi-person-circle p-1'></i>Administracion</a></i>";
                            echo "<li><a class='dropdown-item' href='infoPerfil.php'><i class='bi bi-person-circle p-1'></i>Mi perfil</a></i>";
                        } else {
                            echo "<li><a class='dropdown-item' href='infoPerfil.php'><i class='bi bi-person-circle p-1'></i>Mi perfil</a></i>";
                            echo "<li><a class='dropdown-item' href='#'><i class='bi bi-person-circle p-1'></i>Enviar un ticket</a></i>";
                        }
                    }
                    echo "<div class='dropdown-divider'></div>";
                    echo "<li> <button class='dropdown-item' onclick='closeSesion()' name='closeSesion'> <i class='bi bi-box-arrow-right p-1'></i>Cerrar sesion</button> </i>";
                    ?>
                </ul>
            </div>
    </nav>

    <div class="container">
        <div class="view-account">
            <section class="module">
                <div class="module-inner">
                    <div class="side-bar">
                        <div class="user-info">
                            <?php
                            $dataUser = getUserData($emailUser);
                            $profilePicture = $dataUser['userPicture'];
                            echo "<img class='img-profile img-circle img-responsive center-block' id='avatarUser' alt='Avatar' src='$profilePicture' onclick='pictureProfileUser()'; style='width:100%; height: 100%;' />";
                            ?>

                            <ul class="meta list list-unstyled">
                                <li class="name"><label for="" style="font-size: 0.8em;">Nombre:</label>
                                    <?php
                                    $dataUser = getUserData($emailUser);
                                    $userName = $dataUser['userName'];
                                    echo "$userName";
                                    ?>
                                </li>
                                <li class="email"><label for="" style="font-size: 0.8em;">Mail: </label>
                                    <?php
                                    $dataUser = getUserData($emailUser);
                                    $emailUser = $dataUser['email'];
                                    // echo with style font size
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
                                <li class="active"><a href="infoPerfil.php"><span class="fa fa-user"></span>Profile</a></li>
                                <?php
                                $userData = getUserData($emailUser);
                                $userPrivilege = $userData['privilege'];
                                if ($userData['privilege'] != 'guest') {
                                    echo "<li><a href='actualizandoUser.php'><span class='fa fa-cog'></span>Settings</a></li>";
                                }
                                ?>
                            </ul>
                        </nav>
                    </div>
                    <div class="content-panel">
                        <fieldset class="fieldset">
                            <h3 class="fieldset-title">Personal Info</h3>
                            <div class="form-group avatar">
                            </div>

                            <div class="form-group">
                                <?php
                                $dataUser = getUserData($emailUser);
                                $userName = $dataUser['userName'];
                                echo "<label>Nombre de usuario: </label>";
                                echo " " . "<span>$userName</span>";
                                ?>
                            </div>
                            <div class="form-group">
                                <?php
                                $dataUser = getUserData($emailUser);
                                $emailUser = $dataUser['email'];
                                echo "<label>Correo electronico: </label>";
                                echo " " . "<span>$emailUser</span>";
                                ?>
                            </div>
                            <?php
                            $dataUser = getUserData($emailUser);
                            $IDuser = $dataUser['IDuser'];
                            $infoUser = getInfoAboutUser($IDuser);
                            $fechaCreacion = $infoUser['fechaCreacion'];
                            $sobreUser = $infoUser['infoUser'];
                            $nombre = $infoUser['nombreUser'];
                            $apellidos = $infoUser['apellidoUser'];

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

                            ?>
                        </fieldset>
                        <hr>
                        <div class="mb-3">
                        </div>
            </section>
        </div>
    </div>

    <script>
        // Get the modal
        var modal = document.getElementById("myModal");

        // Get the image and insert it inside the modal - use its "alt" text as a caption
        var img = document.getElementById("avatar");
        var modalImg = document.getElementById("img01");
        var captionText = document.getElementById("caption");
        img.onclick = function() {
            modal.style.display = "block";
            modalImg.src = this.src;
            captionText.innerHTML = this.alt;
        }

        // Get the <span> element that closes the modal
        var span = document.getElementsByClassName("close")[0];

        modal.addEventListener('click', function() {
            this.style.display = "none";
        })
    </script>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js" integrity="sha384-oBqDVmMz9ATKxIep9tiCxS/Z9fNfEXiDAYTujMAeBAsjFuCZSmKbSSUnQlmh/jp3" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>

    <script src="./assets/js/appLogin.js"></script>
    <script src="./assets/js/sweetalert2.all.min.js"></script>
    <script src="./assets/js/functions.js"></script>
</body>

</html>