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
    <link rel="stylesheet" href="./assets/style/novedades.css">
    <link rel="stylesheet" href="./assets/style/parallax.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.3.0/css/font-awesome.min.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.3/font/bootstrap-icons.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>
    <title>Novedades</title>
    <style>
        .custom-table {
            width: 300px;
            margin: 20px auto;
            border-collapse: collapse;
        }

        .custom-table th,
        .custom-table td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }

        .custom-table th {
            background-color: #ddd;
        }

        .expand-row {
            height: 0;
            overflow: hidden;
            transition: all 0.5s ease;
        }

        .custom-table tr:hover {
            background-color: #f5f5f5;
        }

        input[name='buscador_navegacion'] {
            width: 300px;
            height: 35px;
            padding: 5px;
            font-size: 16px;
            border-radius: 5px;
            border: 1px solid #ccc;
            margin-top: 20px;
            margin-left: 10px;
        }

        .side-bar {
            position: fixed;
            margin-top: -30px;
            color: black;
        }

        .view-account {
            position: fixed !important;
            top: 50px;
            z-index: 100;
            margin-top: 30px;
        }

        span,
        label,
        a {
            color: black;
        }
        .navbar {
            position: fixed;
            top: 0;
            width: 100%;
            z-index: 1000;
        }
    </style>
</head>

<body onload="checkSesionUpdate();showSelected()">
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
                            <li><button class="dropdown-item" onclick="closeSesion()" name="closeSesion" style='cursor:url(https://cdn.custom-cursor.com/db/cursor/32/Infinity_Gauntlet_Cursor.png) , default!important'><i class="bi bi-box-arrow-right p-1"></i>Cerrar sesion</a></li>
                        </ul>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" aria-current="page" href="inicio.php" style='cursor:url(https://cdn.custom-cursor.com/db/cursor/32/Infinity_Gauntlet_Cursor.png) , default!important'>Inicio</a>
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
                        <a class="nav-link active" href="novedades.php" style='cursor:url(https://cdn.custom-cursor.com/db/cursor/32/Infinity_Gauntlet_Cursor.png) , default!important'>Novedades</a>
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
            <div class="view-account">
                <section class="module">
                    <div class="module-inner">
                        <div class="side-bar">
                            <br>
                            <div class="container mt-5" style="background-color: white;margin-left:10px">
                                <nav class="side-menu">
                                    <ul class="nav">
                                        <li class="dropdown" onclick="toggleDropdown(this)">
                                            <a href="#" style='color:black;font-size:25px'><span class="fa fa-cog"></span>Escritores</a>
                                            <div id="dropdownContent1" class="dropdown-content" onclick="closeDropdown(this)">
                                                <input type="text" name="buscador_navegacion" id="searchInput1" onkeyup="searchData(1)">
                                                <?php
                                                $tabla_escritores = getScreenwriters();
                                                mostrar_datos($tabla_escritores);
                                                ?>
                                            </div>
                                        </li>

                                        <li class="dropdown dropdown-sibling" onclick="toggleDropdown(this)">
                                            <a href="#" style='color:black;font-size:25px'><span class="fa fa-cog"></span>Artistas</a>
                                            <div id="dropdownContent2" class="dropdown-content" onclick="closeDropdown(this)">
                                                <input type="text" name="buscador_navegacion" id="searchInput2" onkeyup="searchData(2)">
                                                <?php
                                                $tabla_escritores = getArtists();
                                                mostrar_datos($tabla_escritores);
                                                ?>
                                            </div>
                                        </li>

                                        <li class="dropdown" onclick="toggleDropdown(this)">
                                            <a href="#" style='color:black;font-size:25px'><span class="fa fa-cog"></span>Portadas</a>
                                            <div id="dropdownContent3" class="dropdown-content" onclick="closeDropdown(this)">
                                                <input type="text" name="buscador_navegacion" id="searchInput3" onkeyup="searchData(3)">
                                                <?php
                                                $tabla_escritores = getPortadas();
                                                mostrar_datos($tabla_escritores);
                                                ?>
                                            </div>
                                        </li>

                                        <li class="dropdown dropdown-sibling" onclick="toggleDropdown(this)">
                                            <a href="#" style='color:black;font-size:25px'><span class="fa fa-cog"></span>Editorial</a>
                                            <div id="dropdownContent4" class="dropdown-content" onclick="closeDropdown(this)">
                                                <input type="text" id="searchInput4" onkeyup="searchData(4)">
                                                <?php
                                                $tabla_editorial = getEditorial();
                                                mostrar_datos($tabla_editorial);
                                                ?>
                                            </div>
                                        </li>

                                        <script>
                                            function searchData(id) {
                                                let input, filter, table, tr, td, i, txtValue;
                                                input = document.getElementById("searchInput" + id);
                                                filter = input.value.toUpperCase();
                                                table = document.getElementById("dropdownContent" + id);
                                                tr = table.getElementsByTagName("tr");
                                                for (i = 0; i < tr.length; i++) {
                                                    td = tr[i].getElementsByTagName("td")[0];
                                                    if (td) {
                                                        txtValue = td.textContent || td.innerText;
                                                        if (txtValue.toUpperCase().indexOf(filter) > -1) {
                                                            tr[i].style.display = "";
                                                        } else {
                                                            tr[i].style.display = "none";
                                                        }
                                                    }
                                                }
                                            }
                                        </script>
                                    </ul>
                                </nav>
                            </div>
                        </div>
                    </div>
                </section>
            </div>

            <div style="display: flex; justify-content: center;">
                <div class="container mt-5">
                    <div class="last-pubs">
                        <br>
                        <div class="titulo" style="border-radius:10px">
                            <h2 style='text-align: center'>Mis novedades</h2>
                        </div>
                        <br>
                    </div>
                </div>
            </div>

            <div class="bgimg-2">
                <div id="footer-lite">
                    <div class="content">
                        <p class="helpcenter"><a href="http://www.example.com/help">Ayuda</a></p>
                        <p class="legal"><a href="https://www.hoy.es/condiciones-uso.html?ref=https%3A%2F%2Fwww.google.com%2F">Condiciones de uso</a><span>·</span><a href="https://policies.google.com/privacy?hl=es">Política de privacidad</a><span>·</span><a class="cookies" href="https://www.doblemente.com/modelo-de-ejemplo-de-politica-de-cookies/">Mis cookies</a><span>·</span><a href="about.php">Quiénes somos</a></p>
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
        var limit = 24;
        var offset = 0;
        var totalComics = 0;
        var checkboxChecked = null;

        $('input[type=checkbox]').on('change', function() {
            if ($(this).prop('checked') != true) {
                checkboxChecked = null;
            }
        });

        $(document).ready(function() {
            loadComics(checkboxChecked);

            $(window).scroll(function() {
                if ($(window).scrollTop() + $(window).height() >= $(document).height() - 20 && checkboxChecked == null) {
                    offset += limit;
                    loadComics(checkboxChecked);

                }
            });

            var checkboxes = document.querySelectorAll('input[type=checkbox]');
            for (var i = 0; i < checkboxes.length; i++) {
                checkboxes[i].addEventListener('change', function() {
                    if ($("input[type='checkbox']:checked").length > 0) {
                        checkboxChecked = $("input[type='checkbox']:checked").val();
                    }
                    if (checkboxChecked) {
                        offset = 0;
                        $('.new-comic-list').remove();
                        loadComics(checkboxChecked);
                    } else {
                        offset = 0;
                        $('.new-comic-list').remove();
                        loadComics(checkboxChecked);
                    }
                });
            }
        });

        function loadComics() {
            var selectedCheckboxes = $("input[type='checkbox']:checked").map(function() {
                return encodeURIComponent(this.value);
            }).get();

            var data = {
                limit: limit,
                offset: offset,
            };

            if (selectedCheckboxes.length > 0) {
                data.checkboxChecked = selectedCheckboxes.join(",");
            }

            $.ajax({
                url: "php/apis/comics.php",
                data: data,
                success: function(data) {
                    totalComics = $(data).filter("#total-comics").val();
                    if (offset + limit >= totalComics) {
                        $("#load-more-comics").hide();
                    }
                    $('<div class="new-comic-list"><ul class="v2-cover-list" id="comics-list">' + data + '</ul></div>').appendTo('.last-pubs');
                }
            });
        }
    </script>

    <script>
        function toggleDropdown(element) {
            var dropdownContent1 = document.getElementById("dropdownContent1");
            var dropdownContent2 = document.getElementById("dropdownContent2");
            var dropdownContent3 = document.getElementById("dropdownContent3");
            var dropdownContent4 = document.getElementById("dropdownContent4");

            if (element.querySelector(".dropdown-content").style.display === "block" && event.target.tagName !== 'INPUT') {
                dropdownContent1.style.display = "none";
                dropdownContent2.style.display = "none";
                dropdownContent3.style.display = "none";
                dropdownContent4.style.display = "none";
            } else {
                dropdownContent1.style.display = "none";
                dropdownContent2.style.display = "none";
                dropdownContent3.style.display = "none";
                dropdownContent4.style.display = "none";
                element.querySelector(".dropdown-content").style.display = "block";
            }
        }

        function closeDropdown(dropdownContent) {
            dropdownContent.style.display = "none";
        }

        document.addEventListener("click", function(event) {
            var dropdowns = document.getElementsByClassName("dropdown-content");
            for (var i = 0; i < dropdowns.length; i++) {
                var dropdown = dropdowns[i];
                if (event.target.closest(".dropdown") !== dropdown.parentNode && event.target !== dropdown.parentNode) {
                    dropdown.style.display = "none";
                }
            }
        });
    </script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js" integrity="sha384-oBqDVmMz9ATKxIep9tiCxS/Z9fNfEXiDAYTujMAeBAsjFuCZSmKbSSUnQlmh/jp3" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
    <script src="./assets/js/appLogin.js"></script>
    <script src="./assets/js/sweetalert2.all.min.js"></script>
    <script src="./assets/js/functions.js"></script>
</body>

</html>