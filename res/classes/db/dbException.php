<?php

	/**
	* db common exception
	* @author Wexx
	* @package db
	*/
	class dbException extends Exception {
		public function __construct($message, $code = 0, Exception $previous = null) {
			$USER;
			$message = '[' . dbUser::getById($USER->data["id_user"])->login . '@' . $_SERVER["HTTP_HOST"] . '/' . "]\n" . $message;
			parent::__construct($message, $code, $previous);
		}
	}