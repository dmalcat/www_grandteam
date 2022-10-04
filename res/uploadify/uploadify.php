<?php

define('PROJECT_DIR', dirname(dirname(dirname(__FILE__))) . DIRECTORY_SEPARATOR);  // root projektu
//define('PROJECT_DIR', 			 $_SERVER['DOCUMENT_ROOT'] . '/');  // root projektu
require_once PROJECT_DIR . 'res/def.php';
//if(!$_REQUEST['idGallery']) $_REQUEST['idGallery'] = 198;

if ($_REQUEST['idGallery']) {
	if (!empty($_FILES)) {
		$tempFile = $_FILES['Filedata']['tmp_name'];
		$targetPath = $_SERVER['DOCUMENT_ROOT'] . $_REQUEST['folder'] . '/';
		$targetFile = str_replace('//', '/', $targetPath) . $_FILES['Filedata']['name'];
		// $fileTypes  = str_replace('*.','',$_REQUEST['fileext']);
		// $fileTypes  = str_replace(';','|',$fileTypes);
		// $typesArray = split('\|',$fileTypes);
		// $fileParts  = pathinfo($_FILES['Filedata']['name']);
		// if (in_array($fileParts['extension'],$typesArray)) {
		// Uncomment the following line if you want to make the directory if it doesn't exist
		// mkdir(str_replace('//','/',$targetPath), 0755, true);
//			move_uploaded_file($tempFile,$targetFile);
//			$GALLERY = new Gallery_3n($_REQUEST['idGallery']);
		$_FILES['image'] = $_FILES['Filedata'];
		$_FILES['file'] = $_FILES['Filedata'];

//			$GALLERY->image_add(basename($_FILES['Filedata']['name']), '', '', 100, 1);
		if ($_REQUEST["type"] == "video") {
			dbGallery::getById($_REQUEST['idGallery'])->videoAdd(basename($_FILES['Filedata']['name']), '', '', 100, 1);
		} elseif ($_REQUEST["type"] == "file") {
			dbGallery::getById($_REQUEST['idGallery'])->fileAdd(basename($_FILES['Filedata']['name']), '', '', 100, 1);
		} else {
			dbGallery::getById($_REQUEST['idGallery'])->imageAdd(basename($_FILES['Filedata']['name']), '', '', 100, 1);
		}

//			$GALLERY->file_add(basename($_FILES['Filedata']['name']), '', '', 100, 1);
		echo str_replace($_SERVER['DOCUMENT_ROOT'], '', $targetFile);
		// } else {
		// 	echo 'Invalid file type.';
		// }
	}
}
?>