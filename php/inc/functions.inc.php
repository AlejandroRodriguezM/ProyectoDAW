<?php

function errorLogin($email_userName, $password_user)
{
	$error = '';
	if (empty($email_userName)) {
		$error = "<div class='alert alert-danger'>Error. You must fill the user name/email.</div>";
	}
	if (empty($password_user)) {
		$error = "<div class='alert alert-danger'>Error. You must fill the password </div>";
	}
	return $error;
}

// function cookiesUser($email, $password)
// {
// 	setcookie('loginUser', $email, time() + 3600, '/');
// 	setcookie('passwordUser', $password, time() + 3600, '/');
// }

// function destroyCookiesUser()
// {
// 	setcookie('loginUser', '', time() - 3600, '/');
// 	setcookie('passwordUser', '', time() - 3600, '/');
// }

// function cookiesUserTemporal($email, $password, $id)
// {
// 	setcookie('loginUserTemp', $email, time() + 3600, '/');
// 	setcookie('passwordUserTemp', $password, time() + 3600, '/');
// 	setcookie('idTemp', $id, time() + 3600, '/');
// }

// function destroyCookiesUserTemporal()
// {
// 	setcookie('loginUserTemp', '', time() - 3600, '/');
// 	setcookie('passwordUserTemp', '', time() - 3600, '/');
// 	setcookie('idTemp', '', time() - 3600, '/');
// }

// function cookiesAdmin($email, $password)
// {
// 	setcookie('adminUser', $email, time() + 3600, '/');
// 	setcookie('passwordAdmin', $password, time() + 3600, '/');
// }


function check_session_admin(String $email)
{
	if (obtener_privilegio($email)) {
		if (obtener_privilegio($email) == 'user') {
			echo '<script type="text/JavaScript"> 
			localStorage.clear();
			 </script>';
			die("Error. You are not the administrator. Talk to the administrator if you have more problems <a href='logOut.php'>Log in</a>");
		}
	} else {
		echo '<script type="text/JavaScript"> 
		localStorage.clear();
		 </script>';
		die("Error. You are not the administrator. Talk to the administrator if you have more problems <a href='logOut.php'>Log in</a>");
	}
}

// function checkCookiesUser()
// {
// 	if (!isset($_SESSION['email']) || !isset($_COOKIE['loginUser'])) {
// 		echo '<script type="text/JavaScript"> 
// 		localStorage.clear();
//      </script>';
// 		die("Error. You are not logged <a href='logOut.php'>Log in</a>");
// 	} elseif (checkStatus($_SESSION['email'])) {
// 		echo '<script type="text/JavaScript"> 
// 		localStorage.clear();
// 	 </script>';
// 		$data_usuario_bloqueado = obtener_datos_usuario($_SESSION['email']);
// 		$id_user = $data_usuario_bloqueado['IDuser'];
// 		$asunto_ticket = 'Usuario bloqueado';
// 		$descripcion_ticket = 'El usuario ' . $data_usuario_bloqueado['userName'] .  ' con el email ' . $data_usuario_bloqueado['email'] . ' ha intentado acceder a la pagina y ha sido bloqueado.';
// 		$fecha = date("Y-m-d H:i:s");
// 		$estado = 'abierto';
// 		new_ticket($id_user, $asunto_ticket, $descripcion_ticket, $fecha, $estado);
// 		die("Error. You are block <a href='logOut.php'>Log in</a>");
// 	}
// }


// function deleteCookies()
// {
// 	session_start();
// 	session_destroy();

// 	echo '<script type="text/JavaScript">
// 	localStorage.clear();
// 	</script>';

// 	destroyCookiesUser();
// 	destroyCookiesUserTemporal();
// }

/**
 * Function that is used to check that reserved words cannot be saved
 *
 * @return array
 */
function reservedWords()
{
	$palabras = array(
		"select", "insert", "update", "delete", "drop", "alter", "create", "table", "from", "where",
		"and", "or", "not", "like", "in", "between", "is", "null", "asc", "desc", "into", "values", "set", "show",
		"database", "databases", "use", "grant", "revoke", "index", "primary", "key", "foreign", "references", "on",
		"order", "by", "group", "having", "limit", "union", "all", "distinct", "case", "when", "then", "else", "end",
		"count", "sum", "avg", "min", "max", "top", "union", "all", "distinct", "case", "when", "then", "else", "end",
		"count", "sum", "avg", "min", "max", "top", "truncate", "procedure", "function", "declare", "exec", "xp_cmdshell",
		"sp_", "sysobjects", "syscolumns", "sysusers", "sysindexes", "sysconstraints", "syscomments", "sysdepends",
		"sysfiles", "sysgroups", "sysprocesses", "sysprotects", "sysservers", "sysstatistics", "sysviews", "syssegments",
		"sysalternates", "sysconfigures", "sysdepends", "sysfilegroups", "sysfiles1", "sysfiles2", "sysforeignkeys",
		"sysfulltextcatalogs", "sysfulltextnotify", "sysindexes", "sysindexkeys", "sysmembers", "sysobjects", "syspermissions",
		"sysproperties", "sysreferences", "syssegments", "syssubsystems", "systypes", "sysusers", "sysxmlindexes", "sysxmlnodes",
		"sysxmlschemas", "sysxmltypes", "syscolumns", "syscomments", "sysdepends", "sysfiles", "sysfiles1", "sysfiles2",
		"sysfulltextcatalogs", "sysfulltextnotify", "sysindexes", "sysindexkeys", "sysmembers", "sysobjects", "syspermissions",
		"sysproperties", "sysreferences", "syssegments", "syssubsystems", "systypes", "sysxmlindexes", "sysxmlnodes", "sysxmlschemas",
		"sysxmltypes", "xp_cmdshell", "xp_regread", "xp_regwrite", "xp_fileexist", "xp_dirtree", "xp_filelist", "xp_cmdshell",
		"xp_regread", "xp_regwrite", "xp_fileexist", "xp_dirtree", "xp_filelist", "xp_cmdshell", "xp_regread", "xp_regwrite",
		"xp_fileexist", "xp_dirtree", "xp_filelist", "xp_cmdshell", "xp_regread", "xp_regwrite", "xp_fileexist", "xp_dirtree",
		"xp_filelist", "xp_cmdshell", "xp_regread", "xp_regwrite", "xp_fileexist", "xp_dirtree", "xp_filelist", "xp_cmdshell",
		"xp_regread", "xp_regwrite", "xp_fileexist", "xp_dirtree", "xp_filelist", "xp_cmdshell", "xp_regread", "xp_regwrite",
		"xp_fileexist", "xp_dirtree", "xp_filelist", "xp_cmdshell", "xp_regread", "xp_regwrite", "xp_fileexist", "xp_dirtree",
		"xp_filelist", "xp_cmdshell", "xp_regread", "xp_regwrite", "xp_fileexist", "xp_dirtree", "xp_filelist", "xp_cmdshell",
		"xp_regread", "xp_regwrite", "xp_fileexist", "xp_dirtree", "xp_filelist", "xp_cmdshell", "xp_regread", "xp_regwrite",
		"xp_fileexist", "xp_dirtree", "xp_filelist", "xp_cmdshell", "xp_regread", "xp_regwrite", "xp_fileexist", "xp_dirtree",
		"xp_filelist", "xp_cmdshell", "xp_regread", "xp_regwrite", "xp_fileexist", "xp_dirtree", "xp_filelist", 'null'
	);
	return $palabras;
}

function saveImage($email, $idUser)
{
	$email = explode("@", $email);
	$email = $email[0];
	$image = $_POST['userPicture'];

	if (empty($image)) {
		$pathDefault = '../../assets/pictureProfile/default/default.jpg';
		$type = pathinfo($pathDefault, PATHINFO_EXTENSION);
		$data = file_get_contents($pathDefault);
		$image = 'data:image/' . $type . ';base64,' . base64_encode($data);
	} else {
		$image = $_POST['userPicture'];
	}
	$file_path = '../../assets/pictureProfile/' . $idUser . "-" . $email;
	$blob = base64_decode(preg_replace('#^data:image/\w+;base64,#i', '', $image));
	$file = fopen($file_path . "/profile.jpg", "w");
	fwrite($file, $blob);
	fclose($file);
}

function updateSaveImage($email, $image)
{
	$dataUser = obtener_datos_usuario($email);
	$newImage = $_POST['userPicture'];
	$idUser = $dataUser['IDuser'];
	$email = explode("@", $email);
	$email = $email[0];
	if (empty($newImage)) {
		$pathDefault = '../../' . $image;
		$type = pathinfo($pathDefault, PATHINFO_EXTENSION);
		$data = file_get_contents($pathDefault);
		$image = 'data:image/' . $type . ';base64,' . base64_encode($data);
	}
	$file_path = '../../assets/pictureProfile/' . $idUser . "-" . $email;
	$blob = base64_decode(preg_replace('#^data:image/\w+;base64,#i', '', $image));
	$file = fopen($file_path . "/profile.jpg", "w");
	fwrite($file, $blob);
	fclose($file);
}

function portadas_peticiones($image, $id_comic_peticion)
{
	$file_path = '../../assets/covers_img_peticiones';
	$blob = base64_decode(preg_replace('#^data:image/\w+;base64,#i', '', $image));
	$file = fopen($file_path . "/" . $id_comic_peticion . ".jpg", "w");
	fwrite($file, $blob);
	fclose($file);
}

function portadas_confirmadas($image, $id_comic_peticion, $id_comic)
{
	$nueva_imagen = $_POST['portada_comic'];
	if (empty($nueva_imagen)) {
		$pathDefault = '../../assets/covers_img_peticiones/ ' . $id_comic_peticion . 'jpg';
		$type = pathinfo($pathDefault, PATHINFO_EXTENSION);
		$data = file_get_contents($pathDefault);
		$image = 'data:image/' . $type . ';base64,' . base64_encode($data);
	}
	$file_path = '../../assets/covers_img';
	$blob = base64_decode(preg_replace('#^data:image/\w+;base64,#i', '', $image));
	$file = fopen($file_path . "/" . $id_comic . ".jpg", "w");
	fwrite($file, $blob);
	fclose($file);
}

function createDirectory($email, $idUser)
{
	$email = explode("@", $email);
	$email = $email[0];
	$file_path = '../../assets/pictureProfile/' . $idUser . "-" . $email;
	if (!file_exists($file_path)) {
		mkdir($file_path, 0777, true);
	}
}

function deleteDirectory($email, $idUser)
{
	$email = explode("@", $email);
	$email = $email[0];
	$file_path = '../../assets/pictureProfile/' . $idUser . "-" . $email;
	if (file_exists($file_path)) {
		$files = glob($file_path . '/*');
		foreach ($files as $file) {
			if (is_file($file))
				unlink($file);
		}
		rmdir($file_path);
	}
}

function eliminar_portada($id_comic)
{

	$file_path = '../../assets/covers_img_peticiones/' . $id_comic . ".jpg";
	if (file_exists($file_path)) {
		unlink($file_path);
	}
}

function pictureProfile($email)
{
	$dataUser = obtener_datos_usuario($email);
	$profilePicture = $dataUser['userPicture'];
	return $profilePicture;
}

function getScreenwriters()
{
	$table = get_comics();
	$screenwriters = array();
	foreach ($table as $row) {
		$names = preg_split("/[-,]+/", $row["nomGuionista"]);
		foreach ($names as $name) {
			$name = trim($name);
			if (!isset($screenwriters[$name])) {
				$screenwriters[$name] = 0;
			}
			$screenwriters[$name]++;
		}
	}
	return $screenwriters;
}



function getArtists()
{
	$table = get_comics();
	$artists = array();
	foreach ($table as $row) {
		$names = preg_split("/[-,]+/", $row["nomDibujante"]);
		foreach ($names as $name) {
			$name = trim($name);
			if (!isset($artists[$name])) {
				$artists[$name] = 0;
			}
			$artists[$name]++;
		}
	}
	return $artists;
}

function getEditorial()
{
	$table = get_comics();
	$editorial = array();
	foreach ($table as $row) {
		$names = preg_split("/[-,]+/", $row["nomEditorial"]);
		foreach ($names as $name) {
			$name = trim($name);
			if (!isset($editorial[$name])) {
				$editorial[$name] = 0;
			}
			$editorial[$name]++;
		}
	}
	return $editorial;
}

function getPortadas()
{
	$table = get_comics();
	$editorial = array();
	foreach ($table as $row) {
		$names = preg_split("/[-,]+/", $row["nomVariante"]);
		foreach ($names as $name) {
			$name = trim($name);
			if (!isset($editorial[$name])) {
				$editorial[$name] = 0;
			}
			$editorial[$name]++;
		}
	}
	return $editorial;
}

function getScreenwriters_user($id_user)
{
	global $conection;
	$consulta = $conection->prepare("SELECT comics_guardados.*, comics.* 
	FROM comics_guardados, comics
	WHERE comics_guardados.user_id=? AND comics_guardados.comic_id=comics.IDcomic AND comics.nomGuionista IS NOT NULL");
	$consulta->execute(array($id_user));
	$comics = $consulta->fetchAll(PDO::FETCH_ASSOC);

	$screenwriters = array();
	foreach ($comics as $row) {
		$names = preg_split("/[-,]+/", $row["nomGuionista"]);
		foreach ($names as $name) {
			$name = trim($name);
			if (!isset($screenwriters[$name])) {
				$screenwriters[$name] = 0;
			}
			$screenwriters[$name]++;
		}
	}
	return $screenwriters;
}

function getArtists_user($id_user)
{
	global $conection;
	$consulta = $conection->prepare("SELECT comics_guardados.*, comics.* 
	FROM comics_guardados, comics
	WHERE comics_guardados.user_id=? AND comics_guardados.comic_id=comics.IDcomic AND comics.nomDibujante IS NOT NULL");
	$consulta->execute(array($id_user));
	$comics = $consulta->fetchAll(PDO::FETCH_ASSOC);

	$artists = array();
	foreach ($comics as $row) {
		$names = preg_split("/[-,]+/", $row["nomDibujante"]);
		foreach ($names as $name) {
			$name = trim($name);
			if (!isset($artists[$name])) {
				$artists[$name] = 0;
			}
			$artists[$name]++;
		}
	}
	return $artists;
}

function getEditorial_user($id_user)
{
	global $conection;
	$consulta = $conection->prepare("SELECT comics_guardados.*, comics.* 
	FROM comics_guardados, comics
	WHERE comics_guardados.user_id=? AND comics_guardados.comic_id=comics.IDcomic AND comics.nomEditorial IS NOT NULL");
	$consulta->execute(array($id_user));
	$comics = $consulta->fetchAll(PDO::FETCH_ASSOC);

	$editorial = array();
	foreach ($comics as $row) {
		$names = preg_split("/[-,]+/", $row["nomEditorial"]);
		foreach ($names as $name) {
			$name = trim($name);
			if (!isset($editorial[$name])) {
				$editorial[$name] = 0;
			}
			$editorial[$name]++;
		}
	}
	return $editorial;
}

function getPortadas_user($id_user)
{
	global $conection;
	$consulta = $conection->prepare("SELECT comics_guardados.*, comics.* 
	FROM comics_guardados, comics
	WHERE comics_guardados.user_id=? AND comics_guardados.comic_id=comics.IDcomic AND comics.nomVariante IS NOT NULL");
	$consulta->execute(array($id_user));
	$comics = $consulta->fetchAll(PDO::FETCH_ASSOC);

	$portadas = array();
	foreach ($comics as $row) {
		$names = preg_split("/[-,]+/", $row["nomVariante"]);
		foreach ($names as $name) {
			$name = trim($name);
			if (!isset($editorial[$name])) {
				$portadas[$name] = 0;
			}
			$portadas[$name]++;
		}
	}
	return $portadas;
}

function getScreenwriters_lista($id_lista)
{
	global $conection;
	$consulta = $conection->prepare("SELECT contenido_listas.*, comics.* 
	FROM contenido_listas, comics
	WHERE contenido_listas.id_lista=? AND contenido_listas.id_comic=comics.IDcomic AND comics.nomGuionista IS NOT NULL");
	$consulta->execute(array($id_lista));
	$comics = $consulta->fetchAll(PDO::FETCH_ASSOC);

	$screenwriters = array();
	foreach ($comics as $row) {
		$names = preg_split("/[-,]+/", $row["nomGuionista"]);
		foreach ($names as $name) {
			$name = trim($name);
			if (!isset($screenwriters[$name])) {
				$screenwriters[$name] = 0;
			}
			$screenwriters[$name]++;
		}
	}
	return $screenwriters;
}

function getArtists_lista($id_lista)
{
	global $conection;
	$consulta = $conection->prepare("SELECT contenido_listas.*, comics.* 
	FROM contenido_listas, comics
	WHERE contenido_listas.id_lista=? AND contenido_listas.id_comic=comics.IDcomic AND comics.nomDibujante IS NOT NULL");
	$consulta->execute(array($id_lista));
	$comics = $consulta->fetchAll(PDO::FETCH_ASSOC);

	$artists = array();
	foreach ($comics as $row) {
		$names = preg_split("/[-,]+/", $row["nomDibujante"]);
		foreach ($names as $name) {
			$name = trim($name);
			if (!isset($artists[$name])) {
				$artists[$name] = 0;
			}
			$artists[$name]++;
		}
	}
	return $artists;
}

function getEditorial_lista($id_lista)
{
	global $conection;
	$consulta = $conection->prepare("SELECT contenido_listas.*, comics.* 
	FROM contenido_listas, comics
	WHERE contenido_listas.id_lista=? AND contenido_listas.id_comic=comics.IDcomic AND comics.nomEditorial IS NOT NULL");
	$consulta->execute(array($id_lista));
	$comics = $consulta->fetchAll(PDO::FETCH_ASSOC);

	$editorial = array();
	foreach ($comics as $row) {
		$names = preg_split("/[-,]+/", $row["nomEditorial"]);
		foreach ($names as $name) {
			$name = trim($name);
			if (!isset($editorial[$name])) {
				$editorial[$name] = 0;
			}
			$editorial[$name]++;
		}
	}
	return $editorial;
}

function getPortadas_lista($id_lista)
{
	global $conection;
	$consulta = $conection->prepare("SELECT contenido_listas.*, comics.* 
	FROM contenido_listas, comics
	WHERE contenido_listas.id_lista=? AND contenido_listas.id_comic=comics.IDcomic AND comics.nomVariante IS NOT NULL");
	$consulta->execute(array($id_lista));
	$comics = $consulta->fetchAll(PDO::FETCH_ASSOC);

	$portadas = array();
	foreach ($comics as $row) {
		$names = preg_split("/[-,]+/", $row["nomVariante"]);
		foreach ($names as $name) {
			$name = trim($name);
			if (!isset($editorial[$name])) {
				$portadas[$name] = 0;
			}
			$portadas[$name]++;
		}
	}
	return $portadas;
}

function copiar_imagen($id_comic, $id_comic_confirmado)
{
	$ruta_origen = '../../assets/covers_img_peticiones/' . $id_comic . '.jpg';
	$ruta_destino = '../../assets/covers_img/' . $id_comic_confirmado . '.jpg';
	$existe = false;
	if (file_exists($ruta_origen)) { // Verifica si la imagen existe en la ruta de origen
		if (copy($ruta_origen, $ruta_destino)) { // Copia la imagen a la ruta de destino
			$existe = true;
		}
	}
	return $existe;
}

function mostrar_datos($datos): void
{
	// Ordenar por clave
	ksort($datos);
	echo "<table class='custom-table'>
	<thead>
	<tr>
	</tr>
	</thead>
	<tbody>";

	// Iterar por los valores
	foreach ($datos as $key => $value) {
		echo "<tr>
		<td>$key</td>
	<td>
	<input type='checkbox' id='comic' name='comic' value='$key' onclick='handleCheckboxChange();'>
	<input type='hidden' name='comic_value' value='$key'>
	</td>
	</tr>";
	}

	echo "</tbody>
		</table>";
}


  

// function mostrar_datos($datos)
// {
//     $datos_comic = $datos;
//     ksort($datos_comic);
//     echo "<table class='custom-table'>
//         <thead>
//             <tr></tr>
//         </thead>
//         <tbody>";
//     foreach ($datos_comic as $key => $value) {
//         echo "<tr>
//             <td class='comic-cell' data-comic='$key'>$key</td>
//         </tr>";
//     }
//     echo "</tbody>
//         </table>";
//     echo "<input type='hidden' id='comic' name='comic' value=''>";
//     echo "<script>
//         document.addEventListener('DOMContentLoaded', () => {
//             const comicCells = document.querySelectorAll('.comic-cell');
//             comicCells.forEach(cell => {
//                 cell.addEventListener('click', () => {
//                     const key = cell.dataset.comic;
//                     document.getElementById('comic').value = key;
//                 });
//             });
//         });
//     </script>";
// }

// function update_cover_database(){
// 	global $conection;
// 	$max = 15278;

// 	$id = 9630;
// 	$contador = 0;
// 	$id_actual = $id + $contador;
// 	while($id_actual <= $max){
// 		$cover = "./assets/covers_img/$id_actual.jpg";
// 		$consulta = $conection->prepare("UPDATE comics SET cover=:cover WHERE IDcomic=:id");
// 		$consulta->bindParam(':cover', $cover, PDO::PARAM_STR);
// 		$consulta->bindParam(':id', $id_actual, PDO::PARAM_INT);
// 		$consulta->execute();
// 		$contador++;
// 		$id_actual = $id + $contador;
// 	}
// }