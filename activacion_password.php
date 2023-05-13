<?php
session_start();
include_once 'php/inc/header.inc.php';
if (isset($_SESSION['email'])) {
    header('Location: index.php');
}

if (isset($_GET['id_activacion'])) {
    $id_activacion = $_GET['id_activacion'];
    if (!comprobar_codigo_alta($id_activacion)) {
        header('Location: login.php');
    }
} else {
    header('Location: login.php');
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
    <script src="./assets/js/funciones_utilidades.js"></script>
    <script src="./assets/js/ajaxFunctions,js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
    <script src="./assets/js/sweetalert2.all.min.js"></script>
    <title>Recupera tu contraseña</title>

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

        .logo-container {
            display: flex;
            justify-content: center;
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
                                </div>                                <h3 class="mt-2">Nueva contraseña</h3>
                                <form id="form_new_pass" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                                    <div class="mb-3 text-center">
                                        <label for="password" class="form-label w-100">Contraseña</label>
                                        <div class="input-group">
                                            <input type="password" class="form-control w-100" id="password_user" placeholder="Introduce tu contraseña" name="current-password" autocomplete="current-password" class="form-control rounded" spellcheck="false" autocorrect="off" autocapitalize="off" style="cursor:url(https://cdn.custom-cursor.com/db/pointer/32/Infinity_Gauntlet_Pointer.png) , pointer!important ">
                                            <button id="toggle-password" type="button" class="d-none"></button>
                                        </div>
                                        <label for="repassword" class="form-label w-100">Repita contraseña</label>
                                        <div class="input-group">
                                            <input type="password" class="form-control w-100" id="repassword_user" placeholder="Introduce tu contraseña de nuevo" name="current-password" autocomplete="current-password" class="form-control rounded" spellcheck="false" autocorrect="off" autocapitalize="off" style="cursor:url(https://cdn.custom-cursor.com/db/pointer/32/Infinity_Gauntlet_Pointer.png) , pointer!important ">
                                            <button id="toggle-password" type="button" class="d-none"></button>
                                        </div>
                                        <input type="hidden" id="id_activacion" name="id_activacion" value="<?php echo $id_activacion ?>">
                                        <div class="mb-3">
                                            <input type="button" class="btn btn-danger form-control" onclick="new_password();" value="Recuperar contraseña" style="cursor:url(https://cdn.custom-cursor.com/db/pointer/32/Infinity_Gauntlet_Pointer.png) , pointer!important ">
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <script>
                const passwordInputs = document.querySelectorAll('input[type="password"]');
                const togglePasswordButtons = document.querySelectorAll('button[id^="toggle-password"]');

                for (let i = 0; i < passwordInputs.length; i++) {
                    passwordInputs[i].onclick = function() {
                        passwordInputs[i].classList.add("input-password");
                        togglePasswordButtons[i].classList.remove("d-none");

                        togglePasswordButtons[i].addEventListener("click", function() {
                            if (passwordInputs[i].type === "password") {
                                passwordInputs[i].type = "text";
                                togglePasswordButtons[i].setAttribute("aria-label", "Hide password.");
                            } else {
                                passwordInputs[i].type = "password";
                                togglePasswordButtons[i].setAttribute("aria-label", "Show password as plain text. Warning: this will display your password on the screen.");
                            }
                        });
                    };
                }
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