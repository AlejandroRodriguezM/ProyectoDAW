<?php 

function errorLogin($email_userName,$password_user){
$error = '';
if(empty($email_userName)){
    $error = "<div class='alert alert-danger'>Error. You must fill the user name/email.</div>";
}
if(empty($password_user)){
    $error = "<div class='alert alert-danger'>Error. You must fill the password </div>";
}
return $error;
}

















?>