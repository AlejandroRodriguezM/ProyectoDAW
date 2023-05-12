<?php

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

// function check_nombre_user(string $nombre): bool
// {
// 	global $conection;
// 	$existe = false;
// 	try {
// 		$consulta = $conection->prepare("SELECT IDcomic from users WHERE userName = ?");
// 		if ($consulta->execute(array($nombre))) {
// 			if ($consulta->fetchColumn() > 0) {
// 				$existe = true;
// 			}
// 		}
// 	} catch (PDOException $e) {
// 		die("Code: " . $e->getCode() . "\nMessage: " . $e->getMessage());
// 	}
// 	return $existe;
// }

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

function comprobar_activacion($userName)
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

function num_mensajes_usuario(int $id_usuario): int
{
	global $conection;
	$num_mensajes = 0;
	try {
		$consulta = $conection->prepare("SELECT id_conversacion as num_mensajes FROM nuevo_mensajes_usuarios WHERE id_usuario_destinatario = ? OR id_usuario_remitente = ?");
		$consulta->bindParam(1, $id_usuario);
		$consulta->bindParam(2, $id_usuario);
		if ($consulta->execute()) {
			if ($consulta->rowCount() > 0) {
				$resultado = $consulta->fetch(PDO::FETCH_ASSOC);
				$num_mensajes = $resultado['num_mensajes'];
			} else {
				$num_mensajes = 0;
			}
		}
	} catch (PDOException $e) {
		$error_Code = $e->getCode();
		$message = $e->getMessage();
		die("Code: " . $error_Code . "\nMessage: " . $message);
	}
	return $num_mensajes;
}

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

function datos_tickets()
{
	global $conection;
	$consulta = $conection->prepare("SELECT * FROM tickets");
	$consulta->execute();
	$consulta = $consulta->fetchAll(PDO::FETCH_ASSOC);
	return $consulta;
}

function datos_tickets_denuncias()
{
	global $conection;
	$consulta = $conection->prepare("SELECT * FROM denuncias_usuarios");
	$consulta->execute();
	$consulta = $consulta->fetchAll(PDO::FETCH_ASSOC);
	return $consulta;
}

function datos_conversacion_identificador(int $id_conversacion): array
{
	global $conection;
	$id_conversacion = htmlspecialchars($id_conversacion, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
	$consulta = $conection->prepare("SELECT * FROM respuestas_mensajes_usuarios WHERE id_respuesta_mensaje = ?");
	$consulta->bindParam(1, $id_conversacion);
	$consulta->execute();
	$resultados = $consulta->fetchAll(PDO::FETCH_ASSOC);
	$datos = array();
	foreach ($resultados as $resultado) {
		$datos[] = $resultado;
	}
	return $datos;
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

function get_conversacion(int $id_conversacion): array
{
	global $conection;
	$id_conversacion = htmlspecialchars($id_conversacion, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
	try {
		// $consulta = $conection->prepare("
		//     SELECT nm.id_mensaje, rm.id_respuesta_mensaje, nm.id_usuario_remitente, nm.id_usuario_destinatario, rm.mensaje_usuario, rm.fecha_envio_mensaje, rm.estado_mensaje, rm.mensaje_denunciado 
		//     FROM nuevo_mensajes_usuarios nm 
		//     LEFT JOIN respuestas_mensajes_usuarios rm 
		//     ON nm.id_mensaje = rm.id_mensaje 
		//     WHERE nm.id_usuario_remitente = ? OR nm.id_usuario_destinatario = ?
		//     ORDER BY rm.fecha_envio_mensaje ASC");

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
		$consulta = $conection->prepare("SELECT userName,tipo_perfil,userPicture from users WHERE userName LIKE ? OR email LIKE ? AND accountStatus = 'active' AND tipo_perfil = 'publico'");
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
		$consulta = $conection->prepare("INSERT INTO opiniones_comics(id_comic,id_usuario,opinion,puntuacion,fecha_comentario) VALUES (?,?,?,?,?)");
		if ($consulta->execute(array($id_comic, $id_user, $opinion, $puntuacion, date("Y-m-d")))) {
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
		$consulta = $conection->prepare("UPDATE users SET accountStatus = 'active' WHERE email = ? and accountStatus = 'inactive'");
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

function enviar_solicitud_descripcion_comic($id_comic, $descipcion_comic, $id_usuario)
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

function obtener_peticiones_nuevos_comics()
{
	global $conection;
	try {
		$consulta = $conection->prepare("SELECT * FROM peticiones_nuevos_comics");
		$consulta->execute();
		$resultados = $consulta->fetchAll(PDO::FETCH_ASSOC);
	} catch (PDOException $e) {
		echo "Error: " . $e->getMessage();
	}
	return $resultados;
}

function obtener_numero_peticiones_nuevos_comics()
{
	global $conection;
	try {
		$consulta = $conection->prepare("SELECT COUNT(*) FROM peticiones_nuevos_comics");
		$consulta->execute();
		$numero_peticiones = $consulta->fetchColumn();
	} catch (PDOException $e) {
		echo "Error: " . $e->getMessage();
	}
	return $numero_peticiones;
}

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

function nueva_denuncia($id_usuario_denunciado, $id_user_denunciante, $mensaje_usuario, $motivo_denuncia)
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

function obtener_denuncias_usuarios(int $id_denuncia)
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

function obtener_numero_denuncias_usuarios()
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

function eliminar_comentario_pagina($id_comentario)
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

function eliminar_comentario_comic($id_comentario)
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

function eliminar_comic($id_comic)
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

function comprobar_codigo_alta(String $codigo)
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
			}
		}
	} catch (PDOException $e) {
		echo "Error: " . $e->getMessage();
	}
	return $estado;
}

function activar_usuario(String $codigo)
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

function eliminar_codigo(String $codigo)
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

function enviar_correo_activacion($email_registro, $id_unico)
{
	$subject = "Nuevo usuario. Activacion de cuenta"; // Asunto del correo
	$message = "Haga clic en el siguiente enlace para activar su cuenta: https://comicweb.es/activacion_usuario.php?codigo_v=" . $id_unico;
	$message .= "Gracias por unirse a nuestro sitio web. ¡Esperamos que disfrute de su experiencia de usuario!";
	$headers = "From: informacion@comicweb.es"; // Dirección de correo electrónico del remitente
	return mail($email_registro, $subject, $message, $headers); // Envía el correo electrónico y devuelve el resultado (true o false)
}

function enviar_pass_activacion($email_registro, $id_unico)
{
	$subject = "Nuevo usuario. Restaurar cuenta"; // Asunto del correo
	$message = "Haga clic en el siguiente enlace para crear una nueva contraseña su cuenta: https://comicweb.es/activacion_password.php?id_activacion=" . $id_unico;
	$message .= "Gracias por unirse a nuestro sitio web. ¡Esperamos que disfrute de su experiencia de usuario!";
	$headers = "From: informacion@comicweb.es"; // Dirección de correo electrónico del remitente
	return mail($email_registro, $subject, $message, $headers); // Envía el correo electrónico y devuelve el resultado (true o false)
}

function solicitud_password($email)
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

function actualizar_password($id_activacion,$password){
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



function comprobar_propiedad_lista($id_usuario, $id_lista)
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
