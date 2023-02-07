<?php

function checkUser($acceso, $password)
{
	global $conection;
	$exist = false;
	$consulta = $conection->prepare("SELECT * from users WHERE email = ? OR userName = ? and password = ?");
	$consulta->execute(array($acceso, $acceso, $password));
	if ($consulta->fetchColumn()) {
		$exist = true;
	}
	return $exist;
}

function checkEmail($email)
{
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
function obtain_password($acces)
{
	global $conection;
	$consulta = $conection->prepare("SELECT password from users where email=? OR userName=?");
	$consulta->execute(array($acces, $acces));
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
function getUserData($acces)
{
	global $conection;
	$sql = "SELECT * FROM users WHERE email='$acces' OR userName = '$acces' or IDuser = '$acces'";
	$resultado = $conection->query($sql);
	$userData = $resultado->fetch(PDO::FETCH_ASSOC);
	return $userData;
}

function new_user($userName, $email, $password)
{
	global $conection;
	$create = false;
	try {
		$insertData = $conection->prepare("INSERT INTO users (userName,password,email) VALUES(?,?,?)");
		$insertData->bindParam(1, $userName);
		$insertData->bindParam(2, $password);
		$insertData->bindParam(3, $email);

		if ($insertData->execute()) {
			$create = true;
		}
		return $create;
	} catch (PDOException $e) {
		$error_Code = $e->getCode();
		$message = $e->getMessage();
		die("Code: " . $error_Code . "\nMessage: " . $message);
	}
}

function update_user($userName, $email, $password)
{
	global $conection;
	$update = false;
	try {
		$insertData = $conection->prepare("UPDATE users SET userName = ?, password = ? WHERE email = ?");
		$insertData->bindParam(1, $userName);
		$insertData->bindParam(2, $password);
		$insertData->bindParam(3, $email);

		if ($insertData->execute()) {
			$update = true;
		}
		return $update;
	} catch (PDOException $e) {
		$error_Code = $e->getCode();
		$message = $e->getMessage();
		die("Code: " . $error_Code . "\nMessage: " . $message);
	}
}

function delete_user($email, $idUser)
{
	global $conection;

	try {
		$insertData1 = $conection->prepare("DELETE FROM users WHERE email = ?");
		$insertData1->bindParam(1, $email);
		$insertData2 = $conection->prepare("DELETE FROM aboutuser WHERE IDuser = ?");
		$insertData2->bindParam(1, $idUser);
		$insertData3 = $conection->prepare("DELETE FROM possession WHERE user = ?");
		$insertData3->bindParam(1, $idUser);
		$insertData4 = $conection->prepare("DELETE FROM wanted WHERE user = ?");
		$insertData4->bindParam(1, $idUser);
		if ($insertData1->execute()) {
			deleteDirectory($email, $idUser);
		}
	} catch (PDOException $e) {
		$error_Code = $e->getCode();
		$message = $e->getMessage();
		die("Code: " . $error_Code . "\nMessage: " . $message);
	}
}

function update_email($new_email, $old_email)
{
	global $conection;
	$update = false;
	try {
		$insertData = $conection->prepare("UPDATE users SET email = ? WHERE email = ?");
		$insertData->bindParam(1, $new_email);
		$insertData->bindParam(2, $old_email);

		if ($insertData->execute()) {
			$update = true;
		}
		return $update;
	} catch (PDOException $e) {
		$error_Code = $e->getCode();
		$message = $e->getMessage();
		die("Code: " . $error_Code . "\nMessage: " . $message);
	}
}

function insertURL($email, $idUser)
{
	global $conection;
	$create = false;
	$email = explode("@", $email);
	$email = $email[0];
	$file_path = 'assets/pictureProfile/' . $idUser . "-" . $email . "/profile.jpg";
	try {
		$insertData = $conection->prepare("UPDATE users SET userPicture = ? WHERE IDuser = ?");
		$insertData->bindParam(1, $file_path);
		$insertData->bindParam(2, $idUser);
		if ($insertData->execute()) {
			$create = true;
		}
		return $create;
	} catch (PDOException $e) {
		$error_Code = $e->getCode();
		$message = $e->getMessage();
		die("Code: " . $error_Code . "\nMessage: " . $message);
	}
}

function checkStatus($email)
{
	global $conection;
	$status = false;
	$consulta = $conection->prepare("SELECT accountStatus from users where email=?");
	$consulta->execute(array($email));
	$consulta = $consulta->fetch(PDO::FETCH_ASSOC)['accountStatus'];
	if ($consulta == 'block') {
		$status = true;
	}
	return $status;
}

function returnNameUser($email)
{
	global $conection;
	$consulta = $conection->prepare("SELECT userName from users where email=?");
	$consulta->execute(array($email));
	$consulta = $consulta->fetch(PDO::FETCH_ASSOC)['userName'];
	return $consulta;
}

function changeStatusAccount($email)
{
	global $conection;
	$userData = getUserData($email);
	try {
		if ($userData['accountStatus'] == 'active') {
			$consulta = $conection->prepare("UPDATE users SET accountStatus = 'block' WHERE email = ?");
		} elseif ($userData['accountStatus'] == 'block') {
			$consulta = $conection->prepare("UPDATE users SET accountStatus = 'active' WHERE email = ?");
		}

		$consulta->execute(array($email));
	} catch (PDOException $e) {
		$error_Code = $e->getCode();
		$message = $e->getMessage();
		die("Code: " . $error_Code . "\nMessage: " . $message);
	}
}

function insertAbourUser($IDuser, $infoUser, $fechaCreacion)
{
	global $conection;
	try {
		$nameUser = "";
		$apellidoUser = "";
		$insertData = $conection->prepare("INSERT INTO aboutuser (IDuser,infoUser,fechaCreacion,nombreUser,apellidoUser) VALUES (?,?,?,?,?)");
		$insertData->bindParam(1, $IDuser);
		$insertData->bindParam(2, $infoUser);
		$insertData->bindParam(3, $fechaCreacion);
		$insertData->bindParam(4, $nameUser);
		$insertData->bindParam(5, $apellidoUser);
		$insertData->execute();
	} catch (PDOException $e) {
		$error_Code = $e->getCode();
		$message = $e->getMessage();
		die("Code: " . $error_Code . "\nMessage: " . $message);
	}
}

function updateAboutUser($IDuser, $infoUser, $name, $lastname)
{
	global $conection;
	try {
		$userData = getInfoAboutUser($IDuser);
		$checkInfo = $userData['infoUser'];
		if (empty($infoUser)) {
			$infoUser = $checkInfo;
		}
		$insertData = $conection->prepare("UPDATE aboutuser SET infoUser = ?,nombreUser = ?,apellidoUser = ? WHERE IDuser = ?");
		if (empty($infoUser)) {
			$insertData->bindParam(1, " ");
		} else {
			$insertData->bindParam(1, $infoUser);
		}
		$insertData->bindParam(2, $name);
		$insertData->bindParam(3, $lastname);
		$insertData->bindParam(4, $IDuser);
		$insertData->execute();
	} catch (PDOException $e) {
		$error_Code = $e->getCode();
		$message = $e->getMessage();
		die("Code: " . $error_Code . "\nMessage: " . $message);
	} catch (PDOException $e) {
		$error_Code = $e->getCode();
		$message = $e->getMessage();
		die("Code: " . $error_Code . "\nMessage: " . $message);
	}
}

function new_ticket($id_user, $asunto_ticket, $descripcion_ticket, $fecha, $estado)
{
	global $conection;
	$confirmado = false;
	try {
		$insertData = $conection->prepare("INSERT INTO tickets (user_id,asunto_ticket,mensaje,fecha_ticket,status) VALUES (?,?,?,?,?)");
		$insertData->bindParam(1, $id_user);
		$insertData->bindParam(2, $asunto_ticket);
		$insertData->bindParam(3, $descripcion_ticket);
		$insertData->bindParam(4, $fecha);
		$insertData->bindParam(5, $estado);
		if ($insertData->execute()) {
			$confirmado = true;
		}
		return $confirmado;
	} catch (PDOException $e) {
		$error_Code = $e->getCode();
		$message = $e->getMessage();
		die("Code: " . $error_Code . "\nMessage: " . $message);
	}
}

function respond_tickets($ticket_id, $mensaje_ticket, $fecha, $nombre_admin, $privilegio_user)
{

	global $conection;
	$confirmado = false;
	try {
		$insertData = $conection->prepare("INSERT INTO tickets_respuestas (ticket_id, respuesta_ticket, fecha_respuesta, nombre_admin,privilegio_user) VALUES (?,?,?,?,?)");
		$insertData->bindParam(1, $ticket_id);
		$insertData->bindParam(2, $mensaje_ticket);
		$insertData->bindParam(3, $fecha);
		$insertData->bindParam(4, $nombre_admin);
		$insertData->bindParam(5, $privilegio_user);
		if ($insertData->execute()) {
			$confirmado = true;
		}
		return $confirmado;
	} catch (PDOException $e) {
		$error_Code = $e->getCode();
		$message = $e->getMessage();
		die("Code: " . $error_Code . "\nMessage: " . $message);
	}
}

function cambiar_estado($estado, $id)
{
	global $conection;
	try {
		$insertData = $conection->prepare("UPDATE tickets SET status = ? WHERE ticket_id = ?");
		$insertData->bindParam(1, $estado);
		$insertData->bindParam(2, $id);
		$insertData->execute();
	} catch (PDOException $e) {
		$error_Code = $e->getCode();
		$message = $e->getMessage();
		die("Code: " . $error_Code . "\nMessage: " . $message);
	}
}

function getTickets($id)
{
	global $conection;
	$consulta = $conection->prepare("SELECT * from tickets_respuestas where ticket_id=?");
	$consulta->execute(array($id));
	$consulta = $consulta->fetchAll(PDO::FETCH_ASSOC);
	return $consulta;
}

function getTickets_user($id)
{
	global $conection;
	$consulta = $conection->prepare("SELECT * from tickets where user_id=?");
	$consulta->execute(array($id));
	$consulta = $consulta->fetchAll(PDO::FETCH_ASSOC);
	return $consulta;
}

function getInfoAboutUser($IDuser)
{
	global $conection;
	$consulta = $conection->prepare("SELECT * from aboutuser where IDuser=?");
	$consulta->execute(array($IDuser));
	$consulta = $consulta->fetch(PDO::FETCH_ASSOC);
	return $consulta;
}

function checkUserName($userName)
{
	global $conection;
	$exist = false;
	$consulta = $conection->prepare("SELECT * from users WHERE userName = ? OR email = ?");
	$consulta->execute(array($userName, $userName));
	if ($consulta->fetchColumn()) {
		$exist = true;
	}
	return $exist;
}

function search_user($search)
{
	global $conection;
	$consulta = $conection->prepare("SELECT userName,email,userPicture from users WHERE userName LIKE ? OR email LIKE ?");
	$consulta->execute(array("%$search%", "%$search%"));
	return $consulta;
}

function search_comics($search){
	global $conection;
	$consulta = $conection->prepare("SELECT * from comics WHERE nomComic LIKE ? OR nomVariante LIKE ? OR nomEditorial LIKE ? OR Formato LIKE ? OR Procedencia LIKE ? OR date_published LIKE ? OR nomGuionista LIKE ? OR nomDibujante LIKE ?");
	$consulta->execute(array("%$search%", "%$search%", "%$search%", "%$search%", "%$search%", "%$search%", "%$search%", "%$search%"));
	return $consulta;
}

function existe_comic($search){
	global $conection;
	$consulta = $conection->prepare("SELECT * from comics WHERE nomComic LIKE ? OR nomVariante LIKE ? OR nomEditorial LIKE ? OR Formato LIKE ? OR Procedencia LIKE ? OR date_published LIKE ? OR nomGuionista LIKE ? OR nomDibujante LIKE ?");
	$consulta->execute(array("%$search%", "%$search%", "%$search%", "%$search%", "%$search%", "%$search%", "%$search%", "%$search%"));
	if ($consulta->fetchColumn()) {
		return true;
	}else{
		return false;
	}
}

function existe_user($search)
{
	global $conection;
	$consulta = $conection->prepare("SELECT * from users WHERE userName LIKE ? OR email LIKE ?");
	$consulta->execute(array("%$search%", "%$search%"));
	if ($consulta->fetchColumn()) {
		return true;
	} else {
		return false;
	}
}

function showUsers()
{
	global $conection;
	$sql = "SELECT * FROM users";
	$consulta = $conection->query($sql);
	return $consulta;
}

function showComics(){
	global $conection;
	$sql = "SELECT * FROM comics";
	$consulta = $conection->query($sql);
	return $consulta;
}

function countUserSearch($search)
{
	global $conection;
	$consulta = $conection->prepare("SELECT COUNT(*) from users WHERE userName LIKE ? OR email LIKE ?");
	$consulta->execute(array("%$search%", "%$search%"));
	$consulta = $consulta->fetchColumn();
	return $consulta;
}

function countComicSearch($search){
	global $conection;
	$consulta = $conection->prepare("SELECT COUNT(*) from comics WHERE nomComic LIKE ? OR nomVariante LIKE ? OR nomEditorial LIKE ? OR Formato LIKE ? OR Procedencia LIKE ? OR date_published LIKE ? OR nomGuionista LIKE ? OR nomDibujante LIKE ?");
	$consulta->execute(array("%$search%", "%$search%", "%$search%", "%$search%", "%$search%", "%$search%", "%$search%", "%$search%"));
	$consulta = $consulta->fetchColumn();
	return $consulta;
}

function randomComic()
{
	$num = count_comic_total();
	$random = rand(1, $num);
	return $random;
}

function count_comic_total(){
	global $conection;
	$consulta = $conection->prepare("SELECT COUNT(*) from comics");
	$consulta->execute();
	$consulta = $consulta->fetchColumn();
	return $consulta;
}

function return_comic_published($limit, $offset) {
	global $conection;
    // Build the query to retrieve the comic books
    $query = "SELECT IDcomic, numComic, nomComic, nomVariante, date_published FROM comics WHERE date_published IS NOT NULL ORDER BY date_published DESC LIMIT :limit OFFSET :offset";

    // Prepare the statement
    $stmt = $conection->prepare($query);

    // Bind the parameters
    $stmt->bindParam(':limit', $limit, PDO::PARAM_INT);
    $stmt->bindParam(':offset', $offset, PDO::PARAM_INT);

    // Execute the statement
    $stmt->execute();

    // Return the result
    return $stmt;
}

function getDataComic($id){
	global $conection;
	$consulta = $conection->prepare("SELECT * from comics where IDcomic=?");
	$consulta->execute(array($id));
	$consulta = $consulta->fetch(PDO::FETCH_ASSOC);
	return $consulta;
}

function get_comic(){
	global $conection;
	$consulta = $conection->prepare("SELECT * from comics");
	$consulta->execute();
	$consulta = $consulta->fetchAll(PDO::FETCH_ASSOC);
	return $consulta;
}

function getDatacomicName($search){
	global $conection;
	//return 5 comics but do not repit the id
	$consulta = $conection->prepare("SELECT * from comics where nomComic LIKE ?");
	$consulta->execute(array($search));
	$consulta = $consulta->fetch(PDO::FETCH_ASSOC);
	return $consulta;
}

function numComics(){
	global $conection;
	$consulta = $conection->prepare("SELECT COUNT(*) from comics");
	$consulta->execute();
	$consulta = $consulta->fetchColumn();
	return $consulta;
}
