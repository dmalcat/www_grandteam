<?php

/**
 * Nabidka
 * @author Error
 */
class dbUserProperty extends dbProperty implements dbIProperty {

	public $id_user;
	public $value;
	public $displayValue;
	private static $cache;

	/**
	 * @param string $propName
	 * @param int $idUser
	 * @throws dbException
	 * @return dbUserProperty|false
	 */
	public static function create(dbProperty $dbProperty, $idUser) {
		$res = new dbUserProperty($dbProperty, $idUser);
		return $res;
	}

	public function __construct(dbProperty $dbProperty, $idUser) {
		$array = (array) $dbProperty; // nacteme info o properte a rozsirime o id_user
		foreach ($array as $key => $var) {
			$this->$key = $var;
		}
		$this->id_user = $idUser;
	}

	/**
	 * Returns a property value
	 * @throws dbException
	 * @return string|false
	 */
	public function getValue() {
		if (!$this->value) {
			if (in_array($this->prop_type, self::$string_types)) {
				$this->value = $this->getStringValue();
			} elseif (in_array($this->prop_type, self::$set_types)) {
				$this->value = $this->getEnumValue();
			} elseif (in_array($this->prop_type, self::$enum_types)) {
				$this->value = $this->getEnumValue();
			} elseif (in_array($this->prop_type, self::$image_types)) {
				$this->value = $this->getImageValue();
			}
		}
		if ($this->value == false) $this->value = NULL;
		return $this->value;
	}

	/**
	 * Returns a property display value
	 * @throws dbException
	 * @return string|false
	 */
	public function getDisplayValue() {
		if (!$this->displayValue) {
			if (in_array($this->prop_type, self::$string_types)) {
				$this->displayValue = $this->getStringValue();
			} elseif (in_array($this->prop_type, self::$set_types)) {
				$this->displayValue = $this->getEnumDisplayValue();
			} elseif (in_array($this->prop_type, self::$enum_types)) {
				$this->displayValue = $this->getEnumDisplayValue();
			}
		}
		return $this->displayValue;
	}

	/**
	 * Returns a property string value
	 * @throws dbException
	 * @return string|false
	 */
	private function getStringValue() {
//			return dbI::cachedQuery("SELECT value FROM s3n_user_map_property WHERE id_property = %i AND id_user = %i", $this->id, $this->id_user)->cache(self::$cache['propValue'][$this->id_user][$this->id])->fetchSingle();
		return dbI::query("SELECT value FROM s3n_user_map_property WHERE id_property = %i AND id_user = %i", $this->id, $this->id_user)->fetchSingle();
	}

	/**
	 * Returns a property enum value
	 * @throws dbException
	 * @return string|false
	 */
	private function getEnumValue() {
//			return dbI::cachedQuery("SELECT pe.value FROM s3n_user_map_property imp, s3n_property_enumeration pe WHERE imp.id_enumeration = pe.id_enumeration AND imp.id_user = %i AND imp.id_property = %i ", $this->id_user, $this->id)->cache(self::$cache['propValue'][$this->id_user][$this->id])->fetchSingle();
		return dbI::query("SELECT pe.value FROM s3n_user_map_property imp, s3n_property_enumeration pe WHERE imp.id_enumeration = pe.id_enumeration AND imp.id_user = %i AND imp.id_property = %i ", $this->id_user, $this->id)->fetchSingle();
	}

	/**
	 * Returns a property enum display value
	 * @throws dbException
	 * @return string|false
	 */
	private function getEnumDisplayValue() {
//			return dbI::query("SELECT pe.display_value FROM s3n_user_map_property imp, s3n_property_enumeration pe WHERE imp.id_enumeration = pe.id_enumeration AND imp.id_user = %i AND imp.id_property = %i ", $this->id_user, $this->id)->cache(self::$cache['propDisplayValue'][$this->id_user][$this->id])->fetchSingle();
		return dbI::query("SELECT pe.display_value FROM s3n_user_map_property imp, s3n_property_enumeration pe WHERE imp.id_enumeration = pe.id_enumeration AND imp.id_user = %i AND imp.id_property = %i ", $this->id_user, $this->id)->fetchSingle();
	}

	/**
	 * Returns a property file value
	 * @throws dbException
	 * @return string|false
	 */
	public function getImageValue() {
		return dbI::query("SELECT f.id_file, f.filename, f.url, f.size, f.thumbnail_url, f.preview_url, f.detail_url, f.email_url, ft.type, ft.id_type, ft.icon_url from s3n_user_map_property as ump
				INNER JOIN s3n_files as f on f.id_file = ump.id_file
				INNER JOIN s3n_file_types as ft on f.id_type = ft.id_type
				WHERE ump.id_user = %i
				AND ump.id_property = %i", $this->id_user, $this->id)->fetch('dbImage');
	}

	/**
	 * Sets property value
	 * @throws dbException
	 * @return bool|false
	 */
	public function setValue($value) {
		if (in_array($this->prop_type, self::$string_types)) {
			return $this->setStringValue($value);
		} elseif (in_array($this->prop_type, self::$set_types)) {
			return $this->setEnumValue($value);
		} elseif (in_array($this->prop_type, self::$enum_types)) {
			return $this->setEnumValue($value);
		} elseif (in_array($this->prop_type, self::$image_types)) {
			return $this->setImageValue($value);
		} elseif (in_array($this->prop_type, self::$file_types)) {
			return $this->setFileValue($value);
		}
	}

	/**
	 * Sets string property value
	 * @throws dbException
	 * @return bool|false
	 */
	private function setStringValue($value) {
		dbI::query("DELETE FROM s3n_user_map_property WHERE id_user = %i AND id_property = %i", $this->id_user, $this->id)->result();
		if ($value) dbI::query("INSERT INTO s3n_user_map_property (id_user, id_property, value) VALUES (%i, %i, %s)", $this->id_user, $this->id, $value)->insert();
		return true;
	}

	/**
	 * Sets set property value
	 * @throws dbException
	 * @return bool|false
	 */
	private function setEnumValue($idEnumeration, $deleteEnumMappig = true) {
//		print_p($this->prop_name); return;
		if ($deleteEnumMappig) dbI::query("DELETE FROM s3n_user_map_property WHERE id_user = %i AND id_property = %i", $this->id_user, $this->id)->result();
		if (!$idEnumeration) return; // pro pripad ze volame jen kvuli smazani
		if (is_array($idEnumeration)) {
			foreach ($idEnumeration as $val) {
//				$idEnumeration = $this->getIdEnumeration($val);
				if (!$idEnumeration) throw new Exception("Neexistujici enumerace property: " . $this->prop_name . " => " . $val);
				dbI::query("INSERT INTO s3n_user_map_property (id_user, id_property, id_enumeration) VALUES (%i, %i, %i);", $this->id_user, $this->id, $val)->result();
			}
			return true;
		} else {
//			$idEnumeration = $this->getIdEnumeration($value);
			if (!$idEnumeration) throw new Exception("Neexistujici enumerace property: " . $this->prop_name . " => " . $value);
			return dbI::query("INSERT INTO s3n_user_map_property (id_user, id_property, id_enumeration) VALUES (%i, %i, %i);", $this->id_user, $this->id, $idEnumeration)->result();
		}
		return false; // neco spatne
	}

}
