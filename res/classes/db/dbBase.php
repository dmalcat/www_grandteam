<?php

	/**
	* DB base class for row instantiation
	* used instead of DibiRow
	* @package db
	*/
	class dbBase implements dbIBase {

		/**
		* @param array $array
		*/
		public function __construct(Array $array) {
			foreach ($array as $key => $var) {
				$this->$key = $var;
			}
		}

		/**
		* Converts value to date-time format.
		* @author David Grudl
		* @param string $key
		* @param string $format (TRUE means DateTime object)
		* @return mixed
		*/
		public function asDate($key, $format = NULL) {
			$time = $this->$key;
			if ($time == NULL) { // intentionally ==
				return NULL;
			} elseif ($format === NULL) { // return timestamp (default)
				return is_numeric($time) ? (int) $time : strtotime($time);
			} elseif ($format === TRUE) { // return DateTime object
				return new DateTime(is_numeric($time) ? @date('Y-m-d H:i:s', $time) : $time);
			} elseif (is_numeric($time)) { // single timestamp
				return @date($format, $time);
			} elseif (class_exists('DateTime', FALSE)) { // since PHP 5.2
				$time = new DateTime($time);
				return $time ? $time->format($format) : NULL;
			} else {
				return @date($format, strtotime($time));
			}
		}

		/**
		* Converts value to boolean.
		* @author David Grudl
		* @param string $key
		* @return mixed
		*/
		public function asBool($key) {
			$value = $this->$key;
			if ($value === NULL || $value === FALSE) {
				return $value;
			} else {
				return ((bool) $value) && $value !== 'f' && $value !== 'F';
			}
		}

		/**
		* Returns ID
		* @return mixed usualy int
		*/
		public function getId() {
			return $this->id;
		}

//		/**
//		* Returns ID
//		* @return mixed usualy int
//		*/
//		public function limit() {
//			return $this->id;
//		}

		/**
		 * Vrati preforamtovany datum (Y-m-d) z datepickera
		 * @param string $sDate Datum z datepickera
		 * @return string
		 */
		public function changeDatepickerDate ( $sDate = '' ) {
			return vsprintf( '%3$04d-%2$02d-%1$02d', explode( '.', $sDate ) );
		}

}