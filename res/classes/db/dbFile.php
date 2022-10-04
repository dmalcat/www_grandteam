<?php

/**
 * dbFile
 * @author Error
 */
class dbFile extends dbBase {

	public $id;
	public $filename;
	public $url;
	public $id_type;
	public $size;

	/**
	 * For compatibility reasons
	 * @param array $array
	 */
	public function __construct(Array $array) {
		foreach ($array as $key => $var) {
			$this->$key = $var;
		}
		$this->id = $this->id_file;
	}

	/**
	 * Vraci dbImage podle id_file
	 * @param int $id
	 * @throws dbException
	 * @return dbImage|false
	 */
	public static function getById($id) {
		return dbI::query("SELECT * FROM s3n_files WHERE id_file = %i", $id)->fetch('dbImage');
	}



}