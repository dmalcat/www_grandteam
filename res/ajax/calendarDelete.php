<?php

if (dbCalendar::delete($_POST['idCalendar'])) {
	echo json_encode(array('type' => 'success', 'value' => 'Událost byla smazána'));
} else {
	echo json_encode(array('type' => 'error', 'value' => 'Došlo k chybě při mazání události'));
}
?>
