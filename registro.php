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

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>

    <script src="https://cdn.jsdelivr.net/gh/Wruczek/Bootstrap-Cookie-Alert@gh-pages/cookiealert.js"></script>
    <script src="./assets/js/funciones_utilidades.js"></script>
    <script src="./assets/js/ajaxFunctions.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
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

        body {
            margin: 0 !important;
            padding: 0;
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

        .vibrate {
            animation: vibrate 0.5s linear infinite;
            outline: 2px solid red;
            box-shadow: 0 0 5px red;
        }

        @keyframes vibrate {
            0% {
                transform: translateX(-4px) rotate(-2deg);
            }

            20% {
                transform: translateX(4px) rotate(2deg);
            }

            40% {
                transform: translateX(-4px) rotate(-2deg);
            }

            60% {
                transform: translateX(4px) rotate(2deg);
            }

            80% {
                transform: translateX(-4px) rotate(-2deg);
            }

            100% {
                transform: translateX(0) rotate(0);
            }
        }
    </style>
</head>

<body class="d-flex flex-column min-vh-100">
    <main class="flex-shrink-0">
        <!-- Modal -->
        <div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
            <div class="modal-dialog modal-xl">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="staticBackdropLabel">Condiciones de uso</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" onclick="uncheckOnClose()"></button>
                    </div>
                    <div class="modal-body">
                        <h1>Términos y condiciones</h1>

                        <p>
                            Bienvenido a nuestro sitio web. Si continúa navegando y utilizando este sitio web, usted acepta cumplir y estar sujeto a los siguientes términos y condiciones de uso, que junto con nuestra política de privacidad rigen la relación entre usted y nuestra empresa en relación con este sitio web. Si no está de acuerdo con alguno de estos términos, por favor no utilice nuestro sitio web.
                        </p>

                        <h2>Uso del contenido</h2>

                        <p>
                            El contenido de las páginas de este sitio web es para su información y uso general. Se prohíbe su uso para fines comerciales sin la autorización expresa por escrito de nuestra empresa.

                        <h2>Limitación de responsabilidades</h2>

                        <p>
                            Este sitio web se proporciona "tal cual". No garantizamos que el sitio web esté disponible en todo momento o que el contenido sea completamente preciso o actualizado. No nos hacemos responsables de ningún tipo de daños o pérdidas en relación con el uso de este sitio web.

                        <h2>Enlaces de terceros</h2>

                        <p>
                            Este sitio web puede contener enlaces a sitios web de terceros. Estos enlaces se proporcionan sólo como conveniencia y no implican que estemos de acuerdo con el contenido de dichos sitios web. No tenemos control sobre el contenido de los sitios web de terceros y no nos hacemos responsables de ellos.

                        <h2>Derechos de autor</h2>

                        <p>
                            Todos los contenidos de este sitio web, incluyendo texto, imágenes y diseños, están protegidos por derechos de autor. El uso no autorizado de cualquier contenido puede violar los derechos de autor, marcas registradas y otras leyes.

                        <h2>Política de privacidad</h2>

                        <p>
                            Su privacidad es importante para nosotros. Lea nuestra política de privacidad para obtener más información sobre cómo recopilamos y usamos la información personal de nuestros usuarios.

                        <h2>Control de cambios</h2>

                        <p>
                            Nos reservamos el derecho de modificar estos términos y condiciones en cualquier momento. Si hacemos cambios significativos, los notificaremos en esta página.

                        <h2>Contáctenos</h2>

                        <p>
                            Si tiene alguna pregunta sobre estos términos y condiciones, puede contactarnos en <a href="mailto: infoCliente@Comic web.com">Correo atencion al cliente</a>
                        </p>
                    </div>
                    <div class="modal-footer">
                        <input type="button" id="cancelar" name="cancelar" class="btn btn-secondary" data-bs-dismiss="modal" onclick="uncheckOnClose()" value="Close">
                        <input type="button" id="aceptar" name="aceptar" data-bs-dismiss="modal" class="btn btn-primary" onclick="changeCheckboxState()" value="Understood">
                    </div>
                </div>
            </div>
        </div>
        <div class="bg-image bg-attachment-fixed" style="background-image: url('assets/img/background.jpg');opacity: 0.8;">
            <br>
            <div class="container">
                <div class="col-12 col-md-6 offset-md-3 mx-auto max-w-md text-center">
                    <div class="bg-white p-4 rounded-lg shadow-sm no-opacity" style="background-color: white !important;border-radius:15px">

                        <div class="row justify-content-center col-lg-7 mx-auto">
                            <div class="d-flex justify-content-center">
                                <a href="login.php">
                                    <img src="./assets/img/logoWeb.png" class="img-fluid mt-2" alt="logo web">
                                </a>
                            </div>
                            <h3 class="mt-2">DATOS DE REGISTRO</h3>
                            <form id="formInsert" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                                <div class="mb-3 text-center">
                                    <label for="name" class="form-label w-100">Nombre de usuario</label>
                                    <input type="text" class="form-control w-100" id="name" placeholder="Enter your name">
                                </div>
                                <div class="mb-3 text-center">
                                    <label for="correo" class="form-label w-100">Correo electronico</label>
                                    <input type="email" class="form-control w-100" id="correo" placeholder="name@test.com">
                                </div>
                                <label for="password" class="form-label w-100">Contraseña</label>
                                <div class="input-group">
                                    <input type="password" class="form-control w-100" id="password" placeholder="Introduce tu contraseña" name="current-password" autocomplete="current-password" class="form-control rounded" spellcheck="false" autocorrect="off" autocapitalize="off" style="cursor:url(https://cdn.custom-cursor.com/db/pointer/32/Infinity_Gauntlet_Pointer.png) , pointer!important ">
                                    <button id="toggle-password" type="button" class="d-none"></button>
                                </div>
                                <label for="repassword" class="form-label w-100">Repita contraseña</label>
                                <div class="input-group">
                                    <input type="password" class="form-control w-100" id="repassword" placeholder="Introduce tu contraseña de nuevo" name="current-password" autocomplete="current-password" class="form-control rounded" spellcheck="false" autocorrect="off" autocapitalize="off" style="cursor:url(https://cdn.custom-cursor.com/db/pointer/32/Infinity_Gauntlet_Pointer.png) , pointer!important ">
                                    <button id="toggle-password" type="button" class="d-none"></button>
                                </div>
                                <div class="mb-3 text-center">
                                    <img class="chosenUserProfile mb-2" id="output" src="./assets/img/chosePicture.png" />
                                    <input class="form-control w-100" type="file" name="files" id="files" accept=".jpg, .png" onchange="loadFile(event)">
                                </div>
                                <div class="mb-3 text-center">
                                    <button type="button" id="condiciones-aceptar" class="btn btn-primary w-100" data-bs-toggle="modal" data-bs-target="#staticBackdrop" onclick="toggleCheckbox()">
                                        Leer condiciones y servicios
                                    </button>
                                </div>




                                <div class="mb-3 text-center checkbox-opcion">
                                    <label>Acepto y he leido las condiciones y servicios</label>
                                    <input type="checkbox" name="checkbox" id="checkbox" value="checkbox" readonly onclick="toggleCheckbox()">
                                </div>

                                <div class="mb-3">
                                    <input type="button" class="btn btn-danger form-control" onclick="crear_usuario();" value="Registrar" style="cursor:url(https://cdn.custom-cursor.com/db/pointer/32/Infinity_Gauntlet_Pointer.png) , pointer!important ">
                                    <script>
                                        function handleFileSelect(evt) {
                                            var f = evt.target.files[0]; // FileList object
                                            var reader = new FileReader();
                                            // Closure to capture the file information.
                                            reader.onload = (function(theFile) {
                                                return function(e) {
                                                    var binaryData = e.target.result;
                                                    //Converting Binary Data to base 64
                                                    var base64String = window.btoa(binaryData);
                                                    //save into var globally string
                                                    image = base64String;
                                                };
                                            })(f);
                                            // Read in the image file as a data URL
                                            reader.readAsBinaryString(f);
                                        }
                                        document.getElementById('files').addEventListener('change', handleFileSelect, false);
                                    </script>

                                </div>
                                <div class="mb-3">
                                    <a href="login.php" type="button" id="volverBtn" class="btn btn-primary form-control" style="cursor:url(https://cdn.custom-cursor.com/db/pointer/32/Infinity_Gauntlet_Pointer.png), pointer!important">Volver</a>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <script>
                function changeCheckboxState() {
                    var checkbox = document.getElementById("checkbox");
                    checkbox.checked = !checkbox.checked;
                }
            </script>
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

            <script>
                const checkbox = document.getElementById('checkbox');

                function changeCheckboxState() {
                    $('#checkbox').prop('checked', true);
                    checkbox.disabled = true;
                }

                function uncheckOnClose() {
                    const checkbox = document.getElementById('checkbox');
                    checkbox.checked = false;
                    checkbox.disabled = false;
                    const cancelButton = document.getElementById('condiciones-aceptar');
                    cancelButton.classList.add('vibrate');

                    setTimeout(function() {
                        cancelButton.classList.remove('vibrate');
                    }, 3000);
                }
            </script>

            <script>
                function toggleCheckbox() {
                    if (!checkbox.checked) {
                        checkbox.disabled = true;
                        checkbox.checked = true;
                    } else {
                        $('#staticBackdrop').modal('show');
                        checkbox.disabled = true;
                        checkbox.checked = true;
                    }
                }

                function uncheckCheckbox() {
                    const checkbox = document.getElementById('checkbox');
                    checkbox.checked = false;
                }

                function acceptModal() {
                    const checkbox = document.getElementById('checkbox');
                    checkbox.disabled = true;
                }

                $(document).ready(function() {
                    $('#staticBackdrop').on('hide.bs.modal', function(event) {
                        const checkbox = document.getElementById('checkbox');
                        const target = $(event.relatedTarget);
                        if (target.attr('id') === 'cancelar') {
                            checkbox.checked = false;
                            checkbox.disabled = false;
                        } else {
                            checkbox.disabled = true;
                        }
                    });
                });
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