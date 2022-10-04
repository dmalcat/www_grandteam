<?php

/**
 * Nabidka
 * @author Error
 */
class dbProperty extends dbBase {

	public $id;
	public $prop_name;
	public $display_name;
	public $required;
	public $unit;
	public $prop_type;
	public $search;
	public $inherit;
	public $lang_depending;
	public $validation_regex;
	public $show;
	public $visible;
	public $sort_type;
	public $copy_to_cart;
	public $import_property;
	public $mode;
	public static $enum_types = array("E_SELECT", "E_RADIO");
	public static $set_types = array("S_CHECKBOX");
	public static $string_types = array("STRING", "TEXTAREA", "DATE", "BOOL");
	public static $file_types = array("FILE");
	public static $image_types = array("IMAGE");
	public static $allowed_image_types = array(2, 3, 4, 17);
	private static $cache = array();

	/**
	 * For compatibility reasons
	 * @param array $array
	 */
	public function __construct(Array $array) {
		foreach ($array as $key => $var) {
			$this->$key = $var;
		}
		$this->id = $this->id_property;

//		$pPropInfo = $this->getPropertyInfo($this->id);
//
//		$this->prop_type = $pPropInfo->prop_type;
//		$this->prop_name = $pPropInfo->prop_name;
//		$this->display_name = $pPropInfo->display_name;
//		$this->required = $pPropInfo->required;
//		$this->unit = $pPropInfo->unit;
//		$this->prop_type = $pPropInfo->prop_type;
//		$this->search = $pPropInfo->search;
//		$this->inherit = $pPropInfo->inherit;
//		$this->lang_depending = $pPropInfo->lang_depending;
//		$this->validation_regex = $pPropInfo->validation_regex;
//		$this->show = $pPropInfo->show;
//		$this->visible = $pPropInfo->visible;
//		$this->sort_type = $pPropInfo->sort_type;
//		$this->copy_to_cart = $pPropInfo->copy_to_cart;
//		$this->import_property = $pPropInfo->import_property;
	}

	/**
	 * Returns a property id by prop name
	 * @throws dbException
	 * @return int|false
	 */
	public static function getIdPropertyByPropName($propName, $mode = "item") {
		$table = $mode == "item" ? "s3n_property" : "s3n_user_property";
		return dbI::query("SELECT id_property FROM $table WHERE prop_name = %s", $propName)->fetchSingle();
	}

	/**
	 * Returns a property id by prop name
	 * @throws dbException
	 * @return int|false
	 */
	public function getDisplayName() {
		return $this->display_name;
	}

	/**
	 * Returns a property info array
	 * @throws dbException
	 * @return array|false
	 */
	public function getPropertyInfo() {
		$table = $this->mode == "item" ? "s3n_property" : "s3n_user_property";
		return dbI::query("SELECT * FROM $table WHERE id_property = %i", $this->id)->fetch();
	}

	/**
	 * Returns a property by id_property
	 * @param int $id
	 * @throws dbException
	 * @return dbProperty|false
	 */
	public static function getById($id, $mode = "item") {
		$table = $mode == "item" ? "s3n_property" : "s3n_user_property";
		$res = dbI::query("
				SELECT *, '$mode' AS mode
				FROM $table
				WHERE id_property = %i
			", $id)->fetch('dbProperty');
		return $res;
	}

	/**
	 * vraci vsechny property bud item, nebo user
	 * @return dbProperty|array
	 * @throws Exception
	 */
	public static function getAll() {
		if (get_called_class() == "dbItemProperty") {
			$table = "s3n_property";
		} elseif (get_called_class() == "dbUserProperty") {
			$table = "s3n_user_property";
		} else {
			throw new Exception("Neplatne vytvoreni dbProperty");
		}
		echo $table;
//		return dbI::query("SELECT * FROM " . $table)->fetchAll(get_called_class());
		return dbI::query("SELECT * FROM " . $table)->fetchAll('dbProperty');
	}

	/**
	 * Returns a property by name
	 * @param int $id
	 * @throws dbException
	 * @return dbProperty|false
	 */
	public static function getByName($propName, $mode = "item") {
		if ($mode) { // pro zpetnou kompatabilitu
			if ($mode == "item") $table = "s3n_property";
			if ($mode == "user") $table = "s3n_user_property";
		} else { // dohledame podle classy ktera extenduje
			if (get_called_class() == "dbItemProperty") {
				$table = "s3n_property";
			} elseif (get_called_class() == "dbUserProperty") {
				$table = "s3n_user_property";
			} else {
				$table = "s3n_property"; // bohuzel je to casto volano dajo dbProperty::
//				throw new Exception("Neplatne vytvoreni dbProperty");
			}
		}

		if (self::$cache[$mode][$propName]) return self::$cache[$mode][$propName];
		self::$cache[$mode][$propName] = dbI::query("SELECT *, '$mode' AS mode FROM $table WHERE prop_name = %s", $propName)->fetch("dbProperty");
		return self::$cache[$mode][$propName];
	}

	/**
	 * Returns a property enumerations array
	 * @throws dbException
	 * @return array|false
	 */
	public function getEnumarations() {
		$table = $this->mode == "item" ? "s3n_property_enumeration" : "s3n_user_property_enumeration";
		return dbI::query("SELECT * FROM $table WHERE id_property = %i", $this->id)->fetchAll();
	}

}
