<?php

$mode = $_GET["mode"];
$id_gallery = $_GET['id_gallery'];
$id_image = $_GET['id_image'];
$id_item = $_GET["id_item"];
$id_related_item = $_GET["id_related_item"];

//$mode = "image_detail";
// 	$id_image = 155;

switch ($mode) {
    case "image_detail":
        $GALLERY = new Gallery_3n();
        $GALLERY->id_gallery = $id_gallery;
        $p_gallery = $GALLERY->get_gallery_detail();
// 			$p_gallery->IMAGES = $GALLERY->get_gallery_images();
        $p_image = $GALLERY->get_image_detail($id_image);
        echo(json_encode($p_image));

        break;
    case "content_detail":

        break;
    case "add_related_item":
// 			$SHOP->addRelated($id_item, $id_related_item, Shop::RELATED_ITEM);
        break;

    case "discussion":
        $page = $_POST['page'];
        $contentId = $_POST['contentId'];
        $return = '';
        $forum = $FORUM->get_forum_by_id_content_category($contentId);
        if ($forum) {
            $forumId = $forum->id_forum;
            $pager = new class_pager();
            $pager->strana = $page;
            $parents = $FORUM->get_parents_content_by_forum_id($forumId, $pager);
            if (count($parents)) {
                $parentIds = array();
                foreach ($parents as $parent) {
                    $parentIds[] = $parent->id_forum_content;
                    $parent->childs = array();
                }
                $descendants = $FORUM->get_descendants_content_by_forum_id($parentIds);
                foreach ($descendants as $descendant) {
                    $parents[$descendant->id_parent]->childs[] = $descendant;
                }
            }
            $return = $return . showPagging($pager);
            $return = $return . showTextarea();
            $return = $return . showForumContent($parents);
            $return = $return . showPagging($pager);
        } else {
            $return = $return . showTextarea();
        }
        echo $return;
        break;

    case "discussion_add":
        $text = $_POST['text'];
        $jmeno = $_POST['jmeno'];
        $contentId = $_POST['contentId'];
        $userId = $USER->data["id_user"];
        $forum = $FORUM->get_forum_by_id_content_category($contentId);
        $p_content_detail = $CONTENT->get_content_detail($contentId);
//          print_p($p_content_detail,$contentId);
        if (!$forum) {
            $forumId = $FORUM->forum_add($p_content_detail->title_1, $p_content_detail->title_1, 'desc', date('Y-m-d H:i:s'), null, 3, 1, 'open', 1, null, $USER->data["id_user"]);
            $FORUM->set_forum_content_category($forumId, $contentId);
        } else {
            $forumId = $forum->id_forum;
        }
        $FORUM->forum_content_add(null, $forumId, null, '', $text, true, $userId, $jmeno, '', null, null, "open");

        break;

    case "discussion_reaction":
        $parentId = $_POST['id'];
        $text = $_POST['text'];
        $jmeno = $_POST['jmeno'];
        $contentId = $_POST['contentId'];

        $forum = $FORUM->get_forum_by_id_content_category($contentId);
        if ($forum) {
            $FORUM->forum_content_add($parentId, $forum->id_forum, null, '', $text, true, $USER->data["id_user"], $jmeno, '', null, null, "open");
        }

        break;
}

function showTextarea($pager) {
    $return = '';
    $return .= "<div class='h2_diskuse'>&nbsp;&nbsp;&nbsp;komentovat článek</div>";
    $return .= "<div class= 'vlozit_koment'> ";
    $return .= "<div style='float:left;margin-bottom:10px;'> ";
    $return .= "<div style='float:left; font-size:10px;' >Vaše jméno:</div > ";
    $return .= "<input type='text' id='jmenoUzivatele'/><br />";
    $return .= "</div> ";
    $return .= "<div style='float:left;'> ";
    $return .= "<div style='float:left; font-size:10px; display:block;' >Váš komentář:<br /></div > ";
    $return .= "<textarea id='komentar'></textarea><br />";
    $return .= "<input type='button' id='pridatKomentar' class='tlacitko' value='vložit' />";
    $return .= "</div> ";
    $return .= "</div>";
    return $return;
}

function showPagging($pager) {
    $return = '';
    $return .= '<div class="strankovani">';
    $return .= 'Počet nalezených záznamů: <strong>' . $pager->pocet . '</strong>&nbsp;&nbsp;&nbsp;';
    $return .= "strana: {$pager->strana}/{$pager->pocetStran}";
    if ($pager->predchozi) {
        $return .= ' <span class="tlacitko" onclick="setPage(' . $pager->predchozi . ')">předchozí strana</span>';
    }
    if ($pager->dalsi) {
        $return .= ' <span class="tlacitko" onclick="setPage(' . $pager->dalsi . ')">další strana</span>';
    }
    $return .= '</div>';
    return $return;
}

function showForumContent($data) {
    $return = '';
//  print_p($data);
    foreach ($data as $item) {
        $return .= "<div class='polozka'>";
        $return .= "<div class='prizpevek'>";
        $return .= "<div class='com_date' style='text-align:right' >" . date('d.m.Y H:i', strtotime($item->datum)) . "</div>" . "<div class='com_author'>" . $item->author_name . "</div>";

        $return .= $item->text;
        $return .= "<br /><span class='tlacitkoReakce' rel='$item->id_forum_content'>reagovat</span>";
        $return .= "<div class='formularReakce' style='display:none'>";
        $return .= "<input type='text' class='jmenoUzivatele' /><br />";
        $return .= "<textarea class='formular'>";
        $return .= "</textarea><br />";
        $return .= "<input type='button' class='tlacitko' value='reagovat' style='text-align:right' />";
        $return .= "</div>";
        $return .= "</div>";
        if (isset($item->childs) && count($item->childs)) {
            foreach ($item->childs as $child) {
                $return .= "<div class='reakce'>";
                $return .= "<div class='com_date' style='text-align:right'>" . date('d.m.Y H:i', strtotime($child->datum)) . "</div>" . "<div class='com_author'>" . $child->author_name . "</div>";
                $return .= $child->text;
                $return .= "</div>";
            }
        }
        $return .= "</div>";
    }
    return $return;
}

?>