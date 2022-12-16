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
    <title>Acces user</title>
</head>

<body onload="checkSesion();" class="inicio">
    <div class="container" style="cursor:url(https://cdn.custom-cursor.com/db/cursor/32/Infinity_Gauntlet_Cursor.png) , default!important">
        <div class="text-center">
            <img src="./assets/img/logoWeb.png" class="mt-5" width="150px" alt="">
            <h3 class="mt-2">LOGIN SISTEMA</h3>
            <form method="post" id="formIniciar" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                <div class="mb-3">
                    <label for="correo" class="form-label">User name or Email Address</label>
                    <input type="email" class="form-control" id="correo" placeholder="name@test.com" style="cursor:url(https://cdn.custom-cursor.com/db/pointer/32/Infinity_Gauntlet_Pointer.png) , pointer!important">
                </div>
                <div class="mb-3"">
                    <label for="password" class="form-label">Password</label>
                    <input type="password" class="form-control" id="password_User" placeholder="***********"
                    style="cursor:url(https://cdn.custom-cursor.com/db/pointer/32/Infinity_Gauntlet_Pointer.png) , pointer!important ">
                </div>
                <div class="mb-3">
                    <label for="repassword" class="form-label">RePassword</label>
                    <input type="password" class="form-control" id="repassword_User" placeholder="***********"
                    style="cursor:url(https://cdn.custom-cursor.com/db/pointer/32/Infinity_Gauntlet_Pointer.png) , pointer!important ">
                </div>
                <div class="mb-3">
                    <input type="button" name="enter_sesion" class="btn btn-danger form-control" onclick="login_User();" value="Enter sesion" style="cursor:url(https://cdn.custom-cursor.com/db/pointer/32/Infinity_Gauntlet_Pointer.png) , pointer!important ">
                </div>
                <div class="mb-3" >
                    <a href="registro.php" type="button" class="btn btn-primary form-control" style="cursor:url(https://cdn.custom-cursor.com/db/pointer/32/Infinity_Gauntlet_Pointer.png) , pointer!important ">Create account</a>
                </div>
            </form>
        </div>
    </div>
    <script src="./assets/js/functions.js"></script>
    <script src="./assets/js/appLogin.js"></script>
    <script src="./assets/js/bootstrap.bundle.min.js"></script>
    <script src="./assets/js/sweetalert2.all.min.js"></script>
</body>

</html>