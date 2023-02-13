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

    <title>Inicio</title>
    <style>
        .row {
            display: flex;
            flex-wrap: wrap;
        }

        #wrapper.home div.comments {
            padding-right: 20px;
            line-height: 140%;
        }

        .link-grey:hover {
            color: #00913b;
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

    <!-- AQUI VA EL CONTENIDO DE LA PAGINA -->
    <?php
    // global $conection;
    // //update table comics
    // //count rows in comics
    // $query = "SELECT COUNT(*) FROM comics";
    // $count = $conection->prepare($query);
    // $count->execute();
    // $count = $count->fetchColumn();
    // $num = $count;
    // for ($i = 1; $i <= $count; $i++) {
    //     echo $i;
    //     $query = "UPDATE comics SET Cover = './assets/covers_img/$i.jpg' where IDcomic = $i";
    //     $insertData = $conection->prepare($query);
    //     $insertData->execute();
    // }
    ?>

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

    <div class="bgimg-1">
        <div class="caption">
            <div style="display: flex; justify-content: center;">
                <!-- Carousel -->
                <div id="carousel-publi" class="carousel slide" data-bs-ride="carousel">
                    <!-- Indicators/dots -->
                    <div class="carousel-indicators">
                        <button type="button" data-bs-target="#demo" data-bs-slide-to="0" class="active"></button>
                        <button type="button" data-bs-target="#demo" data-bs-slide-to="1"></button>
                        <button type="button" data-bs-target="#demo" data-bs-slide-to="2"></button>
                    </div>
                    <!-- The slideshow/carousel -->
                    <div class="carousel-inner">
                        <div class="carousel-item active">
                            <a href='https://www.panini.es/shp_esp_es/comics/europeo.html' target="_blank">
                                <img src="assets/img/banner/panini.jpg" alt="Pagina de comics de panini" class="d-block" style="width: 945px; height: 300px;">
                            </a>
                        </div>
                        <div class="carousel-item">
                            <a href='https://www.radarcomics.com/es/' target="_blank">
                                <img src="assets/img/banner/radar.jpg" alt="Pagina de comics de radar comics" class="d-block" style="width: 945px; height: 300px;">
                            </a>
                        </div>
                        <div class="carousel-item">
                            <a href='https://www.whakoom.com/' target="_blank">
                                <img src="assets/img/banner/whakoom.jpg" alt="Otra pagina de gestion de comics Whakoom" class="d-block" style="width: 945px; height: 300px;">
                            </a>
                        </div>
                    </div>
                    <!-- Left and right controls/icons -->
                    <button class="carousel-control-prev" type="button" data-bs-target="#carousel-publi" data-bs-slide="prev">
                        <span class="carousel-control-prev-icon"></span>
                    </button>
                    <button class="carousel-control-next" type="button" data-bs-target="#carousel-publi" data-bs-slide="next">
                        <span class="carousel-control-next-icon"></span>
                    </button>
                </div>
            </div>
            <div class="container mt-5">
                <div style="display: flex; justify-content: center;">
                    <div class="last-pubs">
                        <div class="titulo" style="display: flex; justify-content: center; ">
                            <h2 style="align-items: center;color:black">Recomendaciones</h2>

                        </div>
                        <a href='novedades.php'>
                            <button class="v2-cover-list" style='margin-left:1055px !important;'>Ver mas</button>
                        </a>
                        <br>
                        <div class="scrollable-h comic-full">
                            <div class="scrollable-h-content">
                                <ul class="v2-cover-list">
                                    <?php
                                    $total_comics = numComics();
                                    for ($i = 0; $i < 8; $i++) {
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
                        </div>
                    </div>
                </div>
            </div>
            <div class="container mt-5">
                <h2>Videos de interes</h2>
                <div style="display: flex;">
                    <iframe width="560" height="315" src="https://www.youtube.com/embed/1Rx_p3NW7gQ" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in- picture" allowfullscreen style="margin-right: 20px;"></iframe>
                    <iframe width="560" height="315" src="https://www.youtube.com/embed/rYy0o-J0x20" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in- picture" allowfullscreen></iframe>
                </div>
            </div>

            <div class="container mt-5">
                <div class="row d-flex justify-content-center">
                    <div class="col-md-8">
                        <div class="headings d-flex justify-content-between align-items-center mb-3">
                            <h5>Opiniones de los usuarios</h5>
                        </div>
                        <div class="card p-3">
                            <div class="d-flex justify-content-between align-items-center">
                                <div class="user d-flex flex-row align-items-center">
                                    <img src="https://i.imgur.com/hczKIze.jpg" width="30" class="user-img rounded-circle mr-2">
                                    <span><small class="font-weight-bold text-primary">james_olesenn</small> <small class="font-weight-bold">Hmm, This poster looks cool</small></span>
                                </div>
                                <small>2 days ago</small>
                            </div>
                        </div>
                        <div class="card p-3 mt-2">
                            <div class="d-flex justify-content-between align-items-center">
                                <div class="user d-flex flex-row align-items-center">
                                    <img src="https://i.imgur.com/C4egmYM.jpg" width="30" class="user-img rounded-circle mr-2">
                                    <span><small class="font-weight-bold text-primary">olan_sams</small> <small class="font-weight-bold">Loving your work and profile! </small></span>
                                </div>
                                <small>3 days ago</small>
                            </div>
                        </div>
                        <div class="card p-3 mt-2">
                            <div class="d-flex justify-content-between align-items-center">
                                <div class="user d-flex flex-row align-items-center">
                                    <img src="https://i.imgur.com/0LKZQYM.jpg" width="30" class="user-img rounded-circle mr-2">
                                    <span><small class="font-weight-bold text-primary">rashida_jones</small> <small class="font-weight-bold">Really cool Which filter are you using? </small></span>
                                </div>
                                <small>3 days ago</small>
                            </div>
                        </div>
                        <div class="card p-3 mt-2">
                            <div class="d-flex justify-content-between align-items-center">
                                <div class="user d-flex flex-row align-items-center">
                                    <img src="https://i.imgur.com/ZSkeqnd.jpg" width="30" class="user-img rounded-circle mr-2">
                                    <span><small class="font-weight-bold text-primary">simona_rnasi</small> <small class="font-weight-bold text-primary">@macky_lones</small> <small class="font-weight-bold text-primary">@rashida_jones</small> <small class="font-weight-bold">Thanks </small></span>
                                </div>
                                <small>3 days ago</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="bgimg-2">
            <div id="footer-lite">
                <div class="content">
                    <p class="helpcenter"><a href="http://www.example.com/help">Ayuda</a></p>
                    <p class="legal"><a href="https://www.hoy.es/condiciones-uso.html?ref=https%3A%2F%2Fwww.google.com%2F">Condiciones de uso</a><span>·</span><a href="https://policies.google.com/privacy?hl=es">Política de privacidad</a><span>·</span><a class="cookies" href="https://www.doblemente.com/modelo-de-ejemplo-de-politica-de-cookies/">Mis cookies</a><span>·</span><a href="about.php">Quiénes somos</a></p>
                    <!-- add social media with icons -->
                    <p class="social">
                        <a href="https://github.com/AlejandroRodriguezM"><img src="./assets/img/github.png" alt="Github" width="50" height="50" target="_blank"></a>
                        <a href="http://www.infojobs.net/alejandro-rodriguez-mena.prf"><img src="https://brand.infojobs.net/downloads/ij-logo_reduced/ij-logo_reduced.svg" alt="infoJobs" width="50" height="50" target="_blank"></a>

                    </p>
                    <p class="copyright">©2023 Alejandro Rodriguez</p>
                </div>
            </div>
        </div>
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
                        const id_comic = button.previousElementSibling.value;
                        console.log(id_comic);
                    }
                });
            });
        </script>

        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js" integrity="sha384-oBqDVmMz9ATKxIep9tiCxS/Z9fNfEXiDAYTujMAeBAsjFuCZSmKbSSUnQlmh/jp3" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>

        <script src="./assets/js/appLogin.js"></script>
        <script src="./assets/js/sweetalert2.all.min.js"></script>
        <script src="./assets/js/functions.js"></script>
</body>

</html>