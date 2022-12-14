<?php
session_start();
include_once 'php/inc/header.inc.php';
checkCookiesUser();
destroyCookiesUserTemporal();
$email = $_SESSION['email'];
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
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css"  integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.3/font/bootstrap-icons.css">
    <title>Inicio</title>
</head>

<body onload="checkSesionUpdate();showSelected();">
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="btn-group">
            <button id="nav" type="button" class="btn btn-danger dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-justify" viewBox="0 0 16 16">
                    <path fill-rule="evenodd" d="M2 12.5a.5.5 0 0 1 .5-.5h11a.5.5 0 0 1 0 1h-11a.5.5 0 0 1-.5-.5zm0-3a.5.5 0 0 1 .5-.5h11a.5.5 0 0 1 0 1h-11a.5.5 0 0 1-.5-.5zm0-3a.5.5 0 0 1 .5-.5h11a.5.5 0 0 1 0 1h-11a.5.5 0 0 1-.5-.5zm0-3a.5.5 0 0 1 .5-.5h11a.5.5 0 0 1 0 1h-11a.5.5 0 0 1-.5-.5z" />
                </svg>
            </button>
            <div class="dropdown-menu" aria-labelledby="navbarDropdown" id="navbar-inicio">

                <?php
                if (isset($_SESSION['email'])) {
                    $userData = getUserData($email);
                    $userPrivilege = $userData['privilege'];
                    if ($userPrivilege == 'guest') {
                        echo "<button class='dropdown-item' onclick='closeSesion()'> <i class='bi bi-person-circle p-1'></i>Iniciar sesion</button>";
                    } elseif ($userPrivilege == 'admin') {
                        echo "<a class='dropdown-item' href='adminPanelUser.php'><i class='bi bi-person-circle p-1'></i>Administracion</a>";
                        echo "<a class='dropdown-item' href='infoPerfil.php'><i class='bi bi-person-circle p-1'></i>Mi perfil</a>";
                    } else {
                        echo "<a class='dropdown-item' href='infoPerfil.php'><i class='bi bi-person-circle p-1'></i>Mi perfil</a>";
                        echo "<button type='button' class='dropdown-item' data-bs-toggle='modal' data-bs-target='#crear_ticket'>";
                        echo "<i class='bi bi-person-circle p-1'></i>Enviar un ticket</button>";
                        echo "</button>";
                    }
                }
                ?>
                <a class="dropdown-item" href="about.php"><i class="bi bi-newspaper p-1"></i>
                    Sobre WebComics</a>
                <div class="dropdown-divider"></div>
                <button class="dropdown-item" onclick="closeSesion()" name="closeSesion"><i class="bi bi-box-arrow-right p-1"></i>Cerrar sesion</a>
            </div>
        </div>

        <div class="collapse navbar-collapse" id="navbarToggler">
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

        <div class="d-flex" role="search" style="margin-right: 15px;">
            <button class="btn btn-outline-success" type="submit" onclick="toggleFieldset()">
                Buscar
                <i class="bi bi-search"></i>
            </button>
        </div>

        <!-- dropmenu-navbar del usuario  -->
        <div class="dropdown" id="navbar-user" style="left: 2px !important;">
            <?php
            $picture = pictureProfile($email);
            echo "<img src='$picture' id='avatar' alt='Avatar' class='avatarPicture' onclick='pictureProfileAvatar()'>";
            ?>

            <!-- imagen de perfil  -->
            <button class="btn btn-dark dropdown-toggle" id="user" type="button" data-bs-toggle="dropdown" aria-expanded="false" style="margin-right: 20px;">
            </button>
            <ul class="dropdown-menu">
                <?php
                if (isset($_SESSION['email'])) {
                    $userData = getUserData($email);
                    $userPrivilege = $userData['privilege'];
                    if ($userPrivilege == 'guest') {
                        echo " <li><button class='dropdown-item' onclick='closeSesion()'> <i class='bi bi-person-circle p-1'></i>Iniciar sesion</button></i>";
                    } elseif ($userPrivilege == 'admin') {
                        echo " <li><a class='dropdown-item' href='adminPanelUser.php'><i class='bi bi-person-circle p-1'></i>Administracion</a></i>";
                        echo " <li><a class='dropdown-item' href='infoPerfil.php'><i class='bi bi-person-circle p-1'></i>Mi perfil</a></i>";
                    } else {
                        echo " <li><a class='dropdown-item' href='infoPerfil.php' id='myBtn'><i class='bi bi-person-circle p-1'></i>Mi perfil</a></i>";
                    }
                }
                echo "<div class='dropdown-divider'></div>";
                echo "<li> <button class='dropdown-item' onclick='closeSesion()' name='closeSesion'> <i class='bi bi-box-arrow-right p-1'></i>Cerrar sesion</button> </i>";
                ?>
            </ul>
        </div>
    </nav>

    <!-- The Modal -->
    <div id="myModal" class="modal" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <!-- The Close Button -->
        <span class="close"></span>
        <!-- Modal Content (The Image) -->
        <img class="modal-content" id="img01">
    </div>

    <!-- FORMULARIO INSERTAR -->
    <div class="modal fade" id="crear_ticket" data-bs-keyboard="false">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <form method="post" id="formInsert" onsubmit="return false;">
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

    <div class="card-footer text-muted">
        Design by Alejandro Rodriguez 2022
    </div>

    <fieldset class='searchFieldset' id="searchFieldset" style="display: none;">
        <a href='inicio.php' class='btn-close btn-lg' aria-label='Close' role='button'></a>
        <legend class='info-search'>B??squeda</legend>
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

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js" integrity="sha384-oBqDVmMz9ATKxIep9tiCxS/Z9fNfEXiDAYTujMAeBAsjFuCZSmKbSSUnQlmh/jp3" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
    
    <script src="./assets/js/appLogin.js"></script>
    <script src="./assets/js/sweetalert2.all.min.js"></script>
    <script src="./assets/js/functions.js"></script>
</body>

</html>