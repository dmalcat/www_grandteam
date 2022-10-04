<?php

/* @var $CONTENT Content_3n */

//print_p($_POST, $idContentType);
//print_p($_FILES);

if ($_POST["id"]) {
    $idContentCategory = $_POST["id"];
}
if (!$idContentCategory) {
    $idContentCategory = find_url_key_after('clanek');
}
if ($idContentCategory) {
    $dbCC = dbContentCategory::getById($idContentCategory);
    if ($dbCC->menu == dbContentCategory::TYPE_MENU) {
        header("Location: " . str_replace("clanek", "menu", $_SERVER["REQUEST_URI"]));
    }
    $dbC = $dbCC->getContent();
}

//print_p($dbCC);

if ($_POST["do_clanek"]) {
    if ($dbCC) { // upravujeme clanek
        if ($CONTENT->content_category_edit($dbCC->id, array(
                    "name" => $_REQUEST["nazev"],
                    "description" => "",
                    "datum" => $_REQUEST["datum"],
                    "gps" => $_POST["gps"],
                    "id_odbor" => $_POST["id_odbor"],
                    "external_url" => $_REQUEST["external_url"],
                    "id_parent" => $_REQUEST["id_parent"],
                    "visible" => $_REQUEST["visible"],
                    "visible_from" => $_REQUEST["visible_from"],
                    "visible_to" => $_REQUEST["visible_to"],
                    "author" => $_REQUEST["author"],
                    "homepage" => $dbCC->homepage,
                    "priority" => $_REQUEST["priority"],
                    "price" => $_REQUEST["price"],
                ))) {
            $CONTENT->content_edit($_REQUEST["id_content"], array(
                "id_template" => $_REQUEST["id_template"],
                "title_1" => $_REQUEST["nazev"],
                "title_2" => $_REQUEST["title_2"],
                "title_3" => $_REQUEST["title_3"],
                "text_1" => fixFckContent($_REQUEST["text_1"]),
                "text_2" => fixFckContent($_REQUEST["text_2"]),
                "text_3" => fixFckContent($_REQUEST["text_3"]),
                "datum" => $_REQUEST["datum"],
                "visible" => $_REQUEST["visible"],
                "visible_from" => $_REQUEST["visible_from"],
                "visible_to" => $_REQUEST["visible_to"],
                "meta_title" => $_REQUEST["meta_title"],
                "meta_keywords" => $_REQUEST["meta_keywords"],
                "meta_description" => $_REQUEST["meta_description"],
                "content_homepage" => $_REQUEST["content_homepage"]
            ));
            $CONTENT->set_content_category_images($dbCC->id, $_REQUEST["nazev"] . "-" . $_REQUEST["id"]);
            $CONTENT->set_content_category_files($dbCC->id, $_REQUEST["nazev"] . "-" . $_REQUEST["id"]);

            if ($_POST["id_content_type"]) {
                $dbCC->setContentType($_POST["id_content_type"]);
            }

            if ($_REQUEST["do_map_gallery"] AND $_REQUEST["id_gallery"]) {
                $CONTENT->content_category_map_gallery($dbCC->id, $_REQUEST["id_gallery"], $_REQUEST["map_gallery_priority"]);
            }
            if ($_REQUEST["do_edit_map_gallery_priority"] AND $_REQUEST["id_content_map_gallery"]) {
                $CONTENT->set_content_category_map_gallery_priprity($_REQUEST["id_content_map_gallery"], $_REQUEST["map_gallery_priority"]);
            }
            if ($_REQUEST["do_dell_gallery_mapping"] AND $_REQUEST["id_gallery_del_mapping"]) {
                $CONTENT->delete_mapped_gallery($_REQUEST["id_gallery_del_mapping"], $selected_content_category_id);
            }

            if (isset($_POST["id_vizitka"])) {
                $dbCC->setVizitka($_POST["id_vizitka"]);
            }
            if (isset($_POST["id_category"])) {
                $dbCC->setCategory($_POST["id_category"]);
            }

//            print_p($_POST);
//            die();

            foreach ($_POST as $key => $value) {
                if (in_array($key, dbContentCategory::$params)) {
                    $dbCC->setParam($key, $value);
                }
            }

            Message::success("", "/admin/seznam_clanku");
        } else {
            throw new Exception("Chyba při úpravě položky");
        }
    } else { //zakladame novy clanek
        if ($content_category_id_inserted = dbContentCategory::add(
                        array(
                            "name" => $_REQUEST["nazev"],
                            "description" => $_REQUEST["description"],
                            "datum" => $_REQUEST["datum"],
                            "gps" => $_POST["gps"],
                            "id_odbor" => $_POST["id_odbor"],
                            "external_url" => $_REQUEST["external_url"],
                            "id_parent" => $_REQUEST["id_parent"],
                            "content_category_visible" => $_REQUEST["content_category_visible"],
                            "visible" => '1',
                            "visible_from" => $_REQUEST["visible_from"],
                            "visible_to" => $_REQUEST["visible_to"],
                            "homepage" => $_REQUEST["homepage"],
                            "priority" => $_REQUEST["priority"],
                            "menu" => $_REQUEST["menu"],
                            "id_content_type" => $idContentType,
                            "id_author" => $dbUser->id,
                            "author" => $_REQUEST["author"],
                            "price" => $_REQUEST["price"]
                ))) {

            $content_insert_ok = $CONTENT->content_add($content_category_id_inserted, array(
                "id_template" => $_REQUEST["id_template"],
                "title_1" => $_REQUEST["nazev"],
                "title_2" => $_REQUEST["title_2"],
                "title_3" => $_REQUEST["title_3"],
                "text_1" => fixFckContent($_REQUEST["text_1"]),
                "text_2" => fixFckContent($_REQUEST["text_2"]),
                "text_3" => fixFckContent($_REQUEST["text_3"]),
                "meta_title" => $_REQUEST["meta_title"],
                "meta_keywords" => $_REQUEST["meta_keywords"],
                "meta_description" => $_REQUEST["meta_description"],
                "content_homepage" => $_REQUEST["content_homepage"],
                "id_author" => $dbUser->id
            ));
            $CONTENT->set_content_category_images($content_category_id_inserted, $_REQUEST["name"] . "-" . $content_category_id_inserted);
            $CONTENT->set_content_category_files($content_category_id_inserted, $_REQUEST["name"] . "-" . $content_category_id_inserted);
            $CONTENT->set_content_category_content_type($content_category_id_inserted, $idContentType);

            $dbCC = dbContentCategory::getById($content_category_id_inserted);
            if (isset($_POST["id_category"])) {
                $dbCC->setCategory($_POST["id_category"]);
            }

            foreach ($_POST as $key => $value) {
                if (in_array($key, dbContentCategory::$params)) {
                    $dbCC->setParam($key, $value);
                }
            }
            if (isset($_POST["id_vizitka"])) {
                $dbCC->setVizitka($_POST["id_vizitka"]);
            }

            if ($content_insert_ok) {
                Message::success("", "/admin/seznam_clanku");
            } else {
                throw new Exception('Chyba při vkládání clanku');
            }
        } else {
            throw new Exception('Chyba při vkládání clanku menu');
        }
//		$dbCC = dbContentCategory::getById($content_category_id_inserted);
//		self::sortContentCategories($dbCC);
        header("Location: /admin/seznam_clanku/$content_category_id_inserted");
        exit();
    }
}



if ($dbCC) {
    if ($_POST['doMapGallery'])
        if ($dbCC->mapGallery($_POST['idGallery'], $_POST['galleryPriority'], $_POST['galleryPosition'])) {
            $success_message = "Připojeno.";
        } else {
            $error_message = "Došlo k chybě při připojení galerie";
        }
    if ($_POST['doUnMapGallery'])
        if ($dbCC->unMapGallery($_POST['idGallery'])) {
            $success_message = "Galerie byla odpojena.";
        } else {
            $error_message = "Došlo k chybě při odpojení galerie";
        }
    if ($_POST['doVideo'] && ($_FILES['content_category_video']['name'][0] || $_FILES['content_category_video']['name'][1] || $_FILES['content_category_video']['name'][2]))
        if ($CONTENT->set_content_category_videos($par_3, dbContentCategory::getById($par_3)->name . "-" . $par_3)) {
            $success_message = " Pokud byla připojena videa, vyčkejte chvíly na změnu formátu";
        } else {
            $error_message = "Došlo k chybě při vkládání videa";
        }

    $pContentCategory = $CONTENT->get_content_detail_by_id_content_category($idContentCategory);
//	$CONTENT->set_content_type($pContentCategory->content_category->id_content_type);
    $SMARTY->assign("pContentCategory", $pContentCategory);
    $dbCC = dbContentCategory::getById($dbCC->id); // uf to je prasarna - ale je potreba to prenacist po editaci
}
?>