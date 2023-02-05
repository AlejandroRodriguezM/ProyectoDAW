<?php
session_start();
include_once 'php/inc/header.inc.php';

checkCookiesAdmin();
$email = $_COOKIE['adminUser'];
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
    <title>Editar datos usuario</title>
</head>

<?php
if (isset($_COOKIE['loginUser']) && isset($_COOKIE['passwordUser'])) {
    $emailUser = $_COOKIE['loginUserTemp'];
    $IDuser = $_COOKIE['idTemp'];
    $password = $_COOKIE['passwordUserTemp'];
    $dataUser = getUserData($emailUser);
    $nameUser = $dataUser['userName'];
} else {
    $emailUser = $_POST['email'];
    $nameUser = $_POST['name'];
    $IDuser = $_POST['IDuser'];
    $password = $_POST['password'];
}

if (isset($_POST['adminPanel'])) {
    destroyCookiesUserTemporal();
    header('Location: adminPanelUser.php');
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
                        <a class="nav-link" href="#" style='cursor:url(https://cdn.custom-cursor.com/db/cursor/32/Infinity_Gauntlet_Cursor.png) , default!important'>Novedades</a>
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
                                <li><a href="adminInfoUser.php"><span class="fa fa-user"></span>Profile</a></li>
                                <li class="active"><a href="actualizandoUser.php"><span class="fa fa-cog"></span>Updating user data</a></li>
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
                                        $dataUser = getUserData($emailUser);
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
                                $nameUser = $infoUser['nombreUser'];
                                $lastName = $infoUser['apellidoUser'];
                                ?>
                                <div class="form-group" style="margin-top: 5px;">
                                    <label class="col-md-2 col-sm-3 col-xs-12 control-label">User Name</label>
                                    <div class="col-md-10 col-sm-9 col-xs-12" style="width: 350px;">
                                        <input type="text" class="form-control" name="name" id="name" value="<?php echo $nameUser ?>" style="cursor:url(https://cdn.custom-cursor.com/db/pointer/32/Infinity_Gauntlet_Pointer.png) , pointer!important ">
                                    </div>
                                </div>

                                <div class="form-group" style="margin-top: 5px;">
                                    <label class="col-md-2 col-sm-3 col-xs-12 control-label">Your name</label>
                                    <div class="col-md-10 col-sm-9 col-xs-12" style="width: 350px;">

                                        <input type="text" class="form-control" id="nameUser" value="<?php echo $nameUser ?>" placeholder="Enter your name" style="cursor:url(https://cdn.custom-cursor.com/db/pointer/32/Infinity_Gauntlet_Pointer.png) , pointer!important ">
                                    </div>
                                </div>

                                <div class="form-group" style="margin-top: 5px;">
                                    <label class="col-md-2 col-sm-3 col-xs-12 control-label">You lastname</label>
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
                            <div class="mb-3">
                                <div class="col-md-5 col-sm-9 col-xs-12 col-md-push-2 col-sm-push-3 col-xs-push-0">
                                    <table>
                                        <tr>
                                            <td><input class="btn btn-primary" type="button" onclick="modifying_user();" value="Actualizar" style="cursor:url(https://cdn.custom-cursor.com/db/pointer/32/Infinity_Gauntlet_Pointer.png) , pointer!important "></td>
                                            <td><input class="btn btn-primary" type="submit" name="adminPanel" id="adminPanel" value="Volver" style="cursor:url(https://cdn.custom-cursor.com/db/pointer/32/Infinity_Gauntlet_Pointer.png) , pointer!important "></td>
                                        </tr>
                                    </table>
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
                                        document.getElementById('files').addEventListener('change', handleFileSelect, false);
                                    </script>
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

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js" integrity="sha384-oBqDVmMz9ATKxIep9tiCxS/Z9fNfEXiDAYTujMAeBAsjFuCZSmKbSSUnQlmh/jp3" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>

    <script src="./assets/js/appLogin.js"></script>
    <script src="./assets/js/sweetalert2.all.min.js"></script>
    <script src="./assets/js/functions.js"></script>
</body>

</html>