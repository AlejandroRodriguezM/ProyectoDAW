<?php
session_start();
include_once 'php/inc/header.inc.php';

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="./assets/img/webico.ico" type="image/x-icon">
    <link rel="stylesheet" href="./assets/style/bootstrap.rtl.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">

    <link rel="stylesheet" href="./assets/style/style.css">
    <title>Registro</title>
</head>

<body onload="checkSesion();" class="inicio">
    <div class="container" style="cursor:url(https://cdn.custom-cursor.com/db/cursor/32/Infinity_Gauntlet_Cursor.png) , default!important">
        <div class="text-center">
            <img src="./assets/img/logoWeb.png" class="mt-5" width="150px" alt="">
            <h3 class="mt-2">REGISTER SYSTEM</h3>
            <form id="formInsert" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                <div class="mb-3">
                    <label for="name" class="form-label">User name</label>
                    <input type="text" class="form-control" id="name" placeholder="Enter your name" style="cursor:url(https://cdn.custom-cursor.com/db/pointer/32/Infinity_Gauntlet_Pointer.png) , pointer!important ">
                </div>
                <div class="mb-3">
                    <label for="correo" class="form-label">Email Address</label>
                    <input type="email" class="form-control" id="correo" placeholder="name@test.com" style="cursor:url(https://cdn.custom-cursor.com/db/pointer/32/Infinity_Gauntlet_Pointer.png) , pointer!important ">
                </div>
                <div class="mb-3">
                    <label for="password" class="form-label">Password</label>
                    <input type="password" class="form-control" id="password" placeholder="***********" style="cursor:url(https://cdn.custom-cursor.com/db/pointer/32/Infinity_Gauntlet_Pointer.png) , pointer!important ">
                </div>
                <div class="mb-3">
                    <label for="repassword" class="form-label">RePassword</label>
                    <input type="password" class="form-control" id="repassword" placeholder="***********" style="cursor:url(https://cdn.custom-cursor.com/db/pointer/32/Infinity_Gauntlet_Pointer.png) , pointer!important ">
                </div>
                <div class="mb-3">
                    <img class="chosenUserProfile mb-2" id="output" src="./assets/img/chosePicture.png" />
                    <input class="form-control" type="file" name="files" id="files" accept=".jpg, .png" onchange="loadFile(event)" style="cursor:url(https://cdn.custom-cursor.com/db/pointer/32/Infinity_Gauntlet_Pointer.png) , pointer!important ">
                </div>
                <div class="mb-3">
                    <?php
                    if (isset($_POST['test'])) {
                        echo "<input type='checkbox' name='checkbox' id='checkbox' value='checkbox' checked readonly disabled>";
                    } else {
                        echo "<input type='checkbox' name='checkbox' id='checkbox' value='checkbox' readonly disabled>";
                    }
                    ?>
                    <label>Acepto y he leido las condiciones y servicios</label>
                </div>

                <div class="mb-3">
                    <!-- Button trigger modal -->
                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#staticBackdrop">
                        Leer condiciones y servicios
                    </button>
                </div>

                <!-- Modal -->
                <div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                    <div class="modal-dialog modal-xl">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h1 class="modal-title fs-5" id="staticBackdropLabel">Modal title</h1>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <h1>T??rminos y condiciones</h1>

                                <p>
                                    Bienvenido a nuestro sitio web. Si contin??a navegando y utilizando este sitio web, usted acepta cumplir y estar sujeto a los siguientes t??rminos y condiciones de uso, que junto con nuestra pol??tica de privacidad rigen la relaci??n entre usted y nuestra empresa en relaci??n con este sitio web. Si no est?? de acuerdo con alguno de estos t??rminos, por favor no utilice nuestro sitio web.
                                </p>

                                <h2>Uso del contenido</h2>

                                <p>
                                    El contenido de las p??ginas de este sitio web es para su informaci??n y uso general. Se proh??be su uso para fines comerciales sin la autorizaci??n expresa por escrito de nuestra empresa.

                                <h2>Limitaci??n de responsabilidades</h2>

                                <p>
                                    Este sitio web se proporciona "tal cual". No garantizamos que el sitio web est?? disponible en todo momento o que el contenido sea completamente preciso o actualizado. No nos hacemos responsables de ning??n tipo de da??os o p??rdidas en relaci??n con el uso de este sitio web.

                                <h2>Enlaces de terceros</h2>

                                <p>
                                    Este sitio web puede contener enlaces a sitios web de terceros. Estos enlaces se proporcionan s??lo como conveniencia y no implican que estemos de acuerdo con el contenido de dichos sitios web. No tenemos control sobre el contenido de los sitios web de terceros y no nos hacemos responsables de ellos.

                                <h2>Derechos de autor</h2>

                                <p>
                                    Todos los contenidos de este sitio web, incluyendo texto, im??genes y dise??os, est??n protegidos por derechos de autor. El uso no autorizado de cualquier contenido puede violar los derechos de autor, marcas registradas y otras leyes.

                                <h2>Pol??tica de privacidad</h2>

                                <p>
                                    Su privacidad es importante para nosotros. Lea nuestra pol??tica de privacidad para obtener m??s informaci??n sobre c??mo recopilamos y usamos la informaci??n personal de nuestros usuarios.

                                <h2>Control de cambios</h2>

                                <p>
                                    Nos reservamos el derecho de modificar estos t??rminos y condiciones en cualquier momento. Si hacemos cambios significativos, los notificaremos en esta p??gina.

                                <h2>Cont??ctenos</h2>

                                <p>
                                    Si tiene alguna pregunta sobre estos t??rminos y condiciones, puede contactarnos en <a href="mailto: infoCliente@WebComics.com">Correo atencion al cliente</a>
                                </p>
                            </div>
                            <div class="modal-footer">
                                <input type="button" class="btn btn-secondary" data-bs-dismiss="modal" value="close">
                                <input type="button" id="test" name="test" data-bs-dismiss="modal" class="btn btn-primary" onclick="changeCheckboxState()" value="Understood">
                            </div>
                        </div>
                    </div>
                </div>

                <div class="mb-3">
                    <input type="button" class="btn btn-danger form-control" onclick="new_user();" value="Registrar" style="cursor:url(https://cdn.custom-cursor.com/db/pointer/32/Infinity_Gauntlet_Pointer.png) , pointer!important ">
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
                    <a href="index.php" type="button" class="btn btn-primary form-control" style="cursor:url(https://cdn.custom-cursor.com/db/pointer/32/Infinity_Gauntlet_Pointer.png) , pointer!important ">Iniciate session</a>
                </div>
            </form>
        </div>
    </div>
    <script>
        function changeCheckboxState() {
            var checkbox = document.getElementById("checkbox");
            checkbox.checked = !checkbox.checked;
        }
    </script>
    <script src="./assets/js/appLogin.js"></script>
    <script src="./assets/js/functions.js"></script>
    <script src="./assets/js/bootstrap.bundle.min.js"></script>
    <script src="./assets/js/sweetalert2.all.min.js"></script>
</body>

</html>