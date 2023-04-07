<?php
session_start();
include_once '../inc/header.inc.php';

$validate['success'] = array('success' => false, 'message' => "", "userName" => "");

$validate['success'] = true;
$validate['message'] = 'Welcome to the internet guest user!';
$validate['userName'] = "Guest";


echo json_encode($validate);
