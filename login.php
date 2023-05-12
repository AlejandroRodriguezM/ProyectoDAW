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
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/Wruczek/Bootstrap-Cookie-Alert@gh-pages/cookiealert.css">
    <!-- <link rel="stylesheet" href="./assets/style/style.css"> -->
    <link rel="stylesheet" href="./assets/style/show-password-toggle.css">
    <!-- <link rel="stylesheet" href="./assets/style/footer_style.css"> -->
    <link rel="stylesheet" href="./assets/style/style_index.css">
    <script src="https://cdn.jsdelivr.net/gh/Wruczek/Bootstrap-Cookie-Alert@gh-pages/cookiealert.js"></script>
    <script src="./assets/js/functions.js"></script>
    <script src="./assets/js/appLogin.js"></script>
    <script src="./assets/js/bootstrap.bundle.min.js"></script>
    <script src="./assets/js/sweetalert2.all.min.js"></script>
    <title>Registro</title>

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

        html,
        body {
            margin: 0 !important;
            padding: 0 ;
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
            <div class="col-12 col-md-6 offset-md-3 mx-auto max-w-md text-center">
                <div class="bg-white p-4 rounded-lg shadow-sm no-opacity" style="background-color: white !important;">
                    <div class="row justify-content-center col-lg-7 mx-auto">
                        <!-- <div class="col-lg-7 "> -->
                        <img src="./assets/img/logoWeb.png" class="mt-2" width="250px" alt="logo web">
                        <form method="post" id="formIniciar" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" class="form-control-sm">
                            <div class="mb-3">
                                <label for="acceso" class="form-label">Nombre de usuario/Email</label>
                                <input type="text" class="form-control w-100" id="acceso" placeholder="Introduce tu nombre de usuario o email" style="cursor:url(https://cdn.custom-cursor.com/db/pointer/32/Infinity_Gauntlet_Pointer.png) , pointer!important">
                            </div>
                            <div class="mb-3">
                                <label for="password" class="form-label">Contraseña</label>
                                <div class="input-group">
                                    <input type="password" class="form-control w-100" id="password_user" placeholder="Introduce tu contraseña" name="current-password" autocomplete="current-password" class="form-control rounded" spellcheck="false" autocorrect="off" autocapitalize="off" style="cursor:url(https://cdn.custom-cursor.com/db/pointer/32/Infinity_Gauntlet_Pointer.png) , pointer!important ">
                                    <button id="toggle-password" type="button" class="d-none"></button>
                                </div>
                            </div>
                            <div class="mb-3">
                                <input type="button" name="guest_user" class="btn btn-secondary btn-block mb-2 w-100" onclick="guest_User();" value="Ingresar como invitado" style="cursor:url(https://cdn.custom-cursor.com/db/pointer/32/Infinity_Gauntlet_Pointer.png) , pointer!important ">
                            </div>
                            <div class="mb-3">
                                <input type="button" name="enter_sesion" class="btn btn-danger btn-block mb-2 w-100" onclick="login_user();" value="Iniciar sesion" style="cursor:url(https://cdn.custom-cursor.com/db/pointer/32/Infinity_Gauntlet_Pointer.png) , pointer!important ">
                            </div>
                            <div class="mb-3">
                                <a href="registro.php" type="button" class="btn btn-primary btn-block mb-2 w-100" style="cursor:url(https://cdn.custom-cursor.com/db/pointer/32/Infinity_Gauntlet_Pointer.png) , pointer!important ">Crear cuenta</a>
                            </div>

                            <div class="mb-3">
                                <a href="about.php" type="button" class="btn btn-info btn-block mb-2 w-100" style="cursor:url(https://cdn.custom-cursor.com/db/pointer/32/Infinity_Gauntlet_Pointer.png) , pointer!important ">Saber mas</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <script>
                var ShowPasswordToggle = document.querySelector("[type='password']");
                ShowPasswordToggle.onclick = function() {
                    document.querySelector("[type='password']").classList.add("input-password");
                    document.getElementById("toggle-password").classList.remove("d-none");
                    const passwordInput = document.querySelector("[type='password']");
                    const togglePasswordButton = document.getElementById("toggle-password");
                    togglePasswordButton.addEventListener("click", togglePassword);

                    function togglePassword() {
                        if (passwordInput.type === "password") {
                            passwordInput.type = "text";
                            togglePasswordButton.setAttribute("aria-label", "Hide password.")
                        } else {
                            passwordInput.type = "password";
                            togglePasswordButton.setAttribute("aria-label", "Show password as plain text. " + "Warning: this will display your password on the screen.")
                        }
                    }
                };
            </script>
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