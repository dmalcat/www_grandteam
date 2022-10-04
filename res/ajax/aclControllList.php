<?php

require_once('../res/def.php');
//$ACL = new Class_Acl($DB, "s3n_");

$contentId = $_POST['contentId'];
$resourceType = $_POST['resourceType'];
$roleId = $_POST['roleId'];

$zdroje = $ACL->vratZdrojePodleTypu($resourceType);
$return = array();
if (count($zdroje)) {
//	print_p($zdroje);
	foreach($zdroje AS $zdroj) {
		$idZdroju[] = $zdroj->id;
	}
//	$idZdroju = array_keys($zdroje);
	$pridelenaPrava = $ACL->vratObsahPodleIdZdrojeIdRoleAIdContent($idZdroju, $roleId);
	$return[] = '<table style="border-width:0px">';
	$return[] = '<tr>';
	$return[] = '<th>Název</th><th>Zakázano</th>';
	$return[] = '</tr>';
	foreach ($zdroje as $zdroj) {
//		print_p($pridelenaPrava[$zdroj->id]);
		$return[] = "<tr>";
		$return[] = "<td>$zdroj->resource</td>";
		$jePravoPrideleno = in_array($contentId, (array) $pridelenaPrava[$zdroj->id]);
		$checked = $jePravoPrideleno ? 'checked="checked"' : '';
		$return[] = "<td><input type='checkbox' class='resource' id='resource_$zdroj->id' $checked /></td>";
		$return[] = "</tr>";
	}
	$return[] = '</table>';
}
echo implode("\n", $return);
?>
