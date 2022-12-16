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
    <link rel="shortcut icon" href="./assets/img/logoWeb.png" type="image/x-icon">
    <link rel="stylesheet" href="./assets/style/style.css">
    <link rel="stylesheet" href="./assets/style/bootstrap.rtl.min.css">
    <link rel="stylesheet" href="./assets/icons/bootstrap-icons.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <title>CRUD contactos</title>
</head>

<body onload="checkSesion();">
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <a class="btn btn-secondary btn-lg active" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            WebComics
        </a>
        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
            <a class="dropdown-item" href="#"><i class="bi bi-person-circle p-1"></i>Mi perfil</a>
            <a class="dropdown-item" href="#"><i class="bi bi-newspaper p-1"></i>
                Sobre WebComics</a>
            <div class="dropdown-divider"></div>
            <button class="dropdown-item" onclick="closeSesion()" name="closeSesion"><i class="bi bi-box-arrow-right p-1"></i>Salir de
                sesion</a>
        </div>
        <div class="collapse navbar-collapse" id="navbarTogglerDemo01">
            <a class="navbar-brand" href="#">Inicio</a>
            <ul class="navbar-nav mr-auto mt-2 mt-lg-0">
                <li class="nav-item">
                    <a class="nav-link" href="#">Mi colección</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">Novedades</a>
                </li>
            </ul>
        </div>

        <div class="d-flex " role="search">
            <form class="form-inline my-2 my-lg-0">
                <input class="form-control mr-sm-3" type="search" placeholder="Search" aria-label="Search">
                <button class="btn btn-outline-success my-2 my-sm-0 " type="submit">Busqueda</button>
            </form>
        </div>
        <div class="dropdown">
            <?php

            ?>
            <img src="./assets/img/chosePicture.png" id="avatar" alt="Avatar" class="avatar">
            <button class="btn btn-dark dropdown-toggle" id="user" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                (NAME USER)
            </button>
            <ul class="dropdown-menu">
                <li>
                    <a class="dropdown-item" href="#"><i class="bi bi-person-circle p-1"></i>Mi perfil</a>
                    <button class="dropdown-item" onclick="closeSesion()" name="closeSesion"> <i class="bi bi-box-arrow-right p-1"></i>Cerrar sesion</button>
                </li>
            </ul>
        </div>
    </nav>
    <!-- <div class="card text-center m-4">
        <div class="card-header">
            CRUD contactos
        </div>
        <div class="card-body">
            <div class="text-start">
                <button class="btn btn-danger mb-4"> <i class="bi bi-person-plus p-1"></i> New Contact</button>
            </div>
            <table class="table table-hover">
                <thead class="table-dark">
                    <tr>
                        <td>Nombre</td>
                        <td>Apellido 1</td>
                        <td>Apellido 2</td>
                        <td>Telefono</td>
                        <td>Correo</td>
                        <td>Editar</td>
                        <td>Eliminar</td>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>Alejandro</td>
                        <td>Test 1</td>
                        <td>Test 2</td>
                        <td>900000000</td>
                        <td>Test@test.com</td>
                        <td><button class="btn btn-success"> <i class="bi bi-pencil-square p-1"></i> Editar</button>
                        </td>
                        <td><button class="btn btn-danger"> <i class="bi bi-trash p-1"></i> Eliminar</button></td>
                    </tr>
                </tbody>
            </table>
            <h5 class="card-title"></h5>
            <p class="card-text"></p>
        </div> -->
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