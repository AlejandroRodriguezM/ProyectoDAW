<?php
session_start();
include_once '../inc/header.inc.php';

$validate['success'] = array('success' => false, 'message' => "", "userName" => "");

if ($_POST) {
    $acceso = $_POST['acceso'];
    $pass = $_POST['pass'];
    if (!obtener_datos_usuario($acceso)) {
        header("HTTP/1.1 400 Bad Request");
        $validate['success'] = false;
        $validate['message'] = 'ERROR. El usuario no existe';
    } else {
        $pass_encrypted = obtain_password($acceso);
        $reservedWords = reservedWords();
        if (password_verify($pass, $pass_encrypted)) {
            if (checkUser($acceso, $pass_encrypted)) {
                $row = obtener_datos_usuario($acceso);
                $email = $row['email'];
                reactivar_cuenta($email);
                if ($row['privilege'] == 'admin') {
                    cookiesAdmin($email, $pass_encrypted);
                }
                $_SESSION['hour'] = date("H:i", time());
                $_SESSION['email'] = $row['email'];
                $_SESSION['userName'] = $row['userName'];
                cookiesUser($email, $pass_encrypted);
                header("HTTP/1.1 200 OK");

                $validate['success'] = true;
                $validate['message'] = 'Welcome to the internet ' . $row['userName'];
                $validate['userName'] = strtoupper($row['userName']);
            } else {
                header("HTTP/1.1 404 Not Found");
                http_response_code(500); // Internal Server Error
                $validate['success'] = false;
                $validate['message'] = 'ERROR. El usuario no existe';
            }
        } else {
            header("HTTP/1.1 401 Unauthorized");
            http_response_code(500); // Internal Server Error
            $validate['success'] = false;
            $validate['message'] = 'The password doesn\'t match';
        }
    }
}

echo json_encode($validate);
