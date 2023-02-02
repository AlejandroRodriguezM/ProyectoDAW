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
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.3.0/css/font-awesome.min.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.3/font/bootstrap-icons.css">
    <title>Settings</title>
</head>

<body onload="checkSesionUpdate();showSelected();">
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

    <fieldset class='searchFieldset' id="searchFieldset" style="display: none;">
        <a href='inicio.php' class='btn-close btn-lg' aria-label='Close' role='button'></a>
        <legend class='info-search'>Búsqueda</legend>
        <div class="d-flex justify-content-center">
            <form class="form-inline my-2 my-lg-0" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" onsubmit="return false;">
                <label class="search-click-label">
                    <input type="text" class="search-click mr-sm-3" name="search" placeholder="Buscador" id="search-data" />
                    <!-- <script>
                        const input = document.getElementById('search-data');
                        input.addEventListener('input', () => autocomplete(input));
                    </script> -->
                </label>
            </form>
        </div>

        <!-- botones para clasificar que ver  -->
        <div class="d-flex justify-content-center">
            <span id="span1" style="cursor: pointer; display: inline-block;padding: 8px 16px;margin: 8px;border: 1px solid #ccc;border-radius: 4px;cursor: pointer;" class='selected'>Todo</span>
            <span id="span2" style="cursor: pointer; display: inline-block;padding: 8px 16px;margin: 8px;border: 1px solid #ccc;border-radius: 4px;cursor: pointer;">Usuarios</span>
            <span id="span3" style="cursor: pointer; display: inline-block;padding: 8px 16px;margin: 8px;border: 1px solid #ccc;border-radius: 4px;cursor: pointer;">Comics</span>
        </div>

        <div style="margin-left: auto; margin-right: auto; width: 80%; display: none" id="show_users">
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
                                <li class="active"><a href="modificarPerfil.php"><span class="fa fa-cog"></span> Settings</a></li>
                            </ul>
                        </nav>
                    </div>
                    <div class="content-panel">
                        <form class="form-horizontal" id="formUpdate" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                            <fieldset class="fieldset">
                                <h3 class="fieldset-title">Personal Info</h3>
                                <div class="form-group avatar" style="width: 420px;">
                                    <figure>
                                        <?php
                                        $dataUser = getUserData($email);
                                        $profilePicture = $dataUser['userPicture'];
                                        ?>
                                        <div class="image-upload">
                                            <label for="file-input"></label>
                                                <?php
                                                echo "<img class='chosenUserProfile mb-2' id='output' src='$profilePicture' style='cursor:url(https://cdn.custom-cursor.com/db/pointer/32/Infinity_Gauntlet_Pointer.png) , pointer!important '/>";
                                                ?>
                                    </figure>
                                    <div class="form-inline col-md-10 col-sm-9 col-xs-12">
                                        <input class="form-control" type="file" name="file-input" id="file-input" accept=".jpg, .png" onchange="loadFile(event)" style="cursor:url(https://cdn.custom-cursor.com/db/pointer/32/Infinity_Gauntlet_Pointer.png) , pointer!important ">
                                    </div>
                                </div>
                                <?php
                                $IDuser = $dataUser['IDuser'];
                                $infoUser = getInfoAboutUser($IDuser);
                                $nameUser = $infoUser['nombreUser'];
                                $lastName = $infoUser['apellidoUser'];
                                ?>

                                <div class="form-group" style="margin-top: 5px;">
                                    <label class="col-md-2 col-sm-3 col-xs-12 control-label">User Name</label>
                                    <div class="col-md-10 col-sm-9 col-xs-12" style="width: 350px;">
                                        <input type="text" class="form-control" id="name" value="<?php echo $dataUser['userName'] ?>" placeholder="Enter your name" style="cursor:url(https://cdn.custom-cursor.com/db/pointer/32/Infinity_Gauntlet_Pointer.png) , pointer!important ">
                                        <input type="hidden" id="correo" value="<?php echo $email ?>">
                                    </div>
                                </div>
                                <div class="form-group" style="margin-top: 5px;">
                                    <label class="col-md-2 col-sm-3 col-xs-12 control-label">Your name</label>
                                    <div class="col-md-10 col-sm-9 col-xs-12" style="width: 350px;">
                                        <input type="text" class="form-control" id="nameUser" value="<?php echo $nameUser ?>" placeholder="Enter your name" style="cursor:url(https://cdn.custom-cursor.com/db/pointer/32/Infinity_Gauntlet_Pointer.png) , pointer!important">
                                    </div>
                                </div>
                                <div class="form-group" style="margin-top: 5px;">
                                    <label class="col-md-2 col-sm-3 col-xs-12 control-label">You lastname</label>
                                    <div class="col-md-10 col-sm-9 col-xs-12" style="width: 350px;">
                                        <input type="text" class="form-control" id="lastnameUser" value="<?php echo $lastName ?>" placeholder="Enter your name" style="cursor:url(https://cdn.custom-cursor.com/db/pointer/32/Infinity_Gauntlet_Pointer.png) , pointer!important ">
                                    </div>
                                </div>
                                <div class="form-group" style="margin-top: 5px;">
                                    <label class="col-md-2 col-sm-3 col-xs-12 control-label">New Password</label>
                                    <div class="col-md-10 col-sm-9 col-xs-12" style="width: 350px;">
                                        <input type="password" class="form-control" id="password" placeholder="***********" style="cursor:url(https://cdn.custom-cursor.com/db/pointer/32/Infinity_Gauntlet_Pointer.png) , pointer!important ">
                                    </div>
                                </div>
                                <div class="form-group" style="margin-top: 5px;">
                                    <label class="col-md-3 col-sm-3 col-xs-12 control-label">Repit new Password</label>
                                    <div class="col-md-10 col-sm-9 col-xs-12" style="width: 350px;">
                                        <input type="password" class="form-control" id="repassword" placeholder="***********" style="cursor:url(https://cdn.custom-cursor.com/db/pointer/32/Infinity_Gauntlet_Pointer.png) , pointer!important ">
                                    </div>
                                </div>

                                <div class="form-group" style="margin-top: 5px;">
                                    <label class="col-md-3 col-sm-3 col-xs-12 control-label">Sobre mi</label>
                                    <div class="col-md-10 col-sm-9 col-xs-12">
                                        <?php
                                        $IDuser = $dataUser['IDuser'];
                                        $infoUser = getInfoAboutUser($IDuser);
                                        $sobreUser = $infoUser['infoUser'];
                                        ?>
                                        <textarea maxlength="449" class="form-control" id="field" onkeyup="countChar(this)" name="text" rows="3" style="resize:none; background-color:smoke;"><?php echo $sobreUser ?></textarea>
                                        <!-- <p id="charNum" class="help-block">0/450</p> -->
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


    <!-- The Modal -->
    <div id="myModal" class="modal" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <!-- The Close Button -->
        <span class="close"></span>
        <!-- Modal Content (The Image) -->
        <img class="modal-content" id="img01">
    </div>

    <!-- FORMULARIO INSERTAR -->
    <div class="modal fade" id="crear_ticket" data-bs-keyboard="false" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form method="post" id="formInsert" onsubmit="return false;">
                    <div class="modal-header">
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
                        </div>
                    </div>
                    <div class="modal-footer">
                        <input type="button" class="btn btn-default" data-dismiss="modal" value="Cancelar">
                        <!-- <input type="submit" class="btn btn-info" value="Guardar" onclick="insert_request()"> -->
                    </div>
                </form>
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