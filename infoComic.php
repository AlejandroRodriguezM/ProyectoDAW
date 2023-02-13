<?php
session_start();
include_once 'php/inc/header.inc.php';
checkCookiesUser();
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
    <link rel="stylesheet" href="./assets/style/bandeja_comics.css">
    <link rel="stylesheet" href="./assets/style/footer_style.css">
    <link rel="stylesheet" href="./assets/style/coment_section.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.3.0/css/font-awesome.min.css" />
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.14.0/css/all.css" integrity="sha384-HzLeBuhoNPvSl5KYnjx0BT+WB0QEEqLprO+NBkkk5gbc67FTaL7XIGa2w1L0Xbgc" crossorigin="anonymous">



    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.3/font/bootstrap-icons.css">
    <title>Informacion del comic</title>
    <style>
        .comic-details {
            display: flex;
            flex-wrap: wrap;
            justify-content: space-between;
            padding: 10px;
            margin-bottom: 20px;
            border: 1px solid lightgray;
            border-radius: 5px;
        }

        .comic-detail {
            width: 48%;
            padding: 5px;
            box-sizing: border-box;
        }

        .card {
            width: 100%;
        }

        .comic-label {
            font-weight: bold;
        }

        .comic-value {
            color: blue;
        }

        .row {
            display: flex;
            flex-wrap: wrap;
        }
    </style>
</head>

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
                                $name = $userData['userName'];
                                $id_user = $userData['IDuser'];
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
                        <a class="nav-link" href="novedades.php" style='cursor:url(https://cdn.custom-cursor.com/db/cursor/32/Infinity_Gauntlet_Cursor.png) , default!important'>Novedades</a>
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

    <fieldset class='searchFieldset' id="searchFieldset" style="display: none;cursor:url(https://cdn.custom-cursor.com/db/cursor/32/Infinity_Gauntlet_Cursor.png) , default!important">
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
                            $id_comic = $_GET['IDcomic'];
                            $dataUser = getDataComic($id_comic);
                            $profilePicture = $dataUser['Cover'];
                            echo "<input type='hidden' id='id_comic' value='$id_comic'>";
                            echo "<img class='img-profile img-circle img-responsive center-block' id='avatarUser' alt='Avatar' src='$profilePicture' onclick='pictureProfileUser()'; style='width:120%; height: 120%;margin-left:-15px' />";

                            ?>

                            <ul class="meta list list-unstyled">
                                <li class="name"><label for="" style="font-size: 0.8em;">Nombre:</label>
                                    <?php
                                    $comicName = $dataUser['nomComic'];
                                    echo "$comicName";
                                    ?>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="content-panel">
                        <fieldset class="fieldset">
                            <h3 class="fieldset-title">Comic Info</h3>
                            <div class="form-group avatar">
                            </div>
                            <?php
                            $fechaCreacion = $dataUser['date_published'];
                            $nombre = $dataUser['nomComic'];
                            $variante = $dataUser['nomVariante'];
                            $editorial = $dataUser['nomEditorial'];
                            $autor = $dataUser['nomGuionista'];
                            $dibujante = $dataUser['nomDibujante'];
                            $procedencia = $dataUser['Procedencia'];
                            $numero = $dataUser['numComic'];
                            $formato = $dataUser['Formato'];
                            $valoracion_media = valoracion_media($id_comic);
                            echo "<div class='comic-details'>";
                            echo "  <div class='comic-detail'>";
                            echo "    <label class='comic-label'>Nombre del comic: </label>";
                            echo "    <span class='comic-value'><a href='search_data.php?search=" . $nombre . "'>$nombre</a></span>";
                            echo "  </div>";
                            echo "  <div class='comic-detail'>";
                            echo "    <label class='comic-label'>Numero: </label>";
                            echo "    <span class='comic-value'>$numero</span>";
                            echo "  </div>";
                            echo "  <div class='comic-detail'>";
                            echo "    <label class='comic-label'>Variante: </label>";
                            echo "    <span class='comic-value'><a href='search_data.php?search=" . $variante . "'>$variante</a></span>";
                            echo "  </div>";
                            echo "  <div class='comic-detail'>";
                            echo "    <label class='comic-label'>Formato: </label>";
                            echo "    <span class='comic-value'><a href='search_data.php?search=" . $formato . "'>$formato</a></span>";
                            echo "  </div>";
                            echo "  <div class='comic-detail'>";
                            echo "    <label class='comic-label'>Fecha de creacion: </label>";
                            echo "    <span class='comic-value'><a href='search_data.php?search=" . $fechaCreacion . "'>$fechaCreacion</a></span>";

                            echo "  </div>";
                            echo "  <div class='comic-detail'>";
                            echo "    <label class='comic-label'>Editorial: </label>";
                            echo "    <span class='comic-value'><a href='search_data.php?search=" . $editorial . "'>$editorial</a></span>";

                            echo "  </div>";
                            echo "  <div class='comic-detail'>";
                            echo "    <label class='comic-label'>Autor: </label>";
                            echo "    <span class='comic-value'><a href='search_data.php?search=" . $autor . "'>$autor</a></span>";
                            echo "  </div>";
                            echo "  <div class='comic-detail'>";
                            echo "    <label class='comic-label'>Dibujante: </label>";
                            echo "    <span class='comic-value'><a href='search_data.php?search=" . $dibujante . "'>$dibujante</a></span>";
                            echo "  </div>";
                            echo "  <div class='comic-detail'>";
                            echo "    <label class='comic-label'>Procedencia: </label>";
                            echo "    <span class='comic-value'><a href='search_data.php?search=" . $procedencia . "'>$procedencia</a></span>";

                            echo "  </div>";
                            echo "  <div class='comic-detail'>";
                            echo "    <label class='comic-label'>Valoracion media: </label>";

                            $full_stars = floor($valoracion_media);
                            $half_star = $valoracion_media - $full_stars >= 0.5 ? 1 : 0;
                            $empty_stars = 5 - $full_stars - $half_star;

                            for ($i = 0; $i < $full_stars; $i++) {
                                echo '<i class="fas fa-star"></i>';
                            }

                            if ($half_star) {
                                echo '<i class="fas fa-star-half-alt"></i>';
                            }

                            for ($i = 0; $i < $empty_stars; $i++) {
                                echo '<i class="far fa-star"></i>';
                            }

                            echo "  </div>";

                            echo "</div>";
                            ?>
                        </fieldset>

                        <div class="card">
                            <div class="p-3">
                                <h6>Opiniones</h6>
                            </div>
                            <form action="" method='POST' id='form_opinion' onsubmit="return false;">
                                <div class="d-flex flex-column form-color p-3">
                                    <div class="d-flex flex-wrap align-items-center">
                                        <img src='<?php echo $picture ?>' id='avatar' alt='Avatar' class='avatarPicture' onclick='pictureProfileAvatar()' style='cursor:url(https://cdn.custom-cursor.com/db/cursor/32/Infinity_Gauntlet_Cursor.png) , default!important'>
                                        <div class="pr-2">
                                            <h6 class="mb-0" style="margin-left:10px"><?php echo $name ?></h6>
                                        </div>
                                        <textarea id='opinion' class="form-control mt-2" placeholder="Pon tu comentario..." style="width: 100% !important; height: 110px !important; resize: none !important;"></textarea>
                                        <div class="d-flex flex-row align-items-center mr-2" id="rating">
                                            <label for="rating" class="mr-2">Valoracion:</label>
                                            <div class="rating" style="margin-left:5px">
                                                <input type="radio" name="rating" value="5" id="5">
                                                <label for="5">☆</label>
                                                <input type="radio" name="rating" value="4" id="4">
                                                <label for="4">☆</label>
                                                <input type="radio" name="rating" value="3" id="3">
                                                <label for="3">☆</label>
                                                <input type="radio" name="rating" value="2" id="2">
                                                <label for="2">☆</label>
                                                <input type="radio" name="rating" value="1" id="1">
                                                <label for="1">☆</label>
                                            </div>
                                        </div>
                                        <div class="boton-enviar d-flex flex-wrap align-items-center justify-content-end">
                                            <input type="hidden" id='id_user_opinion' value='<?php echo $id_user ?>'>
                                            <input type="hidden" id='id_comic' value='<?php echo $id_comic ?>'>
                                            <button type="submit" class="btn btn-primary boton-enviar" onclick="nueva_opinion()">Enviar</button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                            <div class="comentarios"></div>
                        </div>
                    </div>

                    <hr>

                    <div style="display: flex; justify-content: center;">
                        <div class="last-pubs">
                            <div class="titulo" style="display: flex; justify-content: center;">

                                <h2 style="align-items: center !important;color:black">Recomendaciones</h2>
                                <br>
                                <a href='novedades.php'>
                                    <button class="v2-cover-list" style='margin-left:650px !important;'>Ver mas</button>
                                </a>
                            </div>
                            <!-- <div class="scrollable-h comic-full"> -->
                            <div class="scrollable-h-content">
                                <ul class="v2-cover-list">
                                    <?php
                                    $total_comics = numComics();
                                    for ($i = 0; $i < 7; $i++) {
                                        $numero = randomComic();
                                        $data_comic = getDataComic($numero);
                                        $id = $data_comic['IDcomic'];
                                        $titulo = $data_comic['nomComic'];
                                        $numComic = $data_comic['numComic'];
                                        $variante = $data_comic['nomVariante'];

                                        echo "<li id='comicyXwd2' class='get-it'>
                                            <a href='infoComic.php?IDcomic=$id' title='$titulo - Variante: $variante / $numComic' class='title'>
                                                <span class='cover'>
                                                <img src='./assets/covers_img/$numero.jpg' alt='$titulo - $variante / #$numComic'>
                                            </span>
                                            <strong><?php echo $titulo ?></strong>
                                            <span class='issue-number issue-number-l1'>$numComic</span>
                                            </a>
                                            <input type='hidden' name='id_grapa' id='id_grapa' value='$id'>
                                            <button data-item-id='yXwd2' class='add' >
                                                <span class='sp-icon'>Lo tengo</span>
                                            </button>
                                                </li>";
                                    }
                                    ?>
                                </ul>
                            </div>
                            <!-- </div> -->
                        </div>
                    </div>
                </div>
        </div>
        </section>
    </div>
    </div>

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
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>

    <script>
        const buttons = document.querySelectorAll('.add');

        buttons.forEach(function(button) {
            button.addEventListener('click', function() {
                if (button.classList.contains('add')) {
                    button.classList.remove('add');
                    button.classList.add('rem');
                    const id_comic = button.previousElementSibling.value;
                    console.log(id_comic);
                } else {
                    button.classList.remove('rem');
                    button.classList.add('add');
                }
            });
        });
    </script>
    <script>
        $(document).ready(function() {
            $('input[type="radio"]').click(function() {
                var index = $(this).val();
                $('input[type="radio"]').each(function(i) {
                    if (i < index) {
                        $(this).next().addClass('checked');
                    } else {
                        $(this).next().removeClass('checked');
                    }
                });
            });
        });
    </script>
    <script>
        $(document).ready(function() {
            var id_comic = $("#id_comic").val(); // get the id_comic value here
            loadComentarios(id_comic);
        });

        function loadComentarios(id_comic) {
            var data = {
                id_comic: id_comic,
            };

            $.ajax({
                url: "php/user/comentarios.php",
                data: data,
                success: function(data) {
                    $('<div class="mt-2"> <div class = "d-flex flex-row p-3" > ' + data + ' </div> </div> </div> </div>').appendTo('.comentarios');
                }
            });
        }
    </script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js" integrity="sha384-oBqDVmMz9ATKxIep9tiCxS/Z9fNfEXiDAYTujMAeBAsjFuCZSmKbSSUnQlmh/jp3" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
    <script src="./assets/js/appLogin.js"></script>
    <script src="./assets/js/sweetalert2.all.min.js"></script>
    <script src="./assets/js/functions.js"></script>
</body>

</html>