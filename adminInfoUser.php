<?php
session_start();
include_once 'php/inc/header.inc.php';

checkCookiesAdmin();
$email = $_COOKIE['loginUserTemp'];
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
    <link rel="stylesheet" href="./assets/style/bootstrap.rtl.min.css">
    <link rel="stylesheet" href="./assets/icons/bootstrap-icons.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <title>Perfil de usuario</title>
</head>

<body onload="checkSesionUpdate()">
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <button id="nav" href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" id="navbarDropdown" class="btn btn-secondary btn-lg active">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-justify" viewBox="0 0 16 16">
                <path fill-rule="evenodd" d="M2 12.5a.5.5 0 0 1 .5-.5h11a.5.5 0 0 1 0 1h-11a.5.5 0 0 1-.5-.5zm0-3a.5.5 0 0 1 .5-.5h11a.5.5 0 0 1 0 1h-11a.5.5 0 0 1-.5-.5zm0-3a.5.5 0 0 1 .5-.5h11a.5.5 0 0 1 0 1h-11a.5.5 0 0 1-.5-.5zm0-3a.5.5 0 0 1 .5-.5h11a.5.5 0 0 1 0 1h-11a.5.5 0 0 1-.5-.5z" />
            </svg>
        </button>
        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
            <?php
            if (isset($_SESSION['email'])) {
                $userData = getUserData($_COOKIE['adminUser']);
                $userPrivilege = $userData['privilege'];
                if ($userPrivilege == 'guest') {
                    echo "<button class='dropdown-item' onclick='closeSesion()'> <i class='bi bi-person-circle p-1'></i>Iniciar sesion</button>";
                } elseif ($userPrivilege == 'admin') {
                    echo "<a class='dropdown-item' href='adminPanelUser.php'><i class='bi bi-person-circle p-1'></i>Administracion</a>";
                    echo "<a class='dropdown-item' href='infoPerfil.php'><i class='bi bi-person-circle p-1'></i>Mi perfil</a>";
                } else {
                    echo "<a class='dropdown-item' href='infoPerfil.php'><i class='bi bi-person-circle p-1'></i>Mi perfil</a>";
                }
            }
            ?>
            <a class="dropdown-item" href="about.php"><i class="bi bi-newspaper p-1"></i>
                Sobre WebComics</a>
            <div class="dropdown-divider"></div>
            <button class="dropdown-item" onclick="closeSesion()" name="closeSesion"><i class="bi bi-box-arrow-right p-1"></i>Salir de
                sesion</a>
        </div>
        <div class="collapse navbar-collapse" id="navbarTogglerDemo01">
            <a class="navbar-brand" href="inicio.php">Inicio</a>
            <ul class="navbar-nav mr-auto mt-2 mt-lg-0">
                <li class="nav-item">
                    <a class="nav-link" href="#">Mi colecci??n</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">Novedades</a>
                </li>
            </ul>
        </div>

        <div class="d-flex" role="search">
            <form class="form-inline my-2 my-lg-0" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                <label class="search-click-label">
                    <input type="text" class="search-click mr-sm-3" name="search" placeholder="Buscador" />
                </label>
            </form>
        </div>
        <div class="dropdown">

            <?php
            $picture = pictureProfile($email);
            echo "<img src='$picture' id='avatar' alt='Avatar' class='avatarPicture'>";
            ?>

            <!-- The Modal -->
            <div id="myModal" class="modal" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                <span class="close"></span>
                <!-- Modal Content (The Image) -->
                <img class="modal-content" id="img01">
            </div>

            <button class="btn btn-dark dropdown-toggle" id="user" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                (NAME USER)
            </button>
            <ul class="dropdown-menu">
                <li>
                    <?php
                    if (isset($_SESSION['email'])) {
                        $userData = getUserData($_COOKIE['adminUser']);
                        $userPrivilege = $userData['privilege'];
                        if ($userPrivilege == 'guest') {
                            echo "<button class='dropdown-item' onclick='closeSesion()'> <i class='bi bi-person-circle p-1'></i>Iniciar sesion</button>";
                        } elseif ($userPrivilege == 'admin') {
                            echo "<a class='dropdown-item' href='adminPanelUser.php'><i class='bi bi-person-circle p-1'></i>Administracion</a>";
                            echo "<a class='dropdown-item' href='infoPerfil.php'><i class='bi bi-person-circle p-1'></i>Mi perfil</a>";
                        } else {
                            echo "<a class='dropdown-item' href='infoPerfil.php'><i class='bi bi-person-circle p-1'></i>Mi perfil</a>";
                        }
                    }
                    ?>
                    <div class="dropdown-divider"></div>
                    <button class='dropdown-item' onclick='closeSesion()' name='closeSesion'> <i class='bi bi-box-arrow-right p-1'></i>Cerrar sesion</button>
                </li>
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
                                <li class="active"><a href="infoPerfil.php"><span class="fa fa-user"></span>Profile</a></li>
                                <?php
                                $userData = getUserData($email);
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
                                $dataUser = getUserData($email);
                                $userName = $dataUser['userName'];
                                echo "<label>Nombre de usuario: </label>";
                                echo " " . "<span>$userName</span>";
                                ?>
                            </div>
                            <div class="form-group">
                                <?php
                                $dataUser = getUserData($email);
                                $email = $dataUser['email'];
                                echo "<label>Correo electronico: </label>";
                                echo " " . "<span>$email</span>";
                                ?>
                            </div>
                            <?php
                            $dataUser = getUserData($email);
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

    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>

    <script src="./assets/js/appLogin.js"></script>
    <script src="./assets/js/bootstrap.bundle.min.js"></script>
    <script src="./assets/js/sweetalert2.all.min.js"></script>
    <script src="./assets/js/functions.js"></script>
</body>

</html>