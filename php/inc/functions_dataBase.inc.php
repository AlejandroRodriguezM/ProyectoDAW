<?php

function checkUser($email,$password)
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

function checkEmail($email){
	global $conection;
	$exist = false;
	$consulta = $conection->prepare("SELECT * from users WHERE email = ?");
	$consulta->execute(array($email));
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

/**
 * Function used to insert data, modify, or delete from the database
 *
 * @param [String] $query
 * @param [String] $base
 * @return void
 */
function operacionesMySql($query)
{
	try {
		global $conection;
		// Ejecutamos la consulta
		$conection->exec($query);
	} catch (PDOException $e) {
		$error_Code = $e->getCode();
		$message = $e->getMessage();
		die("Code: " . $error_Code . "\nMessage: " . $message);
	}
}

/**
 * Obtain the data of a user from his Login
 *
 * @param [type] $email
 * @return array
 */
function getUserData($email)
{
	global $conection;
	$sql = "SELECT * FROM users WHERE email='$email'";
	$resultado = $conection->query($sql);
	$userData = $resultado->fetch(PDO::FETCH_ASSOC);
	// Devolvemos los datos del usuario
	return $userData;
}

function new_user($userName,$email,$password){

	global $conection;
	$create = false;
	try{
		$insertData = $conection->prepare("INSERT INTO users (userName,password,email) VALUES(?,?,?)");
		$insertData->bindParam(1, $userName);
		$insertData->bindParam(2, $password);
		$insertData->bindParam(3, $email);

		if($insertData->execute()){
			$create = true;
		}
		return $create;
	}
	catch (PDOException $e) {
		$error_Code = $e->getCode();
		$message = $e->getMessage();
		die("Code: " . $error_Code . "\nMessage: " . $message);
	}
}

function update_user($userName,$email,$password){

	global $conection;
	$update = false;
	try{
		$insertData = $conection->prepare("UPDATE users SET userName = ?, password = ? WHERE email = ?");
		$insertData->bindParam(1, $userName);
		$insertData->bindParam(2, $password);
		$insertData->bindParam(3, $email);

		if($insertData->execute()){
			$update = true;
		}
		return $update;
	}
	catch (PDOException $e) {
		$error_Code = $e->getCode();
		$message = $e->getMessage();
		die("Code: " . $error_Code . "\nMessage: " . $message);
	}
}

function update_email($new_email,$old_email){
	
	global $conection;
	$update = false;
	try{
		$insertData = $conection->prepare("UPDATE users SET email = ? WHERE email = ?");
		$insertData->bindParam(1, $new_email);
		$insertData->bindParam(2, $old_email);

		if($insertData->execute()){
			$update = true;
		}
		return $update;
	}
	catch (PDOException $e) {
		$error_Code = $e->getCode();
		$message = $e->getMessage();
		die("Code: " . $error_Code . "\nMessage: " . $message);
	}
}

function insertURL($email,$idUser){
	global $conection;
	$create = false;
	$email = explode("@", $email);
	$email = $email[0];
	$file_path = 'assets/pictureProfile/' . $idUser . "-" . $email . "/profile.jpg";
	try{
		$insertData = $conection->prepare("UPDATE users SET userPicture = ? WHERE IDuser = ?");
		$insertData->bindParam(1, $file_path);
		$insertData->bindParam(2, $idUser);
		if($insertData->execute()){
			$create = true;
		}
		return $create;
	}
	catch (PDOException $e) {
		$error_Code = $e->getCode();
		$message = $e->getMessage();
		die("Code: " . $error_Code . "\nMessage: " . $message);
	}
}

function showUsers(){
	global $conection;
	$sql = "SELECT * FROM users";
	$resultado = $conection->query($sql);

	return $resultado;
}

function checkStatus($email){
	global $conection;
	$status = false;
	$consulta = $conection->prepare("SELECT accountStatus from users where email=?");
	$consulta->execute(array($email));
	$consulta = $consulta->fetch(PDO::FETCH_ASSOC)['accountStatus'];
	if($consulta == 'block'){
		$status = true;
	}
	return $status;
}

function returnNameUser($email){
	global $conection;
	$consulta = $conection->prepare("SELECT userName from users where email=?");
	$consulta->execute(array($email));
	$consulta = $consulta->fetch(PDO::FETCH_ASSOC)['userName'];
	return $consulta;
}

function changeStatusAccount($email){
	global $conection;
	$userData = getUserData($email);
	try{
		if($userData['accountStatus'] == 'active'){
			$consulta = $conection->prepare("UPDATE users SET accountStatus = 'block' WHERE email = ?");
		}
		elseif($userData['accountStatus'] == 'block'){
			$consulta = $conection->prepare("UPDATE users SET accountStatus = 'active' WHERE email = ?");
		}
	
		$consulta->execute(array($email));
	}
	catch (PDOException $e) {
		$error_Code = $e->getCode();
		$message = $e->getMessage();
		die("Code: " . $error_Code . "\nMessage: " . $message);
	}
}
