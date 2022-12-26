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
    <title>Settings</title>
</head>

<body onload="checkSesionUpdate()">
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <a class="btn btn-secondary btn-lg active" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            WebComics
        </a>
        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
            <?php
            if (isset($_SESSION['email'])) {
                $email = $_SESSION['email'];
                $userData = getUserData($email);
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
                    <a class="nav-link" href="#">Mi colección</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">Novedades</a>
                </li>
            </ul>
        </div>

        <div class="d-flex" role="search">
            <form class="form-inline mr-3 my-lg-0">
                <input class="form-control mr-sm-3" type="search" placeholder="Search" aria-label="Search">
                <button class="btn btn-outline-success my-1 my-sm-0 " type="submit">Busqueda</button>
            </form>
        </div>
        <div class="dropdown">

            <?php
            $email = $_SESSION['email'];
            echo pictureProfile($email);
            ?>


            <!-- The Modal -->
            <div id="myModal" class="modal" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">

                <!-- The Close Button -->
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
                        $email = $_SESSION['email'];
                        $userData = getUserData($email);
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
                                <li><a href="infoPerfil.php"><span class="fa fa-user"></span> Profile</a></li>
                                <li class="active"><a href="modificarPerfil.php"><span class="fa fa-cog"></span> Settings</a></li>
                            </ul>
                        </nav>
                    </div>
                    <div class="content-panel">
                        <form class="form-horizontal" id="formUpdate" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                            <fieldset class="fieldset">
                                <h3 class="fieldset-title">Personal Info</h3>
                                <div class="form-group avatar">
                                    <label class="col-md-3 col-sm-3 col-xs-12 control-label">New profile picture</label>
                                    <figure>
                                        <?php
                                        $dataUser = getUserData($email);
                                        $profilePicture = $dataUser['userPicture'];
                                        ?>
                                        <div class="image-upload">
                                            <label for="file-input">
                                                <?php
                                                echo "<img class='chosenUserProfile mb-2' id='output' src='$profilePicture' style='cursor:url(https://cdn.custom-cursor.com/db/pointer/32/Infinity_Gauntlet_Pointer.png) , pointer!important '/>";
                                                ?>
                                    </figure>
                                    <div class="form-inline col-md-10 col-sm-9 col-xs-12">
                                        <input class="form-control" type="file" name="file-input" id="file-input" accept=".jpg, .png" onchange="loadFile(event)" style="cursor:url(https://cdn.custom-cursor.com/db/pointer/32/Infinity_Gauntlet_Pointer.png) , pointer!important ">
                                    </div>
                                <!-- OTRA FORMA DE HACERLO -->
                                <!-- <label class="col-md-3 col-sm-3 col-xs-12 control-label">New profile picture</label>
                                    <figure>
                                    <?php
                                        // $email = $_SESSION['email'];
                                        // $dataUser = getUserData($email);
                                        // $profilePicture = $dataUser['userPicture'];
                                        ?>
                                        <div class="image-upload">
                                            <label for="file-input">
                                                <?php
                                                // echo "<img class='chosenUserProfile mb-2' id='output' src='$profilePicture' style='cursor:url(https://cdn.custom-cursor.com/db/pointer/32/Infinity_Gauntlet_Pointer.png) , pointer!important '/>";
                                                ?>
                                            </label>
                                        <input type="file" name="file-input" id="file-input" accept=".jpg, .png" onchange="loadFile(event)" style="cursor:url(https://cdn.custom-cursor.com/db/pointer/32/Infinity_Gauntlet_Pointer.png) , pointer!important ">
                                    </div>
                                    </figure> -->
                                </div>
                                <div class="form-group">
                                    <label class="col-md-2 col-sm-3 col-xs-12 control-label">User Name</label>
                                    <div class="col-md-10 col-sm-9 col-xs-12">
                                        <input type="text" class="form-control" id="name" placeholder="Enter your name" style="cursor:url(https://cdn.custom-cursor.com/db/pointer/32/Infinity_Gauntlet_Pointer.png) , pointer!important ">
                                        <input type="hidden" id="correo" value="<?php echo $email ?>">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-2 col-sm-3 col-xs-12 control-label">New Password</label>
                                    <div class="col-md-10 col-sm-9 col-xs-12">
                                        <input type="password" class="form-control" id="password" placeholder="***********" style="cursor:url(https://cdn.custom-cursor.com/db/pointer/32/Infinity_Gauntlet_Pointer.png) , pointer!important ">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-3 col-sm-3 col-xs-12 control-label">Repit new Password</label>
                                    <div class="col-md-10 col-sm-9 col-xs-12">
                                        <input type="password" class="form-control" id="repassword" placeholder="***********" style="cursor:url(https://cdn.custom-cursor.com/db/pointer/32/Infinity_Gauntlet_Pointer.png) , pointer!important ">
                                    </div>
                                </div>
                            </fieldset>
                            <hr>
                            <div class="mb-3">
                                <div class="col-md-5 col-sm-9 col-xs-12 col-md-push-2 col-sm-push-3 col-xs-push-0">
                                    <input class="btn btn-primary" type="button" onclick="update_user();" value="Update Profile" style="cursor:url(https://cdn.custom-cursor.com/db/pointer/32/Infinity_Gauntlet_Pointer.png) , pointer!important ">
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
                        </form>
                    </div>
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