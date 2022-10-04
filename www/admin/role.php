<?php

$roles = dbRole::getAll();

$SMARTY->assign("roles", $roles);

?>