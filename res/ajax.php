<?php

require_once("def.php");

$idUser = $_SESSION['login_session_' . Registry::getDomainName()]["data"]["id_user"];
if ($idUser) {
	$dbUser = dbUser::getById($idUser);
}

Cache::flush();
$mode = $_REQUEST["mode"];
if (file_exists("./ajax/" . $mode . ".php")) {
	require "./ajax/" . $mode . ".php";
} else {
	throw new Exception("Ajax modul " . $mode . " nenalezen");
}
?>