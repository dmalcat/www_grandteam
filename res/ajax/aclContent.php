<?php

$contentType = $_POST['contentType'];
if ($contentType) {
//	$parentId = $_POST['id'];
//	$vybraneKategorie = $CONTENT->get_content_categories($only_parents = true, $only_visible = true, $parentId);
	$vybraneKategorie = dbContentCategory::getAll(null, $_POST['id']);
	$return = array();
	if (count($vybraneKategorie)) {
		$return[] = "<ul class='jqueryFileTree' style='display: none;'>";
		foreach ($vybraneKategorie as $kategorie) {
			$attributes = new stdClass();
			$attributes->id = $kategorie->id_content_category;
			$attributes = json_encode($attributes);
			$return[] = "<li class='branch collapsed' rel='$attributes'>"
					. "<span class='expander'>+</span>"
					. "<span class='icon'>&nbsp;</span>"
					. "<span class='text'>$kategorie->name</span>"
					. "<span class='cleaner'>&nbsp;</span>"
					. "</li>";
		}
		$return[] = "</ul>";
	}
	echo implode("\n", $return);
}
exit();
?>
