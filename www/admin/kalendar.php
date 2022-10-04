<?php



if($_POST["id"]) $idCalendar = $_POST["id"]; if(!$idCalendar) $idCalendar = find_url_key_after('kalendar');
if($idCalendar) {
	$dbCalendar = dbCalendar::getById($idCalendar);
}

if($dbCalendar && $_POST['do_calendar_delete']) {
	dbCalendar::delete($dbCalendar->id);
	header("Location: /admin/kalendar");
	$success_message = "Událost byla úspěšně smazána";
}

if($_POST['do_calendar']) {
	if($dbCalendar) {	// upravujeme udalost
		$dbCalendar = $dbCalendar->updateEvent($_POST);
		header("Location: /admin/kalendar_seznam");
	} else {	// zakladame udalost
		$dbCalendar = dbCalendar::addEvent($_POST);
	}
}



$SMARTY->assign('dbCalendar', $dbCalendar);

?>
