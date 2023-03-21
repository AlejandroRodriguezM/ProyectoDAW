<?php
require_once "./php/inc/header.inc.php";
//destroy cookies and session
session_start();
session_destroy();
deleteCookies();
header('Location: login.php');
?>