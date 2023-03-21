<?php
session_start();
include_once '../inc/header.inc.php';
$query = $_GET['query'];
$registros = searchTest($query);
$user = $registros->fetch();
$users = array();
while ($user != null) {
    $users[] = $user;
    $user = $registros->fetch();
}

echo json_encode($users);