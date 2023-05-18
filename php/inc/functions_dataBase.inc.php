<?php

/**
 * Funcion que sera utlizada para comprobar si el usuario existe en la base de datos
 *
 * @param string $acceso
 * @param string $password
 * @return boolean
 */
function checkUser(string $acceso, string $password): bool
{
	global $conection;
	$existe = false;
	try {
		$consulta = $conection->prepare("SELECT IDuser from users WHERE email = ? OR userName = ? and password = ?");
		if ($consulta->execute(array($acceso, $acceso, $password))) {
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
 * Funcion que sera utlizada para comprobar si el mail existe en la base de datos
 *
 * @param string $acceso
 * @return boolean
 */
function check_email_user(string $acceso): bool
{
	global $conection;
	$existe = false;
	try {
		$consulta = $conection->prepare("SELECT * from users WHERE email = ? OR userName = ?");
		if ($consulta->execute(array($acceso,$acceso))) {
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
		$stmt = $conection->prepare("SELECT IDuser,privilege,userName,email,userPicture,accountStatus,tipo_perfil FROM users WHERE email=:acces OR userName=:acces OR IDuser=:acces");
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

/**
 * Obtiene el tipo de privilegio que tiene un usuario
 *
 * @param string $email
 * @return string
 */
function obtener_privilegio(String $email): String
{
	global $conection;

	// Validar y filtrar la entrada
	$email = htmlspecialchars($email, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
	try {
		// Preparar la consulta SQL con sentencias preparadas
		$stmt = $conection->prepare("SELECT privilege FROM users WHERE email= ?");
		$stmt->bindParam(1, $email, PDO::PARAM_STR);
		// Ejecutar la consulta
		$stmt->execute();
		// Obtener los datos de la consulta
		$privilegio = $stmt->fetch(PDO::FETCH_COLUMN);
	} catch (PDOException $e) {
		die("Code: " . $e->getCode() . "\nMessage: " . $e->getMessage());
	}
	// Devolver los datos
	return $privilegio;
}

/**
 * Permite crear un usuario en la base de datos
 *
 * @param string $userName
 * @param string $email
 * @param string $password
 * @param [type] $id_activacion
 * @return boolean
 */
function crear_usuario(string $userName, string $email, string $password, $id_activacion): bool
{
	global $conection;
	$create = false;
	$userName = htmlspecialchars($userName, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
	$email = htmlspecialchars($email, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
	$password = htmlspecialchars($password, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
	$id_activacion = htmlspecialchars($id_activacion, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
	try {
		$insertData = $conection->prepare("INSERT INTO users (userName,password,email,id_activacion) VALUES(?,?,?,?)");
		$insertData->bindParam(1, $userName);
		$insertData->bindParam(2, $password);
		$insertData->bindParam(3, $email);
		$insertData->bindParam(4, $id_activacion);

		if ($insertData->execute()) {
			$create = true;
		}
		return $create;
	} catch (PDOException $e) {
		die("Code: " . $e->getCode() . "\nMessage: " . $e->getMessage());
	}
}

/**
 * Comprueba si una cuenta de usuario se encuentra activa en la base de datos
 *
 * @param string $userName
 * @return boolean
 */
function comprobar_activacion(String $userName): bool
{
	global $conection;
	$activado = false;
	try {
		$consulta = $conection->prepare("SELECT cuenta_activada from users WHERE userName = ?");
		if ($consulta->execute(array($userName))) {
			if ($consulta->fetchColumn() == 1) {
				$activado = true;
			}
		}
	} catch (PDOException $e) {
		die("Code: " . $e->getCode() . "\nMessage: " . $e->getMessage());
	}
	return $activado;
}

/**
 * Actualiza una cuenta de usuario en la base de datos, siendo usuario y no administrador
 *
 * @param string $userName
 * @return boolean
 */
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

/**
 * Elimina un usuario de la base de datos y tambien diferentes datos en las tablas relacionadas con ese usuario
 *
 * @param string $email
 * @param integer $idUser
 * @return boolean
 */
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


/**
 * Actualiza el correo de un usuario
 *
 * @param string $new_email
 * @param string $old_email
 * @return boolean
 */
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

/**
 * Inserta en la columna de userPicture la direccion de la imagen de perfil en la tabla users
 *
 * @param string $email
 * @param integer $idUser
 * @return boolean
 */
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

/**
 * Inserta en la columna de Cover la direccion de la imagen del comic en la tabla comics
 *
 * @param string $email
 * @param integer $idUser
 * @return boolean
 */
function direccion_imagen_comic(int $id_comic, String $tabla): bool
{
	global $conection;
	$modificado = false;
	$id_comic = htmlspecialchars($id_comic, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
	try {
		$file_path = 'assets/covers_img_peticiones/' . $id_comic . ".jpg";
		$insertData = $conection->prepare("UPDATE $tabla SET Cover = ? WHERE IDcomic = ?");
		$insertData->bindParam(1, $file_path);
		$insertData->bindParam(2, $id_comic);
		if ($insertData->execute()) {
			$modificado = true;
		}
	} catch (PDOException $e) {
		$error_Code = $e->getCode();
		$message = $e->getMessage();
		die("Code: " . $error_Code . "\nMessage: " . $message);
	}
	return $modificado;
}

/**
 * Selecciona el estado de una cuenta, para saber si esta activada, desactivada o bloqueada
 *
 * @param string $email
 * @return boolean
 */
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

/**
 * Desactiva o activa una cuenta de usuario
 *
 * @param string $email
 * @param boolean $estado
 * @return boolean
 */
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

/**
 *Desactiva la cuenta de usuario con el correo electrónico proporcionado
 *@param string $email Correo electrónico de la cuenta a desactivar
 *@return boolean Devuelve true si la cuenta ha sido desactivada correctamente, false en caso contrario
 */
function desactivar_cuenta(string $email): bool
{
	global $conection;
	$cambio = false;
	$email = htmlspecialchars($email, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');

	try {
		$consulta = $conection->prepare("UPDATE users SET accountStatus = 'inactive', tipo_perfil = 'privado' WHERE email = ?");
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

/**
 *Cambia la privacidad de la cuenta de usuario con el correo electrónico proporcionado
 *@param string $email Correo electrónico de la cuenta a modificar la privacidad
 *@param boolean $estado Indica si se quiere poner la cuenta como privada (true) o pública (false)
 *@return boolean Devuelve true si se ha cambiado la privacidad correctamente, false en caso contrario
 */
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
/**
 *Inserta información del usuario en la tabla "aboutuser"
 *@param int $IDuser ID del usuario
 *@param string $infoUser Información del usuario a insertar
 *@param string $fechaCreacion Fecha de creación de la información
 *@return void
 */
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

/**
 * Actualiza la informacion del usuario en la tabla aboutuser
 *
 * @param integer $IDuser
 * @param string $infoUser
 * @param string $name
 * @param string $lastname
 * @return void
 */
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

/**
 * Crea un ticket para un administrador
 *
 * @param integer $id_user
 * @param string $asunto_ticket
 * @param string $descripcion_ticket
 * @param string $fecha
 * @param string $estado
 * @return boolean
 */
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

/**
 * Crea un mensaje para un usuario
 *
 * @param integer $id_usuario_destinatario
 * @param integer $id_usuario_remitente
 * @param string $mensaje_usuario
 * @return boolean
 */
function new_mensaje(int $id_usuario_destinatario, int $id_usuario_remitente, String $mensaje_usuario): bool
{
	global $conection;
	$confirmado = false;
	$id_usuario_destinatario = htmlspecialchars($id_usuario_destinatario, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
	$id_usuario_remitente = htmlspecialchars($id_usuario_remitente, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
	$mensaje_usuario = htmlspecialchars($mensaje_usuario, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
	$fecha = date('Y-m-d H:i:s');
	$fechaCreacion = date('Y-m-d H:i:s', strtotime(str_replace('-', '/', $fecha)));
	$conversacion_id = identificador_conversacion($id_usuario_remitente, $id_usuario_destinatario);


	// var_dump($id_usuario_remitente);
	try {
		if (!existe_conversacion($id_usuario_remitente, $id_usuario_destinatario)) {
			$insertData1 = $conection->prepare("INSERT INTO nuevo_mensajes_usuarios (id_usuario_destinatario,id_usuario_remitente,id_conversacion) VALUES (?,?,?)");
			$insertData1->bindParam(1, $id_usuario_destinatario);
			$insertData1->bindParam(2, $id_usuario_remitente);
			$insertData1->bindParam(3, $conversacion_id);
			$insertData1->execute();
		}
		$mensaje_id = identificador_mensaje($id_usuario_destinatario, $id_usuario_remitente);
		$insertData2 = $conection->prepare("INSERT INTO respuestas_mensajes_usuarios (id_conversacion,id_mensaje,id_usuario_envio,id_usuario_destino,mensaje_usuario,fecha_envio_mensaje) VALUES (?,?,?,?,?,?)");
		$insertData2->bindParam(1, $conversacion_id);
		$insertData2->bindParam(2, $mensaje_id);
		$insertData2->bindParam(3, $id_usuario_remitente);
		$insertData2->bindParam(4, $id_usuario_destinatario);
		$insertData2->bindParam(5, $mensaje_usuario);
		$insertData2->bindParam(6, $fechaCreacion);

		if ($insertData2->execute()) {
			$confirmado = true;
		}
	} catch (PDOException $e) {
		$error_Code = $e->getCode();
		$message = $e->getMessage();
		die("Code: " . $error_Code . "\nMessage: " . $message);
	}
	return $confirmado;
}

/**
 * Devuelve el identificador de una conversacion
 *
 * @param integer $id_usuario_remitente
 * @param integer $id_usuario_destinatario
 * @return integer
 */
function identificador_conversacion(int $id_usuario_remitente, int $id_usuario_destinatario): int
{
	global $conection;
	$conversacion_id = 1;
	try {
		$consulta = $conection->prepare("SELECT id_conversacion as max_conversacion_id FROM nuevo_mensajes_usuarios WHERE (id_usuario_remitente = ? AND id_usuario_destinatario = ?) OR (id_usuario_remitente = ? AND id_usuario_destinatario = ?)");
		if ($consulta->execute(array($id_usuario_remitente, $id_usuario_destinatario, $id_usuario_destinatario, $id_usuario_remitente))) {
			if ($consulta->rowCount() > 0) {
				$resultado = $consulta->fetch(PDO::FETCH_ASSOC);
				$conversacion_id = $resultado['max_conversacion_id'];
			} else {
				$consulta = $conection->prepare("SELECT MAX(id_conversacion) as max_conversacion_id FROM nuevo_mensajes_usuarios");
				if ($consulta->execute()) {
					$resultado = $consulta->fetch(PDO::FETCH_ASSOC);
					$conversacion_id = $resultado['max_conversacion_id'] + 1;
				}
			}
		}
	} catch (PDOException $e) {
		$error_Code = $e->getCode();
		$message = $e->getMessage();
		die("Code: " . $error_Code . "\nMessage: " . $message);
	}
	return $conversacion_id;
}

/**
 * Devuelve el identificador de un mensaje
 *
 * @param integer $id_usuario_destinatario
 * @param integer $id_usuario_remitente
 * @return integer
 */
function identificador_mensaje(int $id_usuario_destinatario, int $id_usuario_remitente): int
{
	global $conection;
	$id_usuario_destinatario = htmlspecialchars($id_usuario_destinatario, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
	$id_usuario_remitente = htmlspecialchars($id_usuario_remitente, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');

	try {
		$consulta = $conection->prepare("SELECT id_mensaje FROM nuevo_mensajes_usuarios WHERE (id_usuario_remitente = ? AND id_usuario_destinatario = ?) OR (id_usuario_remitente = ? AND id_usuario_destinatario = ?)");
		$consulta->bindParam(1, $id_usuario_remitente);
		$consulta->bindParam(2, $id_usuario_destinatario);
		$consulta->bindParam(3, $id_usuario_destinatario);
		$consulta->bindParam(4, $id_usuario_remitente);

		if ($consulta->execute()) {
			$consulta = $consulta->fetch(PDO::FETCH_COLUMN);
		}
	} catch (PDOException $e) {
		$error_Code = $e->getCode();
		$message = $e->getMessage();
		die("Code: " . $error_Code . "\nMessage: " . $message);
	}
	return $consulta;
}


/**
 * Comprueba si existe una conversacion entre dos usuarios
 *
 * @param integer $id_remitente
 * @param integer $id_destinatario
 * @return boolean
 */
function existe_conversacion(int $id_remitente, int $id_destinatario): bool
{
	global $conection;
	$confirmado = false;
	$id_remitente = htmlspecialchars($id_remitente, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
	$id_destinatario = htmlspecialchars($id_destinatario, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');

	try {
		$consulta = $conection->prepare("SELECT id_conversacion FROM nuevo_mensajes_usuarios WHERE (id_usuario_remitente = ? AND id_usuario_destinatario = ?) OR (id_usuario_remitente = ? AND id_usuario_destinatario = ?)");
		$consulta->bindParam(1, $id_remitente);
		$consulta->bindParam(2, $id_destinatario);
		$consulta->bindParam(3, $id_destinatario);
		$consulta->bindParam(4, $id_remitente);
		$consulta->execute();

		if ($consulta->rowCount() > 0) {
			$confirmado = true;
		}
	} catch (PDOException $e) {
		$error_Code = $e->getCode();
		$message = $e->getMessage();
		die("Code: " . $error_Code . "\nMessage: " . $message);
	}
	return $confirmado;
}

/**
 * Comprueba si existe un mensaje entre dos usuarios
 *
 * @param integer $id_usuario_destinatario
 * @param integer $id_usuario_remitente
 * @return boolean
 */
function comprobar_mensaje(int $id_usuario_destinatario, int $id_usuario_remitente): bool
{
	global $conection;
	$confirmado = false;
	$id_usuario_destinatario = htmlspecialchars($id_usuario_destinatario, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
	$id_usuario_remitente = htmlspecialchars($id_usuario_remitente, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');

	try {
		$insertData = $conection->prepare("SELECT * FROM nuevo_mensajes_usuarios WHERE id_usuario_destinatario = ? AND id_usuario_remitente = ?");
		$insertData->bindParam(1, $id_usuario_destinatario);
		$insertData->bindParam(2, $id_usuario_remitente);
		$insertData->execute();

		if ($insertData->rowCount() > 0) {
			$confirmado = true;
		}
	} catch (PDOException $e) {
		$error_Code = $e->getCode();
		$message = $e->getMessage();
		die("Code: " . $error_Code . "\nMessage: " . $message);
	}
	return $confirmado;
}

/**
 * Funcion para devolver un mensaje a un ticket 
 *
 * @param integer $ticket_id
 * @param integer $usuario_id_admin
 * @param integer $usuario_id
 * @param string $mensaje_ticket
 * @param string $fecha
 * @param string $nombre_admin
 * @param string $privilegio_user
 * @return boolean
 */
function respond_tickets(int $ticket_id, int $usuario_id_admin, int $usuario_id, string $mensaje_ticket, string $fecha, string $nombre_admin, string $privilegio_user): bool
{
	global $conection;
	$confirmado = false;
	$ticket_id = htmlspecialchars($ticket_id, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
	$mensaje_ticket = htmlspecialchars($mensaje_ticket, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
	$fecha = htmlspecialchars($fecha, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
	$nombre_admin = htmlspecialchars($nombre_admin, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
	$privilegio_user = htmlspecialchars($privilegio_user, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
	try {
		$insertData = $conection->prepare("INSERT INTO tickets_respuestas (ticket_id,user_id_admin,user_id,respuesta_ticket, fecha_respuesta, nombre_admin,privilegio_user) VALUES (?,?,?,?,?,?,?)");
		$insertData->bindParam(1, $ticket_id);
		$insertData->bindParam(2, $usuario_id_admin);
		$insertData->bindParam(3, $usuario_id);
		$insertData->bindParam(4, $mensaje_ticket);
		$insertData->bindParam(5, $fecha);
		$insertData->bindParam(6, $nombre_admin);
		$insertData->bindParam(7, $privilegio_user);
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

/**
 * Devuelve todos los datos de los tickets
 *
 * @return array
 */
function datos_tickets(): array
{
	global $conection;
	$consulta = $conection->prepare("SELECT * FROM tickets");
	$consulta->execute();
	$consulta = $consulta->fetchAll(PDO::FETCH_ASSOC);
	return $consulta;
}

/**
 * Devuelve todos los datos de una denuncia de un usuario
 *
 * @return array
 */
function datos_tickets_denuncias(): array
{
	global $conection;
	$consulta = $conection->prepare("SELECT * FROM denuncias_usuarios");
	$consulta->execute();
	$consulta = $consulta->fetchAll(PDO::FETCH_ASSOC);
	return $consulta;
}

/**
 * Cambio el estado de un ticket
 * @param string $estado
 * @param integer $id
 * @return void
 */
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


/**
 * Devuelve un ticket cuyo identificador esta siendo mandado como parametro
 *
 * @param integer $id
 * @return array
 */
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

/**
 * Devuelve una denuncia cuyo identificador esta siendo mandado como parametro
 *
 * @param integer $id
 * @return array
 */
function respuestas_denuncias(int $id_denuncia): array
{
	global $conection;
	$id_denuncia = htmlspecialchars($id_denuncia, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
	try {
		$consulta = $conection->prepare("SELECT * from denuncias_usuarios_respuestas where id_denuncia_motivo=?");
		if ($consulta->execute(array($id_denuncia))) {
			$consulta = $consulta->fetchAll(PDO::FETCH_ASSOC);
		}
	} catch (PDOException $e) {
		$error_Code = $e->getCode();
		$message = $e->getMessage();
		die("Code: " . $error_Code . "\nMessage: " . $message);
	}
	return $consulta;
}

/**
 * Devuelve el numero de tickets de denuncias que tiene un usuario
 *
 * @param integer $id
 * @return integer
 */
function num_tickets_denuncias(int $id): int
{
	global $conection;
	$id = htmlspecialchars($id, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
	try {
		$consulta = $conection->prepare("SELECT count(*) from denuncias_usuarios where id_usuario_denunciado=?");
		if ($consulta->execute(array($id))) {
			$consulta = $consulta->fetchColumn();
		}
	} catch (PDOException $e) {
		$error_Code = $e->getCode();
		$message = $e->getMessage();
		die("Code: " . $error_Code . "\nMessage: " . $message);
	}
	return $consulta;
}

/**
 * Devuelve los mensajes que tiene un usuario
 *
 * @param integer $id_usuario
 * @return array
 */
function get_mensajes(int $id_usuario): array
{
	global $conection;
	$id_usuario = htmlspecialchars($id_usuario, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
	try {
		$consulta = $conection->prepare("SELECT * from nuevo_mensajes_usuarios where id_usuario_destinatario = ? OR id_usuario_remitente = ?");
		if ($consulta->execute(array($id_usuario, $id_usuario))) {
			$consulta = $consulta->fetchAll(PDO::FETCH_ASSOC);
		}
	} catch (PDOException $e) {
		$error_Code = $e->getCode();
		$message = $e->getMessage();
		die("Code: " . $error_Code . "\nMessage: " . $message);
	}
	return $consulta;
}

/**
 * Devuelve las respuestas de los usuarios cuyo identificador se manda como parametro
 *
 * @param integer $id_usuario
 * @return array
 */
function get_conversacion(int $id_conversacion): array
{
	global $conection;
	$id_conversacion = htmlspecialchars($id_conversacion, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
	try {

		$consulta = $conection->prepare("SELECT * FROM respuestas_mensajes_usuarios WHERE id_conversacion = ?  ORDER BY fecha_envio_mensaje ASC");
		if ($consulta->execute(array($id_conversacion))) {
			$consulta = $consulta->fetchAll(PDO::FETCH_ASSOC);
		}
	} catch (PDOException $e) {
		$error_Code = $e->getCode();
		$message = $e->getMessage();
		die("Code: " . $error_Code . "\nMessage: " . $message);
	}
	return $consulta;
}

/**
 * Devuelve los tickets de un usuario cuyo ID se pasa como parametro
 *
 * @param integer $id_usuario
 * @return array
 */
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

/**
 * Devuelve la informacion de un usuario cuyo ID se pasa por parametro
 *
 * @param integer $IDuser
 * @return array
 */
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

/**
 * Devuelve la busqueda de usuarios mediante una palabra clave
 *
 * @param integer $IDuser
 * @return PDOStatement
 */
//Esta función hace una búsqueda de usuario en la base de datos
function search_user($search): PDOStatement
{
	global $conection;
	$search = htmlspecialchars($search, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
	try {
		$consulta = $conection->prepare("SELECT userName,tipo_perfil,userPicture from users WHERE userName LIKE ? OR email LIKE ? AND accountStatus = 'active'");
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

/**
 * Devuelve la busqueda de comics mediante una palabra clave
 *
 * @param integer $IDuser
 * @return array
 */
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

/**
 * Comprueba si el comic existe en la base de datos mediante el uso de una palabra clave
 *
 * @param string $search
 * @return boolean
 */
function existe_comic(string $search): bool
{
	global $conection;
	$existe = false;
	$search = htmlspecialchars($search, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
	try {
		$consulta = $conection->prepare("SELECT * from comics WHERE nomComic LIKE ? OR nomVariante LIKE ? OR nomEditorial LIKE ? OR Formato LIKE ? OR Procedencia LIKE ? OR date_published LIKE ? OR nomGuionista LIKE ? OR nomDibujante LIKE ?");
		$consulta->execute(array("%$search%", "%$search%", "%$search%", "%$search%", "%$search%", "%$search%", "%$search%", "%$search%"));
		if ($consulta->rowCount() > 0) {
			$existe = true;
		}
	} catch (PDOException $e) {
		//Obtener el código de error
		$error_Code = $e->getCode();
		//Obtener el mensaje de error
		$message = $e->getMessage();
		//Mostrar el error
		die("Code: " . $error_Code . "\nMessage: " . $message);
	}
	return $existe;
}

/**
 * Devuelve la busqueda de usuarios mediante una palabra clave
 *
 * @param integer $IDuser
 * @return array
 */
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

/**
 * Devuelve datos de los usuarios
 *
 * @param integer $IDuser
 * @return array
 */
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

/**
 * Devuelve el numero de usuarios cuyo datos coincidan con la palabra clave
 *
 * @param string $search
 * @return integer
 */
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

/**
 * Devuelve el numero de comics cuyo datos coincidan con la palabra clave
 *
 * @param string $search
 * @return integer
 */
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

/**
 * Devuelve un comic de forma aleatoria
 *
 * @param string $search
 * @return integer
 */
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

/**
 * Devuelve un comic pero ordenado por fecha de salida
 *
 * @param [type] $limit
 * @param [type] $offset
 * @return PDOStatement
 */
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

/**
 * Devuelve un comic que coincida con la palabra clave y mediante unos limites dados
 *
 * @param [type] $limit
 * @param [type] $offset
 * @param [type] $busqueda
 * @return PDOStatement
 */
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

/**
 * Devuelve la informacion de un comic que coincida con la ID pasada como parametro
 *
 * @param integer $id
 * @return array|null
 */
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

/**
 * Devuelve todos los datos de los comics en espera de aprobación
 *
 * @return PDOStatement
 */
function peticiones_comics_espera(): PDOStatement
{
	global $conection;
	try {
		$consulta = $conection->prepare("SELECT * from peticiones_comics
			JOIN peticiones_nuevos_comics ON peticiones_comics.id_comic_peticion = peticiones_nuevos_comics.IDComic
			WHERE estado='en espera'");
		$consulta->execute();
	} catch (PDOException $e) {
		echo "Error: " . $e->getMessage();
	}
	return $consulta;
}

/**
 * Devuelve todos los datos de los comics cancelados
 *
 * @return PDOStatement
 */
function peticiones_comics_cancelados(): PDOStatement
{
	global $conection;
	try {
		$consulta = $conection->prepare("SELECT * from peticiones_comics
			JOIN peticiones_nuevos_comics ON peticiones_comics.id_comic_peticion = peticiones_nuevos_comics.IDComic
			WHERE estado='cancelado'");
		$consulta->execute();
	} catch (PDOException $e) {
		echo "Error: " . $e->getMessage();
	}
	return $consulta;
}

/**
 * Devuelve todos los datos de los comics aceptados
 *
 * @return PDOStatement
 */
function peticiones_comics_aceptados(): PDOStatement
{
	global $conection;
	try {
		$consulta = $conection->prepare("SELECT * from peticiones_comics
			JOIN peticiones_nuevos_comics ON peticiones_comics.id_comic_peticion = peticiones_nuevos_comics.IDComic
			WHERE estado='aceptado'");
		$consulta->execute();
	} catch (PDOException $e) {
		echo "Error: " . $e->getMessage();
	}
	return $consulta;
}

/**
 * Devuelve todos los datos de los comics
 *
 * @return array
 */
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

/**
 * Devuelve el numero total de comics
 *
 * @return integer
 */
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

/**
 * Devuelve el numero total de comics de un usuario
 *
 * @return integer
 */
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

/**
 * Funcion que permite agregar la opinion de un comics en la bbdd
 *
 * @param integer $id_user
 * @param integer $id_comic
 * @param string $opinion
 * @param integer $puntuacion
 * @return boolean
 */
function agregar_opinion(int $id_user, int $id_comic, string $opinion, int $puntuacion): bool
{
	global $conection;
	$agregado = false;
	$id_user = htmlspecialchars($id_user, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
	$id_comic = htmlspecialchars($id_comic, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
	$opinion = htmlspecialchars($opinion, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
	$puntuacion = htmlspecialchars($puntuacion, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');

	try {
		$consulta = $conection->prepare("INSERT INTO opiniones_comics(id_comic,id_usuario,opinion,puntuacion,fecha_comentario) VALUES (?,?,?,?,?)");
		if ($consulta->execute(array($id_comic, $id_user, $opinion, $puntuacion, date("Y-m-d")))) {
			$agregado = true;
		}
	} catch (PDOException $e) {
		echo "Error: " . $e->getMessage();
	}
	return $agregado;
}

/**
 * Funcion que permite agregar la opinion de la pagina en la bbdd
 *
 * @param integer $id_user
 * @param string $opinion
 * @return boolean
 */
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

/**
 * Devuelve el numero de opiniones de un comic en concreto
 *
 * @param integer $id_comic
 * @return integer
 */
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

/**
 * muestra las opiniones de un comic en concreto
 *
 * @param integer $id_comic
 * @return PDOStatement
 */
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

/**
 * Funcion que muestra las opiniones de la pagina
 *
 * @return PDOStatement
 */
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
 * Devuelve el número de filas de la tabla opiniones_pagina. * 
 * @return int El número de filas en la tabla.
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

/**
 * Calcula y devuelve la puntuacion media de un comic en concreto
 *
 * @param integer $id_comic
 * @return float
 */
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

/**
 * Devuelve la puntuacion que ha dado un usuario a un comic en concreto
 *
 * @param integer $id_user
 * @param integer $id_comic
 * @return float
 */
function valoracion_usuario(int $id_user, int $id_comic): float
{
	global $conection;
	try {
		$consulta = $conection->prepare("SELECT puntuacion from opiniones_comics where id_usuario=? and id_comic=?");
		$consulta->execute(array($id_user, $id_comic));
	} catch (PDOException $e) {
		echo "Error: " . $e->getMessage();
	}
	$consulta = $consulta->fetchColumn();
	return (float) $consulta;
}

/**
 * Funcion que permite crear una nueva lista de lectura personalizada
 *
 * @param string $id_user
 * @param string $nombre_lista
 * @return boolean
 */
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

/**
 * Funcion que permite modificar el nombre de una lista de lectura personalizada
 *
 * @param integer $id_lista
 * @param string $nombre_lista
 * @return boolean
 */
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

/**
 * Devuelve el numero de comics guardado en la bbdd de un uusario en concreto
 *
 * @param integer $id_user
 * @param integer $id_comic
 * @return boolean
 */
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

/**
 * Verifica si un cómic está guardado en una lista de lectura en la base de datos.
 *
 * @param integer $id_lista
 * @param integer $id_comic
 * @return boolean
 */
function check_guardado_lista(int $id_lista, int $id_comic): bool
{
	global $conection;
	$guardado = false;
	$id_lista = htmlspecialchars($id_lista, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
	$id_comic = htmlspecialchars($id_comic, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
	try {
		$consulta = $conection->prepare("SELECT COUNT(*) from contenido_listas where id_lista=? AND id_comic=?");
		$consulta->execute(array($id_lista, $id_comic));
		$cantidad = $consulta->fetchColumn();

		if ($cantidad > 0) {
			$guardado = true;
		}
	} catch (PDOException $e) {
		echo "Error: " . $e->getMessage();
	}

	return $guardado;
}

/**
 * Obtiene el número de cómics en una lista de lectura.
 *
 * @param int $id_lista El ID de la lista de lectura.
 * @return int El número de cómics en la lista.
 */
function numero_comics_lista($id_lista)
{
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

/**
 * Guarda un cómic asociado a un usuario en la base de datos.
 *
 * @param int $id_user ID del usuario.
 * @param int $id_comic ID del cómic.
 * @return bool Retorna true si el cómic fue agregado exitosamente, false en caso contrario.
 */
function guardar_comic(int $id_user, int $id_comic): bool
{
	global $conection;
	$agregado = false;
	$id_user = htmlspecialchars($id_user, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
	$id_comic = htmlspecialchars($id_comic, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
	try {
		// Comprobamos si el usuario existe
		$user_query = $conection->prepare("SELECT * FROM users WHERE IDuser = ?");
		$user_query->execute([$id_user]);
		$user = $user_query->fetch();

		if ($user) {
			$consulta = $conection->prepare("INSERT INTO comics_guardados(user_id,comic_id) VALUES (?,?)");
			$consulta->execute(array($id_user, $id_comic));
			$agregado = true;
		} else {
			// En caso de que el usuario no exista
			$agregado = false;
		}
	} catch (PDOException $e) {
		echo "Error: " . $e->getMessage();
	}
	return $agregado;
}

/**
 * Elimina un cómic asociado a un usuario de la base de datos.
 *
 * @param int $id_user ID del usuario.
 * @param int $id_comic ID del cómic.
 * @return bool Retorna true si el cómic fue eliminado exitosamente, false en caso contrario.
 */
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

/**
 * Guarda un cómic en una lista específica en la base de datos.
 *
 * @param int $id_comic ID del cómic.
 * @param int $id_lista ID de la lista.
 * @return bool Retorna true si el cómic fue agregado exitosamente a la lista, false en caso contrario.
 */
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

/**
 * Elimina un cómic de una lista específica en la base de datos.
 *
 * @param int $id_comic ID del cómic.
 * @param int $id_lista ID de la lista.
 * @return bool Retorna true si el cómic fue eliminado exitosamente de la lista, false en caso contrario.
 */
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

/**
 * Obtiene los cómics guardados por un usuario de la base de datos.
 *
 * @param int $limit Cantidad máxima de cómics a obtener.
 * @param int $offset Valor de desplazamiento para la paginación de resultados.
 * @param int $id_user ID del usuario.
 * @return PDOStatement Retorna un objeto PDOStatement que contiene los resultados de la consulta.
 */
function get_comics_guardados(int $limit, int $offset, int $id_user): PDOStatement
{
	$id_user = htmlspecialchars($id_user, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
	$limit = htmlspecialchars($limit, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
	$offset = htmlspecialchars($offset, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
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

/**
 * Obtiene los cómics de una lista específica de la base de datos.
 *
 * @param int $limit Cantidad máxima de cómics a obtener.
 * @param int $offset Valor de desplazamiento para la paginación de resultados.
 * @param int $id_lista ID de la lista.
 * @return PDOStatement Retorna un objeto PDOStatement que contiene los resultados de la consulta.
 */
function get_comics_lista(int $limit, int $offset, int $id_lista): PDOStatement
{
	$id_lista = htmlspecialchars($id_lista, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
	$limit = htmlspecialchars($limit, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
	$offset = htmlspecialchars($offset, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
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

/**
 * Obtiene el número total de elementos en una lista específica de la base de datos.
 *
 * @param int $id_lista ID de la lista.
 * @return int Retorna el número total de elementos en la lista.
 */
function get_total_contenido(int $id_lista): int
{
	$id_lista = htmlspecialchars($id_lista, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
	global $conection;
	try {
		$consulta = $conection->prepare("SELECT COUNT(*) from contenido_listas where id_lista=?");
		$consulta->execute(array($id_lista));
	} catch (PDOException $e) {
		echo "Error: " . $e->getMessage();
	}
	return $consulta->fetchColumn();
}

/**
 * Obtiene el número total de cómics guardados por un usuario de la base de datos.
 *
 * @param int $id_user ID del usuario.
 * @return int Retorna el número total de cómics guardados por el usuario.
 */
function get_total_guardados(int $id_user): int
{
	$id_user = htmlspecialchars($id_user, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
	global $conection;
	try {
		$consulta = $conection->prepare("SELECT COUNT(*) from comics_guardados where user_id=?");
		$consulta->execute([$id_user]);
	} catch (PDOException $e) {
		echo "Error: " . $e->getMessage();
	}
	return $consulta->fetchColumn();
}

/**
 * Obtiene el número total de cómics en la base de datos.
 *
 * @return int Retorna el número total de cómics.
 */
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

/**
 * Obtiene la descripción de un cómic específico de la base de datos.
 *
 * @param int $id ID del cómic.
 * @return array Retorna un array asociativo con los datos de la descripción del cómic.
 */
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

/**
 * Obtiene las listas de cómics de un usuario específico de la base de datos.
 *
 * @param int $id ID del usuario.
 * @return array Retorna un array con los datos de las listas de cómics del usuario.
 */
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

/**
 * Obtiene el nombre de una lista de cómics específica de la base de datos.
 *
 * @param int $id_lista ID de la lista de cómics.
 * @return array Retorna un array asociativo con los datos del nombre de la lista.
 */
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

/**
 * Obtiene el número de listas de cómics de un usuario específico en la base de datos.
 *
 * @param int $id ID del usuario.
 * @return int Retorna el número de listas de cómics del usuario.
 */
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

/**
 * Verifica si un usuario específico tiene acceso a una lista de cómics en la base de datos.
 *
 * @param int $id_user ID del usuario.
 * @param int $id_lista ID de la lista de cómics.
 * @return int Retorna 1 si el usuario tiene acceso a la lista, de lo contrario retorna 0.
 */
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

/**
 * Reactiva una cuenta de usuario inactiva en la base de datos.
 *
 * @param string $email Dirección de correo electrónico asociada a la cuenta.
 * @throws Exception Si ocurre un error en la base de datos.
 */
function reactivar_cuenta(string $email): void
{
	global $conection;
	$email = htmlspecialchars($email, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
	try {
		$consulta = $conection->prepare("UPDATE users SET accountStatus = 'active' WHERE email = ? and accountStatus = 'inactive'");
		$consulta->execute(array($email));
	} catch (PDOException $e) {
		throw new Exception('Error en la base de datos: ' . $e->getMessage());
	}
}

/**
 * Obtiene el estado de una solicitud de amistad entre dos usuarios en la base de datos.
 *
 * @param int $id_destinatario ID del usuario destinatario de la solicitud.
 * @param int $id_solicitante ID del usuario solicitante de la solicitud.
 * @return string Retorna el estado de la solicitud ('pendiente', 'aceptada', 'rechazada').
 * @throws Exception Si ocurre un error en la base de datos.
 */
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

/**
 * Obtiene el número de amistades de un usuario en la base de datos.
 *
 * @param int $id_usuario ID del usuario.
 * @return int Retorna el número de amistades del usuario.
 * @throws Exception Si ocurre un error en la base de datos.
 */
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

/**
 * Obtiene las solicitudes de amistad pendientes de un usuario en la base de datos.
 *
 * @param int $id_user ID del usuario.
 * @return array Retorna un array con las solicitudes de amistad pendientes.
 * @throws Exception Si ocurre un error en la base de datos.
 */
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

/**
 * Acepta una solicitud de amistad en la base de datos.
 *
 * @param int $id_remitente ID del usuario remitente de la solicitud.
 * @param int $id_mi_usuario ID de mi usuario.
 * @return bool Retorna true si se acepta la solicitud correctamente, o false si ocurre un error.
 * @throws Exception Si ocurre un error en la base de datos.
 */
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

/**
 * Rechaza una solicitud de amistad en la base de datos.
 *
 * @param int $id_remitente ID del usuario remitente de la solicitud.
 * @param int $id_mi_usuario ID de mi usuario.
 * @return bool Retorna true si se rechaza la solicitud correctamente, o false si ocurre un error.
 * @throws Exception Si ocurre un error en la base de datos.
 */
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

/**
 * Cancela una solicitud de amistad en la base de datos.
 *
 * @param int $id_remitente ID del usuario remitente de la solicitud.
 * @param int $id_mi_usuario ID de mi usuario.
 * @return bool Retorna true si se cancela la solicitud correctamente, o false si ocurre un error.
 * @throws Exception Si ocurre un error en la base de datos.
 */
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

/**
 * Comprueba si existe una amistad entre dos usuarios en la base de datos.
 *
 * @param int $id_amigo ID del usuario amigo.
 * @param int $id_mi_usuario ID de mi usuario.
 * @return bool Retorna true si existe una amistad entre los usuarios, o false si no existe.
 * @throws Exception Si ocurre un error en la base de datos.
 */
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

/**
 * Envía una solicitud de amistad desde un usuario solicitante a un usuario destinatario.
 *
 * @param int $id_destinatario ID del usuario destinatario.
 * @param int $id_solicitante ID del usuario solicitante.
 * @return bool Retorna true si la solicitud se envió correctamente, o false si ocurrió un error.
 * @throws Exception Si ocurre un error en la base de datos.
 */
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

/**
 * Elimina una amistad entre dos usuarios.
 *
 * @param int $id_amigo ID del amigo a eliminar.
 * @param int $id_mi_usuario ID del usuario actual.
 * @return bool Retorna true si la amistad se eliminó correctamente, o false si ocurrió un error.
 * @throws Exception Si ocurre un error en la base de datos.
 */
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

/**
 * Obtiene la lista de amigos de un usuario.
 *
 * @param int $id_user ID del usuario.
 * @return array Retorna un array con los datos de los amigos del usuario.
 * @throws Exception Si ocurre un error en la base de datos.
 */
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

/**
 * Obtiene el número de amigos de un usuario.
 *
 * @param int $id_user ID del usuario.
 * @return int Retorna el número de amigos del usuario.
 * @throws Exception Si ocurre un error en la base de datos.
 */
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

/**
 * Bloquea a un usuario.
 *
 * @param int $id_destinatario ID del usuario que se va a bloquear.
 * @param int $id_solicitante ID del usuario que realiza el bloqueo.
 * @return bool Retorna true si el usuario ha sido bloqueado correctamente, false en caso contrario.
 * @throws Exception Si ocurre un error en la base de datos.
 */
function bloquear_usuario(int $id_destinatario, int $id_solicitante): bool
{
	global $conection;
	$bloqueado = false;
	$id_destinatario = htmlspecialchars($id_destinatario, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
	$id_solicitante = htmlspecialchars($id_solicitante, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
	try {
		// Insertar en la tabla de usuarios bloqueados
		$consulta1 = $conection->prepare("INSERT INTO usuarios_bloqueados (id_usuario_bloqueado, id_solicitante) VALUES (?, ?)");
		$consulta1->execute(array($id_destinatario, $id_solicitante));

		// Verificar si existen amistades entre los usuarios
		$consulta2 = $conection->prepare("SELECT COUNT(*) FROM amistades_usuario WHERE id_amigo = ?");
		$consulta2->execute(array($id_destinatario));
		$amistades_destinatario = $consulta2->fetchColumn();

		if ($amistades_destinatario > 0) {
			// Eliminar la amistad en ambos sentidos
			$consulta3 = $conection->prepare("DELETE FROM amistades_usuario WHERE id_usuario = ? AND id_amigo = ?");
			$consulta3->execute(array($id_destinatario, $id_solicitante));

			$consulta4 = $conection->prepare("DELETE FROM amistades_usuario WHERE id_usuario = ? AND id_amigo = ?");
			$consulta4->execute(array($id_solicitante, $id_destinatario));
		}

		// Eliminar las solicitudes de amistad entre los usuarios
		$consulta5 = $conection->prepare("DELETE FROM solicitudes_amistad WHERE id_usuario_solicitante = ? AND id_usuario_destinatario = ?");
		$consulta5->execute(array($id_solicitante, $id_destinatario));

		$bloqueado = true;
	} catch (PDOException $e) {
		echo "Error: " . $e->getMessage();
	}
	return $bloqueado;
}

/**
 * Verifica si un usuario está bloqueado.
 *
 * @param int $id_destinatario ID del usuario bloqueado.
 * @param int $id_solicitante ID del usuario que realiza la verificación.
 * @return bool Retorna true si el usuario está bloqueado, false en caso contrario.
 * @throws Exception Si ocurre un error en la base de datos.
 */
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

/**
 * Desbloquea a un usuario.
 *
 * @param int $id_destinatario ID del usuario a desbloquear.
 * @param int $id_solicitante ID del usuario que realiza el desbloqueo.
 * @return bool Retorna true si el usuario fue desbloqueado, false en caso contrario.
 * @throws Exception Si ocurre un error en la base de datos.
 */
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

/**
 * Comprueba si un usuario está bloqueado por otro usuario.
 *
 * @param int $id_destinatario ID del usuario bloqueado.
 * @param int $id_solicitante ID del usuario que realiza la comprobación.
 * @return bool Retorna true si el usuario está bloqueado, false en caso contrario.
 * @throws Exception Si ocurre un error en la base de datos.
 */
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

/**
 * Obtiene el número de usuarios bloqueados por un usuario.
 *
 * @param int $id_mi_usuario ID del usuario que realiza la consulta.
 * @return int Retorna el número de usuarios bloqueados.
 * @throws Exception Si ocurre un error en la base de datos.
 */
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

/**
 * Obtiene la lista de usuarios bloqueados por un usuario.
 *
 * @param int $id_mi_usuario ID del usuario que realiza la consulta.
 * @return array Retorna un array con los datos de los usuarios bloqueados.
 * @throws Exception Si ocurre un error en la base de datos.
 */
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

/**
 * Obtiene el tipo de privacidad de un usuario.
 *
 * @param int $id_user ID del usuario.
 * @return string Retorna el tipo de privacidad del usuario.
 * @throws Exception Si ocurre un error en la base de datos.
 */
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

/**
 * Guarda la fecha de la última conexión de un usuario.
 *
 * @param string $email_usuario Email del usuario.
 * @throws Exception Si ocurre un error en la base de datos.
 */
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

/**
 * Comprueba la última conexión de un usuario y devuelve la diferencia de tiempo.
 *
 * @param int $id_usuario ID del usuario.
 * @return string Retorna la diferencia de tiempo desde la última conexión.
 * @throws Exception Si ocurre un error en la base de datos.
 */
function comprobar_ultima_conexion($id_usuario)
{
	global $conection;
	$id_usuario = htmlspecialchars($id_usuario, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
	try {
		// localiza el ID del usuario
		$consulta = $conection->prepare("SELECT ultima_conexion from aboutuser where IDuser=?");
		$consulta->execute(array($id_usuario));
		$ultima_conexion = $consulta->fetchColumn();

		// obtiene la diferencia de tiempo
		$fecha_conexion = new DateTime($ultima_conexion);
		$fecha_actual = new DateTime();
		$intervalo = date_diff($fecha_conexion, $fecha_actual);

		$diferencia = '';

		if ($intervalo->y > 0) {
			$diferencia .= $intervalo->y . ' años, ';
		}

		if ($intervalo->m > 0) {
			$diferencia .= $intervalo->m . ' meses, ';
		}

		if ($intervalo->d > 0) {
			$diferencia .= $intervalo->d . ' días, ';
		}

		if ($intervalo->h > 0) {
			$diferencia .= $intervalo->h . ' horas';
			if ($intervalo->i > 0) {
				$diferencia .= ', ' . $intervalo->i . ' minutos ';
			}
			if ($intervalo->s > 0 && $intervalo->h < 1) {
				$diferencia .= ' y ' . $intervalo->s . ' segundos';
			}
		} elseif ($intervalo->i > 0) {
			$diferencia .= $intervalo->i . ' minutos';
			if ($intervalo->s > 0) {
				$diferencia .= ' y ' . $intervalo->s . ' segundos';
			}
		} else {
			$diferencia = 'Recién conectado';
		}
	} catch (PDOException $e) {
		echo "Error: " . $e->getMessage();
	}
	return $diferencia;
}

/**
 * Obtiene una lista de cómics según los filtros de búsqueda y paginación.
 *
 * @param array $userData Datos del usuario.
 * @param int $limit Límite de resultados por página.
 * @param int $offset Desplazamiento de resultados para paginación.
 * @param object $conection Conexión a la base de datos.
 * @return object Retorna el resultado de la consulta de cómics.
 */
function comics_lista($userData, $limit, $offset)
{
	global $conection;
	$id_user = $userData['IDuser'];
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

/**
 * Obtiene el número de mensajes sin leer de un usuario.
 *
 * @param int $id_usuario ID del usuario.
 * @return int Retorna el número de mensajes sin leer.
 */
function obtener_numero_mensajes_sin_leer($id_usuario)
{
	global $conection;
	$id_usuario = htmlspecialchars($id_usuario, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
	try {
		$consulta = $conection->prepare("SELECT COUNT(*) from respuestas_mensajes_usuarios where estado_mensaje='no leido' AND id_usuario_destino = ?");
		$consulta->execute(array($id_usuario));
		$numero_mensajes_sin_leer = $consulta->fetchColumn();
	} catch (PDOException $e) {
		echo "Error: " . $e->getMessage();
	}
	return $numero_mensajes_sin_leer;
}

/**
 * Obtiene el número de notificaciones de amistad sin leer de un usuario.
 *
 * @param int $id_usuario ID del usuario.
 * @return int Retorna el número de notificaciones de amistad sin leer.
 */
function obtener_numero_notificaciones_amistad_sin_leer($id_usuario)
{
	global $conection;
	$id_usuario = htmlspecialchars($id_usuario, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
	try {
		$consulta = $conection->prepare("SELECT COUNT(*) from solicitudes_amistad where estado_solicitud='en espera' AND id_usuario_destinatario = ?");
		$consulta->execute(array($id_usuario));
		$numero_mensajes_sin_leer = $consulta->fetchColumn();
	} catch (PDOException $e) {
		echo "Error: " . $e->getMessage();
	}
	return $numero_mensajes_sin_leer;
}

/**
 * Cambia el estado de los mensajes de una conversación a "leído" para el usuario actual.
 *
 * @param int $id_conversacion ID de la conversación.
 * @param int $id_usuario ID del usuario.
 * @return void
 */
function cambiar_estado_mensajes(int $id_conversacion, int $id_usuario): void
{
	global $conection;
	$id_conversacion = htmlspecialchars($id_conversacion, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');

	try {
		// Obtener todos los registros que cumplan la condición
		$consulta = $conection->prepare("SELECT * FROM respuestas_mensajes_usuarios WHERE id_conversacion = ? AND id_usuario_envio != ?");
		$consulta->execute([$id_conversacion, $id_usuario]);
		$resultados = $consulta->fetchAll(PDO::FETCH_ASSOC);

		// Cambiar el estado de los registros obtenidos
		foreach ($resultados as $row) {
			$id_otro_usuario = $row['id_usuario_envio'];
			if ($id_otro_usuario != $id_usuario) {
				$id_otro_usuario = $row['id_usuario_envio'];
				$consulta = $conection->prepare("UPDATE respuestas_mensajes_usuarios SET estado_mensaje = 'leido' WHERE id_usuario_envio = ?");
				$consulta->execute([$id_otro_usuario]);
			}
		}
	} catch (PDOException $e) {
		echo "Error: " . $e->getMessage();
	}
}

/**
 * Envía una solicitud de cómic asociada a un usuario y una descripción de cómic.
 *
 * @param int $id_comic ID del cómic.
 * @param int $id_usuario ID del usuario que envía la solicitud.
 * @param int $id_descripcion ID de la descripción de cómic.
 * @return bool Retorna true si la solicitud se envió correctamente, de lo contrario retorna false.
 */
function enviar_solicitud_comic($id_comic, $id_usuario, $id_descripcion)
{
	global $conection;
	$estado = false;
	$id_comic = htmlspecialchars($id_comic, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
	$id_descripcion = htmlspecialchars($id_descripcion, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
	try {
		$consulta = $conection->prepare("INSERT INTO peticiones_comics (id_comic_peticion,id_usuario_peticion,id_comic_descripcion) VALUES (?,?,?)");
		if ($consulta->execute(array($id_comic, $id_usuario, $id_descripcion))) {
			$estado = true;
		}
	} catch (PDOException $e) {
		echo "Error: " . $e->getMessage();
	}
	return $estado;
}

/**
 * Envía una solicitud de nuevos datos de cómic.
 *
 * @param string $nombre_comic Nombre del cómic.
 * @param string $nombre_variante Nombre de la variante del cómic.
 * @param string $numero Número del cómic.
 * @param string $formato Formato del cómic.
 * @param string $editorial Editorial del cómic.
 * @param string $fecha Fecha de publicación del cómic.
 * @param string $guionista Guionista del cómic.
 * @param string $procedencia Procedencia del cómic.
 * @param string $descipcion_comic Descripción del cómic.
 * @param string $dibujante Dibujante del cómic.
 * @param string $portada_comic Portada del cómic.
 * @param int $id_usuario ID del usuario que envía la solicitud.
 * @return bool Retorna true si la solicitud se envió correctamente, de lo contrario retorna false.
 */
function enviar_solicitud_datos_comic($nombre_comic, $nombre_variante, $numero, $formato, $editorial, $fecha, $guionista, $procedencia, $descipcion_comic, $dibujante, $portada_comic, $id_usuario)
{
	global $conection;
	$estado = false;
	$nombre_comic = htmlspecialchars($nombre_comic, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
	$nombre_variante = htmlspecialchars($nombre_variante, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
	$numero = htmlspecialchars($numero, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
	$formato = htmlspecialchars($formato, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
	$editorial = htmlspecialchars($editorial, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
	$fecha = htmlspecialchars($fecha, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
	$guionista = htmlspecialchars($guionista, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
	$procedencia = htmlspecialchars($procedencia, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
	$descipcion_comic = htmlspecialchars($descipcion_comic, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
	$dibujante = htmlspecialchars($dibujante, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
	$portada_comic = htmlspecialchars($portada_comic, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
	try {
		$consulta = $conection->prepare("INSERT INTO peticiones_nuevos_comics (nomComic,nomVariante,numComic,Formato,nomEditorial,date_published,nomGuionista,Procedencia,nomDibujante,cover) VALUES (?,?,?,?,?,?,?,?,?,?)");
		if ($consulta->execute(array($nombre_comic, $nombre_variante, $numero, $formato, $editorial, $fecha, $guionista, $procedencia, $dibujante, $portada_comic))) {
			$id_comic = $conection->lastInsertId();
			if (enviar_solicitud_descripcion_comic($id_comic, $descipcion_comic, $id_usuario)) {
				$estado = true;
			}
		}
	} catch (PDOException $e) {
		echo "Error: " . $e->getMessage();
	}
	return $estado;
}

/**
 * Confirma una solicitud de datos de cómic, guardando los datos proporcionados en la base de datos.
 *
 * @param int $id_comic_peticion ID de la solicitud de cómic.
 * @param string $nombre_comic Nombre del cómic.
 * @param string $nombre_variante Nombre de la variante del cómic.
 * @param string $numero Número del cómic.
 * @param string $formato Formato del cómic.
 * @param string $editorial Editorial del cómic.
 * @param string $fecha Fecha de publicación del cómic.
 * @param string $guionista Guionista del cómic.
 * @param string $procedencia Procedencia del cómic.
 * @param string $descipcion_comic Descripción del cómic.
 * @param string $dibujante Dibujante del cómic.
 * @param string $portada_comic Portada del cómic.
 * @return bool Retorna true si la confirmación se realizó correctamente, de lo contrario retorna false.
 */
function confirmar_solicitud_datos_comic($id_comic_peticion, $nombre_comic, $nombre_variante, $numero, $formato, $editorial, $fecha, $guionista, $procedencia, $descipcion_comic, $dibujante, $portada_comic)
{
	global $conection;
	$estado = false;
	$nombre_comic = htmlspecialchars($nombre_comic, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
	$nombre_variante = htmlspecialchars($nombre_variante, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
	$numero = htmlspecialchars($numero, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
	$formato = htmlspecialchars($formato, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
	$editorial = htmlspecialchars($editorial, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
	$fecha = htmlspecialchars($fecha, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
	$guionista = htmlspecialchars($guionista, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
	$procedencia = htmlspecialchars($procedencia, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
	$descipcion_comic = htmlspecialchars($descipcion_comic, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
	$dibujante = htmlspecialchars($dibujante, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
	$portada_comic = htmlspecialchars($portada_comic, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
	try {
		$consulta1 = $conection->prepare("INSERT INTO comics (nomComic,nomVariante,numComic,Formato,nomEditorial,date_published,nomGuionista,Procedencia,nomDibujante,cover) VALUES (?,?,?,?,?,?,?,?,?,?)");

		if ($consulta1->execute(array($nombre_comic, $nombre_variante, $numero, $formato, $editorial, $fecha, $guionista, $procedencia, $dibujante, $portada_comic))) {
			$id_comic = $conection->lastInsertId();
			$consulta2 = $conection->prepare("INSERT INTO descripcion_comics (id_comic,descripcion_comics) VALUES (?,?)");
			if ($consulta2->execute(array($id_comic, $descipcion_comic))) {
				copiar_imagen($id_comic_peticion, $id_comic);
				$estado = true;
			}
		}
	} catch (PDOException $e) {
		echo "Error: " . $e->getMessage();
	}
	return $estado;
}

/**
 * Cambia el estado de una petición de cómic a "cancelado".
 *
 * @param int $id_comic_peticion ID de la petición de cómic.
 * @return bool Retorna true si el cambio de estado se realizó correctamente, de lo contrario retorna false.
 */
function cambiar_estado_peticion_cancelar(int $id_comic_peticion): bool
{
	global $conection;
	$estado = false;
	$id_comic_peticion = htmlspecialchars($id_comic_peticion, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
	try {
		$consulta = $conection->prepare("UPDATE peticiones_comics SET estado = 'cancelado' WHERE id_comic_peticion = ?");
		if ($consulta->execute([$id_comic_peticion])) {
			$estado = true;
		}
	} catch (PDOException $e) {
		echo "Error: " . $e->getMessage();
	}
	return $estado;
}

/**
 * Cambia el estado de una petición de cómic a "aceptado".
 *
 * @param int $id_comic_peticion ID de la petición de cómic.
 */
function cambiar_estado_peticion_confirmado(int $id_comic_peticion): void
{
	global $conection;
	$id_comic_peticion = htmlspecialchars($id_comic_peticion, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
	try {
		$consulta = $conection->prepare("UPDATE peticiones_comics SET estado = 'aceptado' WHERE id_peticion = ?");
		$consulta->execute([$id_comic_peticion]);
	} catch (PDOException $e) {
		echo "Error: " . $e->getMessage();
	}
}

/**
 * Obtiene la información de una petición de cómic.
 *
 * @param int $id_comic ID del cómic de la petición.
 * @return array Retorna un array asociativo con la información de la petición de cómic, o un array vacío si no se encuentra la petición.
 */
function info_peticiones_comics(int $id_comic): array
{
	global $conection;
	$id_comic = htmlspecialchars($id_comic, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
	try {
		$consulta = $conection->prepare("SELECT * FROM peticiones_comics WHERE id_comic_peticion = ?");
		$consulta->execute([$id_comic]);
		$resultados = $consulta->fetch(PDO::FETCH_ASSOC);
	} catch (PDOException $e) {
		echo "Error: " . $e->getMessage();
	}
	return $resultados;
}

/**
 * Obtiene la información de un cómic registrado a través del formulario.
 *
 * @param int $id_comic ID del cómic.
 * @return array Retorna un array asociativo con la información del cómic, o un array vacío si no se encuentra el cómic.
 */
function info_comic_formulario(int $id_comic): array
{
	global $conection;
	$id_comic = htmlspecialchars($id_comic, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
	try {
		$consulta = $conection->prepare("SELECT * FROM peticiones_nuevos_comics WHERE IDcomic = ?");
		$consulta->execute([$id_comic]);
		$resultados = $consulta->fetch(PDO::FETCH_ASSOC);
	} catch (PDOException $e) {
		echo "Error: " . $e->getMessage();
	}
	return $resultados;
}

/**
 * Obtiene la descripción de un cómic registrado a través del formulario.
 *
 * @param int $id_comic ID del cómic.
 * @return array Retorna un array asociativo con la descripción del cómic, o un array vacío si no se encuentra la descripción.
 */
function info_comic_descripcion_formulario(int $id_comic): array
{
	global $conection;
	$id_comic = htmlspecialchars($id_comic, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
	try {
		$consulta = $conection->prepare("SELECT * FROM peticiones_descripcion_comics WHERE id_comic = ?");
		$consulta->execute([$id_comic]);
		$resultados = $consulta->fetch(PDO::FETCH_ASSOC);
	} catch (PDOException $e) {
		echo "Error: " . $e->getMessage();
	}
	return $resultados;
}

/**
 * Envía una solicitud de descripción de cómic.
 *
 * @param int $id_comic ID del cómic.
 * @param string $descripcion_comic Descripción del cómic.
 * @param int $id_usuario ID del usuario que envía la solicitud.
 * @return bool Retorna true si la solicitud se envía correctamente, o false en caso contrario.
 */
function enviar_solicitud_descripcion_comic($id_comic, $descipcion_comic, $id_usuario): bool
{
	global $conection;
	$estado = false;
	$id_comic = htmlspecialchars($id_comic, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
	$descipcion_comic = htmlspecialchars($descipcion_comic, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
	try {
		$consulta = $conection->prepare("INSERT INTO peticiones_descripcion_comics (id_comic,descripcion_comic) VALUES (?,?)");
		if ($consulta->execute(array($id_comic, $descipcion_comic))) {
			$id_descripcion = $conection->lastInsertId();
			if (enviar_solicitud_comic($id_comic, $id_usuario, $id_descripcion)) {
				$estado = true;
			}
		}
	} catch (PDOException $e) {
		echo "Error: " . $e->getMessage();
	}
	return $estado;
}

/**
 * Obtiene el último ID de cómic de una tabla específica.
 *
 * @param string $nombre_tabla Nombre de la tabla.
 * @return int Retorna el último ID de cómic de la tabla especificada.
 */
function ultimo_id_comic(String $nombre_tabla): int
{
	global $conection;
	$ultimo_id = 0;
	try {
		$consulta = $conection->prepare("SELECT MAX(IDcomic) FROM $nombre_tabla");
		$consulta->execute();
		$ultimo_id = $consulta->fetchColumn();
	} catch (PDOException $e) {
		echo "Error: " . $e->getMessage();
	}
	return $ultimo_id;
}

/**
 * Elimina una petición de cómic y sus registros relacionados.
 *
 * @param int $id_peticion ID de la petición de cómic a eliminar.
 * @return bool Retorna true si se elimina correctamente, false en caso contrario.
 */
function eliminar_peticion_comic(int $id_peticion): bool
{
	global $conection;
	$estado = false;
	$id_peticion = htmlspecialchars($id_peticion, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
	$datos_comic = info_peticiones_comics($id_peticion);
	$id_comic = $datos_comic['id_comic_peticion'];
	$id_descripcion = $datos_comic['id_comic_descripcion'];
	try {
		$consulta1 = $conection->prepare("DELETE FROM peticiones_comics WHERE id_comic_peticion = ?");
		$consulta2 = $conection->prepare("DELETE FROM peticiones_nuevos_comics WHERE IDcomic = ?");
		$consulta3 = $conection->prepare("DELETE FROM peticiones_descripcion_comics WHERE id_comic = ?");
		if ($consulta1->execute([$id_peticion])) {
			if ($consulta2->execute([$id_comic])) {
				if ($consulta3->execute([$id_descripcion])) {
					eliminar_portada($id_comic);
					$estado = true;
				}
			}
		}
	} catch (PDOException $e) {
		echo "Error: " . $e->getMessage();
	}
	return $estado;
}

/**
 * Registra una nueva denuncia de usuario.
 *
 * @param int $id_usuario_denunciado ID del usuario denunciado.
 * @param int $id_user_denunciante ID del usuario denunciante.
 * @param string $mensaje_usuario Mensaje del usuario denunciante.
 * @param string $motivo_denuncia Motivo de la denuncia.
 * @return bool Retorna true si se registra correctamente, false en caso contrario.
 */
function nueva_denuncia($id_usuario_denunciado, $id_user_denunciante, $mensaje_usuario, $motivo_denuncia): bool
{
	global $conection;
	$estado = false;
	$id_usuario_denunciado = htmlspecialchars($id_usuario_denunciado, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
	$id_user_denunciante = htmlspecialchars($id_user_denunciante, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
	$mensaje_usuario = htmlspecialchars($mensaje_usuario, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
	$contexto_denuncia = htmlspecialchars($motivo_denuncia, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
	$fecha = date('Y-m-d H:i:s');
	$fecha_respuesta = date('Y-m-d H:i:s', strtotime(str_replace('-', '/', $fecha)));
	try {
		$consulta = $conection->prepare("INSERT INTO denuncias_usuarios (id_usuario_denunciante,id_usuario_denunciado,motivo_denuncia,contexto_denuncia,fecha_denuncia) VALUES (?,?,?,?,?)");
		if ($consulta->execute(array($id_user_denunciante, $id_usuario_denunciado, $mensaje_usuario, $contexto_denuncia, $fecha_respuesta))) {
			$estado = true;
		}
	} catch (PDOException $e) {
		echo "Error: " . $e->getMessage();
	}
	return $estado;
}

/**
 * Registra una respuesta a una denuncia de usuario.
 *
 * @param int $id_denuncia ID de la denuncia.
 * @param int $id_admin ID del administrador que responde.
 * @param int $id_usuario ID del usuario denunciado.
 * @param string $respuesta_mensaje Mensaje de respuesta a la denuncia.
 * @return bool Retorna true si se registra correctamente, false en caso contrario.
 */
function respuesta_denuncia(int $id_denuncia, int $id_admin, int $id_usuario, String $respuesta_mensaje): bool
{
	global $conection;
	$estado = false;
	$id_denuncia = htmlspecialchars($id_denuncia, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
	$id_admin = htmlspecialchars($id_admin, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
	$id_usuario = htmlspecialchars($id_usuario, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
	$respuesta_mensaje = htmlspecialchars($respuesta_mensaje, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
	$fecha = date('Y-m-d H:i:s');
	$fecha_respuesta = date('Y-m-d H:i:s', strtotime(str_replace('-', '/', $fecha)));
	try {
		$consulta = $conection->prepare("INSERT INTO denuncias_usuarios_respuestas(id_denuncia_motivo,id_admin,id_usuario,respuesta_denuncia,fecha_respuesta) VALUES (?,?,?,?,?)");
		if ($consulta->execute(array($id_denuncia, $id_admin, $id_usuario, $respuesta_mensaje, $fecha_respuesta))) {
			$estado = true;
		}
	} catch (PDOException $e) {
		echo "Error: " . $e->getMessage();
	}
	return $estado;
}

/**
 * Obtiene información de una denuncia de usuario.
 *
 * @param int $id_denuncia ID de la denuncia.
 * @return array Retorna un array con los datos de la denuncia.
 */
function obtener_denuncias_usuarios(int $id_denuncia): array
{
	global $conection;
	try {
		$consulta = $conection->prepare("SELECT * FROM denuncias_usuarios WHERE id_denuncia = ?");
		$consulta->execute(array($id_denuncia));
		$resultados = $consulta->fetchAll(PDO::FETCH_ASSOC);
	} catch (PDOException $e) {
		echo "Error: " . $e->getMessage();
	}
	return $resultados;
}

/**
 * Obtiene el número total de denuncias de usuarios.
 *
 * @return int Retorna el número total de denuncias de usuarios.
 */
function obtener_numero_denuncias_usuarios(): int
{
	global $conection;
	try {
		$consulta = $conection->prepare("SELECT COUNT(*) FROM denuncias_usuarios");
		$consulta->execute();
		$numero_denuncias = $consulta->fetchColumn();
	} catch (PDOException $e) {
		echo "Error: " . $e->getMessage();
	}
	return $numero_denuncias;
}

/**
 * Elimina un comentario de la página.
 *
 * @param int $id_comentario El ID del comentario a eliminar.
 * @return bool Retorna true si se elimina el comentario correctamente, false en caso contrario.
 */
function eliminar_comentario_pagina($id_comentario): bool
{
	global $conection;
	$estado = false;
	$id_comentario = htmlspecialchars($id_comentario, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
	try {
		$consulta = $conection->prepare("DELETE FROM opiniones_pagina WHERE id_opinion = ?");
		if ($consulta->execute([$id_comentario])) {
			$estado = true;
		}
	} catch (PDOException $e) {
		echo "Error: " . $e->getMessage();
	}
	return $estado;
}

/**
 * Elimina un comentario de un cómic.
 *
 * @param int $id_comentario El ID del comentario a eliminar.
 * @return bool Retorna true si se elimina el comentario correctamente, false en caso contrario.
 */
function eliminar_comentario_comic($id_comentario): bool
{
	global $conection;
	$estado = false;
	$id_comentario = htmlspecialchars($id_comentario, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
	try {
		$consulta = $conection->prepare("DELETE FROM opiniones_comics WHERE id_opinion = ?");
		if ($consulta->execute([$id_comentario])) {
			$estado = true;
		}
	} catch (PDOException $e) {
		echo "Error: " . $e->getMessage();
	}
	return $estado;
}

/**
 * Elimina un cómic.
 *
 * @param int $id_comic El ID del cómic a eliminar.
 * @return bool Retorna true si se elimina el cómic correctamente, false en caso contrario.
 */
function eliminar_comic($id_comic): bool
{
	global $conection;
	$estado = false;
	$id_comic = htmlspecialchars($id_comic, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
	try {
		$consulta = $conection->prepare("DELETE FROM comics WHERE IDcomic = ?");
		if ($consulta->execute([$id_comic])) {
			$estado = true;
		}
	} catch (PDOException $e) {
		echo "Error: " . $e->getMessage();
	}
	return $estado;
}

/**
 * Comprueba si un código de activación existe en la base de datos.
 *
 * @param string $codigo El código de activación a comprobar.
 * @return bool Retorna true si el código de activación existe en la base de datos, false en caso contrario.
 */
function comprobar_codigo_alta(String $codigo): bool
{
	global $conection;
	$estado = false;
	$codigo = htmlspecialchars($codigo, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
	try {
		$consulta = $conection->prepare("SELECT userName FROM users WHERE id_activacion = ?");
		if ($consulta->execute([$codigo])) {
			$resultados = $consulta->fetchAll(PDO::FETCH_ASSOC);
			if (count($resultados) > 0) {
				$estado = true;
				activar_usuario($codigo);
				eliminar_codigo($codigo);
			}
		}
	} catch (PDOException $e) {
		echo "Error: " . $e->getMessage();
	}
	return $estado;
}

/**
 * Activa la cuenta de un usuario en la base de datos.
 *
 * @param string $codigo El código de activación asociado a la cuenta del usuario.
 * @return bool Retorna true si se activa la cuenta correctamente, false en caso contrario.
 */
function activar_usuario(String $codigo): bool
{
	global $conection;
	$estado = false;
	$codigo = htmlspecialchars($codigo, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
	try {
		$consulta = $conection->prepare("UPDATE users SET cuenta_activada = 1 WHERE id_activacion = ?");
		if ($consulta->execute([$codigo])) {
			$estado = true;
		}
	} catch (PDOException $e) {
		echo "Error: " . $e->getMessage();
	}
	return $estado;
}

/**
 * Elimina un código de activación de la base de datos.
 *
 * @param string $codigo El código de activación a eliminar.
 * @return bool Retorna true si se elimina el código correctamente, false en caso contrario.
 */
function eliminar_codigo(String $codigo): bool
{
	global $conection;
	$estado = false;
	$codigo = htmlspecialchars($codigo, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
	try {
		$consulta = $conection->prepare("UPDATE users SET id_activacion = NULL WHERE id_activacion = ?");
		if ($consulta->execute([$codigo])) {
			$estado = true;
		}
	} catch (PDOException $e) {
		echo "Error: " . $e->getMessage();
	}
	return $estado;
}

/**
 * Envía un correo de activación de cuenta al usuario registrado.
 *
 * @param string $email_registro El correo electrónico del usuario registrado.
 * @param string $id_unico El identificador único para la activación de la cuenta.
 * @return string Retorna true si el correo se envía correctamente, false en caso contrario.
 */
function enviar_correo_activacion(String $email_registro, String $id_unico): string
{
	$subject = "Nuevo usuario. Activacion de cuenta"; // Asunto del correo
	$message = "Haga clic en el siguiente enlace para activar su cuenta: https://comicweb.es/activacion_usuario.php?codigo_v=" . $id_unico;
	$message .= " Gracias por unirse a nuestro sitio web. ¡Esperamos que disfrute de su experiencia de usuario!";
	$headers = "From: informacion@comicweb.es"; // Dirección de correo electrónico del remitente
	return mail($email_registro, $subject, $message, $headers); // Envía el correo electrónico y devuelve el resultado (true o false)
}

/**
 * Envía un correo de restauración de contraseña al usuario.
 *
 * @param string $email_registro El correo electrónico del usuario.
 * @param string $id_unico El identificador único para la restauración de contraseña.
 * @return string Retorna true si el correo se envía correctamente, false en caso contrario.
 */
function enviar_pass_activacion(String $email_registro, String $id_unico): string
{
	$subject = "Nuevo usuario. Restaurar cuenta"; // Asunto del correo
	$message = "Haga clic en el siguiente enlace para crear una nueva contraseña su cuenta: https://comicweb.es/activacion_password.php?id_activacion=" . $id_unico;
	$message .= " Gracias por unirse a nuestro sitio web. ¡Esperamos que disfrute de su experiencia de usuario!";
	$headers = "From: informacion@comicweb.es"; // Dirección de correo electrónico del remitente
	return mail($email_registro, $subject, $message, $headers); // Envía el correo electrónico y devuelve el resultado (true o false)
}

/**
 * Envía una solicitud de restauración de contraseña al usuario.
 *
 * @param string $email El correo electrónico del usuario.
 * @return bool Retorna true si se realiza la solicitud correctamente, false en caso contrario.
 */
function solicitud_password(String $email): bool
{
	global $conection;
	$estado = false;
	$email = htmlspecialchars($email, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
	try {
		$consulta = $conection->prepare("SELECT IDuser FROM users WHERE email = ?");
		if ($consulta->execute([$email])) {
			$resultados = $consulta->fetchAll(PDO::FETCH_ASSOC);
			if (count($resultados) > 0) {
				$id_unico = uniqid();
				$consulta = $conection->prepare("UPDATE users SET id_activacion = ? WHERE email = ?");
				if ($consulta->execute([$id_unico, $email])) {
					enviar_pass_activacion($email, $id_unico);
					$estado = true;
				}
			}
		}
	} catch (PDOException $e) {
		echo "Error: " . $e->getMessage();
	}
	return $estado;
}

/**
 * Actualiza la contraseña de un usuario utilizando el código de activación.
 *
 * @param string $id_activacion El código de activación del usuario.
 * @param string $password La nueva contraseña del usuario.
 * @return bool Retorna true si se actualiza la contraseña correctamente, false en caso contrario.
 */
function actualizar_password(string $id_activacion, string $password): bool
{
	global $conection;
	$estado = false;
	$id_activacion = htmlspecialchars($id_activacion, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
	$password_hash = htmlspecialchars($password, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
	try {
		$consulta = $conection->prepare("UPDATE users SET password = ? WHERE id_activacion = ?");
		if ($consulta->execute([$password_hash, $id_activacion])) {
			$estado = true;
		}
	} catch (PDOException $e) {
		echo "Error: " . $e->getMessage();
	}
	return $estado;
}

/**
 * Verifica si un usuario es propietario de una lista de comics.
 *
 * @param int $id_usuario El ID del usuario.
 * @param int $id_lista El ID de la lista de comics.
 * @return bool Retorna true si el usuario es propietario de la lista, false en caso contrario.
 */
function comprobar_propiedad_lista(int $id_usuario, int $id_lista): bool
{
	global $conection;
	$estado = false;
	$id_usuario = htmlspecialchars($id_usuario, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
	$id_lista = htmlspecialchars($id_lista, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');

	try {
		$consulta = $conection->prepare("SELECT id_user from lista_comics where id_lista = ? and id_user = ?");
		if ($consulta->execute([$id_lista, $id_usuario])) {
			$resultados = $consulta->fetchAll(PDO::FETCH_ASSOC);
			if (count($resultados) > 0) {
				$estado = true;
			}
		}
	} catch (PDOException $e) {
		echo "Error: " . $e->getMessage();
	}
	return $estado;
}
