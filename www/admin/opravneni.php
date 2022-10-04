<?php

//$ACL = new Class_Acl($DB, "s3n_");

$roleId = isset($par_3) && is_numeric($par_3) ? $par_3 : 'null';
$vsechnyRole = $ACL->vratVsechnyRole();
$systemoveZdroje = $ACL->vratZdrojePodleTypu('system');
$contentZdroje = $ACL->vratZdrojePodleTypu('content');

$SMARTY->assign("roleId", $roleId);
$SMARTY->assign("systemoveZdroje", $systemoveZdroje);
$SMARTY->assign("contentZdroje", $contentZdroje);
$SMARTY->assign("vsechnyRole", $vsechnyRole);

?>