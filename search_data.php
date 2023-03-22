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
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="shortcut icon" href="./assets/img/webico.ico" type="image/x-icon">
    <link rel="stylesheet" href="./assets/style/styleProfile.css">
    <link rel="stylesheet" href="./assets/style/stylePicture.css">
    <link rel="stylesheet" href="./assets/style/style.css">
    <link rel="stylesheet" href="./assets/style/bandeja_comics.css">
    <link rel="stylesheet" href="./assets/style/footer_style.css">

    <link rel="stylesheet" href="./assets/style/parallax.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.3.0/css/font-awesome.min.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.3/font/bootstrap-icons.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>


    <title>Busqueda</title>
    <style>
        img {
            max-width: 200px;
            max-height: 300px;
        }

        .row {
            display: flex;
            flex-wrap: wrap;
        }

        .busqueda {
            border: 1px solid black;
            text-align: center;
            margin-bottom: 20px;
        }

        .busqueda h1 {
            margin: 0;
            padding: 20px;
            background-color: #343a40;
            color: white;
        }

        .panel_busqueda {
            display: flex;
            justify-content: center;
            width: 90%;
            margin: 0 auto;
        }

        .contenedor {
            width: 72% !important;
            overflow-x: auto;
            margin: 0 auto;
            padding-top: 30px;
            border-radius: 30px;
        }

        .contenido_busqueda {
            max-width: 120%;
            overflow: auto;
        }

        .table {
            min-width: 1200px;
            display: table;
            width: 100%;
            max-width: 100%;
            margin-bottom: 1rem;
            background-color: rgb(77, 81, 84);
            border-collapse: collapse;
        }

        .table td,
        .table th {
            padding: 0.75rem;
            vertical-align: top;
            border-top: 1px solid #dee2e6;
            color: white;
        }

        .table thead th {
            vertical-align: bottom;
            border-bottom: 2px solid #dee2e6;
        }

        .table tbody+tbody {
            border-top: 2px solid #dee2e6;
        }

        .table .table {
            background-color: #fff;
        }

        .table-sm td,
        .table-sm th {
            padding: 0.3rem;
        }

        .table-bordered {
            border: 1px solid #dee2e6;
        }

        .table-bordered td,
        .table-bordered th {
            border: 1px solid #dee2e6;
            width: 5%;
        }

        .table-bordered thead td,
        .table-bordered thead th {
            border-bottom-width: 2px;
        }

        .table-striped tbody tr:nth-of-type(odd) {
            background-color: rgba(0, 0, 0, 0.05);
        }

        .table-hover tbody tr:hover {
            background-color: rgba(0, 0, 0, 0.075);
        }

        a {
            color: white;
            font-size: 15px;
        }

        a:hover {
            color: red;
        }

        .comic-value {
            font-family: Arial, sans-serif !important;
            font-size: 14px !important;
            color: white;
        }

        .ver-mas-btn {
            background-color: #3498DB;
            border: none;
            color: #fff;
            padding: 10px 20px;
            border-radius: 5px;
            text-decoration: none;
            font-size: 18px;
            transition: all 0.3s ease;
            margin-left: 1026px !important;
            text-align: right;
            margin-top: 20px;
            margin-bottom: 20px;
        }

        .ver-mas-btn:hover {
            background-color: #2980B9;
            cursor: pointer;
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

$input_comic = $_GET['search'];
$input_user = $_GET['search'];
$count_comic = 0;
$count_user = 0;
echo "<input type='hidden' name='input_comic' id='input_comic' value='$input_comic'>";
if (existe_comic($input_comic)) {
    $count_comic = countComicSearch($input_comic);
}

if (existe_user($input_user)) {
    $count_user = countUserSearch($input_user);
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
                            if ($userPrivilege != 'guest') {
                            ?>
                                <li>
                                    <a class="dropdown-item" href="escribir_comentario_pagina.php" style='cursor:url(https://cdn.custom-cursor.com/db/cursor/32/Infinity_Gauntlet_Cursor.png) , default!important'><i class="bi bi-newspaper p-1"></i>
                                        Escribe tu opinión</a>
                                </li>
                            <?php
                            }
                            ?>
                            <div class="dropdown-divider"></div>
                            <!-- <li><button class="dropdown-item" onclick="closeSesion()" name="closeSesion" style='cursor:url(https://cdn.custom-cursor.com/db/cursor/32/Infinity_Gauntlet_Cursor.png) , default!important'><i class="bi bi-box-arrow-right p-1"></i>Cerrar sesion</a></li> -->
                        </ul>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="inicio.php" style='cursor:url(https://cdn.custom-cursor.com/db/cursor/32/Infinity_Gauntlet_Cursor.png) , default!important'>Inicio</a>
                    </li>

                        <?php
                        if ($userPrivilege == 'guest') {
                        ?>
                            <a class="nav-link" href="logOut.php" style='cursor:url(https://cdn.custom-cursor.com/db/cursor/32/Infinity_Gauntlet_Cursor.png) , default!important'>Mi colección</a>
                        <?php
                        } else {
                        ?>
                            <a class="nav-link" href="micoleccion.php" style='cursor:url(https://cdn.custom-cursor.com/db/cursor/32/Infinity_Gauntlet_Cursor.png) , default!important'>Mi colección</a>

                        <?php
                        }
                        ?>
                    <li class="nav-item">
                        <a class="nav-link" href="novedades.php" style='cursor:url(https://cdn.custom-cursor.com/db/cursor/32/Infinity_Gauntlet_Cursor.png) , default!important'>Novedades</a>
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
                        } elseif ($userPrivilege == 'user') {
                            echo "<li><a class='dropdown-item' href='infoPerfil.php' style='cursor:url(https://cdn.custom-cursor.com/db/cursor/32/Infinity_Gauntlet_Cursor.png) , default!important'><i class='bi bi-person-circle p-1'></i>Mi perfil</a></i>";
                            echo "<li><a class='dropdown-item' href='#' style='cursor:url(https://cdn.custom-cursor.com/db/cursor/32/Infinity_Gauntlet_Cursor.png) , default!important'><i class='bi bi-person-circle p-1'></i>Enviar un ticket</a></i>";
                        } else {
                            echo "<li><button class='dropdown-item' onclick='closeSesion()'> <i class='bi bi-person-circle p-1'></i>Iniciar sesion</button></li>";
                        }
                    }
                    echo "<div class='dropdown-divider'></div>";
                    echo "<li> <button class='dropdown-item' onclick='closeSesion()' name='closeSesion' style='cursor:url(https://cdn.custom-cursor.com/db/cursor/32/Infinity_Gauntlet_Cursor.png) , default!important'> <i class='bi bi-box-arrow-right p-1'></i>Cerrar sesion</button> </i>";
                    ?>
                </ul>
            </div>
        </div>
    </nav>

    <!-- The Modal -->
    <div id="myModal" class="modal modal_img" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <img class="modal-content_img" id="img01">
    </div>

    <!-- FORMULARIO INSERTAR -->
    <div id="crear_ticket" class="modal" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
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
                <div class="modal-footer">
                    <input type="button" class="btn btn-default" data-dismiss="modal" value="Cancelar">
                    <input type="submit" class="btn btn-info" value="Enviar ticket" onclick="mandar_ticket()">
                </div>
                </form>
            </div>
        </div>
    </div>

    <div class="card-footer text-muted">
        Design by Alejandro Rodriguez 2022
    </div>

    <div class="bgimg-1">
        <div class="caption">
            <?php
            if ($count_user > 0) {
            ?>
                <div class="busqueda">
                    <h1>Busqueda de <?php echo $input_user ?></h1>
                </div>
                <div class="contenedor mt-5">
                    <div class='panel_busqueda'>
                        <table class="table table-hover">
                            <thead class="table-dark">
                                <tr>
                                    <td>Foto de perfil</td>
                                    <td>Usuario</td>
                                    <td>Nombre</td>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $registros = search_user($input_user);
                                $user = $registros->fetch();
                                while ($user != null) {
                                ?>
                                    <tr style="background-color:rgb(77,81,84)">
                                        <td>
                                            <a href="infoUser.php?userName=<?php echo $user['userName']; ?>">
                                                <img src="<?php echo $user['userPicture']; ?>" alt="profile picture" class="avatarPicture" name="avatarUser" id="avatar" alt="Avatar" style="width: 100px; height: 100px; border-radius: 50%;">
                                            </a>
                                        </td>
                                        <td><?php echo $user['userName']; ?></td>
                                        <td><?php echo $user['email']; ?></td>
                                    </tr>
                                <?php
                                    $user = $registros->fetch();
                                }

                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>

            <?php

            }
            ?>

            <?php
            if ($count_comic > 0) {
            ?>
                <?php
                if ($count_comic > 0 && $count_user < 1) {
                ?>
                    <div class="busqueda">
                        <h1>Busqueda de <?php echo $input_comic ?></h1>
                    </div>
                <?php
                }
                ?>
                <div class="contenedor mt-5">
                    <div class='panel_busqueda'>
                        <table class="comic_table table table-hover">
                            <thead class="table-dark">
                                <tr>
                                    <th>Portada</th>
                                    <th>Nombre del comic</th>
                                    <th>Numero</th>
                                    <th>Variante</th>
                                    <th>Editorial</th>
                                    <th>Formato</th>
                                    <th>Procedencia</th>
                                    <th>Fecha de publicacion</th>
                                    <th>Nombre del guionista</th>
                                    <th>Nombre del dibujante</th>
                                </tr>
                            </thead>
                        </table>
                        <h5 class="card-title"></h5>
                        <p class="card-text"></p>
                    </div>
                </div>
            <?php
            }
            if ($count_user > 0 && $count_comic == 0) {
            ?>
                <div class="container mt-5">
                    <div style="display: flex; justify-content: center;">
                        <div class="last-pubs">
                            <div class="titulo">
                                <h2>Recomendaciones</h2>
                            </div>
                            <a href='novedades.php'>
                                <button class="ver-mas-btn">Ver más</button>
                            </a>
                            <div class="scrollable-h comic-full">
                                <div class="scrollable-h-content">
                                    <ul class="v2-cover-list">
                                        <?php
                                        $total_comics = numComics();
                                        echo "<input type='hidden' id='id_user' value='$id_user'>";

                                        for ($i = 0; $i < 8; $i++) {
                                            $numero = randomComic();
                                            $data_comic = getDataComic($numero);
                                            $id_comic = $data_comic['IDcomic'];
                                            $titulo = $data_comic['nomComic'];
                                            $numComic = $data_comic['numComic'];
                                            $variante = $data_comic['nomVariante'];
                                            $cover = $data_comic['Cover'];
                                            echo "<li id='comicyXwd2' class='get-it'>
                                        <a href='infoComic.php?IDcomic=$id_comic' title='$titulo - Variante: $variante / $numComic' class='title'>
                                        <span class='cover'>
                                        <img src='$cover' alt='$titulo - $variante / #$numComic'>
                                        </span>
                                        <strong><?php echo $titulo ?></strong>
                                        <span class='issue-number issue-number-l1'>$numComic</span>
                                    </a>
                                    <input type='hidden' name='id_grapa' id='id_grapa' value='$id_comic'>";

                                            if (check_guardado($id_user, $id_comic)) {
                                                echo "<button data-item-id='yXwd2' class='rem' >
                                        <span class='sp-icon'>Lo tengo</span>
                                    </button>";
                                            } else {
                                                echo "<button data-item-id='yXwd2' class='add' >
                                        <span class='sp-icon'>Lo tengo</span>
                                        </button>";
                                            }
                                            echo "</li>";
                                        }
                                        ?>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            <?php
            }
            ?>
            <div class="bgimg-2">
                <div id="footer-lite">
                    <div class="content">
                        <p class="helpcenter"><a href="http://www.example.com/help">Ayuda</a></p>
                        <p class="legal"><a href="https://www.hoy.es/condiciones-uso.html?ref=https%3A%2F%2Fwww.google.com%2F">Condiciones de uso</a><span>·</span><a href="https://policies.google.com/privacy?hl=es">Política de privacidad</a><span>·</span><a class="cookies" href="https://www.doblemente.com/modelo-de-ejemplo-de-politica-de-cookies/">Mis cookies</a><span>·</span><a href="about.php">Quiénes somos</a></p>
                        <!-- add social media with icons -->
                        <p class="social">
                            <a href="https://github.com/AlejandroRodriguezM"><img src="./assets/img/github.png" alt="Github" width="50" height="50" target="_blank"></a> <a href="http://www.infojobs.net/alejandro-rodriguez-mena.prf"><img src="https://brand.infojobs.net/downloads/ij-logo_reduced/ij-logo_reduced.svg" alt="infoJobs" width="50" height="50" target="_blank"></a>

                        </p>
                        <p class="copyright">©2023 Alejandro Rodriguez</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        var limit = 5;
        var offset = 0;
        var totalComics = 0;

        $(document).ready(function() {
            loadComics();

            $(window).scroll(function() {
                if ($(window).scrollTop() + $(window).height() >= $(document).height() - 20) {
                    offset += limit;
                    loadComics();
                }
            });
        });

        function loadComics() {
            var data = {
                limit: limit,
                offset: offset,
                search: "<?php echo $input_comic; ?>"
            };

            var url = "php/apis/resultado_comics.php?" + $.param(data);

            $.ajax({
                url: url,
                type: 'GET',
                success: function(data) {
                    var newComicList = '<tbody class="busqueda_comics">' + data + '</tbody>';
                    $('.comic_table').append(newComicList);
                }
            });
        }
    </script>
    <script>
        (function() {
            const buttonsAdd = document.querySelectorAll('.add');
            buttonsAdd.forEach(function(button) {
                button.addEventListener('click', function() {
                    if (button.classList.contains('add')) {
                        button.classList.remove('add');
                        button.classList.add('rem');
                        const id_comic = button.previousElementSibling.value;
                        guardar_comic(id_comic);
                    } else if (button.classList.contains('rem')) {
                        button.classList.remove('rem');
                        button.classList.add('add');
                        const id_comic = button.previousElementSibling.value;
                        quitar_comic(id_comic);
                    }
                });
            });

            const buttonsRem = document.querySelectorAll('.rem');
            buttonsRem.forEach(function(button) {
                button.addEventListener('click', function() {
                    if (button.classList.contains('rem')) {
                        button.classList.remove('rem');
                        button.classList.add('add');
                        const id_comic = button.previousElementSibling.value;
                        quitar_comic(id_comic);
                    } else if (button.classList.contains('add')) {
                        button.classList.remove('add');
                        button.classList.add('rem');
                        const id_comic = button.previousElementSibling.value;
                        guardar_comic(id_comic);

                    }
                });
            });
        })();
    </script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js" integrity="sha384-oBqDVmMz9ATKxIep9tiCxS/Z9fNfEXiDAYTujMAeBAsjFuCZSmKbSSUnQlmh/jp3" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>

    <script src="./assets/js/appLogin.js"></script>
    <script src="./assets/js/sweetalert2.all.min.js"></script>
    <script src="./assets/js/functions.js"></script>

</body>

</html>