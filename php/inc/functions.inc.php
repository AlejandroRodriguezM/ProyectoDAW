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

function checkCookiesAdmin()
{
	if (!isset($_SESSION['email']) || !isset($_COOKIE['loginUser']) || !isset($_COOKIE['adminUser']) || !isset($_COOKIE['passwordAdmin'])) {
		echo '<script type="text/JavaScript"> 
		localStorage.clear();
     </script>';
		die("Error. You are not the administrator. Talk to the administrator if you have more problems <a href='logOut.php'>Log in</a>");
	} elseif (checkStatus($_SESSION['email'])) {
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

	if (isset($_COOKIE['adminUser']) || isset($_COOKIE['passwordAdmin'])) {
		setcookie('adminUser', '', time() - 3600, '/');
		setcookie('passwordAdmin', '', time() - 3600, '/');
	}
	setcookie('loginUser', '', time() - 3600, '/');
	setcookie('passwordUser', '', time() - 3600, '/');
	destroyCookiesUserTemporal();
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
	return "<img src='$profilePicture' id='avatar' alt='Avatar' class='avatarPicture'>";
}
