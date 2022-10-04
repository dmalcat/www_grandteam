<?php

	if($par_3 == "delete" && $par_4) {
		dbI::query("UPDATE soutez SET visible = 0 WHERE id = %i", $par_4)->result();
		Message::success("Výsledek odebrán", "/admin/soutez");
	}

?>