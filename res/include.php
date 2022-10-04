<?php

//echo "def_".strtolower(Session::get_session("class_owner")).".php";

$php_to_include = $seo_url_array[$par_1];
if (!$php_to_include) {
    $php_to_include = $par_1;
}

$php_to_include = "/www/$par_1/" . $php_to_include;

if (!file_exists(PROJECT_DIR . $php_to_include . ".php")) {
    $php_to_include = "/www/main";
}
$php_to_include .= ".php";

// 	echo $php_to_include;

include_once(PROJECT_DIR . $php_to_include);
?>