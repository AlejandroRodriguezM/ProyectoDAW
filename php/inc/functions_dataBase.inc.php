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

function info_user_id($id)
{
	global $conection;
	$consulta = $conection->prepare("SELECT * from users WHERE IDuser = ?");
	$consulta->execute(array($id));
	$info = $consulta->fetch(PDO::FETCH_ASSOC);
	return $info;
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
	$delete = false;
	try {
		$insertData1 = $conection->prepare("DELETE FROM comics_guardados WHERE user_id = ?");
		$insertData1->bindParam(1, $idUser);
		$insertData1->execute();
		$insertData2 = $conection->prepare("DELETE FROM lista_comics WHERE id_user = ?");
		$insertData2->bindParam(1, $idUser);
		// $insertData3 = $conection->prepare("SELECT COUNT(*) FROM lista_comics WHERE id_user = ?");
		// $insertData3->bindParam(1, $idUser);
		$insertData4 = $conection->prepare("DELETE FROM users WHERE email = ?");
		$insertData4->bindParam(1, $email);
		$insertData5 = $conection->prepare("DELETE FROM aboutuser WHERE IDuser = ?");
		$insertData5->bindParam(1, $idUser);
		$insertData6 = $conection->prepare("DELETE FROM possession WHERE user = ?");
		$insertData6->bindParam(1, $idUser);
		$insertData7 = $conection->prepare("DELETE FROM wanted WHERE user = ?");
		$insertData7->bindParam(1, $idUser);
		if ($insertData1->execute()) {
			$insertData4->execute();
			deleteDirectory($email, $idUser);
		}
		$delete == true;
	} catch (PDOException $e) {
		$error_Code = $e->getCode();
		$message = $e->getMessage();
		die("Code: " . $error_Code . "\nMessage: " . $message);
	}
	return $delete;
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

function changeStatusAccount($email, $estado)
{
	global $conection;
	$cambio = false;
	try {
		if ($estado == 'true') {
			$consulta = $conection->prepare("UPDATE users SET accountStatus = 'block' WHERE email = ?");
			$consulta = $conection->prepare("UPDATE users SET tipo_perfil = 'privado' WHERE email = ?");
		} elseif ($estado == 'false') {
			$consulta = $conection->prepare("UPDATE users SET accountStatus = 'active' WHERE email = ?");
		} else {
			$consulta = $conection->prepare("UPDATE users SET accountStatus = 'inactive' WHERE email = ?");
			$consulta = $conection->prepare("UPDATE users SET tipo_perfil = 'privado' WHERE email = ?");
		}

		$consulta->execute(array($email));
		$cambio = true;
	} catch (PDOException $e) {
		$error_Code = $e->getCode();
		$message = $e->getMessage();
		die("Code: " . $error_Code . "\nMessage: " . $message);
	}
	return $cambio;
}

function cambiar_privacidad($email, $estado)
{
	global $conection;
	$cambio = false;
	try {
		if ($estado == 'true') {
			$consulta = $conection->prepare("UPDATE users SET tipo_perfil = 'privado' WHERE email = ?");
		} elseif ($estado == 'false') {
			$consulta = $conection->prepare("UPDATE users SET tipo_perfil = 'publico' WHERE email = ?");
		}

		$consulta->execute(array($email));
		$cambio = true;
	} catch (PDOException $e) {
		$error_Code = $e->getCode();
		$message = $e->getMessage();
		die("Code: " . $error_Code . "\nMessage: " . $message);
	}
	return $cambio;
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
	$consulta = $conection->prepare("SELECT userName,email,userPicture from users WHERE userName LIKE ? OR email LIKE ? AND accountStatus = 'active' AND tipo_perfil = 'publico'");
	$consulta->execute(array("%$search%", "%$search%"));
	return $consulta;
}

function search_comics($search)
{
	global $conection;
	$consulta = $conection->prepare("SELECT * from comics WHERE nomComic LIKE ? OR nomVariante LIKE ? OR nomEditorial LIKE ? OR Formato LIKE ? OR Procedencia LIKE ? OR date_published LIKE ? OR nomGuionista LIKE ? OR nomDibujante LIKE ?");
	$consulta->execute(array("%$search%", "%$search%", "%$search%", "%$search%", "%$search%", "%$search%", "%$search%", "%$search%"));
	return $consulta;
}

function existe_comic($search)
{
	global $conection;
	$consulta = $conection->prepare("SELECT * from comics WHERE nomComic LIKE ? OR nomVariante LIKE ? OR nomEditorial LIKE ? OR Formato LIKE ? OR Procedencia LIKE ? OR date_published LIKE ? OR nomGuionista LIKE ? OR nomDibujante LIKE ?");
	$consulta->execute(array("%$search%", "%$search%", "%$search%", "%$search%", "%$search%", "%$search%", "%$search%", "%$search%"));
	if ($consulta->fetchColumn()) {
		return true;
	} else {
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

function showComics()
{
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

function countComicSearch($search)
{
	global $conection;
	$consulta = $conection->prepare("SELECT COUNT(*) from comics WHERE nomComic LIKE ? OR nomVariante LIKE ? OR nomEditorial LIKE ? OR Formato LIKE ? OR Procedencia LIKE ? OR date_published LIKE ? OR nomGuionista LIKE ? OR nomDibujante LIKE ?");
	$consulta->execute(array("%$search%", "%$search%", "%$search%", "%$search%", "%$search%", "%$search%", "%$search%", "%$search%"));
	$consulta = $consulta->fetchColumn();
	return $consulta;
}

function randomComic()
{
	global $conection;

	$stmt = $conection->query("SELECT IDcomic FROM comics ORDER BY RAND() LIMIT 1");

	if ($stmt) {
		$row = $stmt->fetch(PDO::FETCH_ASSOC);
		return $row['IDcomic'];
	} else {
		return null;
	}
}


function count_comic_total()
{
	global $conection;
	$consulta = $conection->prepare("SELECT COUNT(*) from comics");
	$consulta->execute();
	$consulta = $consulta->fetchColumn();
	return $consulta;
}

function return_comic_published($limit, $offset)
{
	global $conection;
	// Build the query to retrieve the comic books
	$query = "SELECT IDcomic, numComic, nomComic, nomVariante, date_published, Cover 
	FROM comics 
	WHERE date_published IS NOT NULL 
	ORDER BY date_published DESC 
	LIMIT :limit 
	OFFSET :offset";

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

function return_comic_search($limit, $offset, $busqueda)
{
	global $conection;
	// Build the query to retrieve the comic books
	$query = "SELECT * FROM comics
	WHERE nomComic LIKE CONCAT('%', :search, '%')
	OR nomVariante LIKE CONCAT('%', :search, '%')
	OR nomEditorial LIKE CONCAT('%', :search, '%')
	OR Formato LIKE CONCAT('%', :search, '%')
	OR Procedencia LIKE CONCAT('%', :search, '%')
	OR date_published LIKE CONCAT('%', :search, '%')
	OR nomGuionista LIKE CONCAT('%', :search, '%')
	OR nomDibujante LIKE CONCAT('%', :search, '%')
	OR nomEditorial LIKE CONCAT('%', :search, '%')
	OR Formato LIKE CONCAT('%', :search, '%')
	OR Procedencia LIKE CONCAT('%', :search, '%')
	OR nomGuionista LIKE CONCAT('%', :search, '%')
	OR nomDibujante LIKE CONCAT('%', :search, '%')
	ORDER BY date_published DESC LIMIT :limit OFFSET :offset";
	// Prepare the statement
	$stmt = $conection->prepare($query);

	// Bind the parameters
	$stmt->bindParam(':limit', $limit, PDO::PARAM_INT);
	$stmt->bindParam(':offset', $offset, PDO::PARAM_INT);
	$stmt->bindParam(':search', $busqueda, PDO::PARAM_STR);
	// Execute the statement
	$stmt->execute();

	// Return the result
	return $stmt;
}

function getDataComic($id)
{
	global $conection;
	$consulta = $conection->prepare("SELECT * from comics where IDcomic=?");
	$consulta->execute(array($id));
	$consulta = $consulta->fetch(PDO::FETCH_ASSOC);
	return $consulta;
}

function get_comics()
{
	global $conection;
	$consulta = $conection->prepare("SELECT * from comics");
	$consulta->execute();
	$consulta = $consulta->fetchAll(PDO::FETCH_ASSOC);
	return $consulta;
}

function getDatacomicName($search)
{
	global $conection;
	//return 5 comics but do not repit the id
	$consulta = $conection->prepare("SELECT * from comics where nomComic LIKE ?");
	$consulta->execute(array($search));
	$consulta = $consulta->fetch(PDO::FETCH_ASSOC);
	return $consulta;
}

function numComics()
{
	global $conection;
	$consulta = $conection->prepare("SELECT COUNT(*) from comics");
	$consulta->execute();
	$consulta = $consulta->fetchColumn();
	return $consulta;
}

function agregar_opinion($id_user, $id_comic, $opinion, $puntuacion)
{
	global $conection;
	$agregado = false;
	try {
		$consulta = $conection->prepare("INSERT INTO opiniones_comics(id_comic,id_usuario,opinion,puntuacion) VALUES (?,?,?,?)");
		$consulta->execute(array($id_comic, $id_user, $opinion, $puntuacion));
		$agregado = true;
	} catch (PDOException $e) {
		echo "Error: " . $e->getMessage();
	}
	return $agregado;
}

function agregar_opinion_pagina($id_user, $opinion)
{
	global $conection;
	$agregado = false;
	try {
		$consulta = $conection->prepare("INSERT INTO opiniones_pagina(id_user,comentario,fecha_comentario) VALUES (?,?,?)");
		$consulta->execute(array($id_user, $opinion, date("Y-m-d")));
		$agregado = true;
	} catch (PDOException $e) {
		echo "Error: " . $e->getMessage();
	}
	return $agregado;
}

function num_opiniones($id_comic)
{
	global $conection;
	$consulta = $conection->prepare("SELECT COUNT(*) from opiniones_comics where id_comic=?");
	$consulta->execute(array($id_comic));
	$consulta = $consulta->fetchColumn();
	return $consulta;
}

function opiniones_usuario($id_usuario)
{
	global $conection;
	$consulta = $conection->prepare("SELECT COUNT(*) from opiniones_comics where id_usuario=?");
	$consulta->execute(array($id_usuario));
	$consulta = $consulta->fetchAll(PDO::FETCH_ASSOC);
	return $consulta;
}

function mostrar_opiniones($id_comic)
{
	global $conection;
	$consulta = $conection->prepare("SELECT * from opiniones_comics where id_comic=?");
	$consulta->execute(array($id_comic));
	return $consulta;
}

function mostrar_opiniones_pagina()
{
	global $conection;
	$consulta = $conection->prepare("SELECT * from opiniones_pagina");
	$consulta->execute();
	return $consulta;
}

function numero_opiniones_pagina()
{
	global $conection;
	$consulta = $conection->prepare("SELECT count(*) from opiniones_pagina");
	$consulta->execute();
	$resultado = $consulta->fetch();
	return $resultado[0];
}

function valoracion_media($id_comic)
{
	global $conection;
	$consulta = $conection->prepare("SELECT AVG(puntuacion) from opiniones_comics where id_comic=?");
	$consulta->execute(array($id_comic));
	$consulta = $consulta->fetchColumn();
	return $consulta;
}

function nueva_lista($id_user, $nombre_lista)
{
	global $conection;
	$agregado = false;
	try {
		$consulta = $conection->prepare("INSERT INTO lista_comics(nombre_lista,id_user) VALUES (?,?)");
		$consulta->execute(array($nombre_lista, $id_user));
		$agregado = true;
	} catch (PDOException $e) {
		echo "Error: " . $e->getMessage();
	}
	return $agregado;
}

function modificar_lista($id_lista, $nombre_lista)
{
	global $conection;
	$modificada = false;
	try {
		$consulta = $conection->prepare("UPDATE lista_comics SET nombre_lista=? WHERE id_lista=?");
		$consulta->execute(array($nombre_lista, $id_lista));
		$modificada = true;
	} catch (PDOException $e) {
		echo "Error: " . $e->getMessage();
	}

	return $modificada;
}

function check_guardado($id_user, $id_comic)
{
	global $conection;
	$guardado = false;
	$consulta = $conection->prepare("SELECT COUNT(*) from comics_guardados where user_id=? AND comic_id=?");
	$consulta->execute(array($id_user, $id_comic));
	$consulta = $consulta->fetchColumn();
	if ($consulta > 0) {
		$guardado = true;
	}
	// var_dump($guardado);
	return $guardado;
}

function check_guardado_lista($id_lista, $id_comic)
{
	global $conection;
	$guardado = false;
	$consulta = $conection->prepare("SELECT COUNT(*) from contenido_listas where id_lista=? AND id_comic=?");
	$consulta->execute(array($id_lista, $id_comic));
	$consulta = $consulta->fetchColumn();
	if ($consulta > 0) {
		$guardado = true;
	}
	// var_dump($guardado);
	return $guardado;
}

function guardar_comic($id_user, $id_comic)
{
	global $conection;
	$agregado = false;
	try {
		$consulta = $conection->prepare("INSERT INTO comics_guardados(user_id,comic_id) VALUES (?,?)");
		$consulta->execute(array($id_user, $id_comic));
		$agregado = true;
	} catch (PDOException $e) {
		echo "Error: " . $e->getMessage();
	}
	return $agregado;
}

function quitar_comic($id_user, $id_comic)
{
	global $conection;
	$agregado = false;
	try {
		$consulta = $conection->prepare("DELETE FROM comics_guardados WHERE user_id=? AND comic_id=?");
		$consulta->execute(array($id_user, $id_comic));
		$agregado = true;
	} catch (PDOException $e) {
		echo "Error: " . $e->getMessage();
	}
	return $agregado;
}

function guardar_comic_lista($id_comic, $id_lista)
{
	global $conection;
	$agregado = false;
	try {
		$consulta = $conection->prepare("INSERT INTO contenido_listas(id_comic,id_lista) VALUES (?,?)");
		$consulta->execute(array($id_comic, $id_lista));
		$agregado = true;
	} catch (PDOException $e) {
		echo "Error: " . $e->getMessage();
	}
	return $agregado;
}

function quitar_comic_lista($id_comic, $id_lista)
{
	global $conection;
	$agregado = false;
	try {
		$consulta = $conection->prepare("DELETE FROM contenido_listas WHERE id_comic=? AND id_lista=?");
		$consulta->execute(array($id_comic, $id_lista));
		$agregado = true;
	} catch (PDOException $e) {
		echo "Error: " . $e->getMessage();
	}
	return $agregado;
}

function get_comics_guardados($limit, $offset, $id_user)
{
	global $conection;
	$consulta = $conection->prepare("SELECT * from comics_guardados JOIN comics ON comics_guardados.comic_id=comics.IDcomic where user_id=:id_user ORDER BY comic_id  DESC LIMIT :limit OFFSET :offset");
	$consulta->bindParam(':id_user', $id_user, PDO::PARAM_INT);
	$consulta->bindParam(':limit', $limit, PDO::PARAM_INT);
	$consulta->bindParam(':offset', $offset, PDO::PARAM_INT);
	$consulta->execute();
	return $consulta;
}

function get_comics_lista($limit, $offset, $id_lista)
{
	global $conection;
	$consulta = $conection->prepare("SELECT * FROM contenido_listas JOIN comics ON contenido_listas.id_comic=comics.IDcomic WHERE contenido_listas.id_lista=:id_lista ORDER BY comics.IDcomic DESC LIMIT :limit OFFSET :offset");
	$consulta->bindParam(':id_lista', $id_lista, PDO::PARAM_INT);
	$consulta->bindParam(':limit', $limit, PDO::PARAM_INT);
	$consulta->bindParam(':offset', $offset, PDO::PARAM_INT);
	$consulta->execute();
	return $consulta;
}

function get_id_contenido($id_lista, $id_comic)
{
	global $conection;
	$consulta = $conection->prepare("SELECT id_contenido from contenido_listas where id_lista=? and id_comic=?");
	$consulta->execute(array($id_lista, $id_comic));
	$resultado = $consulta->fetch(PDO::FETCH_ASSOC);
	return "[" . $resultado['id_contenido'] . "]";
}

function get_total_contenido($id_lista)
{
	global $conection;
	$consulta = $conection->prepare("SELECT COUNT(*) from contenido_listas where id_lista=?");
	$consulta->execute(array($id_lista));
	$resultado = $consulta->fetchColumn();
	return $resultado;
}

function get_total_guardados($id_user)
{
	global $conection;
	$consulta = $conection->prepare("SELECT COUNT(*) from comics_guardados where user_id=?");
	$consulta->execute(array($id_user));
	$resultado = $consulta->fetchColumn();
	return $resultado;
}
function get_descripcion($id)
{
	global $conection;
	$consulta = $conection->prepare("SELECT * from descripcion_comics where id_comic=?");
	$consulta->execute(array($id));
	$consulta = $consulta->fetch(PDO::FETCH_ASSOC);
	return $consulta;
}

function get_listas($id)
{
	global $conection;
	$consulta = $conection->prepare("SELECT * from lista_comics where id_user=?");
	$consulta->execute(array($id));
	$consulta = $consulta->fetchAll(PDO::FETCH_ASSOC);
	return $consulta;
}

function get_nombre_lista($id_lista)
{
	global $conection;
	$consulta = $conection->prepare("SELECT * from lista_comics where id_lista=?");
	$consulta->execute(array($id_lista));
	$nombre_lista = $consulta->fetch(PDO::FETCH_ASSOC);
	return $nombre_lista;
}

function num_listas_user($id)
{
	global $conection;
	$consulta = $conection->prepare("SELECT COUNT(*) from lista_comics where id_user=?");
	$consulta->execute(array($id));
	$consulta = $consulta->fetchColumn();
	return $consulta;
}

function check_lista_user($id_user, $id_lista)
{
	global $conection;
	$existe = false;
	$consulta = $conection->prepare("SELECT COUNT(*) from lista_comics where id_user=? and id_lista=?");
	$consulta->execute(array($id_user, $id_lista));

	//si existe, true
	if ($consulta->fetchColumn() > 0) {
		$existe = true;
	}

	return $existe;
}

/**
 * Elimina una lista de comics y su contenido asociado
 *
 * @param int $id_lista El ID de la lista a eliminar
 * @return bool True si la lista fue eliminada con éxito, False en caso contrario
 */
function eliminar_lista($id_lista, $id_user)
{
	global $conection;
	$eliminado = false;
	try {
		if (eliminar_contenido_listas($id_lista)) {
			$consulta = $conection->prepare("DELETE FROM lista_comics WHERE id_lista=? AND id_user=?");
			$consulta->execute(array($id_lista, $id_user));
			if ($consulta->execute()) {
				$eliminado = true;
			}
		}
	} catch (PDOException $e) {
		echo "Error: " . $e->getMessage();
	}

	return $eliminado;
}

/**
 * Elimina el contenido asociado a una lista de comics
 *
 * @param int $id_lista El ID de la lista de la que se eliminará el contenido
 * @return bool True si el contenido fue eliminado con éxito, False en caso contrario
 */
function eliminar_contenido_listas($id_lista)
{
	global $conection;
	$eliminado = false;
	try {
		// Primero, verificamos si hay contenido en la lista
		$consulta_contenido = $conection->prepare("SELECT COUNT(*) FROM contenido_listas WHERE id_lista=?");
		$consulta_contenido->execute(array($id_lista));
		$num_filas = $consulta_contenido->fetchColumn();

		if ($num_filas == 0) {
			// Si no hay contenido, devolvemos true
			$eliminado = true;
		} else {
			// Si hay contenido, lo eliminamos y devolvemos true si se afectaron filas
			$consulta_eliminar = $conection->prepare("DELETE FROM contenido_listas WHERE id_lista=?");
			$consulta_eliminar->execute(array($id_lista));
			$eliminado = $consulta_eliminar->rowCount() > 0;
		}
	} catch (PDOException $e) {
		echo "Error: " . $e->getMessage();
	}
	return $eliminado;
}

function lista_usuario($id_usuario)
{
	global $conection;
	$consulta = $conection->prepare("SELECT * from lista_comics where id_user=?");
	$consulta->execute(array($id_usuario));
	$consulta = $consulta->fetchAll(PDO::FETCH_ASSOC);
	return $consulta;
}

function reactivar_cuenta($email)
{
	global $conection;
	try {
		$consulta = $conection->prepare("UPDATE users SET accountStatus = 'active' WHERE email = ? AND accountStatus != 'block'");
		$consulta->execute(array($email));
	} catch (PDOException $e) {
		echo "Error: " . $e->getMessage();
	}
}

function estado_solicitud($id_destinatario,$id_solicitante){
	global $conection;
	$consulta = $conection->prepare("SELECT estado_solicitud from solicitudes_amistad where id_usuario_destinatario=? AND id_usuario_solicitante = ?");
	$consulta->execute(array($id_destinatario,$id_solicitante));
	$consulta = $consulta->fetchColumn();
	return $consulta;
}

function num_amistades($id_usuario){
	global $conection;
	$consulta = $conection->prepare("SELECT COUNT(*) from amistades_usuario where id_usuario=?");
	$consulta->execute(array($id_usuario));
	$consulta = $consulta->fetchColumn();
	return $consulta;
}

function solicitudes_amistad($id_user){
	global $conection;
	$consulta = $conection->prepare("SELECT * from solicitudes_amistad where id_usuario_destinatario=? AND estado_solicitud='en espera'");
	$consulta->execute(array($id_user));
	$consulta = $consulta->fetchAll(PDO::FETCH_ASSOC);
	return $consulta;
}

function num_solicitudes_amistad($id_user){
	global $conection;
	$consulta = $conection->prepare("SELECT COUNT(*) from solicitudes_amistad where id_usuario_destinatario=? AND estado_solicitud='en espera'");
	$consulta->execute(array($id_user));
	$consulta = $consulta->fetchColumn();
	return $consulta;
}

function solicitudes_amistad_enviadas($id_user){
	global $conection;
	$consulta = $conection->prepare("SELECT * from solicitudes_amistad where id_usuario_solicitante= ? AND estado_solicitud='en espera'");
	$consulta->execute(array($id_user));
	$consulta = $consulta->fetchAll(PDO::FETCH_ASSOC);
	return $consulta;
}

function num_solicitudes_amistad_enviadas($id_user){
	global $conection;
	$consulta = $conection->prepare("SELECT COUNT(*) from solicitudes_amistad where id_usuario_solicitante = ? AND estado_solicitud='en espera'");
	$consulta->execute(array($id_user));
	$consulta = $consulta->fetchColumn();
	return $consulta;
}

function aceptar_solicitud($id_remitente,$id_mi_usuario){
	global $conection;
	$aceptado = false;
	try {
		$consulta1 = $conection->prepare("UPDATE solicitudes_amistad SET estado_solicitud = 'aceptada' WHERE id_usuario_solicitante = ? AND id_usuario_destinatario = ?");
		$consulta1->execute(array($id_remitente,$id_mi_usuario));
		$consulta2 = $conection->prepare("INSERT INTO amistades_usuario (id_usuario,id_amigo) VALUES (?,?)");
		$consulta2->execute(array($id_remitente,$id_mi_usuario));
		$consulta3 = $conection->prepare("INSERT INTO amistades_usuario (id_usuario,id_amigo) VALUES (?,?)");
		$consulta3->execute(array($id_mi_usuario,$id_remitente));
		$aceptado = true;
		
	} catch (PDOException $e) {
		echo "Error: " . $e->getMessage();
	}
	return $aceptado;
}

function rechazar_solicitud($id_remitente,$id_mi_usuario){
	global $conection;
	$rechazado = false;
	try {
		$consulta1 = $conection->prepare("UPDATE solicitudes_amistad SET estado_solicitud = 'rechazada' WHERE id_usuario_solicitante = ? AND id_usuario_destinatario = ?");
		$consulta1->execute(array($id_remitente,$id_mi_usuario));
		$rechazado = true;
		
	} catch (PDOException $e) {
		echo "Error: " . $e->getMessage();
	}

	return $rechazado;
}

function cancelar_solicitud($id_remitente,$id_mi_usuario){
	global $conection;
	$cancelado = false;
	try {
		$consulta = $conection->prepare("DELETE FROM solicitudes_amistad WHERE id_usuario_solicitante = ? AND id_usuario_destinatario = ?");
		$consulta->execute(array($id_mi_usuario,$id_remitente));
		$cancelado = true;
		
	} catch (PDOException $e) {
		echo "Error: " . $e->getMessage();
	}

	return $cancelado;
}

function comprobar_solicitud($id_solicitante,$id_mi_usuario){
	global $conection;
	$existe = false;
	$consulta = $conection->prepare("SELECT * from solicitudes_amistad where id_usuario_solicitante=? AND id_usuario_destinatario=? AND estado_solicitud='en espera'");
	$consulta->execute(array($id_solicitante,$id_mi_usuario));
	$consulta = $consulta->fetchAll(PDO::FETCH_ASSOC);
	if($consulta){
		$existe = true;
	}
	return $existe;
}

function comprobar_amistad($id_amigo,$id_mi_usuario){
	global $conection;
	$existe = false;
	$consulta = $conection->prepare("SELECT * from amistades_usuario where id_usuario=? AND id_amigo=?");
	$consulta->execute(array($id_mi_usuario,$id_amigo));
	$consulta = $consulta->fetchAll(PDO::FETCH_ASSOC);
	if($consulta){
		$existe = true;
	}
	return $existe;
}

function enviar_solicitud($id_destinatario,$id_solicitante){
	global $conection;
	$enviado = false;
	try {
		$consulta = $conection->prepare("INSERT INTO solicitudes_amistad (id_usuario_destinatario,id_usuario_solicitante) VALUES (?,?)");
		$consulta->execute(array($id_destinatario,$id_solicitante));
		$enviado = true;
		
	} catch (PDOException $e) {
		echo "Error: " . $e->getMessage();
	}

	return $enviado;
}

function eliminar_amigo($id_amigo,$id_mi_usuario){
	global $conection;
	$eliminado = false;
	try {
		$consulta1 = $conection->prepare("DELETE FROM amistades_usuario WHERE id_usuario = ? AND id_amigo = ?");
		$consulta1->execute(array($id_mi_usuario,$id_amigo));
		$consulta2 = $conection->prepare("DELETE FROM amistades_usuario WHERE id_usuario = ? AND id_amigo = ?");
		$consulta2->execute(array($id_amigo,$id_mi_usuario));
		$consulta3 = $conection->prepare("DELETE FROM solicitudes_amistad WHERE id_usuario_solicitante = ? AND id_usuario_destinatario = ?");
		$consulta3->execute(array($id_amigo,$id_mi_usuario));
		$eliminado = true;
		
	} catch (PDOException $e) {
		echo "Error: " . $e->getMessage();
	}

	return $eliminado;
}

function amigos($id_user){
	global $conection;
	$consulta = $conection->prepare("SELECT * from amistades_usuario where id_usuario=?");
	$consulta->execute(array($id_user));
	$consulta = $consulta->fetchAll(PDO::FETCH_ASSOC);
	return $consulta;
}

function num_amigos($id_user){
	global $conection;
	$consulta = $conection->prepare("SELECT COUNT(*) from amistades_usuario where id_usuario=?");
	$consulta->execute(array($id_user));
	$consulta = $consulta->fetchColumn();
	return $consulta;
}

function bloquear_usuario($id_destinatario,$id_solicitante){
	global $conection;
	$bloqueado = false;
	try {
		$consulta1 = $conection->prepare("INSERT INTO usuarios_bloqueados (id_usuario_bloqueado,id_solicitante) VALUES (?,?)");
		$consulta1->execute(array($id_destinatario,$id_solicitante));

		$consulta2 = $conection->prepare("SELECT COUNT(*) from amistades_usuario where id_amigo=?");
		$consulta2->execute(array($id_destinatario));
		$consulta2 = $consulta2->fetchColumn();
		if($consulta2 > 0){
			$consulta3 = $conection->prepare("DELETE FROM amistades_usuario WHERE id_usuario = ? AND id_amigo = ?");
			$consulta3->execute(array($id_destinatario,$id_solicitante));
			$consulta4 = $conection->prepare("DELETE FROM amistades_usuario WHERE id_usuario = ? AND id_amigo = ?");
			$consulta4->execute(array($id_solicitante,$id_destinatario));
		}
		$num_solicitudes = num_solicitudes_amistad($id_destinatario);

		if($num_solicitudes > 0){
			$consulta5 = $conection->prepare("DELETE FROM solicitudes_amistad WHERE id_usuario_solicitante = ? AND id_usuario_destinatario = ?");
			$consulta5->execute(array($id_solicitante,$id_destinatario));
		}

		$bloqueado = true;
		
	} catch (PDOException $e) {
		echo "Error: " . $e->getMessage();
	}

	return $bloqueado;
}

function desbloquear_usuario($id_destinatario,$id_solicitante){
	global $conection;
	$desbloqueado = false;
	try {
		$consulta1 = $conection->prepare("DELETE FROM usuarios_bloqueados WHERE id_usuario_bloqueado = ? AND id_solicitante = ?");
		$consulta1->execute(array($id_destinatario,$id_solicitante));
		$desbloqueado = true;
		
	} catch (PDOException $e) {
		echo "Error: " . $e->getMessage();
	}

	return $desbloqueado;
}

function comprobar_bloqueo($id_destinatario,$id_solicitante){
	global $conection;
	$bloqueado = false;
	$consulta = $conection->prepare("SELECT * from usuarios_bloqueados where id_usuario_bloqueado=? AND id_solicitante=?");
	$consulta->execute(array($id_destinatario,$id_solicitante));
	$consulta = $consulta->fetchAll(PDO::FETCH_ASSOC);
	if($consulta){
		$bloqueado = true;
	}
	return $bloqueado;
}

function num_usuarios_bloqueados($id_mi_usuario){
	global $conection;
	$consulta = $conection->prepare("SELECT COUNT(*) from usuarios_bloqueados where id_solicitante=?");
	$consulta->execute(array($id_mi_usuario));
	$consulta = $consulta->fetchColumn();
	return $consulta;
}
function usuarios_bloqueados($id_mi_usuario){
	global $conection;
	$consulta = $conection->prepare("SELECT * from usuarios_bloqueados where id_solicitante=?");
	$consulta->execute(array($id_mi_usuario));
	$consulta = $consulta->fetchAll(PDO::FETCH_ASSOC);
	return $consulta;
}

function tipo_privacidad($id_user){
	global $conection;
	$consulta = $conection->prepare("SELECT tipo_perfil from users where IDuser=?");
	$consulta->execute(array($id_user));
	$consulta = $consulta->fetchColumn();
	return $consulta;
}



