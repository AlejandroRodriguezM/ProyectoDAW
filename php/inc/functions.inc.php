<?php

/**
 * Verifica si la sesión actual pertenece a un administrador.
 *
 * @param string $email El correo electrónico del usuario.
 * @return void
 */
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

/**
 * Obtiene un array de palabras reservadas.
 *
 * @return array El array de palabras reservadas.
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

/**
 * Guarda la imagen de perfil del usuario.
 *
 * @param string $email El correo electrónico del usuario.
 * @param int $idUser El ID del usuario.
 */
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

/**
 * Actualiza y guarda la imagen de perfil del usuario.
 *
 * @param string $email El correo electrónico del usuario.
 * @param string $image La ruta de la imagen actual del usuario.
 */
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

/**
 * Guarda la imagen de portada de una petición de cómic.
 *
 * @param string $image La imagen de portada de la petición.
 * @param int $id_comic_peticion El ID de la petición de cómic.
 */
function portadas_peticiones($image, $id_comic_peticion)
{
	$file_path = '../../assets/covers_img_peticiones';
	$blob = base64_decode(preg_replace('#^data:image/\w+;base64,#i', '', $image));
	$file = fopen($file_path . "/" . $id_comic_peticion . ".jpg", "w");
	fwrite($file, $blob);
	fclose($file);
}

/**
 * Guarda la imagen de portada de un cómic confirmado.
 *
 * @param string $image La imagen de portada del cómic.
 * @param int $id_comic_peticion El ID de la petición de cómic.
 * @param int $id_comic El ID del cómic confirmado.
 */
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

/**
 * Crea un directorio para el perfil de un usuario.
 *
 * @param string $email El correo electrónico del usuario.
 * @param int $idUser El ID del usuario.
 */
function createDirectory($email, $idUser)
{
	$email = explode("@", $email);
	$email = $email[0];
	$file_path = '../../assets/pictureProfile/' . $idUser . "-" . $email;
	if (!file_exists($file_path)) {
		mkdir($file_path, 0777, true);
	}
}

/**
 * Elimina un directorio y todos sus archivos.
 *
 * @param string $email El correo electrónico del usuario.
 * @param int $idUser El ID del usuario.
 */
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

/**
 * Elimina una portada de cómic.
 *
 * @param int $id_comic El ID del cómic.
 */
function eliminar_portada($id_comic)
{
	$file_path = '../../assets/covers_img_peticiones/' . $id_comic . ".jpg";
	if (file_exists($file_path)) {
		unlink($file_path);
	}
}

/**
 * Obtiene la imagen de perfil de un usuario.
 *
 * @param string $email El correo electrónico del usuario.
 * @return string La ruta de la imagen de perfil.
 */
function pictureProfile($email)
{
	$dataUser = obtener_datos_usuario($email);
	$profilePicture = $dataUser['userPicture'];
	return $profilePicture;
}

/**
 * Obtiene los guionistas de los cómics.
 *
 * @return array Un arreglo asociativo donde las claves son los nombres de los guionistas
 *              y los valores son la cantidad de cómics asociados a cada guionista.
 */
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

/**
 * Obtiene los dibujantes de los cómics.
 *
 * @return array Un arreglo asociativo donde las claves son los nombres de los dibujantes
 *              y los valores son la cantidad de cómics asociados a cada dibujante.
 */
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

/**
 * Obtiene las editoriales de los cómics.
 *
 * @return array Un arreglo asociativo donde las claves son los nombres de las editoriales
 *              y los valores son la cantidad de cómics asociados a cada editorial.
 */
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

/**
 * Obtiene las portadas de los cómics 
 *
 * @return array Un arreglo asociativo donde las claves son los nombres de las portadas
 *              y los valores son la cantidad de cómics asociados a cada portada.
 */
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

/**
 * Obtiene los escritores de los cómics por un usuario específico.
 *
 * @return array Un arreglo asociativo donde las claves son los nombres de los escritores
 *              y los valores son la cantidad de cómics asociados a cada portada.
 */
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

/**
 * Obtiene los artistas de los cómics por un usuario específico.
 *
 * @return array Un arreglo asociativo donde las claves son los nombres de los artistas
 *              y los valores son la cantidad de cómics asociados a cada portada.
 */
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

/**
 * Obtiene las editoriales de los cómics por un usuario específico.
 *
 * @return array Un arreglo asociativo donde las claves son los nombres de las editoriales
 *              y los valores son la cantidad de cómics asociados a cada portada.
 */
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

/**
 * Obtiene las portadas de los cómics guardados por un usuario específico.
 *
 * @param int $id_user El ID del usuario.
 * @return array Un arreglo asociativo donde las claves son los nombres de las portadas
 *              y los valores son la cantidad de cómics asociados a cada portada.
 */
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

/**
 * Obtiene los guionistas de los cómics en una lista específica.
 *
 * @param int $id_lista El ID de la lista.
 * @return array Un arreglo asociativo donde las claves son los nombres de los guionistas
 *              y los valores son la cantidad de cómics asociados a cada guionista.
 */
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

/**
 * Obtiene los dibujantes de los cómics en una lista específica.
 *
 * @param int $id_lista El ID de la lista.
 * @return array Un arreglo asociativo donde las claves son los nombres de los dibujantes
 *              y los valores son la cantidad de cómics asociados a cada guionista.
 */
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

/**
 * Obtiene los guionistas de las editoriales en una lista específica.
 *
 * @param int $id_lista El ID de la lista.
 * @return array Un arreglo asociativo donde las claves son los nombres de las editoriales
 *              y los valores son la cantidad de cómics asociados a cada guionista.
 */
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

/**
 * Obtiene las portadas de los cómics en una lista específica.
 *
 * @param int $id_lista El ID de la lista.
 * @return array Un arreglo asociativo donde las claves son los nombres de las portadas
 *              y los valores son la cantidad de cómics asociados a cada guionista.
 */
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

/**
 * Copia una imagen de una ruta de origen a una ruta de destino.
 *
 * @param string $id_comic El ID del cómic en la ruta de origen.
 * @param string $id_comic_confirmado El ID del cómic en la ruta de destino.
 * @return bool Devuelve true si la imagen se copió correctamente, o false si ocurrió algún error.
 */
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
