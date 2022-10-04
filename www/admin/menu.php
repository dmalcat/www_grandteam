<?php

if ($_POST["do_clanek"]) {
    if ($_POST["id"]) { // upravujeme clanek
        $dbCC = dbContentCategory::getById($_POST["id"]);
        if ($CONTENT->content_category_edit($_REQUEST["id"], array(
                    "name" => $_REQUEST["nazev"],
                    "description" => "",
                    "datum" => $_REQUEST["datum"],
                    "gps" => $_REQUEST["gps"],
                    "menu" => $_REQUEST["menu"],
                    "external_url" => $_REQUEST["external_url"],
                    "id_parent" => $_REQUEST["id_parent"],
                    "visible" => $_REQUEST["visible"],
                    "visible_from" => $_REQUEST["visible_from"],
                    "visible_to" => $_REQUEST["visible_to"],
                    "homepage" => $dbCC->homepage,
                    "priority" => $_REQUEST["priority"]))) {

            $CONTENT->set_content_category_images($_REQUEST["id"], $_REQUEST["nazev"] . "-" . $_REQUEST["id"]);
            $CONTENT->set_content_category_videos($_REQUEST["id"], $_REQUEST["nazev"] . "-" . $_REQUEST["id"]);
            $CONTENT->set_content_category_content_type($_POST["id"], $_POST["id_content_type"]);

            if ($_REQUEST["do_map_gallery"] AND $_REQUEST["id_gallery"]) {
                $CONTENT->content_category_map_gallery($selected_content_category_id, $_REQUEST["id_gallery"], $_REQUEST["map_gallery_priority"]);
            }
            if ($_REQUEST["do_edit_map_gallery_priority"] AND $_REQUEST["id_content_map_gallery"]) {
                $CONTENT->set_content_category_map_gallery_priprity($_REQUEST["id_content_map_gallery"], $_REQUEST["map_gallery_priority"]);
            }
            if ($_REQUEST["do_dell_gallery_mapping"] AND $_REQUEST["id_gallery_del_mapping"]) {
                $CONTENT->delete_mapped_gallery($_REQUEST["id_gallery_del_mapping"], $selected_content_category_id);
            }
            if (isset($_POST["id_vizitka"]))
                $dbCC->setVizitka($_POST["id_vizitka"]);
            $success_message = "Položka byla úspěšně upravena";
        } else {
            $error_message = "Chyba při ukládání položky";
        }
    } else { //zakladame nove menu
        if ($content_category_id_inserted = dbContentCategory::add(
                        array(
                            "name" => $_REQUEST["nazev"],
                            "description" => $_REQUEST["description"],
                            "datum" => $_REQUEST["datum"],
                            "gps" => $_REQUEST["gps"],
                            "external_url" => $_REQUEST["external_url"],
                            "id_parent" => $_REQUEST["id_parent"],
                            "content_category_visible" => $_REQUEST["content_category_visible"],
                            "visible_from" => $_REQUEST["visible_from"],
                            "visible_to" => $_REQUEST["visible_to"],
                            "visible" => "1",
                            "homepage" => $_REQUEST["homepage"],
                            "priority" => $_REQUEST["priority"],
                            "menu" => $_REQUEST["menu"],
                            "id_content_type" => $_REQUEST["id_content_type"],
                            "id_author" => $dbUser->id,
                ))) {

            $CONTENT->set_content_category_images($content_category_id_inserted, $_REQUEST["name"] . "-" . $content_category_id_inserted);
            $CONTENT->set_content_category_videos($content_category_id_inserted, $_REQUEST["name"] . "-" . $content_category_id_inserted);
            $CONTENT->set_content_category_content_type($content_category_id_inserted, $_POST["id_content_type"]);
            $dbCC = dbContentCategory::getById($content_category_id_inserted);
            if (isset($_POST["id_vizitka"]))
                $dbCC->setVizitka($_POST["id_vizitka"]);

            if ($content_category_id_inserted) {
                $success_message = "Položka menu vložena";
            } else {
                $error_message = "Chyba při ukládání položky";
            }
            header("Location: /admin/seznam_clanku/$content_category_id_inserted");
            exit();
        } else {
            $error_message = "Chyba při ukládání položky";
        }
    }
}



$idContentCategory = find_url_key_after('menu');
if ($idContentCategory) {
    Cache::flush();
    $dbCC = dbContentCategory::getById($idContentCategory);
    if ($dbCC) {
        if ($_POST['doMapGallery'])
            if ($dbCC->mapGallery($_POST['idGallery'], $_POST['galleryPriority'], $_POST['galleryPosition']))
                $success_message = "Připojeno.";
            else
                $error_message = "Došlo k chybě při připojení galerie";
        if ($_POST['doUnMapGallery'])
            if ($dbCC->unMapGallery($_POST['idGallery']))
                $success_message = "Galerie byla odpojena.";
            else
                $error_message = "Došlo k chybě při odpojení galerie";
        if ($_POST['doVideo'] && ($_FILES['content_category_video']['name'][0] || $_FILES['content_category_video']['name'][1] || $_FILES['content_category_video']['name'][2]))
            if ($CONTENT->set_content_category_videos($par_3, dbContentCategory::getById($par_3)->name . "-" . $par_3))
                $success_message = "Pokud byla připojena videa, vyčkejte chvíly na změnu formátu";
            else
                $error_message = "Došlo k chybě při vkládání videa";

        $pContentCategory = $CONTENT->get_content_detail_by_id_content_category($idContentCategory);
//	$CONTENT->set_content_type($pContentCategory->content_category->id_content_type);
        $SMARTY->assign("pContentCategory", $pContentCategory);
        $dbCC = dbContentCategory::getById($dbCC->id); // uf to je prasarna - ale je potreba to prenacist po editaci
    }
//	print_p($dbCC->external_url); die();
    if ($dbCC->menu == dbContentCategory::TYPE_CLANEK) {
        header("Location: " . str_replace("menu", "clanek", $_SERVER["REQUEST_URI"]));
    }
    $dbC = $dbCC->getContent();
}
?>