<?php

if (isset($_POST['idContentType'])) Session::set('idContentType', $_POST['idContentType']); $idContentType = Session::get('idContentType');
if (!$idContentType) $idContentType = dbContentType::getDefault()->id;

if ($_POST['filterContentCategory'] == 'filterZajimavosti') Session::set('filterContentCategory', 'filterZajimavosti');
if ($_POST['filterContentCategory'] == 'filterAktuality') Session::set('filterContentCategory', 'filterAktuality');
if ($_POST['filterContentCategory'] == '') Session::set('filterContentCategory', '');


$idContentCategory = find_url_key_after('seznam_clanku');
if($idContentCategory) $dbCC = dbContentCategory::getById ($idContentCategory);	// pro pripadne rozevreni struktury menu

$SMARTY->assign('idContentType', $idContentType);
$SMARTY->assign('filterContentCategory', Session::get('filterContentCategory'));

?>
