<?php

function checkUser($email, $password)
{
    global $conection;
    $exist = false;
    $consulta = $conection->prepare("SELECT * from users WHERE email = ? and password = ?");
    $consulta->execute(array($email,$password));
    if ($consulta->fetchColumn()) {
        $exist = true;
    }
    return $exist;
}

/**
 * Return the password from a user using loggin
 *
 * @param [type] $login
 * @param [type] $con
 * @return string
 */
function obtain_password($email)
{
	global $conection;
	$consulta = $conection->prepare("SELECT password from users where email=?");
	$consulta->execute(array($email));
	$password = $consulta->fetch(PDO::FETCH_ASSOC)['password'];
	unset($consulta);
	return $password;
}


?>