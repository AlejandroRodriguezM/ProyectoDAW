<?php
//destroy cookies and session
session_start();
session_destroy();
if(isset($_COOKIE['loginUser']) && isset($_COOKIE['passwordUser'])){
    setcookie('loginUser', '', time() - 3600, '/');
    setcookie('passwordUser', '', time() - 3600, '/');
}
header('Location: index.php');

?>