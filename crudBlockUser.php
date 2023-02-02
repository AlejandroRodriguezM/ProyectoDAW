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
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.3/font/bootstrap-icons.css">
    <title>Lista de bloqueados</title>
</head>

<?php
if (isset($_POST['edit'])) {
    $emailUser = $_POST['emailUser'];
    $IDuser = $_POST['IDuser'];
    $passwordUser = obtain_password($emailUser);
    cookiesUserTemporal($emailUser, $passwordUser, $IDuser);
    header("Location: actualizandoUser.php");
}

if (isset($_POST['status'])) {
    $email = $_POST['emailUser'];
    changeStatusAccount($email);
}
?>


<body onload="checkSesionUpdate()">
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
    <div>
        <div class="view-account">
            <section class="module">
                <div class="module-inner">
                    <div class="side-bar">
                        <div class="user-info">
                            <?php
                            $email = $_SESSION['email'];
                            $dataUser = getUserData($email);
                            $profilePicture = $dataUser['userPicture'];
                            echo "<img class='img-profile img-circle img-responsive center-block' src='$profilePicture' style='width: 20%px; height: 20%; />";
                            ?>
                            <ul class="meta list list-unstyled">
                                <li class="name"><label for="" style="font-size: 0.8em;">Nombre:</label>
                                    <?php
                                    $email = $_SESSION['email'];
                                    $dataUser = getUserData($email);
                                    $userName = $dataUser['userName'];
                                    echo "$userName";
                                    ?>
                                </li>
                                <li class="email"><label for="" style="font-size: 0.8em;">Mail: </label>
                                    <?php
                                    $email = $_SESSION['email'];
                                    $dataUser = getUserData($email);
                                    $email = $dataUser['email'];
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
                                <li><a href="adminPanelUser.php"><span class="fa fa-user"></span>Lista de usuarios</a></li>
                                <li><a href=""><span class="fa fa-cog"></span>Lista de comics</a></li>
                                <li class="active"><a href="crudBlockUser.php"><span class="fa fa-cog"></span>Bloqueados</a></li>
                            </ul>
                        </nav>
                    </div>
                </div>
            </section>
        </div>

        <div style="margin-left: auto; margin-right: auto; width: 80%">
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


                            <?php
                                    if ($user['accountStatus'] == 'block') {
                            ?>
                                <td name='IDuser'><?php echo $user['IDuser'] ?></td>
                                <td><img src='<?php echo $user['userPicture'] ?>' style='width: 100px; height: 100px; border-radius: 50%;'></td>
                                <td id='nameUser' name='nameUser'><?php echo $user['userName'] ?></td>
                                <td id='emailUser' name='emailUser'><?php echo $user['email'] ?></td>
                                <td><?php echo $user['privilege'] ?></td>
                                <td><?php echo $user['accountStatus'] ?></td>
                                <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                                    <td style='margin-left: auto; margin-right: auto; width: 10%'><button class='btn btn-success' name='edit' id='edit'> <i class='bi bi-pencil-square p-1'></i>Editar</button></td>
                                    <td style='margin-left: auto; margin-right: auto; width: 10%'><button class='btn btn-danger' name='status' onclick='return confirm("¿Estas seguro que quieres desbloquear al usuario?")'> <i class='bi bi-trash p-1'></i>Desbloquear</button></td>
                                    <td><input type='hidden' name='IDuser' id='IDuser' value='<?php echo $user['IDuser'] ?>'></td>
                                    <td><input type='hidden' name='nameUser' id='nameUser' value='<?php echo $user['userName'] ?>'></td>
                                    <td><input type='hidden' name='emailUser' id='emailUser' value='<?php echo $user['email'] ?>'></td>
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
    <script>
        // Get the modal
        var modal = document.getElementById("myModal");

        // Get the image and insert it inside the modal - use its "alt" text as a caption
        var img = document.getElementById("avatar");
        var modalImg = document.getElementById("img01");
        var captionText = document.getElementById("caption");
        img.onclick = function() {
            modal.style.display = "block";
            modalImg.src = this.src;
            captionText.innerHTML = this.alt;
        }

        // Get the <span> element that closes the modal
        var span = document.getElementsByClassName("close")[0];

        modal.addEventListener('click', function() {
            this.style.display = "none";
        })
    </script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js" integrity="sha384-oBqDVmMz9ATKxIep9tiCxS/Z9fNfEXiDAYTujMAeBAsjFuCZSmKbSSUnQlmh/jp3" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>

    <script src="./assets/js/appLogin.js"></script>
    <script src="./assets/js/sweetalert2.all.min.js"></script>
    <script src="./assets/js/functions.js"></script>
</body>

</html>