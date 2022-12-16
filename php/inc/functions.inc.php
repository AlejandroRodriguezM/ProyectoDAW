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

function createCookies($email, $password)
{
    if (checkUser($email, $password)) {
        setcookie('loginUser', $email, time() + 3600, '/');
        setcookie('passwordUser', $password, time() + 3600, '/');
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
	setcookie('loginUser', '', time() - 3600, '/');
	setcookie('passwordUser', '', time() - 3600, '/');
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
		"xp_filelist", "xp_cmdshell", "xp_regread", "xp_regwrite", "xp_fileexist", "xp_dirtree", "xp_filelist", "withdrawal", "receipt return"
	);
	return $palabras;
}

?>
