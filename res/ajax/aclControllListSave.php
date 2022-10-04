<?php

require_once('../res/def.php');
//$ACL = new Class_Acl($DB, "s3n_");

$contentId = $_POST['contentId'];
$resourceId = $_POST['resourceId'];
$roleId = $_POST['roleId'];
$checked = $_POST['checked'];
//$checked = $checked == 'true' ? true : false;
if($checked == "true" || $checked == "checked") {
	$checked = true;
} else {
	$checked = false;
}

$ACL->ulozitContentOpravneni($resourceId, $roleId, $contentId, $checked);
?>
