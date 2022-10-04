<?php
	switch ($_GET['direction']) {
		case 'up':
			$res = dbContentCategory::sortUp($_GET['idContentCategory']);
			break;
		case 'down':
			$res = dbContentCategory::sortDown($_GET['idContentCategory']);
			break;
	}
	echo json_encode($res);
?>
