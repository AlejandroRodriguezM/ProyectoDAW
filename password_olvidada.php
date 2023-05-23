<?php
session_start();
include_once 'php/inc/header.inc.php';
if (isset($_SESSION['email'])) {
    header('Location: index.php');
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="./assets/img/webico.ico" type="image/x-icon">
    <link rel="shortcut icon" href="./assets/img/webico.ico" type="image/x-icon">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/Wruczek/Bootstrap-Cookie-Alert@gh-pages/cookiealert.css">
    <!-- <link rel="stylesheet" href="./assets/style/style.css"> -->
    <link rel="stylesheet" href="./assets/style/show-password-toggle.css">
    <!-- <link rel="stylesheet" href="./assets/style/footer_style.css"> -->
    <link rel="stylesheet" href="./assets/style/style_index.css">

    <script src="https://cdn.jsdelivr.net/gh/Wruczek/Bootstrap-Cookie-Alert@gh-pages/cookiealert.js"></script>
    <script src="./assets/js/funciones_utilidades.js"></script>
    <script src="./assets/js/ajaxFunctions.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
    <script src="./assets/js/sweetalert2.all.min.js"></script>
    <title>¿Has olvidado tu contraseña?</title>

    <style>
        .chosenUserProfile {
            width: 106px;
            height: 106px;
            background-color: #999999;
            border: 4px solid #CCCCCC;
            color: #FFFFFF;
            border-radius: 50%;
            margin: 0px auto;
            overflow: hidden;
            transition: all 0.2s;
            -webkit-transition: all 0.2s;
        }

        body {
            margin: 0 !important;
            /* padding: 0 !important; */
            height: 100% !important;

        }

        main {

            min-height: 100vh !important;
        }

        /* Estilos generales para el footer */
        #footer-lite {
            background-color: #f5f5f5;
            padding: 20px 0;
            text-align: center;
        }

        /* Estilos para los enlaces */
        #footer-lite a {
            color: #444;
        }

        #footer-lite a:hover {
            color: #007bff;
            text-decoration: none;
        }

        /* Estilos para los íconos de redes sociales */
        #footer-lite .social a img {
            margin-right: 10px;
        }

        /* Estilos para el texto del copyright */
        #footer-lite .copyright {
            font-size: 14px;
            margin-top: 10px;
        }
    </style>
</head>

<body class="d-flex flex-column min-vh-100">
    <main class="flex-shrink-0">

        <div class="bg-image bg-attachment-fixed" style="background-image: url('assets/img/background.jpg');opacity: 0.8;">
            <br>
            <div class="container">
                <div class="d-flex justify-content-center align-items-center" style="min-height: 68vh;">
                    <div class="col-12 col-md-6 offset-md-3 mx-auto max-w-md text-center">
                        <div class="bg-white p-4 rounded-lg shadow-sm no-opacity" style="background-color: white !important;border-radius:15px">

                            <div class="row justify-content-center col-lg-7 mx-auto">
                                    <div class="logo-container">
                                    <a href="login.php">
                                        <img src="./assets/img/logoWeb.png" alt="logo web">
                                    </a>
                                </div>                                <h3 class="mt-2">Datos para recuperar la contraseña</h3>
                                <form id="form_pass_olvidada" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">

                                    <div class="mb-3 text-center">
                                        <label for="correo" class="form-label w-100">Correo electronico</label>
                                        <input type="email" class="form-control" id="correo" name="correo" placeholder="Correo electronico" required>
                                    </div>

                                    <div class="mb-3">
                                        <input type="button" class="btn btn-danger form-control" onclick="solicitud_password();" value="Recuperar contraseña" style="cursor:url(https://cdn.custom-cursor.com/db/pointer/32/Infinity_Gauntlet_Pointer.png) , pointer!important ">
                                    </div>
                                    <div class="mb-3">
                                        <a href="login.php" type="button" class="btn btn-primary form-control" style="cursor:url(https://cdn.custom-cursor.com/db/pointer/32/Infinity_Gauntlet_Pointer.png) , pointer!important ">Volver</a>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div id="footer-lite" class="mt-5">
                <div class="container">
                    <p class="helpcenter">
                        <a href="http://www.example.com/help">Ayuda</a>
                    </p>
                    <p class="footer-title">
                        <a href="https://www.hoy.es/condiciones-uso.html?ref=https%3A%2F%2Fwww.google.com%2F" style="color:black">Condiciones de uso</a>
                        <span>·</span>
                        <a href="https://policies.google.com/privacy?hl=es" style="color:black">Política de privacidad</a>
                        <span>·</span>
                        <a class="cookies" href="https://www.doblemente.com/modelo-de-ejemplo-de-politica-de-cookies/" style="color:black">Mis cookies</a>
                        <span>·</span>
                        <a href="about.php" style="color:black">Quiénes somos</a>
                    </p>
                    <!-- add social media with icons -->
                    <p class="social">
                        <a href="https://github.com/AlejandroRodriguezM"><img src="./assets/img/github.png" alt="Github" width="50" height="50" target="_blank"></a>
                        <a href="http://www.infojobs.net/alejandro-rodriguez-mena.prf"><img src="https://brand.infojobs.net/downloads/ij-logo_reduced/ij-logo_reduced.svg" alt="infoJobs" width="50" height="50" target="_blank"></a>

                    </p>
                    <p class="copyright" style="color:black">©2023 Alejandro Rodriguez</p>
                </div>
            </div>
        </div>
    </main>
</body>

</html>