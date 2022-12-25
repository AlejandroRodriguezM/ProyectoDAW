<?php
session_start();
include_once 'php/inc/header.inc.php';

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="./assets/img/webico.ico" type="image/x-icon">
    <link rel="stylesheet" href="./assets/style/style.css">
    <link rel="stylesheet" href="./assets/style/bootstrap.rtl.min.css">
    <link rel="stylesheet" href="./assets/icons/bootstrap-icons.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <title>Sobre web Comics</title>
</head>


<body onload="checkSesion();">
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
                    echo "<a class='dropdown-item' href='admin.php'><i class='bi bi-person-circle p-1'></i>Administracion</a>";
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
            <form class="form-inline my-2 my-lg-0">
                <input class="form-control mr-sm-3" type="search" placeholder="Search" aria-label="Search">
                <button class="btn btn-outline-success my-2 my-sm-0 " type="submit">Busqueda</button>
            </form>
        </div>
        <div class="dropdown">

            <?php
            $email = $_SESSION['email'];
            echo pictureProfile($email);
            ?>

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
                    echo "<div class='dropdown-divider'></div>";
                    echo "<button class='dropdown-item' onclick='closeSesion()' name='closeSesion'> <i class='bi bi-box-arrow-right p-1'></i>Cerrar sesion</button>";
                    ?>
                </li>
            </ul>
        </div>
    </nav>
    <div class="card text-center m-4">
        <div class="card-header">
            Web Comics
        </div>
        <div>
            <!-- //presentacion de quien soy  -->
            <div class="card-body">
                <h5 class="card-titl
                e">Bienvenido a WebComics</h5>
                <p class="card-text">
                    Esta pagina es un trabajo de fin de
                    curso del grado superior de DAW en el
                    que recreo una pagina web donde puedes guardar una coleccion de lectura.
                    En esta pagina he tratado de hacer una pagina web que sea facil de usar y que sea intuitiva.
                    He usado tanto front end como back end, para poder juntar conocimientos. Incluye una base de datos MySql.
                    Tanto als notas de funcionalidad que voy añadiendo se muestran dentro del propio proyecto php en github.
                    <br>
                    Esta pagina aparte estara presente en mi repositorio de github, en el que podras ver el codigo de la pagina.
                    <br>
                    Mas abajo dejare el acceso a diferentes paginas de interes a mis perfiles para que puedas ver mas de mi trabajo.
                </p>
                <!-- //abrir en otra ventana. Usando javascript  -->
                <div class="d-flex justify-content-center">
                    <a href="https://github.com/AlejandroRodriguezM" class="btn btn-primary m-2" target="_blank">Github</a>
                    <a href="https://www.linkedin.com/in/alejandro-rodriguez-mena-497a00179/" class="btn btn-primary m-2" target="_blank">Linkedin</a>
                </div>
            </div>


            <div class="card-footer text-muted">
                Design by Alejandro Rodriguez 2022
            </div>
        </div>

        <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
        <script src="./assets/js/appCRUD.js"></script>
        <script src="./assets/js/bootstrap.bundle.min.js"></script>
        <script src="./assets/js/sweetalert2.all.min.js"></script>
</body>

</html>