<?php

/**
 * Description of FileSystem
 *
 * @author leos
 */
class Helper_FileSystem {

	const CREATE_FILE_MODE = 0644;
	const CREATE_DIR_MODE = 0755;

	public static function deleteDirectory($dir) {
		if (!file_exists($dir)) return true;
		if (!is_dir($dir) || is_link($dir)) return unlink($dir);
		foreach (scandir($dir) as $item) {
			if ($item == '.' || $item == '..') continue;
			if (!self::deleteDirectory($dir . "/" . $item)) {
				chmod($dir . "/" . $item, 0777);
				if (!self::deleteDirectory($dir . "/" . $item)) return false;
			};
		}
		return rmdir($dir);
	}

	public static function deleteFile($file) {
		if (!unlink($file)) {
			chmod($file, 0777);
			if (!unlink($file)) return false;
		};
		return true;
	}

	public static function checkDir($dir) {
		if (is_array($dir)) {
			foreach ($dir as $path) {
				
			}
		} else {
			if (!file_exists($dir)) {
				mkdir($dir);
				chmod($dir, self::CREATE_DIR_MODE);
			}
		}
	}

}

?>
