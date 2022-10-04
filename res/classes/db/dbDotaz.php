<?php

/**
 * Description of dbDotaz
 *
 * @author leos
 */
class dbDotaz {

	const DEFAULT_RECIPIENT_EMAIL = "info@3nicom.cz"; // pro pripad ze neni vyplnen email u vizitky

	public $id;
	public $id_user;
	public $id_editor;
	public $from_email;
	public $to_email;
	public $text;
	public $answer;
	public $date;
	public $status;

	const STATUS_SEND = 0;
	const STATUS_DEFFERED = 1;
	const STATUS_ANSWERED = 3;

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
	 * Returns a dbDotaz by id
	 * @param int $id
	 * @throws dbException
	 * @return dbDotaz|null
	 */
	public static function getById($id) {
		return dbI::query("SELECT * FROM s3n_dotaz WHERE id = %i", $id)->fetch('dbDotaz');
	}

	/**
	 * Returns all dbDotaz
	 * @throws dbException
	 * @return dbDotaz|array
	 */
	public static function getAll() {
		return dbI::query("SELECT * FROM s3n_dotaz ORDER BY id DESC")->fetchAll('dbDotaz');
	}

	/**
	 * Returns all dbDotaz
	 * @throws dbException
	 * @return dbDotaz|array
	 */
	public static function getByIdEditor($idEditor) {
		return dbI::query("SELECT * FROM s3n_dotaz WHERE id_editor = %i ORDER BY id DESC", $idEditor)->fetchAll('dbDotaz');
	}

	public static function getSendTo() {
		return self::DEFAULT_RECIPIENT_EMAIL;	// pro ostry provoz zakomentovat
		return dbContentCategory::getById($this->id_editor)->external_url;
//		return self::DEFAULT_RECIPIENT_EMAIL;
	}

	public static function create($data) {
		if (!$data["date"]) $data["date"] = date("Y-m-d H:i:s");
		if (!$data["status"]) $data["status"] = 0;
		if (!$data["to_email"]) $data["to_email"] = dbUser::getById($data["id_editor"])->getPropertyValue("email");
		return self::getById(dbI::query("INSERT INTO s3n_dotaz ", $data)->insert());
	}

	public function delete() {
		return dbI::query("DELETE FROM s3n_dotaz WHERE id=%i", $this->id)->result();
	}

	public function send() {
		if (DOTAZ_EMAIL_COPY) {
			$m = new MailSend(DOTAZ_EMAIL_COPY);
			$m->sendDotaz($this, $this->from_email);
		}


//		$emailTo = $this->getOwner()->external_url;
		$emailTo = $this->getSendTo();
		if (!$emailTo) $emailTo = self::DEFAULT_RECIPIENT_EMAIL;
//		$emailTo = $this->to_email;
//		if (!$emailTo) throw new Exception("Nepodarilo se zjisti email prijemce dotazu");
		$m = new MailSend($emailTo);
		$m->sendDotaz($this, $this->from_email);

		return true;
	}

	/**
	 * Vrati ktery uzivatel dotaz polozil
	 * @return dbContentCategory
	 */
	public function getOwner() {
		return dbUser::getById($this->id_user);
//		return dbContentCategory::getById($this->id_editor);
	}

	/**
	 * Vrati editora kteremu byl dotaz polozen
	 * @return dbContentCategory
	 */
	public function getEditor() {
//		return dbUser::getById($this->id_editor);
		return dbContentCategory::getById($this->id_editor);
	}

	public function getStatusTxt() {
		switch ($this->status) {
			case self::STATUS_SEND:
				return "přijato";
				break;
			case self::STATUS_DEFFERED:
				return "předáno na odeslání";
				break;
			case self::STATUS_ANSWERED:
				return "zodpovězeno";
				break;
			default:
				throw new Exception("Nepodarilo se dohledat preklad pro status dotazu");
				break;
		}
	}

	public function setAnswer($answer) {
		return dbI::query("UPDATE s3n_dotaz SET answer = %s WHERE id = %i", $answer, $this->id)->update($this->answer, $answer)->result();
	}

	public function setStatus($status) {
		return dbI::query("UPDATE s3n_dotaz SET status = %i WHERE id = %i", $status, $this->id)->result();
	}

}
