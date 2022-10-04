<?php

/**
 * Description of dbConstant
 *
 * @author leos
 */
class dbConstant {

	public static function getAll() {
		return dbI::query("SELECT * FROM s3n_constants WHERE name IS NOT NULL AND name <> ''")->fetchAll();
	}

	public static function getAllPairs() {
		return dbI::query("SELECT name, value FROM s3n_constants WHERE name IS NOT NULL AND name <> ''")->fetchPairs();
	}

	public static function get($name) {
		return dbI::query("SELECT value FROM s3n_constants WHERE name = %s", $name)->fetchSingle();
	}
	public static function set($name, $value) {
		$idConstant = dbI::query("SELECT id_constant FROM s3n_constants WHERE name = %s", $name)->fetchSingle();
		if($idConstant) {
			return dbI::query("UPDATE s3n_constants SET value = %s WHERE name = %s", $value, $name)->result();
		} else {
			return dbI::query("INSERT INTO s3n_constants SET name = %s, value = %s", $name, $value)->insert();
		}
	}

	public static function setById($idConstant, $value) {
		return dbI::query("UPDATE s3n_constants SET value = %s WHERE id_constant = %i", $value, $idConstant)->result();
	}

	public function delete($name) {
		return dbI::query("DELETE FROM s3n_constants WHERE name = %s", $name)->result();
	}

}

?>
