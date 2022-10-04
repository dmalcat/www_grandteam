<?php

/**
 * Description of dbArray
 *
 * @author leos
 */
class dbArray extends ArrayObject {

	private static $_sortBy;
	private static $_sortOrder;
	
	public static $parPage = 6;
	public static $hasPrev = 0;
	public static $hasNext = 0;
	public static $prevLnk = "";
	public static $nextLnk = "";

	public function limit($offset, $limit) {
		if(!$offset) $offset = 0;
		if(!$limit) $limit = self::$parPage -1;
		return array_slice((array) $this, $offset, $limit);
	}
	
	public function page($page = null) {
		if(!$page) $page = (int)$_GET["pg"];
		if(!$page) $page = 1;
		$offset = $page - 1;
		if($offset < 0) $offset = 0;
		$offset = $offset * self::$parPage;
		$limit = self::$parPage;
		self::$hasPrev = $offset == 0 ? false : $page - 1; 
		self::$hasNext = array_slice((array) $this, ($page) * self::$parPage , $limit) ? ($page + 1) : false; 
		
//		print_p(array_slice((array) $this, ($page) * self::$parPage , $limit));
		
		self::$prevLnk = $page > 2 ? substr($_SERVER["REQUEST_URI"], 0, strpos($_SERVER["REQUEST_URI"], '?')) . "?pg=" . ($page - 1) : substr($_SERVER["REQUEST_URI"], 0, strpos($_SERVER["REQUEST_URI"], '?'));
		self::$nextLnk = substr($_SERVER["REQUEST_URI"], 0, strpos($_SERVER["REQUEST_URI"], '?')) . "?pg=" . ($page+1);
		
//		print_p($offset);
//		print_p($limit);
//		print_p(self::$hasPrev);
//		print_p(self::$hasNext);
//		print_p(self::$prevLnk);
//		print_p(self::$nextLnk);
		return array_slice((array) $this, $offset, $limit);
	}
	
	public function sort($sortBy, $sortOrder = "ASC") {
		self::$_sortBy = $sortBy;
		self::$_sortOrder = trim(strtolower($sortOrder)) == "desc" ? "DESC" : "ASC";
		switch ($orderBy) {
			case "id": $this->uasort(array("dbArray", "_cmpInt")); break;
			case "priority": $this->uasort(array("dbArray", "_cmpInt")); break;
			case "name": $this->uasort(array("dbArray", "_cmpString")); break;
			case "datum": $this->uasort(array("dbArray", "_cmpDate")); break;
			case "visible_from": $this->uasort(array("dbArray", "_cmpDate")); break;
			case "visible_to": $this->uasort(array("dbArray", "_cmpDate")); break;
			default: is_numeric($orderBy) ? $this->uasort(array("dbArray", "_cmpInt")) : $this->uasort(array("dbArray", "_cmpString")) ; break;
		}
		return $this;


	}

	public static function _cmpInt($a, $b) {
		if(self::$_sortOrder == "ASC")  {
			return ($a->{self::$_sortBy} - $b->{self::$_sortBy});
		} else {
			return ($b->{self::$_sortBy} - $a->{self::$_sortBy});
		}

	}
	public static function _cmpDate($a, $b) {
		$a = strtotime($a);
		$b = strtotime($b);
		if(self::$_sortOrder == "ASC")  {
			return ($a->{self::$_sortBy} - $b->{self::$_sortBy});
		} else {
			return ($b->{self::$_sortBy} - $a->{self::$_sortBy});
		}

	}
	public static function _cmpString($a, $b) {
		$sortable = array(strtolower($a->{self::$_sortBy}),strtolower($b->{self::$_sortBy}));
		$sorted = $sortable;
		sort($sorted);
		if(self::$_sortOrder == "ASC")  {
			return ($sorted[0] == $sortable[0]) ? -1 : 1;
		} else {
			return ($sorted[0] == $sortable[0]) ? 1 : -1;
		}
	}
}
?>
