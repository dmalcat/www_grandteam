<?php

/**
 * Description of dbUserLog
 *
 * @author leos
 */
class dbUserLog {

	public $id;
	public $id_user;
	public $date;
	
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
	 * 
	 * @param string $from
	 * @param string $to
	 * @return dbUserLog|array
	 */
	public static function getAll($from = null, $to = null) {
		return new dbArray(dbI::query("SELECT * FROM s3n_users_log WHERE DATE(`date`) >= COALESCE(%s, DATE(`date`)) AND DATE(`date`) <= COALESCE(%s, DATE(`date`)) AND id_user <> 1", $from, $to)->fetchAll("dbUserLog"));
	}
	
	public static function create($idUser) {
		return dbI::query("INSERT INTO s3n_users_log (`date`, id_user) VALUES (NOW(), %i)", $idUser)->insert();
	}
	
	public function __destruct() {
		
	}
	
	public function getUser() {
		return dbUser::getById($this->id_user);
	}
	

}
