<?php

require_once (SMARTY_DIR . "Smarty.class.php");
$SMARTY = new Smarty();

$auth = new Auth('DB', $authOptions, 'displayLoginForm');
$authData = $auth->getAuthData();

$dbUser = dbUser::getById($authData['id_user']);

$SMARTY->template_dir = SMARTY_DATADIR;
$SMARTY->compile_dir = PROJECT_DIR . "data/templates_c/";
$SMARTY->config_dir = SMARTY_DIR . "configs/";
$SMARTY->cache_dir = SMARTY_DIR . "cache/";
$SMARTY->plugins_dir[] = SMARTY_DIR . "plugins/";

$id_parent = isset($_POST['id_item']) ? $_POST['id_item'] : null;
$level = $_POST['level'];
$content_type = isset($_POST['content_type']) ? $_POST['content_type'] : false;
$pouzePocet = isset($_POST['countOnly']) ? true : false;
$items = dbContentCategory::getById($id_parent)->getSubCategories(null)->sort('priority', 'DESC');

if ($pouzePocet) { //  chceme vedet pouze pocet
    echo json_encode(array("pocet" => sizeof($items)));
    die(); //  dalsi echo jasona dale by nam vratilo nesmysl, zabijeme skript
}

$obsah = array(); //  chceme data
if ($content_type)
    $SMARTY->assign('idContentType', $content_type);

foreach ($items as $item) {
    if (!$dbUser->isAllowed('editovat', $item->id))
        continue;
    $SMARTY->assign('item', $item);
    $podkategorie = $item;
    $parent = $podkategorie ? "parent" : "";
    $obsah[] = "<div id=\"accordion_item_{$item->id}\" class=\"appended level-{$level} $parent\">" . $SMARTY->fetch('admin/_accordion_item.tpl') . "</div>";
}

echo json_encode(array("obsah" => $obsah, "POST" => $_POST, "items" => $items));
?>