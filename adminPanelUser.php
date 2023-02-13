<?php
session_start();
include_once 'php/inc/header.inc.php';
checkCookiesAdmin();
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
    <link rel="stylesheet" href="./assets/style/footer_style.css">

    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.3/font/bootstrap-icons.css">
    <title>Panel de administracion</title>
</head>

<?php
if (isset($_POST['edit'])) {
    $emailUser = $_POST['emailUser'];
    $IDuser = $_POST['IDuser'];
    $passwordUser = obtain_password($emailUser);
    cookiesUserTemporal($emailUser, $passwordUser, $IDuser);
    header("Location: actualizandoUser.php");
}
if (isset($_POST['avatarUser'])) {
    $emailUser = $_POST['emailUser'];
    $IDuser = $_POST['IDuser'];
    $passwordUser = obtain_password($emailUser);
    cookiesUserTemporal($emailUser, $passwordUser, $IDuser);
    header("Location: adminInfoUser.php");
}

if (isset($_POST['status'])) {
    $emailStatus = $_POST['emailUser'];
    changeStatusAccount($emailStatus);
}

if (isset($_POST['del'])) {
    $email = $_POST['emailUser'];
    $IDuser = $_POST['IDuser'];
    delete_user($email, $IDuser);
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
                        <a class="nav-link" aria-current="page" href="inicio.php" style='cursor:url(https://cdn.custom-cursor.com/db/cursor/32/Infinity_Gauntlet_Cursor.png) , default!important'>Inicio</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="micoleccion.php" style='cursor:url(https://cdn.custom-cursor.com/db/cursor/32/Infinity_Gauntlet_Cursor.png) , default!important'>Mi colección</a>
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
                        } elseif($userPrivilege == 'user') {
                            echo "<li><a class='dropdown-item' href='infoPerfil.php' style='cursor:url(https://cdn.custom-cursor.com/db/cursor/32/Infinity_Gauntlet_Cursor.png) , default!important'><i class='bi bi-person-circle p-1'></i>Mi perfil</a></i>";
                            echo "<li><a class='dropdown-item' href='#' style='cursor:url(https://cdn.custom-cursor.com/db/cursor/32/Infinity_Gauntlet_Cursor.png) , default!important'><i class='bi bi-person-circle p-1'></i>Enviar un ticket</a></i>";
                        }
                        else{
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
                            <li class="name">
                                <label for="" style="font-size: 0.8em;">Nombre:</label>
                                <?php
                                $dataUser = getUserData($email);
                                $userName = $dataUser['userName'];
                                echo "$userName";
                                ?>
                            </li>
                            <li class="email">
                                <label for="" style="font-size: 0.8em;">Mail: </label>
                                <?php
                                $dataUser = getUserData($email);
                                $email = $dataUser['email'];
                                echo " " . "<span style='font-size: 0.7em'>$email</span>";
                                ?>
                            </li>
                            <li class="activity">
                                <label for="" style="font-size: 0.8em;">Logged in: </label>
                                <?php
                                $hora = $_SESSION['hour'];
                                echo "$hora";
                                ?>
                            </li>
                        </ul>
                    </div>
                    <nav class="side-menu">
                        <ul class="nav">
                            <li class="active"><a href="adminPanelUser.php"><span class="fa fa-user"></span>Lista de usuarios</a></li>
                            <li><a href=""><span class="fa fa-cog"></span>Lista de comics</a></li>
                            <li><a href="admin_panel_block.php"><span class="fa fa-cog"></span>Bloqueados</a></li>
                            <li><a href="panel_tickets_admin.php"><span class="fa fa-cog"></span>Panel de mensajes</a></li>
                        </ul>
                    </nav>
                </div>
                <div class="content-panel">
                    <div style="margin-right: auto; width: 80%">
                        <div class="card-body">
                            <table class="table table-hover">
                                <thead class="table-dark">
                                    <tr>
                                        <td>ID</td>
                                        <td>Imagen de perfil</td>
                                        <td>Nombre</td>
                                        <td>Correo</td>
                                        <td>Privilegio</td>
                                        <td>Estado</td>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                                            <?php
                                            $registros = showUsers();
                                            $user = $registros->fetch();
                                            while ($user != null) {
                                            ?>
                                    <tr>
                                        <td name='IDuser'><?php echo $user['IDuser'] ?></td>

                                        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                                            <td><input type="hidden" name="avatarUser"><input type="image" src="<?php echo $user['userPicture'] ?>" class="avatarPicture" name="avatarUser" id="avatar" alt="Avatar" style="width: 100px; height: 100px; border-radius: 50%;"></td>
                                            <input type='hidden' name='IDuser' id='IDuser' value='<?php echo $user['IDuser'] ?>'>
                                            <input type='hidden' name='nameUser' id='nameUser' value='<?php echo $user['userName'] ?>'>
                                            <input type='hidden' name='emailUser' id='emailUser' value='<?php echo $user['email'] ?>'>
                                        </form>
                                        <td id='nameUser' name='nameUser'><?php echo $user['userName'] ?></td>
                                        <td id='emailUser' name='emailUser'><?php echo $user['email'] ?></td>
                                        <td><?php echo $user['privilege'] ?></td>
                                        <td><?php echo $user['accountStatus'] ?></td>
                                        <?php
                                                if ($user['privilege'] == 'guest') {
                                        ?>
                                            <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                                                <td style='margin-left: auto; margin-right: auto; width: 10%; cursor: not-allowed'><button class='btn btn-success' disabled> <i class='bi bi-pencil-square p-1'></i>Editar</button></td>
                                                <td style='margin-left: auto; margin-right: auto; width: 10%; cursor: not-allowed'><button class='btn btn-danger' disabled> <i class='bi bi-trash p-1'></i>Bloquear</button></td>
                                                <td style='margin-left: auto; margin-right: auto; width: 10%; cursor: not-allowed'><button class='btn btn-danger' disabled> <i class='bi bi-trash p-1'></i>Eliminar</button></td>
                                                <td><input type='hidden' name='IDuser' id='IDuser' value='<?php echo $user['IDuser'] ?>'></td>
                                                <td><input type='hidden' name='nameUser' id='nameUser' value='<?php echo $user['userName'] ?>'></td>
                                                <td><input type='hidden' name='emailUser' id='emailUser' value='<?php echo $user['email'] ?>'></td>
                                            </form>
                                        <?php
                                                } elseif ($user['privilege'] == 'admin') {
                                        ?>
                                            <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                                                <td style='margin-left: auto; margin-right: auto; width: 10%'><button name='edit' class='btn btn-success'> <i class='bi bi-pencil-square p-1'></i>Editar</button></td>
                                                <td style='margin-left: auto; margin-right: auto; width: 10%; cursor: not-allowed'><button class='btn btn-danger' disabled> <i class='bi bi-trash p-1'></i>Bloquear</button></td>
                                                <td style='margin-left: auto; margin-right: auto; width: 10%; cursor: not-allowed'><button class='btn btn-danger' disabled> <i class='bi bi-trash p-1'></i>Eliminar</button></td>

                                                <input type='hidden' name='IDuser' id='IDuser' value='<?php echo $user['IDuser'] ?>'>
                                                <input type='hidden' name='nameUser' id='nameUser' value='<?php echo $user['userName'] ?>'>
                                                <input type='hidden' name='emailUser' id='emailUser' value='<?php echo $user['email'] ?>'>
                                            </form>
                                        <?php
                                                } elseif ($user['accountStatus'] == 'block') {
                                        ?>
                                            <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                                                <td style='margin-left: auto; margin-right: auto; width: 10%'><button class='btn btn-success' name='edit' id='edit'> <i class='bi bi-pencil-square p-1'></i>Editar</button></td>
                                                <td style='margin-left: auto; margin-right: auto; width: 10%'><button class='btn btn-danger' name='status' onclick='return confirm("¿Estas seguro que quieres desbloquear al usuario?")'> <i class='bi bi-trash p-1'></i>Desbloquear</button></td>
                                                <td style='margin-left: auto; margin-right: auto; width: 10%'><button class='btn btn-danger' name='del' onclick='return confirm("¿Estas seguro que quieres borrar al usuario?")'> <i class='bi bi-trash p-1'></i>Eliminar</button></td>

                                                <input type='hidden' name='IDuser' id='IDuser' value='<?php echo $user['IDuser'] ?>'>
                                                <input type='hidden' name='nameUser' id='nameUser' value='<?php echo $user['userName'] ?>'>
                                                <input type='hidden' name='emailUser' id='emailUser' value='<?php echo $user['email'] ?>'>
                                            </form>
                                        <?php
                                                } else {
                                        ?>
                                            <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                                                <td style='margin-left: auto; margin-right: auto; width: 10%'><button class='btn btn-success' name='edit'> <i class='bi bi-pencil-square p-1'></i>Editar</button></td>
                                                <td style='margin-left: auto; margin-right: auto; width: 10%'><button class='btn btn-danger' name='status' onclick='return confirm("¿Estas seguro que quieres bloquear al usuario?")'> <i class='bi bi-trash p-1'></i>Bloquear</button></td>
                                                <td style='margin-left: auto; margin-right: auto; width: 10%'><button class='btn btn-danger' name='del' onclick='return confirm("¿Estas seguro que quieres borrar al usuario?")'> <i class='bi bi-trash p-1'></i>Eliminar</button></td>
                                                <input type='hidden' name='IDuser' id='IDuser' value='<?php echo $user['IDuser'] ?>'>
                                                <input type='hidden' name='nameUser' id='nameUser' value='<?php echo $user['userName'] ?>'>
                                                <input type='hidden' name='emailUser' id='emailUser' value='<?php echo $user['email'] ?>'>
                                            </form>
                                    <?php
                                                }
                                                echo "</tr>";
                                                $user = $registros->fetch();
                                            }
                                    ?>
                                    </form>
                                    </tr>
                                </tbody>
                            </table>
                            <h5 class="card-title"></h5>
                            <p class="card-text"></p>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>



    <!-- The Modal -->
    <div id="myModal" class="modal modal_img" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <img class="modal-content_img" id="img01">
    </div>
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
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js" integrity="sha384-oBqDVmMz9ATKxIep9tiCxS/Z9fNfEXiDAYTujMAeBAsjFuCZSmKbSSUnQlmh/jp3" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>

    <script src="./assets/js/appLogin.js"></script>
    <script src="./assets/js/sweetalert2.all.min.js"></script>
    <script src="./assets/js/functions.js"></script>
</body>

</html>