<?php

function checkUser(string $acceso, string $password): bool
{
	global $conection;
	$existe = false;
	try {
		$consulta = $conection->prepare("SELECT * from users WHERE email = ? OR userName = ? and password = ?");
		if ($consulta->execute(array($acceso, $acceso, $password))) {
			$existe = true;
		}
	} catch (PDOException $e) {
		die("Code: " . $e->getCode() . "\nMessage: " . $e->getMessage());
	}
	return $existe;
}

function check_nombre_user(string $nombre): bool
{
	global $conection;
	$existe = false;
	try {
		$consulta = $conection->prepare("SELECT * from users WHERE userName = ?");
		if ($consulta->execute(array($nombre))) {
			if ($consulta->fetchColumn() > 0) {
				$existe = true;
			}
		}
	} catch (PDOException $e) {
		die("Code: " . $e->getCode() . "\nMessage: " . $e->getMessage());
	}
	return $existe;
}

function check_email_user(string $email): bool
{
	global $conection;
	$existe = false;
	try {
		$consulta = $conection->prepare("SELECT * from users WHERE email = ?");
		if ($consulta->execute(array($email))) {
			if ($consulta->fetchColumn() > 0) {
				$existe = true;
			}
		}
	} catch (PDOException $e) {
		die("Code: " . $e->getCode() . "\nMessage: " . $e->getMessage());
	}
	return $existe;
}



/**
 * Return the password from a user using loggin
 *
 * @param [type] $login
 * @param [type] $con
 * @return string
 */
function obtain_password(string $acces): string
{
	global $conection;
	$acces = htmlspecialchars($acces, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
	$consulta = $conection->prepare("SELECT password from users where email=? OR userName=?");
	$consulta->execute(array($acces, $acces));
	$password = $consulta->fetch(PDO::FETCH_ASSOC)['password'];
	unset($consulta);
	return $password;
}

/**
 * Obtain the data of a user from his Login
 *
 * @param [type] $email
 * @return array
 */
function obtener_datos_usuario(string $acces): array
{
	global $conection;

	// Validar y filtrar la entrada
	$acces = htmlspecialchars($acces, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
	try {
		// Preparar la consulta SQL con sentencias preparadas
		$stmt = $conection->prepare("SELECT * FROM users WHERE email=:acces OR userName=:acces OR IDuser=:acces");
		$stmt->bindParam(':acces', $acces, PDO::PARAM_STR);
		// Ejecutar la consulta
		$stmt->execute();
		// Obtener los datos de la consulta
		$row = $stmt->fetch(PDO::FETCH_ASSOC);
		// Cerrar la conexión
		unset($stmt);
	} catch (PDOException $e) {
		die("Code: " . $e->getCode() . "\nMessage: " . $e->getMessage());
	}
	// Devolver los datos
	return $row;
}


function crear_usuario(string $userName, string $email, string $password): bool
{
	global $conection;
	$create = false;
	$userName = htmlspecialchars($userName, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
	$email = htmlspecialchars($email, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
	$password = htmlspecialchars($password, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');

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
		die("Code: " . $e->getCode() . "\nMessage: " . $e->getMessage());
	}
}

function actualizar_usuario(string $userName, string $email, string $password): bool
{
	global $conection;
	$update = false;
	$userName = htmlspecialchars($userName, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
	$email = htmlspecialchars($email, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
	$password = htmlspecialchars($password, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
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
		die("Code: " . $e->getCode() . "\nMessage: " . $e->getMessage());
	}
}

function eliminar_usuario(String $email, int $idUser): bool
{
	global $conection;

	// Prepare queries to delete data related to the user from each table.
	$eliminarComicsGuardadosQuery = $conection->prepare("DELETE FROM comics_guardados WHERE user_id = ?");
	$eliminarComicsGuardadosQuery->bindParam(1, $idUser);

	$eliminarListaComicsQuery = $conection->prepare("DELETE FROM lista_comics WHERE id_user = ?");
	$eliminarListaComicsQuery->bindParam(1, $idUser);

	$eliminarPeticionesAmistadQuery = $conection->prepare("DELETE FROM solicitudes_amistad WHERE id_usuario_destinatario = ? OR id_usuario_solicitante = ?");
	$eliminarPeticionesAmistadQuery->bindParam(1, $idUser);
	$eliminarPeticionesAmistadQuery->bindParam(2, $idUser);

	$eliminarAmistadesQuery = $conection->prepare("DELETE FROM amistades_usuario WHERE id_usuario = ? OR id_amigo = ?");
	$eliminarAmistadesQuery->bindParam(1, $idUser);
	$eliminarAmistadesQuery->bindParam(2, $idUser);

	$eliminarAboutUserQuery = $conection->prepare("DELETE FROM aboutuser WHERE IDuser = ?");
	$eliminarAboutUserQuery->bindParam(1, $idUser);

	$eliminarUsuarioQuery = $conection->prepare("DELETE FROM users WHERE email = ?");
	$eliminarUsuarioQuery->bindParam(1, $email);

	// Wrap the deletion queries in a transaction.
	$conection->beginTransaction();

	try {
		$eliminarComicsGuardadosQuery->execute();
		$eliminarListaComicsQuery->execute();
		$eliminarPeticionesAmistadQuery->execute();
		$eliminarAmistadesQuery->execute();
		$eliminarAboutUserQuery->execute();
		$eliminarUsuarioQuery->execute();

		// Commit the transaction.
		$conection->commit();

		// Delete the user's directory.
		deleteDirectory($email, $idUser);

		return true;
	} catch (PDOException $e) {
		// Roll back the transaction on error.
		$conection->rollBack();

		$error_Code = $e->getCode();
		$message = $e->getMessage();

		die("Code: " . $error_Code . "\nMessage: " . $message);
	}
}


function actualizar_email(string $new_email, string $old_email): bool
{
	global $conection;
	$update = false;
	$new_email = htmlspecialchars($new_email, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
	$old_email = htmlspecialchars($old_email, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
	try {
		$insertData = $conection->prepare("UPDATE users SET email = ? WHERE email = ?");
		$insertData->bindParam(1, $new_email);
		$insertData->bindParam(2, $old_email);

		if ($insertData->execute()) {
			$update = true;
		}
		return $update;
	} catch (PDOException $e) {
		die("Code: " . $e->getCode() . "\nMessage: " . $e->getMessage());
	}
}

function insertURL(string $email, int $idUser): bool
{
	global $conection;

	$email = explode("@", $email);
	$email = $email[0];
	$file_path = 'assets/pictureProfile/' . $idUser . "-" . $email . "/profile.jpg";
	$email = htmlspecialchars($email, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
	$idUser = htmlspecialchars($idUser, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');

	try {
		$insertData = $conection->prepare("UPDATE users SET userPicture = ? WHERE IDuser = ?");
		$insertData->bindParam(1, $file_path);
		$insertData->bindParam(2, $idUser);
		return $insertData->execute();
	} catch (PDOException $e) {
		$error_Code = $e->getCode();
		$message = $e->getMessage();
		die("Code: " . $error_Code . "\nMessage: " . $message);
	}
}

function checkStatus(string $email): bool
{
	global $conection;
	$status = false;
	$email = htmlspecialchars($email, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
	try {
		$consulta = $conection->prepare("SELECT accountStatus from users where email=?");
		if ($consulta->execute(array($email))) {
			$consulta = $consulta->fetch(PDO::FETCH_ASSOC)['accountStatus'];
			if ($consulta == 'block') {
				$status = true;
			}
		}
	} catch (PDOException $e) {
		$error_Code = $e->getCode();
		$message = $e->getMessage();
		die("Code: " . $error_Code . "\nMessage: " . $message);
	}
	return $status;
}

function desautorizar_cuenta(string $email, bool $estado): bool
{
	global $conection;
	$cambio = false;
	$email = htmlspecialchars($email, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
	try {
		if ($estado) {
			$consulta = $conection->prepare("UPDATE users SET accountStatus = 'block', tipo_perfil = 'privado' WHERE email = ?");
			$cambio = true;
		} else {
			$consulta = $conection->prepare("UPDATE users SET accountStatus = 'active', tipo_perfil = 'publico' WHERE email = ?");
		}

		$consulta->execute(array($email));
	} catch (PDOException $e) {
		$error_Code = $e->getCode();
		$message = $e->getMessage();
		die("Code: " . $error_Code . "\nMessage: " . $message);
	}
	return $cambio;
}

function desactivar_cuenta(string $email): bool
{
	global $conection;
	$cambio = false;
	$email = htmlspecialchars($email, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
	try {
		$consulta = $conection->prepare("UPDATE users SET accountStatus = 'inactive',tipo_perfil = 'privado' WHERE email = ?");
		if ($consulta->execute(array($email))) {
			$cambio = true;
		}
	} catch (PDOException $e) {
		$error_Code = $e->getCode();
		$message = $e->getMessage();
		die("Code: " . $error_Code . "\nMessage: " . $message);
	}
	return $cambio;
}

function cambiar_privacidad(string $email, bool $estado): bool
{
	global $conection;
	$cambio = false;
	$email = htmlspecialchars($email, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
	try {
		if ($estado) {
			$consulta = $conection->prepare("UPDATE users SET tipo_perfil = 'privado' WHERE email = ?");
			$cambio = true;
		} else {
			$consulta = $conection->prepare("UPDATE users SET tipo_perfil = 'publico' WHERE email = ?");
		}

		$consulta->execute(array($email));
	} catch (PDOException $e) {
		$error_Code = $e->getCode();
		$message = $e->getMessage();
		die("Code: " . $error_Code . "\nMessage: " . $message);
	}
	return $cambio;
}

function insertAbourUser(int $IDuser, string $infoUser, string $fechaCreacion): void
{
	global $conection;
	$IDuser = htmlspecialchars($IDuser, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
	$infoUser = htmlspecialchars($infoUser, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
	$fechaCreacion = htmlspecialchars($fechaCreacion, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');

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

function updateAboutUser(int $IDuser, string $infoUser, string $name, string $lastname): void
{
	global $conection;
	$IDuser = htmlspecialchars($IDuser, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
	$infoUser = htmlspecialchars($infoUser, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
	$name = htmlspecialchars($name, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
	try {
		$userData = getInfoAboutUser($IDuser);
		$checkInfo = $userData['infoUser'];
		if (empty($infoUser)) {
			$infoUser = $checkInfo;
		}
		$insertData = $conection->prepare("UPDATE aboutuser SET infoUser = ?,nombreUser = ?,apellidoUser = ? WHERE IDuser = ?");
		if (empty($infoUser)) {
			$insertData->bindValue(1, " ");
		} else {
			$insertData->bindValue(1, $infoUser);
		}
		$insertData->bindValue(2, $name);
		$insertData->bindValue(3, $lastname);
		$insertData->bindValue(4, $IDuser);
		$insertData->execute();
	} catch (PDOException $e) {
		$error_Code = $e->getCode();
		$message = $e->getMessage();
		die("Code: " . $error_Code . "\nMessage: " . $message);
	}
}

function new_ticket(int $id_user, string $asunto_ticket, string $descripcion_ticket, string $fecha, string $estado): bool
{
	global $conection;
	$confirmado = false;
	$id_user = htmlspecialchars($id_user, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
	$asunto_ticket = htmlspecialchars($asunto_ticket, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
	$descripcion_ticket = htmlspecialchars($descripcion_ticket, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
	$fecha = htmlspecialchars($fecha, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
	$estado = htmlspecialchars($estado, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');

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
	} catch (PDOException $e) {
		$error_Code = $e->getCode();
		$message = $e->getMessage();
		die("Code: " . $error_Code . "\nMessage: " . $message);
	}
	return $confirmado;
}

function respond_tickets(int $ticket_id, string $mensaje_ticket, string $fecha, string $nombre_admin, string $privilegio_user): bool
{
	global $conection;
	$confirmado = false;
	$ticket_id = htmlspecialchars($ticket_id, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
	$mensaje_ticket = htmlspecialchars($mensaje_ticket, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
	$fecha = htmlspecialchars($fecha, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
	$nombre_admin = htmlspecialchars($nombre_admin, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
	$privilegio_user = htmlspecialchars($privilegio_user, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
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
	} catch (PDOException $e) {
		$error_Code = $e->getCode();
		$message = $e->getMessage();
		die("Code: " . $error_Code . "\nMessage: " . $message);
	}
	return $confirmado;
}

function cambiar_estado(string $estado, int $id): void
{
	global $conection;
	$estado = htmlspecialchars($estado, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
	$id = htmlspecialchars($id, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
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

function getTickets(int $id): array
{
	global $conection;
	$id = htmlspecialchars($id, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
	try {
		$consulta = $conection->prepare("SELECT * from tickets_respuestas where ticket_id=?");
		if ($consulta->execute(array($id))) {
			$consulta = $consulta->fetchAll(PDO::FETCH_ASSOC);
		}
	} catch (PDOException $e) {
		$error_Code = $e->getCode();
		$message = $e->getMessage();
		die("Code: " . $error_Code . "\nMessage: " . $message);
	}
	return $consulta;
}

function getTickets_user(int $id): array
{
	global $conection; //We need to use the global variable $conection
	$id = htmlspecialchars($id, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8'); //We sanitize the variable $id

	try {
		//We create the query, we will receive the user id
		$consulta = $conection->prepare("SELECT * from tickets where user_id=?");
		//We execute the query and we send the user id
		if ($consulta->execute(array($id))) {
			//If the query is executed correctly, we will fetch the result and we will return it as an array
			$consulta = $consulta->fetchAll(PDO::FETCH_ASSOC);
		}
	} catch (PDOException $e) {
		//If we catch an error, we will show the error code and the error message
		$error_Code = $e->getCode();
		$message = $e->getMessage();
		die("Code: " . $error_Code . "\nMessage: " . $message);
	}
	return $consulta;
}

function getInfoAboutUser(int $IDuser): array
{
	global $conection;
	$IDuser = htmlspecialchars($IDuser, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
	try {
		$consulta = $conection->prepare("SELECT * from aboutuser where IDuser=:IDuser");
		if ($consulta->execute(array(':IDuser' => $IDuser))) {
			$consulta = $consulta->fetch(PDO::FETCH_ASSOC);
		}
	} catch (PDOException $e) {
		$error_Code = $e->getCode();
		$message = $e->getMessage();
		die("Code: " . $error_Code . "\nMessage: " . $message);
	}
	return $consulta;
}

//Esta función hace una búsqueda de usuario en la base de datos
function search_user($search): PDOStatement
{
	global $conection;
	$search = htmlspecialchars($search, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
	try {
		$consulta = $conection->prepare("SELECT userName,email,userPicture from users WHERE userName LIKE ? OR email LIKE ? AND accountStatus = 'active' AND tipo_perfil = 'publico'");
		$consulta->execute(array("%$search%", "%$search%"));
	} catch (PDOException $e) {
		//Obtener el código de error
		$error_Code = $e->getCode();
		//Obtener el mensaje de error
		$message = $e->getMessage();
		//Mostrar el error
		die("Code: " . $error_Code . "\nMessage: " . $message);
	}
	return $consulta;
}

function search_comics($search): PDOStatement
{
	global $conection;
	$search = htmlspecialchars($search, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
	try {
		$consulta = $conection->prepare("SELECT * from comics WHERE nomComic LIKE ? OR nomVariante LIKE ? OR nomEditorial LIKE ? OR Formato LIKE ? OR Procedencia LIKE ? OR date_published LIKE ? OR nomGuionista LIKE ? OR nomDibujante LIKE ?");
		$consulta->execute(array("%$search%", "%$search%", "%$search%", "%$search%", "%$search%", "%$search%", "%$search%", "%$search%"));
	} catch (PDOException $e) {
		//Obtener el código de error
		$error_Code = $e->getCode();
		//Obtener el mensaje de error
		$message = $e->getMessage();
		//Mostrar el error
		die("Code: " . $error_Code . "\nMessage: " . $message);
	}
	return $consulta;
}

function existe_comic(string $search): bool
{
	global $conection;
	$search = htmlspecialchars($search, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
	try {
		$consulta = $conection->prepare("SELECT * from comics WHERE nomComic LIKE ? OR nomVariante LIKE ? OR nomEditorial LIKE ? OR Formato LIKE ? OR Procedencia LIKE ? OR date_published LIKE ? OR nomGuionista LIKE ? OR nomDibujante LIKE ?");
	} catch (PDOException $e) {
		//Obtener el código de error
		$error_Code = $e->getCode();
		//Obtener el mensaje de error
		$message = $e->getMessage();
		//Mostrar el error
		die("Code: " . $error_Code . "\nMessage: " . $message);
	}
	return $consulta->execute(array("%$search%", "%$search%", "%$search%", "%$search%", "%$search%", "%$search%", "%$search%", "%$search%"));
}

function existe_user(string $search): bool
{
	global $conection;
	try {
		$consulta = $conection->prepare("SELECT * from users WHERE userName LIKE ? OR email LIKE ?");
	} catch (PDOException $e) {
		//Obtener el código de error
		$error_Code = $e->getCode();
		//Obtener el mensaje de error
		$message = $e->getMessage();
		//Mostrar el error
		die("Code: " . $error_Code . "\nMessage: " . $message);
	}
	return $consulta->execute(array("%$search%", "%$search%"));
}

function showUsers(): PDOStatement
{
	global $conection;
	try {
		$sql = "SELECT IDuser,privilege,accountStatus,email,userName,userPicture FROM users";
	} catch (PDOException $e) {
		//Obtener el código de error
		$error_Code = $e->getCode();
		//Obtener el mensaje de error
		$message = $e->getMessage();
		//Mostrar el error
		die("Code: " . $error_Code . "\nMessage: " . $message);
	}
	return $conection->query($sql);
}

function countUserSearch(string $search): int
{
	global $conection;
	try {
		$consulta = $conection->prepare("SELECT COUNT(*) from users WHERE userName LIKE ? OR email LIKE ?");
		$consulta->execute(array("%$search%", "%$search%"));
		return $consulta->fetchColumn();
	} catch (PDOException $e) {
		//Obtener el código de error
		$error_Code = $e->getCode();
		//Obtener el mensaje de error
		$message = $e->getMessage();
		//Mostrar el error
		die("Code: " . $error_Code . "\nMessage: " . $message);
	}
}

function countComicSearch($search): int
{
	global $conection;
	try {
		$consulta = $conection->prepare("SELECT COUNT(*) from comics WHERE nomComic LIKE ? OR nomVariante LIKE ? OR nomEditorial LIKE ? OR Formato LIKE ? OR Procedencia LIKE ? OR date_published LIKE ? OR nomGuionista LIKE ? OR nomDibujante LIKE ?");
		$consulta->execute(array("%$search%", "%$search%", "%$search%", "%$search%", "%$search%", "%$search%", "%$search%", "%$search%"));
		return $consulta->fetchColumn();
	} catch (PDOException $e) {
		//Obtener el código de error
		$error_Code = $e->getCode();
		//Obtener el mensaje de error
		$message = $e->getMessage();
		//Mostrar el error
		die("Code: " . $error_Code . "\nMessage: " . $message);
	}
}

function randomComic(): int
{
	global $conection;
	try {
		$stmt = $conection->query("SELECT IDcomic FROM comics ORDER BY RAND() LIMIT 1");
		$row = $stmt->fetch(PDO::FETCH_ASSOC);
	} catch (PDOException $e) {
		echo "Error: " . $e->getMessage();
	}
	return (int) $row['IDcomic'];
}

function return_comic_published($limit, $offset): PDOStatement
{
	global $conection;
	try {
		$query = "SELECT IDcomic, numComic, nomComic, nomVariante, date_published, Cover
		FROM comics
		WHERE date_published IS NOT NULL
		ORDER BY date_published DESC
		LIMIT :limit
		OFFSET :offset";

		$stmt = $conection->prepare($query);

		$stmt->bindParam(':limit', $limit, PDO::PARAM_INT);
		$stmt->bindParam(':offset', $offset, PDO::PARAM_INT);

		$stmt->execute();
	} catch (PDOException $e) {
		echo "Error: " . $e->getMessage();
	}
	return $stmt;
}

function return_comic_search($limit, $offset, $busqueda): PDOStatement
{
	global $conection;
	try {
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
	} catch (PDOException $e) {
		echo "Error: " . $e->getMessage();
	}
	return $stmt;
}

function getDataComic(int $id): ?array
{
	global $conection;
	try {
		$consulta = $conection->prepare("SELECT * from comics where IDcomic=?");
		if ($consulta->execute(array($id))) {
			$consulta = $consulta->fetch(PDO::FETCH_ASSOC);
		}
	} catch (PDOException $e) {
		echo "Error: " . $e->getMessage();
	}
	return $consulta;
}

function get_comics(): array
{
	global $conection;
	try {
		$consulta = $conection->prepare("SELECT * from comics");
		if ($consulta->execute()) {
			$consulta = $consulta->fetchAll(PDO::FETCH_ASSOC);
		}
	} catch (PDOException $e) {
		echo "Error: " . $e->getMessage();
	}
	return $consulta;
}

// function getDatacomicName($search)
// {
// 	global $conection;
// 	try {
// 		$consulta = $conection->prepare("SELECT * from comics where nomComic LIKE ?");
// 		if($consulta->execute(array($search))){
// 			$consulta = $consulta->fetch(PDO::FETCH_ASSOC);
// 		}
// 	} catch (PDOException $e) {
// 		echo "Error: " . $e->getMessage();
// 	}
// 	return $consulta;
// }

function numComics(): int
{
	global $conection;
	try {
		$consulta = $conection->prepare("SELECT COUNT(*) from comics");
		if ($consulta->execute()) {
			$consulta = $consulta->fetchColumn();
		}
	} catch (PDOException $e) {
		echo "Error: " . $e->getMessage();
	}
	return $consulta;
}

function numComics_usuario(int $id_usuario): int
{
	global $conection;
	try {
		$consulta = $conection->prepare("SELECT COUNT(*) from comics_guardados where user_id=?");
		if ($consulta->execute(array($id_usuario))) {
			$consulta = $consulta->fetchColumn();
		}
	} catch (PDOException $e) {
		echo "Error: " . $e->getMessage();
	} catch (PDOException $e) {
		echo "Error: " . $e->getMessage();
	}
	return $consulta;
}

function agregar_opinion(int $id_user, int $id_comic, string $opinion, int $puntuacion): bool
{
	global $conection;
	$agregado = false;
	$id_user = htmlspecialchars($id_user, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
	$id_comic = htmlspecialchars($id_comic, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
	$opinion = htmlspecialchars($opinion, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
	$puntuacion = htmlspecialchars($puntuacion, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');

	try {
		$consulta = $conection->prepare("INSERT INTO opiniones_comics(id_comic,id_usuario,opinion,puntuacion) VALUES (?,?,?,?)");
		if ($consulta->execute(array($id_comic, $id_user, $opinion, $puntuacion))) {
			$agregado = true;
		}
	} catch (PDOException $e) {
		echo "Error: " . $e->getMessage();
	}
	return $agregado;
}

function agregar_opinion_pagina(int $id_user, string $opinion): bool
{
	global $conection;
	$agregado = false;
	$id_user = htmlspecialchars($id_user, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
	$opinion = htmlspecialchars($opinion, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
	try {
		$consulta = $conection->prepare("INSERT INTO opiniones_pagina(id_user,comentario,fecha_comentario) VALUES (?,?,?)");
		if ($consulta->execute(array($id_user, $opinion, date("Y-m-d")))) {
			$agregado = true;
		}
	} catch (PDOException $e) {
		echo "Error: " . $e->getMessage();
	}
	return $agregado;
}

function num_opiniones(int $id_comic): int
{
	global $conection;
	$id_comic = htmlspecialchars($id_comic, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');

	try {
		$consulta = $conection->prepare("SELECT COUNT(*) from opiniones_comics where id_comic=?");
		$consulta->execute(array($id_comic));
	} catch (PDOException $e) {
		echo "Error: " . $e->getMessage();
	}
	$consulta = $consulta->fetchColumn();
	return $consulta;
}

// function opiniones_usuario(string $id_usuario): array
// {
// 	global $conection;
// 	try {
// 		$consulta = $conection->prepare("SELECT COUNT(*) from opiniones_comics where id_usuario=?");
// 		$consulta->execute(array($id_usuario));
// 	} catch (PDOException $e) {
// 		echo "Error: " . $e->getMessage();
// 	}
// 	return $consulta->fetchAll(PDO::FETCH_ASSOC);
// }

function mostrar_opiniones(int $id_comic): PDOStatement
{
	global $conection;
	$id_comic = htmlspecialchars($id_comic, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
	try {
		$consulta = $conection->prepare("SELECT * from opiniones_comics where id_comic=?");
	} catch (PDOException $e) {
		echo "Error: " . $e->getMessage();
	}
	$consulta->execute(array($id_comic));
	return $consulta;
}

function mostrar_opiniones_pagina(): PDOStatement
{
	global $conection;
	try {
		$consulta = $conection->prepare("SELECT * from opiniones_pagina");
	} catch (PDOException $e) {
		echo "Error: " . $e->getMessage();
	}
	$consulta->execute();
	return $consulta;
}

/**
 * It returns the number of rows in the table opiniones_pagina.
 * 
 * @return int The number of rows in the table.
 */
function numero_opiniones_pagina(): int
{
	global $conection;
	try {
		$consulta = $conection->prepare("SELECT count(*) from opiniones_pagina");
		$consulta->execute();
	} catch (PDOException $e) {
		echo "Error: " . $e->getMessage();
	}
	$resultado = $consulta->fetch();
	return $resultado[0];
}

function valoracion_media(int $id_comic): float
{
	global $conection;
	try {
		$consulta = $conection->prepare("SELECT AVG(puntuacion) from opiniones_comics where id_comic=?");
		$consulta->execute(array($id_comic));
	} catch (PDOException $e) {
		echo "Error: " . $e->getMessage();
	}
	$consulta = $consulta->fetchColumn();
	return (float) $consulta;
}

function nueva_lista(string $id_user, string $nombre_lista): bool
{
	global $conection;
	$agregado = false;
	$id_user = htmlspecialchars($id_user, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
	$nombre_lista = htmlspecialchars($nombre_lista, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
	try {
		$consulta = $conection->prepare("INSERT INTO lista_comics(nombre_lista,id_user) VALUES (?,?)");
		if ($consulta->execute(array($nombre_lista, $id_user))) {
			$agregado = true;
		}
	} catch (PDOException $e) {
		echo "Error: " . $e->getMessage();
	}
	return $agregado;
}

function modificar_lista(int $id_lista, string $nombre_lista): bool
{
	global $conection;
	$modificada = false;
	$id_lista = htmlspecialchars($id_lista, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
	$nombre_lista = htmlspecialchars($nombre_lista, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
	try {
		$consulta = $conection->prepare("UPDATE lista_comics SET nombre_lista=? WHERE id_lista=?");
		if ($consulta->execute(array($nombre_lista, $id_lista))) {
			$modificada = true;
		}
	} catch (PDOException $e) {
		echo "Error: " . $e->getMessage();
	}

	return $modificada;
}

function check_guardado(int $id_user, int $id_comic): bool
{
	global $conection;
	$guardado = false;
	$id_user = htmlspecialchars($id_user, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
	$id_comic = htmlspecialchars($id_comic, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
	try {
		$consulta = $conection->prepare("SELECT COUNT(*) from comics_guardados where user_id=? AND comic_id=?");
		if ($consulta->execute(array($id_user, $id_comic))) {
			if ($consulta->fetchColumn() > 0) {
				$guardado = true;
			}
		}
	} catch (PDOException $e) {
		echo "Error: " . $e->getMessage();
	}
	return $guardado;
}

function check_guardado_lista(int $id_lista, int $id_comic): bool
{
	global $conection;
	$guardado = false;
	$id_lista = htmlspecialchars($id_lista, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
	$id_comic = htmlspecialchars($id_comic, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
	try {
		$consulta = $conection->prepare("SELECT COUNT(*) from contenido_listas where id_lista=? AND id_comic=?");
		$consulta->execute(array($id_lista, $id_comic));
		if ($consulta->fetchColumn() > 0) {
			$guardado = true;
		}
	} catch (PDOException $e) {
		echo "Error: " . $e->getMessage();
	}
	return $guardado;
}

function numero_comics_lista($id_lista){
	global $conection;
	$id_lista = htmlspecialchars($id_lista, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
	try {
		$consulta = $conection->prepare("SELECT COUNT(*) from contenido_listas where id_lista=?");
		$consulta->execute(array($id_lista));
	} catch (PDOException $e) {
		echo "Error: " . $e->getMessage();
	}
	$resultado = $consulta->fetch();
	return $resultado[0];
}

function guardar_comic(int $id_user, int $id_comic): bool
{
	global $conection;
	$agregado = false;
	$id_user = htmlspecialchars($id_user, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
	$id_comic = htmlspecialchars($id_comic, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
	try {
		// Check if user exists
		$user_query = $conection->prepare("SELECT * FROM users WHERE IDuser = ?");
		$user_query->execute([$id_user]);
		$user = $user_query->fetch();

		if ($user) {
			$consulta = $conection->prepare("INSERT INTO comics_guardados(user_id,comic_id) VALUES (?,?)");
			$consulta->execute(array($id_user, $id_comic));
			$agregado = true;
		} else {
			// User does not exist
			$agregado = false;
		}
	} catch (PDOException $e) {
		echo "Error: " . $e->getMessage();
	}
	return $agregado;
}


function quitar_comic(int $id_user, int $id_comic): bool
{
	global $conection;
	$agregado = false;
	$id_user = htmlspecialchars($id_user, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
	$id_comic = htmlspecialchars($id_comic, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
	try {
		// Check if user exists
		$user_query = $conection->prepare("SELECT * FROM users WHERE IDuser = ?");
		$user_query->execute([$id_user]);
		$user = $user_query->fetch();

		if ($user) {
			$consulta = $conection->prepare("DELETE FROM comics_guardados WHERE user_id=? AND comic_id=?");
			$consulta->execute(array($id_user, $id_comic));
			$agregado = true;
		}
	} catch (PDOException $e) {
		echo "Error: " . $e->getMessage();
	}
	return $agregado;
}

function guardar_comic_lista(int $id_comic, int $id_lista): bool
{
	global $conection;
	$agregado = false;
	$id_comic = htmlspecialchars($id_comic, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
	$id_lista = htmlspecialchars($id_lista, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
	try {
		$consulta = $conection->prepare("INSERT INTO contenido_listas(id_comic,id_lista) VALUES (?,?)");
		$consulta->execute(array($id_comic, $id_lista));
		$agregado = true;
	} catch (PDOException $e) {
		echo "Error: " . $e->getMessage();
	}
	return $agregado;
}

function quitar_comic_lista(int $id_comic, int $id_lista): bool
{
	global $conection;
	$agregado = false;
	$id_comic = htmlspecialchars($id_comic, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
	$id_lista = htmlspecialchars($id_lista, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
	try {
		$consulta = $conection->prepare("DELETE FROM contenido_listas WHERE id_comic=? AND id_lista=?");
		($consulta->execute(array($id_comic, $id_lista)));
		$agregado = true;
	} catch (PDOException $e) {
		echo "Error: " . $e->getMessage();
	}
	return $agregado;
}

function get_comics_guardados(int $limit, int $offset, int $id_user): PDOStatement
{
	global $conection;
	try {
		$consulta = $conection->prepare("SELECT * from comics_guardados JOIN comics ON comics_guardados.comic_id=comics.IDcomic where user_id=:id_user ORDER BY comic_id  DESC LIMIT :limit OFFSET :offset");
		$consulta->bindParam(':id_user', $id_user, PDO::PARAM_INT);
		$consulta->bindParam(':limit', $limit, PDO::PARAM_INT);
		$consulta->bindParam(':offset', $offset, PDO::PARAM_INT);
	} catch (PDOException $e) {
		echo "Error: " . $e->getMessage();
	}
	$consulta->execute();
	return $consulta;
}

function get_comics_lista(int $limit, int $offset, int $id_lista): PDOStatement
{
	global $conection;
	try {
		$consulta = $conection->prepare("SELECT * FROM contenido_listas JOIN comics ON contenido_listas.id_comic=comics.IDcomic WHERE contenido_listas.id_lista=:id_lista ORDER BY comics.IDcomic DESC LIMIT :limit OFFSET :offset");
		$consulta->bindParam(':id_lista', $id_lista, PDO::PARAM_INT);
		$consulta->bindParam(':limit', $limit, PDO::PARAM_INT);
		$consulta->bindParam(':offset', $offset, PDO::PARAM_INT);
	} catch (PDOException $e) {
		echo "Error: " . $e->getMessage();
	}
	$consulta->execute();
	return $consulta;
}

// function get_id_contenido(int $id_lista, int $id_comic): string
// {
// 	global $conection;
// 	try {
// 		$consulta = $conection->prepare("SELECT id_contenido from contenido_listas where id_lista=? and id_comic=?");
// 		$consulta->execute(array($id_lista, $id_comic));
// 	} catch (PDOException $e) {
// 		echo "Error: " . $e->getMessage();
// 	}
// 	$resultado = $consulta->fetch(PDO::FETCH_ASSOC);
// 	return "[" . $resultado['id_contenido'] . "]";
// }

function get_total_contenido(int $id_lista): int
{
	global $conection;
	try {
		$consulta = $conection->prepare("SELECT COUNT(*) from contenido_listas where id_lista=?");
		$consulta->execute(array($id_lista));
	} catch (PDOException $e) {
		echo "Error: " . $e->getMessage();
	}
	return $consulta->fetchColumn();
}

function get_total_guardados(int $id_user): int
{
	global $conection;
	try {
		$consulta = $conection->prepare("SELECT COUNT(*) from comics_guardados where user_id=?");
		$consulta->execute([$id_user]);
	} catch (PDOException $e) {
		echo "Error: " . $e->getMessage();
	}
	return $consulta->fetchColumn();
}

function get_total_comics(): int
{
	global $conection;
	try {
		$consulta = $conection->prepare("SELECT COUNT(*) from comics_guardados ORDER BY RAND() LIMIT 8");
		$consulta->execute();
	} catch (PDOException $e) {
		echo "Error: " . $e->getMessage();
	}
	return $consulta->fetchColumn();
}

function get_descripcion(int $id): array
{
	global $conection;
	try {
		$consulta = $conection->prepare("SELECT * from descripcion_comics where id_comic=?");
		$consulta->execute(array($id));
	} catch (PDOException $e) {
		echo "Error: " . $e->getMessage();
	}
	return $consulta->fetch(PDO::FETCH_ASSOC);
}

function get_listas($id): array
{
	global $conection;
	try {
		$consulta = $conection->prepare("SELECT * from lista_comics where id_user=?");
		$consulta->execute(array($id));
	} catch (PDOException $e) {
		echo "Error: " . $e->getMessage();
	}
	return $consulta->fetchAll(PDO::FETCH_ASSOC);
}

function get_nombre_lista(int $id_lista): array
{
	global $conection;
	try {
		$consulta = $conection->prepare("SELECT * from lista_comics where id_lista=?");
		$consulta->execute(array($id_lista));
	} catch (PDOException $e) {
		echo "Error: " . $e->getMessage();
	}
	return $consulta->fetch(PDO::FETCH_ASSOC);
}

function num_listas_user($id): int
{
	global $conection;
	try {
		$consulta = $conection->prepare("SELECT COUNT(*) from lista_comics where id_user=?");
		$consulta->execute(array($id));
	} catch (PDOException $e) {
		echo "Error: " . $e->getMessage();
	}
	return $consulta->fetchColumn();
}

function check_lista_user(int $id_user, int $id_lista): int
{
	global $conection;
	try {
		$consulta = $conection->prepare("SELECT COUNT(*) from lista_comics where id_user=? and id_lista=?");
		if (!$consulta->execute(array($id_user, $id_lista))) {
			return 0;
		}
	} catch (PDOException $e) {
		echo "Error: " . $e->getMessage();
	}
	return $consulta->fetchColumn();
}

/**
 * Elimina una lista de comics y su contenido asociado
 *
 * @param int $id_lista El ID de la lista a eliminar
 * @return bool True si la lista fue eliminada con éxito, False en caso contrario
 */
function eliminar_lista(int $id_lista, int $id_user): bool
{
	global $conection;
	$eliminado = false;
	$id_lista = htmlspecialchars($id_lista, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
	$id_user = htmlspecialchars($id_user, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
	try {
		if (eliminar_contenido_listas($id_lista)) {
			$consulta = $conection->prepare("DELETE FROM lista_comics WHERE id_lista=? AND id_user=?");
			if ($consulta->execute(array($id_lista, $id_user))) {
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
function eliminar_contenido_listas($id_lista): bool
{
	global $conection;
	$eliminado = false;
	$id_lista = htmlspecialchars($id_lista, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
	try {
		$consulta_eliminar = $conection->prepare("DELETE FROM contenido_listas WHERE id_lista=?");
		if ($consulta_eliminar->execute(array($id_lista))) {
			$eliminado = true;
		}
	} catch (PDOException $e) {
		echo "Error: " . $e->getMessage();
	}
	return $eliminado;
}

function lista_usuario($id_usuario): array
{
	try {
		global $conection;
		$consulta = $conection->prepare("SELECT * from lista_comics where id_user=?");
		$consulta->execute(array($id_usuario));
		return $consulta->fetchAll(PDO::FETCH_ASSOC);
	} catch (PDOException $e) {
		return [];
	}
}

function reactivar_cuenta(string $email): void
{
	global $conection;
	$email = htmlspecialchars($email, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
	try {
		$consulta = $conection->prepare("UPDATE users SET accountStatus = 'active' WHERE email = ?");
		$consulta->execute(array($email));
	} catch (PDOException $e) {
		throw new Exception('Error en la base de datos: ' . $e->getMessage());
	}
}

function estado_solicitud(int $id_destinatario, int $id_solicitante): string
{
	global $conection;
	try {
		$consulta = $conection->prepare("SELECT estado_solicitud from solicitudes_amistad where id_usuario_destinatario=? AND id_usuario_solicitante = ?");
		$consulta->execute(array($id_destinatario, $id_solicitante));
		$consulta = $consulta->fetchColumn();
	} catch (PDOException $e) {
		throw new Exception('Error en la base de datos: ' . $e->getMessage());
	}
	return $consulta;
}

function num_amistades(int $id_usuario): int
{
	global $conection;
	try {
		$consulta = $conection->prepare("SELECT COUNT(*) from amistades_usuario where id_usuario=?");
		$consulta->execute([$id_usuario]);
		return $consulta->fetchColumn();
	} catch (PDOException $e) {
		throw new Exception('Error en la base de datos: ' . $e->getMessage());
	}
}

function solicitudes_amistad(int $id_user): array
{
	global $conection;
	try {
		$consulta = $conection->prepare("SELECT * from solicitudes_amistad where id_usuario_destinatario=? AND estado_solicitud='en espera'");
		$consulta->execute(array($id_user));
		return $consulta->fetchAll(PDO::FETCH_ASSOC);
	} catch (PDOException $e) {
		throw new Exception('Error en la base de datos: ' . $e->getMessage());
	}
}

function num_solicitudes_amistad(int $id_user): int
{
	global $conection;
	try {
		$consulta = $conection->prepare("SELECT COUNT(*) from solicitudes_amistad where id_usuario_destinatario=? AND estado_solicitud='en espera'");
		$consulta->execute(array($id_user));
		return $consulta->fetchColumn();
	} catch (PDOException $e) {
		throw new Exception('Error en la base de datos: ' . $e->getMessage());
	}
}

function solicitudes_amistad_enviadas(int $id_user): array
{
	global $conection;
	try {
		$consulta = $conection->prepare("SELECT * from solicitudes_amistad where id_usuario_solicitante= ? AND estado_solicitud='en espera'");
		$consulta->execute(array($id_user));
		return $consulta->fetchAll(PDO::FETCH_ASSOC);
	} catch (PDOException $e) {
		throw new Exception('Error en la base de datos: ' . $e->getMessage());
	}
}

function num_solicitudes_amistad_enviadas(int $id_user): int
{
	global $conection;
	try {
		$consulta = $conection->prepare("SELECT COUNT(*) from solicitudes_amistad where id_usuario_solicitante = ? AND estado_solicitud='en espera'");
		$consulta->execute(array($id_user));
		return $consulta->fetchColumn();
	} catch (PDOException $e) {
		throw new Exception('Error en la base de datos: ' . $e->getMessage());
	}
}

function aceptar_solicitud(int $id_remitente, int $id_mi_usuario): bool
{
	global $conection;
	$aceptado = false;
	$id_remitente = htmlspecialchars($id_remitente, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
	$id_mi_usuario = htmlspecialchars($id_mi_usuario, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');

	try {
		$consulta1 = $conection->prepare("UPDATE solicitudes_amistad SET estado_solicitud = 'aceptada' WHERE id_usuario_solicitante = ? AND id_usuario_destinatario = ?");
		$consulta1->execute(array($id_remitente, $id_mi_usuario));
		$consulta2 = $conection->prepare("INSERT INTO amistades_usuario (id_usuario,id_amigo) VALUES (?,?)");
		$consulta2->execute(array($id_remitente, $id_mi_usuario));
		$consulta3 = $conection->prepare("INSERT INTO amistades_usuario (id_usuario,id_amigo) VALUES (?,?)");
		$consulta3->execute(array($id_mi_usuario, $id_remitente));
		$aceptado = true;
	} catch (PDOException $e) {
		echo "Error: " . $e->getMessage();
	}
	return $aceptado;
}

function rechazar_solicitud(int $id_remitente, int $id_mi_usuario): bool
{
	global $conection;
	$rechazado = false;
	$id_remitente = htmlspecialchars($id_remitente, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
	$id_mi_usuario = htmlspecialchars($id_mi_usuario, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
	try {
		$consulta = $conection->prepare("UPDATE solicitudes_amistad SET estado_solicitud = 'rechazada' WHERE id_usuario_solicitante = ? AND id_usuario_destinatario = ?");
		$consulta->execute([$id_remitente, $id_mi_usuario]);
		$rechazado = true;
	} catch (PDOException $e) {
		echo "Error: " . $e->getMessage();
	}

	return $rechazado;
}

function cancelar_solicitud(int $id_remitente, int $id_mi_usuario): bool
{
	global $conection;
	$cancelado = false;
	$id_remitente = htmlspecialchars($id_remitente, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
	$id_mi_usuario = htmlspecialchars($id_mi_usuario, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
	try {
		$consulta = $conection->prepare("DELETE FROM solicitudes_amistad WHERE id_usuario_solicitante = ? AND id_usuario_destinatario = ?");
		$consulta->execute(array($id_mi_usuario, $id_remitente));
		$cancelado = true;
	} catch (PDOException $e) {
		echo "Error: " . $e->getMessage();
	}

	return $cancelado;
}

function comprobar_solicitud(int $id_solicitante, int $id_mi_usuario): bool
{
	global $conection;
	$solicitud = false;
	/* Trying to connect to the database. */
	try {
		$consulta = $conection->prepare("SELECT * from solicitudes_amistad where id_usuario_solicitante=? AND id_usuario_destinatario=? AND estado_solicitud='en espera'");
		$consulta->execute(array($id_solicitante, $id_mi_usuario));
		if ($consulta->fetchAll(PDO::FETCH_ASSOC)) {
			$solicitud = true;
		}
	} catch (PDOException $e) {
		echo "Error: " . $e->getMessage();
	}
	return $solicitud;
}

function comprobar_amistad(int $id_amigo, int $id_mi_usuario): bool
{
	global $conection;
	$amistad = false;
	try {
		$consulta = $conection->prepare("SELECT * from amistades_usuario where id_usuario=? AND id_amigo=?");
		$consulta->execute(array($id_mi_usuario, $id_amigo));
		if ($consulta->fetchAll(PDO::FETCH_ASSOC)) {
			$amistad = true;
		}
	} catch (PDOException $e) {
		echo "Error: " . $e->getMessage();
	}
	return $amistad;
}

function enviar_solicitud(int $id_destinatario, int $id_solicitante): bool
{
	global $conection;
	$enviado = false;
	$id_destinatario = htmlspecialchars($id_destinatario, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
	$id_solicitante = htmlspecialchars($id_solicitante, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
	try {
		$consulta = $conection->prepare("INSERT INTO solicitudes_amistad (id_usuario_destinatario,id_usuario_solicitante) VALUES (?,?)");
		if ($consulta->execute(array($id_destinatario, $id_solicitante))) {
			$enviado = true;
		}
	} catch (PDOException $e) {
		echo "Error: " . $e->getMessage();
	}
	return $enviado;
}

function eliminar_amigo(int $id_amigo, int $id_mi_usuario): bool
{
	global $conection;
	$eliminado = false;
	$id_amigo = htmlspecialchars($id_amigo, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
	$id_mi_usuario = htmlspecialchars($id_mi_usuario, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
	try {
		$consulta1 = $conection->prepare("DELETE FROM amistades_usuario WHERE id_usuario = ? AND id_amigo = ?");
		$consulta1->execute([$id_mi_usuario, $id_amigo]);
		if ($consulta1->rowCount() !== 0) {
			$consulta2 = $conection->prepare("DELETE FROM amistades_usuario WHERE id_usuario = ? AND id_amigo = ?");
			$consulta2->execute([$id_amigo, $id_mi_usuario]);
			$consulta3 = $conection->prepare("DELETE FROM solicitudes_amistad WHERE id_usuario_solicitante = ? AND id_usuario_destinatario = ?");
			$consulta3->execute([$id_amigo, $id_mi_usuario]);
			$eliminado = true;
		}
	} catch (PDOException $e) {
		echo "Error: " . $e->getMessage();
	}
	return $eliminado;
}

function amigos(int $id_user): array
{
	global $conection;
	try {
		$consulta = $conection->prepare("SELECT * from amistades_usuario where id_usuario=:id_usuario");
		$consulta->execute(['id_usuario' => $id_user]);
		$resultado = $consulta->fetchAll(PDO::FETCH_ASSOC);
	} catch (PDOException $e) {
		echo "Error: " . $e->getMessage();
		return [];
	}
	return $resultado;
}

function num_amigos(int $id_user): int
{
	global $conection;
	$resultado = 0;
	try {
		$sql = "SELECT COUNT(*) from amistades_usuario where id_usuario=?";
		$consulta = $conection->prepare($sql);
		if ($consulta->execute(array($id_user))) {
			$resultado = $consulta->fetchColumn();
		}
	} catch (PDOException $e) {
		echo "Error: " . $e->getMessage();
	}
	return $resultado;
}

function bloquear_usuario(int $id_destinatario, int $id_solicitante): bool
{
	global $conection;
	$bloqueado = false;
	$id_destinatario = htmlspecialchars($id_destinatario, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
	$id_solicitante = htmlspecialchars($id_solicitante, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
	try {
		$consulta1 = $conection->prepare("INSERT INTO usuarios_bloqueados (id_usuario_bloqueado,id_solicitante) VALUES (?,?)");
		$consulta1->execute(array($id_destinatario, $id_solicitante));

		$consulta1 = $conection->prepare("SELECT COUNT(*) from amistades_usuario where id_amigo=?");
		$consulta1->execute(array($id_destinatario));
		$consulta1 = $consulta1->fetchColumn();
		if ($consulta1 > 0) {
			$consulta2 = $conection->prepare("DELETE FROM amistades_usuario WHERE id_usuario = ? AND id_amigo = ?");
			$consulta2->execute(array($id_destinatario, $id_solicitante));
			$consulta3 = $conection->prepare("DELETE FROM amistades_usuario WHERE id_usuario = ? AND id_amigo = ?");
			$consulta3->execute(array($id_solicitante, $id_destinatario));
		}

		$consulta4 = $conection->prepare("DELETE FROM solicitudes_amistad WHERE id_usuario_solicitante = ? AND id_usuario_destinatario = ?");
		$consulta4->execute(array($id_solicitante, $id_destinatario));
		$bloqueado = true;
	} catch (PDOException $e) {
		echo "Error: " . $e->getMessage();
	}
	return $bloqueado;
}

function check_usuario_bloqueado(int $id_destinatario, int $id_solicitante): bool
{
	global $conection;
	$existe = false;
	$id_destinatario = htmlspecialchars($id_destinatario, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
	$id_solicitante = htmlspecialchars($id_solicitante, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
	try {
		$consulta = $conection->prepare("SELECT COUNT(*) FROM usuarios_bloqueados WHERE id_usuario_bloqueado = ? AND id_solicitante = ?");
		$consulta->execute(array($id_destinatario, $id_solicitante));
		if ((int) $consulta->fetchColumn() > 0) {
			$existe = true;
		}
	} catch (PDOException $e) {
		echo "Error: " . $e->getMessage();
	}
	return $existe;
}

function desbloquear_usuario(int $id_destinatario, int $id_solicitante): bool
{
	global $conection;
	$desbloquear = false;
	$id_destinatario = htmlspecialchars($id_destinatario, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
	$id_solicitante = htmlspecialchars($id_solicitante, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
	try {
		if (check_usuario_bloqueado($id_destinatario, $id_solicitante)) {
			$consulta2 = $conection->prepare("DELETE FROM usuarios_bloqueados WHERE id_usuario_bloqueado = ? AND id_solicitante = ?");
			if ($consulta2->execute(array($id_destinatario, $id_solicitante))) {
				$desbloquear = true;
			}
		}
	} catch (PDOException $e) {
		echo "Error: " . $e->getMessage();
	}
	return $desbloquear;
}

function comprobar_bloqueo(int $id_destinatario, int $id_solicitante): bool
{
	global $conection;
	$bloqueado = false;
	$id_destinatario = htmlspecialchars($id_destinatario, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
	$id_solicitante = htmlspecialchars($id_solicitante, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
	try {
		$consulta = $conection->prepare("SELECT * from usuarios_bloqueados where id_usuario_bloqueado=? AND id_solicitante=?");
		if ($consulta->execute(array($id_destinatario, $id_solicitante))) {
			if ($consulta->rowCount() > 0) {
				$bloqueado = true;
			}
		}
	} catch (PDOException $e) {
		echo "Error: " . $e->getMessage();
	}
	return $bloqueado;
}

function num_usuarios_bloqueados(int $id_mi_usuario): int
{
	global $conection;
	$usuarios_bloqueados = 0;
	$id_mi_usuario = htmlspecialchars($id_mi_usuario, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');

	try {
		$consulta = $conection->prepare("SELECT COUNT(*) from usuarios_bloqueados where id_solicitante=?");
		if ($consulta->execute(array($id_mi_usuario))) {
			$usuarios_bloqueados = $consulta->fetchColumn();
		}
	} catch (PDOException $e) {
		echo "Error: " . $e->getMessage();
	}
	return $usuarios_bloqueados;
}
function usuarios_bloqueados(int $id_mi_usuario): array
{
	global $conection;
	$datos_usuario_bloqueado = [];
	$id_mi_usuario = htmlspecialchars($id_mi_usuario, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
	try {
		$consulta = $conection->prepare("SELECT * from usuarios_bloqueados where id_solicitante=?");
		$consulta->execute(array($id_mi_usuario));
		$datos_usuario_bloqueado = $consulta->fetchAll(PDO::FETCH_ASSOC);
	} catch (PDOException $e) {
		echo "Error: " . $e->getMessage();
	}
	return $datos_usuario_bloqueado;
}

function tipo_privacidad(int $id_user): string
{
	global $conection;
	$id_user = htmlspecialchars($id_user, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');

	try {
		$consulta = $conection->prepare("SELECT tipo_perfil from users where IDuser=?");
		if ($consulta->execute(array($id_user))) {
			$tipo_privacidad = $consulta->fetchColumn();
		}
	} catch (PDOException $e) {
		echo "Error: " . $e->getMessage();
	}
	return $tipo_privacidad;
}

function guardar_ultima_conexion($email_usuario)
{
	global $conection;
	$email_usuario = htmlspecialchars($email_usuario, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');

	try {
		//localiza el ID del usuario
		$consulta = $conection->prepare("SELECT IDuser from users where email=?");
		$consulta->execute(array($email_usuario));
		$id_usuario = $consulta->fetchColumn();
		//guarda la fecha de la ultima conexion
		$consulta2 = $conection->prepare("UPDATE aboutuser SET ultima_conexion=NOW() WHERE IDuser=?");
		$consulta2->execute(array($id_usuario));
	} catch (PDOException $e) {
		echo "Error: " . $e->getMessage();
	}
}

function comprobar_ultima_conexion($id_usuario)
{
	global $conection;
	$id_usuario = htmlspecialchars($id_usuario, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
	try {
		//localiza el ID del usuario
		$consulta = $conection->prepare("SELECT ultima_conexion from aboutuser where IDuser=?");
		$consulta->execute(array($id_usuario));
		$ultima_conexion = $consulta->fetchColumn();
	} catch (PDOException $e) {
		echo "Error: " . $e->getMessage();
	}
	return $ultima_conexion;
}

function comics_lista($userData, $limit, $offset, $conection)
{
	$id_user = $userData['IDuser'];
	$id_lista = $_GET['id_lista'];
	if (isset($_GET['checkboxChecked'])) {
		$search = explode(",", $_GET['checkboxChecked']);
		$search = array_map('trim', $search);
		$search = array_map('urldecode', $search);
		$search_count = count($search);
		if ($search_count == 1) {
			$where_clause = " WHERE comics_guardados.comic_id = comics.IDcomic AND comics_guardados.user_id = $id_user AND (nomVariante LIKE '%" . $search[0] . "%' OR nomGuionista LIKE '%" . $search[0] . "%' OR nomDibujante LIKE '%" . $search[0] . "%' OR nomEditorial = '" . $search[0] . "')";
		} else {
			$where_clauses = [];
			for ($i = 0; $i < $search_count; $i++) {
				$where_clauses[] = "(nomGuionista LIKE '%" . $search[$i] . "%' OR nomDibujante LIKE '%" . $search[$i] . "%' OR nomVariante LIKE '%" . $search[$i] . "%' OR nomEditorial = '" . $search[$i] . "')";
			}
			$where_clause = " WHERE comics_guardados.comic_id = comics.IDcomic AND comics_guardados.user_id = $id_user AND (" . implode(' OR ', $where_clauses) . ")";
		}
		$comics = $conection->prepare("SELECT * FROM comics_guardados,comics" . $where_clause);
		$comics->execute();
	} else {
		$comics = get_comics_guardados($limit, $offset, $id_user);
	}
	return $comics;
}
