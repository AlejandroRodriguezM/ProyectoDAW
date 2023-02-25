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

function cookiesUser($email, $password)
{
	setcookie('loginUser', $email, time() + 3600, '/');
	setcookie('passwordUser', $password, time() + 3600, '/');
}

function destroyCookiesUser()
{
	setcookie('loginUser', '', time() - 3600, '/');
	setcookie('passwordUser', '', time() - 3600, '/');
}

function cookiesGuest()
{
	$email = 'guest@webComics.com';
	$password = 'guest';
	setcookie('loginUser', $email, time() + 3600, '/');
	setcookie('passwordUser', $password, time() + 3600, '/');
}

function destroyCookiesGuest()
{
	setcookie('loginGuest', '', time() - 3600, '/');
	setcookie('passwordGuest', '', time() - 3600, '/');
}

function cookiesUserTemporal($email, $password, $id)
{
	setcookie('loginUserTemp', $email, time() + 3600, '/');
	setcookie('passwordUserTemp', $password, time() + 3600, '/');
	setcookie('idTemp', $id, time() + 3600, '/');
}

function destroyCookiesUserTemporal()
{
	setcookie('loginUserTemp', '', time() - 3600, '/');
	setcookie('passwordUserTemp', '', time() - 3600, '/');
	setcookie('idTemp', '', time() - 3600, '/');
}

function cookiesAdmin($email, $password)
{
	setcookie('adminUser', $email, time() + 3600, '/');
	setcookie('passwordAdmin', $password, time() + 3600, '/');
}

function destroyCookiesAdmin()
{
	setcookie('adminUser', '', time() - 3600, '/');
	setcookie('passwordAdmin', '', time() - 3600, '/');
}

function checkCookiesAdmin()
{
	if (!isset($_SESSION['email']) || !isset($_COOKIE['loginUser']) || !isset($_COOKIE['adminUser']) || !isset($_COOKIE['passwordAdmin'])) {
		echo '<script type="text/JavaScript"> 
		localStorage.clear();
     </script>';
		die("Error. You are not the administrator. Talk to the administrator if you have more problems <a href='logOut.php'>Log in</a>");
	} elseif (checkStatus($_COOKIE['adminUser'])) {
		echo '<script type="text/JavaScript"> 
		localStorage.clear();
	 </script>';
		die("Error. You are block <a href='logOut.php'>Log in</a>");
	}
}

function checkCookiesUser()
{
	if (!isset($_SESSION['email']) || !isset($_COOKIE['loginUser'])) {
		echo '<script type="text/JavaScript"> 
		localStorage.clear();
     </script>';
		die("Error. You are not logged <a href='logOut.php'>Log in</a>");
	} elseif (checkStatus($_SESSION['email'])) {
		echo '<script type="text/JavaScript"> 
		localStorage.clear();
	 </script>';
		die("Error. You are block <a href='logOut.php'>Log in</a>");
	}
}

/**
 * Log out and delete user and admin cookies
 *
 * @return void
 */
function deleteCookies()
{
	session_start();
	session_destroy();

	echo '<script type="text/JavaScript">
	localStorage.clear();
	</script>';

	destroyCookiesAdmin();
	destroyCookiesUser();
	destroyCookiesUserTemporal();
	destroyCookiesGuest();
}

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
		"xp_filelist", "xp_cmdshell", "xp_regread", "xp_regwrite", "xp_fileexist", "xp_dirtree", "xp_filelist"
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
	$dataUser = getUserData($email);
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

function pictureProfile($email)
{
	$dataUser = getUserData($email);
	$profilePicture = $dataUser['userPicture'];
	return $profilePicture;
}

function getScreenwriters()
{
	$table = get_comic();
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
	$table = get_comic();
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
	$table = get_comic();
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
	$table = get_comic();
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

function mostrar_datos($datos)
{
	ksort($datos);
	echo "<table class='custom-table'>
	<thead>
	<tr>
	</tr>
	</thead>
	<tbody>";

	foreach ($datos as $key => $value) {
		echo "<tr>
		<td>$key</td>
	<td>
	<input type='checkbox' id='comic' name='comic' value='$key'>
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

function select_data_and_check_spaces_pdo()
{
	try {
		global $conection;
		// Select all data from the table
		$stmt = $conection->prepare("SELECT * FROM comics");
		$stmt->execute();

		// Fetch all the rows into an array
		$data = $stmt->fetchAll(PDO::FETCH_ASSOC);

		// Check if the first character of each string in the data is a space
		foreach ($data as $row) {
			foreach ($row as $value) {
				if (is_string($value) && strpos($value, ' ') !== false) {
					$id = $row['IDcomic'];

					echo "Found a string starting with a space: $value\n " . ":$id ;";
				}
			}
		}
	} catch (PDOException $e) {
		echo "Error: " . $e->getMessage();
	}

	// Close the connection
	$conection = null;
}
