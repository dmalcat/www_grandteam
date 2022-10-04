<?php

	class Session {

	public static function get($name) {
		return $_SESSION[$name];
	}
	public static function set($name, $value) {
		$_SESSION[$name] = $value;
	}
	public static function set_if_different($name, $value) {
		if (Session::get($name) != $value) $_SESSION[$name] = $value;
	}
	public static function set_if_not_exist($name, $value) {
		if (Session::get($name) == "") $_SESSION[$name] = $value;
	}


}
?>