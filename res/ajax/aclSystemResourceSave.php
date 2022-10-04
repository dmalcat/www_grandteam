<?php

require_once('../res/def.php');
//$ACL = new Class_Acl($DB, "s3n_");



$resourceId = $_POST['resourceId'];
$roleId = $_POST['roleId'];
$checked = $_POST['checked'];
if($checked == "true" || $checked == "checked") {
	$checked = true;
} else {
	$checked = false;
}
//$checked = $checked == 'true' ? true : false;

$ACL->ulozitSystemOpravneni($resourceId, $roleId, $checked);
?>
