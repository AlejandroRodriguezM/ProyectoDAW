<?php
session_start();
include_once '../inc/header.inc.php';

session_start();
session_destroy();

header('Location: index.php');
