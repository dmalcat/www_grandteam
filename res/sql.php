<?php

//	$namespace = Registry::getConfig()->database->namespace;
//	$configArray = Registry::getConfig()->database->{$namespace}->toArray();
//	print_p($configArray);
//	define('SYS_DATABASE', 			$configArray['driver'] .  '://'.$configArray['username'].':'.$configArray['password'].'@'.$configArray['host'].'/'.$configArray['database']); // connection string do DB

require_once("DB.php"); // PEAR
// zalozeni connection na DB
$DB = & DB::connect($configArray['driver'] . '://' . $configArray['username'] . ':' . $configArray['password'] . '@' . $configArray['host'] . '/' . $configArray['database']);
//print_p($configArray);
if (PEAR::isError($DB)) {
	//die($DB->toString());
	$ERROR->Spawn("DBConnect", 1, Error::INTERNALERROR, 2, $DB->getMessage());
}

// vseobecne uzitecne nastaveni
$DB->setFetchMode(DB_FETCHMODE_ASSOC);
$DB->query("SET names 'utf8'");
//$DB->query("SET names 'ISO-8859-2'");

if (PEAR::isError($DB)) {
	//die($DB->toString());
	$ERROR->Spawn("DBInit", 1, Error::INTERNALERROR, 2, $DB->getMessage());
}
?>
