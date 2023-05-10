<?php
session_start();
include_once 'php/inc/header.inc.php';
// 

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
    <link rel="stylesheet" href="./assets/style/footer_style.css">
    <link rel="stylesheet" href="./assets/style/style_index.css">

    <script src="https://cdn.jsdelivr.net/gh/Wruczek/Bootstrap-Cookie-Alert@gh-pages/cookiealert.js"></script>
    <script src="./assets/js/functions.js"></script>
    <script src="./assets/js/appLogin.js"></script>
    <script src="./assets/js/bootstrap.bundle.min.js"></script>
    <script src="./assets/js/sweetalert2.all.min.js"></script>
    <title>Aceso de usuario</title>
</head>

<body class="inicio">
    <div class="sec1">
        <div class="container" style="cursor:url(https://cdn.custom-cursor.com/db/cursor/32/Infinity_Gauntlet_Cursor.png) , default!important">
        <br>
            <div class="bg-white p-1">
            <div class="text-center">
                <img src="./assets/img/logoWeb.png" class="mt-1" width="250px" alt="logo web">
                <h3 class="mt-2">LOGIN SISTEMA</h3>
                <form method="post" id="formIniciar" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                    <div class="mb-3">
                        <label for="acceso" class="form-label">Email Address</label>
                        <input type="text" class="form-control" id="acceso" placeholder="Introduce your userName or Email" style="cursor:url(https://cdn.custom-cursor.com/db/pointer/32/Infinity_Gauntlet_Pointer.png) , pointer!important">
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">Password</label>
                        <div class="input-group">
                            <input type="password" class="form-control" id="password_user" placeholder="***********" name="current-password" autocomplete="current-password" class="form-control rounded" spellcheck="false" autocorrect="off" autocapitalize="off" style="cursor:url(https://cdn.custom-cursor.com/db/pointer/32/Infinity_Gauntlet_Pointer.png) , pointer!important ">
                            <button id="toggle-password" type="button" class="d-none"></button>
                        </div>
                    </div>
                    <div class="mb-3">
                        <input type="button" name="guest_user" class="btn btn-secondary form-control" onclick="guest_User();" value="Ingresar como invitado" style="cursor:url(https://cdn.custom-cursor.com/db/pointer/32/Infinity_Gauntlet_Pointer.png) , pointer!important ">
                    </div>
                    <div class="mb-3">
                        <input type="button" name="enter_sesion" class="btn btn-danger form-control" onclick="login_user();" value="Iniciar sesion" style="cursor:url(https://cdn.custom-cursor.com/db/pointer/32/Infinity_Gauntlet_Pointer.png) , pointer!important ">
                    </div>
                    <div class="mb-3">
                        <a href="registro.php" type="button" class="btn btn-primary form-control" style="cursor:url(https://cdn.custom-cursor.com/db/pointer/32/Infinity_Gauntlet_Pointer.png) , pointer!important ">Crear cuenta</a>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="alert text-center cookiealert" role="alert">
        <b>Do you like cookies?</b> &#x1F36A; We use cookies to ensure you get the best experience on our website. <a href="https://cookiesandyou.com/" target="_blank">Learn more</a>

        <button type="button" class="btn btn-primary btn-sm acceptcookies">
            I agree
        </button>
    </div>
    </div>
    <div id="footer-lite">
        <div class="content">
            <p class="helpcenter">
                <a href="http://www.example.com/help">Ayuda</a>
            </p>
            <p class="legal">
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


    </main>
</body>

</html>