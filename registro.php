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
    <link rel="shortcut icon" href="./assets/img/logoWeb.png" type="image/x-icon">
    <link rel="stylesheet" href="./assets/style/bootstrap.rtl.min.css">
    <link rel="stylesheet" href="./assets/style/style.css">
    <title>CRUD contactos</title>
</head>

<body onload="checkSesion();" class="inicio">
    <div class="container" style="cursor:url(https://cdn.custom-cursor.com/db/cursor/32/Infinity_Gauntlet_Cursor.png) , default!important">
        <div class="text-center">
        <img src="./assets/img/logoWeb.png" class="mt-5" width="150px" alt="">
            <h3 class="mt-2">REGISTER SYSTEM</h3>
            <form id="formInsert" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
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
                    <label for="name" class="form-label">Name</label>
                    <input type="text" class="form-control" id="name" placeholder="Enter your name" style="cursor:url(https://cdn.custom-cursor.com/db/pointer/32/Infinity_Gauntlet_Pointer.png) , pointer!important ">
                </div>
                <div class="mb-3">
                    <img class="chosenUserProfile mb-2" id="output" src="./assets/img/chosePicture.png" />
                    <input class="form-control" type="file" name="files" id="files" accept=".jpg, .jpeg, .png" onchange="loadFile(event)" style="cursor:url(https://cdn.custom-cursor.com/db/pointer/32/Infinity_Gauntlet_Pointer.png) , pointer!important ">
                </div>
                <div class="mb-3">
                    <input type="button" class="btn btn-danger form-control" onclick="new_User();" value="Registrar" style="cursor:url(https://cdn.custom-cursor.com/db/pointer/32/Infinity_Gauntlet_Pointer.png) , pointer!important ">
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
    <script src="./assets/js/appLogin.js"></script>
    <script src="./assets/js/functions.js"></script>
    <script src="./assets/js/bootstrap.bundle.min.js"></script>
    <script src="./assets/js/sweetalert2.all.min.js"></script>
</body>

</html>