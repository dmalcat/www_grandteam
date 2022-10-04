<?php

require_once(SMARTY_DIR . "Smarty.class.php");
$SMARTY = new Smarty();

$SMARTY->template_dir = SMARTY_DATADIR;
$SMARTY->compile_dir = PROJECT_DIR . "data/templates_c/";
$SMARTY->config_dir = SMARTY_DIR . "configs/";
$SMARTY->cache_dir = SMARTY_DIR . "cache/";
$SMARTY->plugins_dir[] = SMARTY_DIR . "plugins/"; // vlastni fce

$dbGallery = dbGallery::getById($_GET['idGallery']);
$SMARTY->assign('dbGallery', $dbGallery);
echo $SMARTY->fetch('content/fotogalerie/galerieDetail.tpl');
?>
