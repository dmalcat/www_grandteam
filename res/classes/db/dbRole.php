<?php

/**
 * Pobocka
 * @author Error
 */
class dbRole extends dbBase {

	public $id;
	public $parent_id;
	public $published;
	public $name;
	public $code;
	public $desc;

//		public $editable_access;
//		public $priority;

	/**
	 * For compatibility reasons
	 * @param array $array
	 */
	public function __construct(Array $array) {
		foreach ($array as $key => $var) {
			$this->$key = $var;
		}
	}

	/**
	 * Returns role
	 * @throws dbException
	 * @return dbRole|false
	 */
	public static function getById($id) {
		$res = dbI::query("
				SELECT *
				FROM s3n_roles
				WHERE id = %i
			", $id)->fetch('dbRole');
		return $res;
	}

	/**
	 * Returns all dbRole
	 * @throws dbException
	 * @return array of dbRole
	 */
	public static function getAll() {
		return dbI::query("SELECT * FROM s3n_roles")->fetchAll('dbRole');
	}

	public static function addRole($name, $desc) {
		return dbI::query("INSERT INTO `s3n_roles` (`name`, `code`, `desc`) VALUES (%s, %s, %s)", $name, urlFriendly($name), $desc)->result();
	}

	public function editRole($data) {
		if (empty($data['code'])) $data['code'] = $this->code;
		return dbI::query("
				UPDATE s3n_roles SET `name` = %s, `code` = %s, `desc` = %s
				WHERE `id` = %i
				", $data['name'], $data['code'], $data['desc'], $this->id)->result();
	}

	public static function deleteRole($id) {
		$res = dbI::query("DELETE FROM s3n_roles WHERE id = %i", $id)->result();
		return $res ? true : false;
	}

}

?>