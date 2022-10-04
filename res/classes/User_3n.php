<?php

/**
 * @package 3n_devel
 * @class User_3n - zakladni trida pro praci s daty e-shopu
 * @author Habr habr@pinda.cz
 * @version 1.2-20071111A
 * @depends ErrorHeap
 * @license http://opensource.org/licenses/gpl-license.php GNU Public License
 */

/**
 * error_heap - to je tam potreba :o)
 */
//require_once "error_heap.class.php";


class User_3n {

	const FILE_STORAGE_PATH = USER_IMG_DATA_DIR;
	const FILE_HTTP_PATH = USER_IMG_HTTP_DIR; // bez lomitka na konci !!
	const IMG_CATEGORY_PATH = SYS_IMG_CATEGORY_PATH;
	const CREATE_FILE_MODE = 0644;
	const CREATE_DIR_MODE = 0755;
	const IMG_THUMBNAIL_WIDTH = 73;
	const IMG_THUMBNAIL_HEIGHT = 83;
	const IMG_PREVIEW_WIDTH = 172;
	const IMG_PREVIEW_HEIGHT = 172;
	const IMG_EMAIL_WIDTH = 73;
	const IMG_EMAIL_HEIGHT = 83;
	const IMG_JPEG_QUALITY = 80;
	const IMG_CATEGORY_WIDTH = 280;
	const IMG_CATEGORY_HEIGHT = 346;

	/**
	 * @var PEAR::DB PEAR::DB Objekt
	 */
	var $DB;

	/**
	 * @var ErrorHeap ERROR Objekt
	 */
	var $ERROR;

	/**
	 * @var String Prefix tabulek v DB
	 */
	var $tbl_prefix;
	var $enum_types;
	var $set_types;
	var $string_types;
	var $file_types;
	var $image_types;
	var $allowed_image_types;
	var $data;

	/**
	 * @param PEAR::DB $DB (klonovat, nikoli ukazatel!)
	 * @param string|NULL $tbl_prefix prefix tabulek, nepovinny
	 * @return Shop_3n Objekt
	 */
	public function __construct($DB, $tbl_prefix = "") {
		global $ERROR;

		$this->DB = $DB;
		$this->tbl_prefix = $tbl_prefix;
		$this->ERROR = &$ERROR;

		$this->DB->autoCommit(false);
		$this->DB->setFetchMode(DB_FETCHMODE_OBJECT);

		// DB typy
		$this->enum_types = array("E_SELECT", "E_RADIO");
		$this->set_types = array("S_CHECKBOX");
		$this->string_types = array("STRING", "TEXTAREA");
		$this->file_types = array("FILE");
		$this->image_types = array("IMAGE");
		$this->allowed_image_types = array(2, 3, 4);
	}

	public function __destruct() {
		$this->DB->commit();
	}

	/**
	 * @param String $msg Popis chyby
	 * @param int $severity Zavazost chyby podle ERROR::severity
	 * @return null
	 */
	private function spawn_error($msg, $severity, $svrcode = ERROR::OK) {
		$this->DB->rollback();
		$this->ERROR->spawn("User_3n", 1, $svrcode, $severity, $msg);
	}

	/**
	 * overeni vystupu z pear::db pri dotazu, de li o chybu crashne
	 *
	 * @param DB::result $r
	 * @return boolean|null
	 */
	public function check($r) {
		if (PEAR::isError($r)) {
			echo $this->DB->last_query;
			self::spawn_error($r->getMessage(), ERROR::CRIT);
			return false;
		}
	}

	/**
	 * pridani zaznamu (vlastnosti) k useru, pokud je ok vrati true
	 *
	 * @param int $id_user
	 * @param string $prop_name
	 * @param string $prop_value
	 * @return boolean
	 */
	public function set_user_property($id_user, $prop_name, $prop_value) {
		$id_user = (int) $id_user;
		if ($id_user < 1) return false;
		$tbl_prefix = $this->tbl_prefix;
		$prop_info = $this->get_property_info($prop_name);
		if (!is_array($prop_info)) {
			$this->spawn_error("Prop info neexistuje", ERROR::CRIT);
			return false;
		}

		$id_property = (int) $prop_info["PROP_ID"];

		//echo "$prop_name -> $prop_value ($id_property)<br/>";

		if ($id_property < 1) return false;

		// kdyz de vo enum, mrdne se tam mapovani ..
		if (in_array($prop_info["PROP_TYPE"], $this->enum_types)) {
			// smazem existujici
			$this->del_property_mapping($id_user, $id_property);

			// zjisteni id_enumeration
			$id_enumeration = (int) $this->get_id_enumeration($id_property, $prop_value);

			// a ulozeni
			$r = $this->DB->query("
				insert into ${tbl_prefix}user_map_property (id_user, id_property, id_enumeration)
				values (?, ?, ?);
			", array(
				(int) $id_user,
				(int) $id_property,
				(int) $id_enumeration
			));
			$this->check($r);

			// dyz de vo SET (vycet s vice moznostmama) to samy co predtim ale s foreach na hodnoty
		} else if (in_array($prop_info["PROP_TYPE"], $this->set_types)) {
			// smazem existujici
			$this->del_property_mapping($id_user, $id_property);

			if (!is_array($prop_value)) return false;

			foreach ($prop_value as $value) {

				// zjisteni id_enumeration
				$id_enumeration = (int) $this->get_id_enumeration($id_property, $value);

				// a ulozeni
				$r = $this->DB->query("
					insert into ${tbl_prefix}user_map_property (id_user, id_property, id_enumeration)
					values (?, ?, ?);
				", array(
					(int) $id_user,
					(int) $id_property,
					(int) $id_enumeration
				));
				$this->check($r);
			}

			// fuj to je zas if dlouhej jak tejden pred vejplatou	.
			// tady teda string typy (string/textarea...to samy) ...
		} else if (in_array($prop_info["PROP_TYPE"], $this->string_types)) {
			// neni co resit ... rovnou smazem a ulozime
			$this->del_property_mapping($id_user, $id_property);

			$r = $this->DB->query("
				insert into ${tbl_prefix}user_map_property (id_user, id_property, value)
				values (?, ?, ?);
			", array(
				(int) $id_user,
				(int) $id_property,
				$prop_value
			));
			$this->check($r);

			// souborovy typy ... image / file (proste upload souboru hec!)
		} else if (in_array($prop_info["PROP_TYPE"], array_merge($this->image_types, $this->file_types))) {
			// TUDU kdybys to Habre hledal
			if ($prop_value === null OR $prop_value == "_delete_file_") {
				$this->del_property_mapping($id_user, $id_property);
			} else if (is_uploaded_file($prop_value["tmp_name"]) OR true) { // true pouze pro automedic - kvuli importu
				$ext = getFileExtenstion($prop_value["name"]);
				$name_without_ext = getFileNameWithoutExtenstion($prop_value["name"]);
				$id_file_type = $this->getFileIdType($ext);
				// a vubec uz me to nebavi komentovat!
				if (in_array($prop_info["PROP_TYPE"], $this->image_types)) {
					if (!in_array($id_file_type, $this->allowed_image_types)) {
						$this->spawn_error("Nepodporovany format obrazku!", ERROR::ERR);
					}
				}

				$this->DB->query("
					insert into s3n_files (filename, id_type, size)
					values (?, ?, ?);
				", array(
					$prop_value["name"],
					$id_file_type,
					filesize($prop_value["tmp_name"])
				));
				$id_file = (int) $this->DB->getOne("
					select last_insert_id();
				");

				$dir = self::FILE_STORAGE_PATH . "/" . $id_user;
				//echo $dir;
				if (!file_exists($dir)) {
					if (!mkdir($dir)) {
						$this->spawn_error("Nele vytvorit adresar pro upload souboru $dir !", ERROR::CRIT);
					}
					chmod($dir, self::CREATE_DIR_MODE);
				}
				$new_name = $id_file . "-O-" . urlFriendly($name_without_ext) . "." . $ext;
				$new_name_thumbnail = $id_file . "-T-" . urlFriendly($name_without_ext) . ".jpg";
				$new_name_preview = $id_file . "-P-" . urlFriendly($name_without_ext) . ".jpg";
				$new_name_email = $id_file . "-E-" . urlFriendly($name_without_ext) . ".jpg";

				$new_fname = $dir . "/" . $new_name;
				$new_fname_thumbnail = $dir . "/" . $new_name_thumbnail;
				$new_fname_preview = $dir . "/" . $new_name_preview;
				$new_fname_email = $dir . "/" . $new_name_email;

				if (!rename($prop_value["tmp_name"], $new_fname)) {
					$this->spawn_error("Nele nahrat soubor!", ERROR::CRIT);
				}

				chmod($new_fname, self::CREATE_FILE_MODE);

				$file_url = $id_user . "/" . $new_name;
				$thumbnail_url = null;
				$preview_url = null;
				$email_url = null;

				if (in_array($prop_info["PROP_TYPE"], $this->image_types)) {
					$thumbnail_url = $id_user . "/" . $new_name_thumbnail;
					$preview_url = $id_user . "/" . $new_name_preview;
					$email_url = $id_user . "/" . $new_name_email;

					$resize = new Resize($new_fname);
					$resize->setJpegQuality(self::IMG_JPEG_QUALITY);
					$resize->sizeAutoBothDimensions(self::IMG_PREVIEW_WIDTH, self::IMG_PREVIEW_HEIGHT);
					$resize->save($new_fname_preview);
					chmod($new_fname_preview, self::CREATE_FILE_MODE);

					$resize = new Resize($new_fname_preview);
					$resize->setJpegQuality(self::IMG_JPEG_QUALITY);
					$resize->sizeAutoBothDimensions(self::IMG_THUMBNAIL_WIDTH, self::IMG_THUMBNAIL_HEIGHT);
					$resize->save($new_fname_thumbnail);
					chmod($new_fname_thumbnail, self::CREATE_FILE_MODE);

					$resize = new Resize($new_fname_thumbnail);
					$resize->setJpegQuality(self::IMG_JPEG_QUALITY);
					$resize->sizeAutoBothDimensions(self::IMG_EMAIL_WIDTH, self::IMG_EMAIL_HEIGHT);
					$resize->save($new_fname_email);
					chmod($new_fname_email, self::CREATE_FILE_MODE);
				}
				// TODO email do db
				$this->DB->query("
					update s3n_files set url = ?, thumbnail_url = ?, preview_url = ?, email_url = ?
					where id_file = ?;
				", array(
					$file_url,
					$thumbnail_url,
					$preview_url,
					$email_url,
					$id_file
				));

				$this->del_property_mapping($id_user, $id_property);

				$r = $this->DB->query("
					insert into s3n_user_map_property (id_user, id_property, id_file)
					values (?, ?, ?);
				", array(
					(int) $id_user,
					(int) $id_property,
					$id_file
				));
				$this->check($r);
			}
		}
		$this->DB->commit();
		return true;
	}

	public function getFileIdType($fext) {
		$r = $this->DB->getAssoc("
			select id_type, extensions from s3n_file_types;
		");

		$this->check($r);

		foreach ($r as $id_type => $extensions) {
			$extensions = explode(",", $extensions);
			foreach ($extensions as $extension) {
				if (strtolower($fext) == strtolower($extension)) {
					return $id_type;
				}
			}
		}
		return 1;
	}

	/**
	 * vrati pole s obsahem vlastnosti
	 *
	 * @param int id_user
	 * @param string prop_name
	 *
	 * @return array|null v pripade ze dana vazba neexistuje
	 */
	public function get_user_property($id_user, $prop_name) {
		$tbl_prefix = $this->tbl_prefix;

		$id_user = (int) $id_user;

		$row = $this->DB->getRow("
				select ump.id_property as ID_PROPERTY, p.prop_name as PROP_NAME, p.prop_type as PROP_TYPE, p.unit as PROP_UNIT, ump.value as PROP_VALUE from ${tbl_prefix}user_map_property as ump
				inner join ${tbl_prefix}user_property as p on ump.id_property = p.id_property
				where ump.id_user = ? and p.prop_name = ?
				limit 1;
		", array(
			(int) $id_user,
			$prop_name,
		));
		$this->check($row);

		if ($row == null) return null;

		$property["PROP_NAME"] = $row->PROP_NAME;
		$property["PROP_TYPE"] = $row->PROP_TYPE;
		$property["PROP_UNIT"] = $row->PROP_UNIT;

		// stringy
		if (in_array($row->PROP_TYPE, $this->string_types)) {
			$property["ENUMERATED"] = false;
			$property["PROP_VALUE"] = $row->PROP_VALUE;
			// enumy/sety
		} else if (in_array($row->PROP_TYPE, $this->enum_types) || in_array($row->PROP_TYPE, $this->set_types)) {
			$property["ENUMERATED"] = true;
			// select vyctu
			$re = $this->DB->getAll("
				select pe.id_enumeration, pe.value, ump.id_map from ${tbl_prefix}user_property_enumeration as pe
				left join ${tbl_prefix}user_map_property as ump on pe.id_enumeration = ump.id_enumeration and ump.id_user = ?
				where pe.id_property = ?
			", array(
				(int) $id_user,
				(int) $row->ID_PROPERTY
			));
			$this->check($re);
			unset($enums);
			unset($values);
			if (is_array($re)) {
				foreach ($re as $enum) {
					unset($enum_val);
					$enum_val["id_enumeration"] = $enum->id_enumeration;
					$enum_val["value"] = $enum->value;

					if ($enum->id_map !== null) {
						$values[] = $enum_val;
					}
					$enum_vals[] = $enum_val;
				}
			}

			$property["PROP_ENUMERATION"] = $enum_vals;
			$property["PROP_VALUE"] = $values;

			// subory
		} else if (in_array($row->PROP_TYPE, array_merge($this->file_types, $this->image_types))) {
			$property["ENUMERATED"] = false;

			$r = $this->DB->getRow("
				select f.filename, f.url, f.size, f.thumbnail_url, f.preview_url, f.email_url, ft.type, ft.icon_url from s3n_user_map_property as imp
				inner join s3n_files as f on f.id_file = imp.id_file
				inner join s3n_file_types as ft on f.id_type = ft.id_type
				where imp.id_user = ?
				and imp.id_property = ?
			", array(
				(int) $id_user,
				(int) $row->ID_PROPERTY
			));
			$this->check($r);


			if (in_array($row->PROP_TYPE, $this->file_types)) {
				$property["PROP_VALUE"]["url"] = self::FILE_HTTP_PATH . "/" . $r->url;
				$property["PROP_VALUE"]["type"] = $r->type;
				$property["PROP_VALUE"]["icon_url"] = $r->icon_url;
				$property["PROP_VALUE"]["size"] = $r->size;
				$property["PROP_VALUE"]["filename"] = $r->filename;
			} else {
				$property["PROP_VALUE"]["url"] = self::FILE_HTTP_PATH . "/" . $r->url;
				$property["PROP_VALUE"]["preview_url"] = self::FILE_HTTP_PATH . "/" . $r->preview_url;
				$property["PROP_VALUE"]["thumbnail_url"] = self::FILE_HTTP_PATH . "/" . $r->thumbnail_url;
				$property["PROP_VALUE"]["email_url"] = self::FILE_HTTP_PATH . "/" . $r->email_url;
			}
		}
		//print_p($property);
		return $property;
	}

	/**
	 * vrati seznam stepu
	 *
	 * @return array
	 */
	public function get_steps($only_visible = false) {
		$tbl_prefix = $this->tbl_prefix;

		$sql = "select id_step, name, description, weight, visible from {$tbl_prefix}user_step";
		if ($only_visible) $sql .= " where visible = '1'";
		$sql .= " order by weight asc;";
		$r = $this->DB->getAll($sql);
		$this->check($r);

		$steps = array();

		if (is_array($r)) {
			$count = 1; // potrebujeme aby stepy sli od jednicky kvuli registraci
			foreach ($r as $row) {
				unset($step);
				$step["ID_STEP"] = (int) $row->id_step;
				$step["NAME"] = $row->name;
				$step["DESCRIPTION"] = $row->description;
				$step["WEIGHT"] = $row->weight;
				$step["VISIBLE"] = $row->visible;
				//error dodano weight
				//$steps[(int) $row->id_step] = $step;
				$steps[$count] = $step;
				$count++;
			}
		}

		return $steps;
	}

	/**
	 * vraci pole kategorii a jejich vlastnosti ve stepu
	 *
	 * @param int id_step
	 *
	 * @return array
	 */
	public function get_step_categories($id_step, $only_visible = false) {
		$tbl_prefix = $this->tbl_prefix;

		$sql = "select c.id_category AS id, c.id_category, c.name, c.description, c.visible from ${tbl_prefix}user_step_map_category as smc
			inner join ${tbl_prefix}user_category as c on smc.id_category = c.id_category
			where smc.id_step = ?";
		if ($only_visible) $sql .= " AND visible = '1'";
		$sql .= " order by smc.weight asc;";
// 		echo $sql;
		$r = $this->DB->getAll($sql, array(
			(int) $id_step
		));
		$this->check($r);

		if ($r == null) return array();

		$cats = array();
		foreach ($r as $row) {
			unset($cat);
			$cat["ID_CATEGORY"] = $row->id_category;
			$cat["NAME"] = $row->name;
			$cat["DESCRIPTION"] = $row->description;
			$cat["VISIBLE"] = $row->visible;

			$cats[$row->id_category] = $cat;
		}
		return $cats;
	}

	/**
	 * nic leda ze je to pouzito i mimo kategorie - tj kdyz se nezada kategorie
	 */
	public function get_category_properties($id_category, $show = "", $only_visible = false) {
		$tbl_prefix = $this->tbl_prefix;

		if (strlen($show) > 0) {
			$show = explode(",", $show);
			foreach ($show as $condition) {
				$condition = addslashes($condition);
				$show_conditions[] = "find_in_set('${condition}', `show`) > 0";
			}
			$show_condition = implode(" or ", $show_conditions);
			if (strlen($show_condition) > 0) {
				$show_condition = "and (" . $show_condition . ")";
			}
		}

		if ($id_category) $show_condition .= " AND ucmp.id_category = " . (int) $id_category;
		if ($only_visible) $show_condition .= " AND visible = '1'";

		$r = $this->DB->getAll("
			select ucmp.id_category, p.id_property, p.prop_name, p.required, p.must_fill, p.unit, p.prop_type, p.visible, p.validation_regex, p.show from ${tbl_prefix}user_category_map_property as ucmp
			inner join ${tbl_prefix}user_property as p on ucmp.id_property = p.id_property
			where 1
			" . $show_condition . "
			order by ucmp.weight asc, ucmp.id_category, p.id_property;");
		$this->check($r);

		if ($r == null) return array();

		$props = array();
		foreach ($r as $row) {
			unset($prop);
			$prop["PROP_ID"] = $row->id_property;
			$prop["PROP_NAME"] = $row->prop_name;
			$prop["PROP_TYPE"] = $row->prop_type;
			$prop["PROP_UNIT"] = $row->unit;
			$prop["PROP_SEARCH"] = $row->search ? true : false;
			$prop["PROP_INHERIT"] = $row->inherit ? true : false;
			$prop["PROP_VISIBLE"] = $row->visible ? true : false;
			$prop["PROP_REQUIRED"] = $row->required ? true : false;
			$prop["PROP_MUST_FILL"] = $row->must_fill ? true : false;
			$prop["PROP_VALIDATION_REGEX"] = $row->validation_regex;
			$prop["PROP_SORT_TYPE"] = $row->sort_type;
			$prop["PROP_SHOW"] = explode(",", $row->show);

			if (in_array($row->prop_type, array_merge($this->enum_types, $this->set_types))) {
				$prop["PROP_ENUMERATED"] = true;
				$prop["PROP_ENUMERATION"] = $this->get_property_enumeration($row->id_property);
			} else {
				$prop["PROP_ENUMERATED"] = false;
			}

			//$props[$prop["PROP_ID"]] = $prop;
			$props[$prop["PROP_NAME"]] = $prop;
		}
		return $props;
	}

	/**
	 * vraci pole infa o userovi - tj login atd.
	 *
	 * @param int id_user
	 *
	 * @return array
	 */
	public function get_user_info($id_user) {
		$tbl_prefix = $this->tbl_prefix;

		$r = $this->DB->getRow("SELECT * FROM ${tbl_prefix}users WHERE id_user = ?
		", array(
			(int) $id_user
		));
		$this->check($r);
		return ($r);
	}

	public function get_user_sleva($id_price_list) {
		$result = $this->DB->getone("SELECT sleva FROM s3n_price_list WHERE id_list = " . $id_price_list);
		return ($result);
	}

	/**
	 * vraci pole kategorii ve kterych se user vyskytuje
	 *
	 * @param int id_user
	 *
	 * @return array
	 */
	public function get_user_categories($id_user) {
		$tbl_prefix = $this->tbl_prefix;

		$r = $this->DB->getAssoc("SELECT id_category AS id, id_category FROM ${tbl_prefix}user_category_map_property WHERE id_user = " . (int) $id_user);
		$this->check($r);
		//echo $this->DB->last_query;
		return ($r);
	}

	public function get_user_detail($id_user, $show_empty = false, $show = "detail", $only_visible = false) {
		$steps = $this->get_steps($only_visible);

		foreach ($steps as $step) {
			$step["CATEGORIES"] = $this->get_step_categories($step["ID_STEP"], $only_visible);
			foreach ($step["CATEGORIES"] as $key => $value) {
				$step["CATEGORIES"][$key]["PROPERTIES"] = $this->get_category_properties($value["ID_CATEGORY"], $show, $only_visible);
				//echo $value["ID_CATEGORY"];

				foreach ($step["CATEGORIES"][$key]["PROPERTIES"] as $prop_key => $prop_val) {
					$user_prop = $this->get_user_property($id_user, $prop_val["PROP_NAME"]);

					if ($user_prop !== null) {
						$step["CATEGORIES"][$key]["PROPERTIES"][$prop_key] = $this->get_user_property($id_user, $prop_val["PROP_NAME"]);
					} else {
						if (!$show_empty) {
							unset($step["CATEGORIES"][$key]["PROPERTIES"][$prop_key]);
						}
					}
				}
				$full_steps[$step["ID_STEP"]] = $step;
			}
		}

		$result["INFO"] = $this->get_user_info($id_user);
		$result["STEPS"] = $full_steps;

		//var_dump($full_steps);
		return ($result);
	}

	public function get_user_detail_compact($id_user, $show_empty = false, $show = "detail", $only_visible = false) {
		$steps = $this->get_steps($only_visible);

		foreach ($steps as $step) {
			$p_categories = $this->get_step_categories($step["ID_STEP"], $only_visible);
			foreach ($p_categories as $key => $value) {
				$p_properties = $this->get_category_properties($value["ID_CATEGORY"], $show, $only_visible);
				foreach ($p_properties as $prop_key => $prop_val) {
					$user_prop = $this->get_user_property($id_user, $prop_val["PROP_NAME"]);


					if ($user_prop !== null) {
						$p_full_properties[$prop_val["PROP_NAME"]] = $this->get_user_property($id_user, $prop_val["PROP_NAME"]);
					} else {
						if (!$show_empty) {
							unset($step["CATEGORIES"][$key]["PROPERTIES"][$prop_key]);
						}
					}
				}
			}
		}

		$result["INFO"] = $this->get_user_info($id_user);
		$result["PROPERTIES"] = $p_full_properties;
		return ($result);
	}

	public function user_delete($id_user) {
		$tbl_prefix = $this->tbl_prefix;
		$r = $this->DB->query("
			delete from ${tbl_prefix}users
			where id_user = ?
			;
		", array(
			(int) $id_user
		));
		$this->check($r);
		return true;
	}

	public function step_add($step_name, $step_description, $step_weight, $visible) {
		$tbl_prefix = $this->tbl_prefix;
		// vytvoreni itemu
		$r = $this->DB->query("
			insert into ${tbl_prefix}user_step (name, description, weight, visible)
			values (?, ?, ?, ?);
		", array(
			$step_name,
			$step_description,
			(int) $step_weight,
			$visible ? "1" : "0"
		));
		$this->check($r);
		$this->DB->commit();
		return true;
	}

	public function step_edit($id_step, $step_name, $step_description, $step_weight, $visible) {
		$tbl_prefix = $this->tbl_prefix;
		$id_step = (int) $id_step;
		// TODO: osetrit, nebo ne?
		$r = $this->DB->getOne("
			select id_step from ${tbl_prefix}user_step WHERE id_step = ?;
		", array($id_step));
		$this->check($r);
		if ($r == null) {
			$this->spawn_error("Krok $id_step neexistuje!", ERROR::ERR);
			return false;
		}

		$r = $this->DB->query("
			update ${tbl_prefix}user_step set name = ?, description = ?, weight = ?, visible = ?
			where id_step = ?;
		", array(
			$step_name,
			$step_description,
			(int) $step_weight,
			$visible ? "1" : "0",
			$id_step
		));
		$this->check($r);
		$this->DB->commit();

		return true;
	}

	public function step_delete($id_step) {
		$tbl_prefix = $this->tbl_prefix;
		$r = $this->DB->query("
			delete from ${tbl_prefix}user_step
			where id_step = ?
			;
		", array(
			(int) $id_step
		));
		$this->check($r);
		return true;
	}

	public function category_add($category_name, $category_description, $category_weight, $id_step, $visible) {
		$tbl_prefix = $this->tbl_prefix;
		// vytvoreni itemu
		$r = $this->DB->query("
			insert into ${tbl_prefix}user_category (name, description, visible)
			values (?, ?, ?);
		", array(
			$category_name,
			$category_description,
			$visible ? "1" : "0"
		));
		//echo $this->DB->last_query;
		$this->check($r);
		// zjisteni id_category
		$r = $this->DB->getOne("
			select max(id_category) from ${tbl_prefix}user_category;
		");
		$this->check($r);
		$id_category = (int) $r;

		$r = $this->DB->query("
			insert into ${tbl_prefix}user_step_map_category (id_step, id_category, weight)
			values (?, ?, ?);
		", array(
			(int) $id_step,
			(int) $id_category,
			(int) $category_weight
		));
		$this->check($r);

		$this->DB->commit();
		return true;
	}

	public function category_edit($id_category, $category_name, $category_description, $id_step, $visible) {
		$tbl_prefix = $this->tbl_prefix;
		$id_category = (int) $id_category;
		$id_step = (int) $id_step;

		$r = $this->DB->query("
			update ${tbl_prefix}user_category set name = ?, description = ?, visible = ?
			where id_category = ?;
		", array(
			$category_name,
			$category_description,
			$visible ? "1" : "0",
			$id_category
		));
		$this->check($r);

		$r = $this->DB->getOne("
			select id_step from ${tbl_prefix}user_step_map_category WHERE id_category = ?;
		", array($id_category));
		$this->check($r);
		if ($r != $id_step) { //premapujeme categorii na jiny step
			$r = $this->DB->query("
				update ${tbl_prefix}user_step_map_category set id_step = ?
				where id_category = ?;
			", array(
				$id_step,
				$id_category
			));
			$this->check($r);
		}

		$this->DB->commit();

		return true;
	}

	public function category_delete($id_category) {
		$tbl_prefix = $this->tbl_prefix;
		$r = $this->DB->query("
			delete from ${tbl_prefix}user_category
			where id_category = ?
			;
		", array(
			(int) $id_category
		));
		$this->check($r);
		$this->DB->commit();
		return true;
	}

	/**
	 * vrati pole s vyctem pro vlastnost (pokud neni vrati null)
	 *
	 * @param int id_property
	 * @return array|null
	 */
	public function get_property_enumeration($id_property) {
		$tbl_prefix = $this->tbl_prefix;

		$r = $this->DB->getAll("
			select id_enumeration, value from ${tbl_prefix}user_property_enumeration
			where id_property = ?;
		", array(
			(int) $id_property
		));
		$this->check($r);

		if ($r == null) return null;

		foreach ($r as $row) {
			unset($enum);
			$enum["id_enumeration"] = $row->id_enumeration;
			$enum["value"] = $row->value;

			$enums[] = $enum;
		}

		return $enums;
	}

	/**
	 * vrati pole s informacema o vlastnosti
	 *
	 * @param string $prop_name
	 * @return array
	 */
	public function get_property_info($prop_name) {
		$tbl_prefix = $this->tbl_prefix;

		$r = $this->DB->getRow("
			select id_property, prop_name, required, unit, prop_type, validation_regex, must_fill from ${tbl_prefix}user_property
			where prop_name = ?;
		", array(
			$prop_name
		));
		$this->check($r);
		// vlastnost neexistuje
		if ($r === null) {
			$this->spawn_error("Vlastnost '${prop_name}' neexistuje!", ERROR::ERR);
			return false;
		}
		return array(
			"PROP_ID" => $r->id_property,
			"PROP_NAME" => $r->prop_name,
			"PROP_IS_REQUIRED" => $r->required ? true : false,
			"PROP_MUST_FILL" => $r->must_fill ? true : false,
			"PROP_UNIT" => $r->unit,
			"PROP_TYPE" => $r->prop_type,
			"PROP_SEARCH" => $r->search,
			"PROP_INHERIT" => $r->inherit,
			"PROP_VALIDATION_REGEX" => $r->validation_regex,
			"PROP_SORT_TYPE" => $r->sort_type
		);
	}

	/**
	 * smaze secky udaje o mapovani (hodnoty vlastnosti)
	 *
	 * @param int $id_user
	 * @param int $id_property
	 * @return null
	 */
	public function del_property_mapping($id_user, $id_property) {
		$tbl_prefix = $this->tbl_prefix;
		$r = $this->DB->query("
			delete from ${tbl_prefix}user_map_property
			where id_property = ?
			and id_user = ?;
		", array(
			(int) $id_property,
			(int) $id_user,
		));
		$this->check($r);
	}

	/**
	 * vrati id_enumeration podle hodnoty a id_property
	 *
	 * @param int $id_property
	 * @param string $value
	 * @return int id_enumeration
	 */
	private function get_id_enumeration($id_property, $prop_value) {
		$tbl_prefix = $this->tbl_prefix;
		$r = $this->DB->getOne("
			select id_enumeration from ${tbl_prefix}user_property_enumeration
			where id_property = ?
			and value = ?;
		", array(
			(int) $id_property,
			$prop_value
		));
		$this->check($r);
		return $prop_value; //uprava error - ja uz posilam ve valu id_enumeration
		return $r ? (int) $r : false;
	}

	public function property_add($id_category, $prop_name, $prop_type, $prop_unit, $prop_validation_regex, $prop_show, $move_to_category, $prop_visible, $must_fill) {
		$tbl_prefix = $this->tbl_prefix;
		$id_property = (int) $id_property;

		$r = $this->DB->query("
			INSERT ${tbl_prefix}user_property  (prop_name, prop_type, unit, validation_regex, `show`, visible, must_fill)
			VALUES (?, ?, ?, ?, ?, ?, ?)
		", array(
			$prop_name,
			$prop_type,
			$prop_unit,
			$prop_validation_regex,
			implode(",", is_array($prop_show) ? $prop_show : array('detail')),
			$prop_visible ? "1" : "0",
			$must_fill ? "1" : "0"
		));
		$this->check($r);

		// zjisteni id_category
		$r = $this->DB->getOne("
			select max(id_property) from ${tbl_prefix}user_property;
		");
		$this->check($r);
		$id_property = (int) $r;

		$r = $this->DB->query("
			INSERT ${tbl_prefix}user_category_map_property  (id_category, id_property, weight)
			VALUES (?, ?, ?)
		", array(
			(int) $id_category,
			(int) $id_property,
			10
		));
		$this->check($r);
		$r = $this->DB->query("
			UPDATE ${tbl_prefix}user_category_map_property  set id_category = ?
			WHERE id_property = ?;
		", array(
			(int) $move_to_category,
			(int) $id_property
		));
		$this->check($r);

		$this->DB->commit();
		return true;
	}

	public function property_edit($id_property, $prop_name, $prop_type, $prop_unit, $prop_validation_regex, $prop_show, $move_to_category, $prop_visible, $must_fill) {
		$tbl_prefix = $this->tbl_prefix;

		$r = $this->DB->query("
			update ${tbl_prefix}user_property set prop_name = ?, unit = ?, validation_regex = ?, `show` = ?, visible = ?, must_fill = ?
			where id_property = ?;
		", array(
			$prop_name,
			//$prop_type,
			$prop_unit,
			$prop_validation_regex,
			implode(",", is_array($prop_show) ? $prop_show : array('detail')),
			$prop_visible ? "1" : "0",
			$must_fill ? "1" : "0",
			(int) $id_property
		));
		$this->check($r);

		$r = $this->DB->query("
			UPDATE ${tbl_prefix}user_category_map_property  set id_category = ?
			WHERE id_property = ?;
		", array(
			(int) $move_to_category,
			(int) $id_property
		));
		$this->check($r);
		$this->DB->commit();

		return true;
	}

	public function property_delete($id_property) {
		$tbl_prefix = $this->tbl_prefix;
		$r = $this->DB->query("
			delete from ${tbl_prefix}user_property
			where id_property = ?
			;
		", array(
			(int) $id_property
		));
		$this->check($r);
		$this->DB->commit();
		return true;
	}

	public function property_enum_add($id_property, $enum_value) {
		$tbl_prefix = $this->tbl_prefix;

		$r = $this->DB->query("
			insert into ${tbl_prefix}user_property_enumeration ( id_property, value ) values (?, ?)
			;
		", array(
			(int) $id_property,
			$enum_value,
		));
		$this->check($r);
		$this->DB->commit();
		return true;
	}

	public function property_enum_edit($id_property, $id_enumeration, $enum_value) {
		$tbl_prefix = $this->tbl_prefix;

		$r = $this->DB->query("
			update ${tbl_prefix}user_property_enumeration set value = ?
			where id_property = ? AND id_enumeration = ?;
		", array(
			$enum_value,
			(int) $id_property,
			(int) $id_enumeration
		));
		$this->check($r);
		$this->DB->commit();
		return true;
	}

	public function property_enum_delete($id_property, $id_enumeration) {
		$tbl_prefix = $this->tbl_prefix;
		$r = $this->DB->query("
			delete from ${tbl_prefix}user_property_enumeration
			where id_property = ? AND id_enumeration = ?
			;
		", array(
			(int) $id_property,
			(int) $id_enumeration,
		));
		$this->check($r);
		$this->DB->commit();
		return true;
	}

	/* vrati kompletni pole s ajtemama pro select parent id */

	public function get_raw_users() {
		$tbl_prefix = $this->tbl_prefix;

		$r = $this->DB->getAssoc("select u.id_user AS id, u.* from ${tbl_prefix}users as u");
		$this->check($r);

		return $r;
	}

	public function get_price_lists($only_visible = false) {
		$tbl_prefix = $this->tbl_prefix;

		$sql = "select id_list AS id, ${tbl_prefix}price_list.* from ${tbl_prefix}price_list";
		if ($only_visible) $sql .= " where visible = '1'";
		$sql .= " order by name;";
		$r = $this->DB->getAssoc($sql);
		$this->check($r);

		return $r;
	}

	public function get_price_lists_for_select($only_visible = false) {
		$tbl_prefix = $this->tbl_prefix;

		$sql = "select id_list AS id, name from ${tbl_prefix}price_list";
		if ($only_visible) $sql .= " where visible = '1'";
		$sql .= " order by name;";
		$r = $this->DB->getAssoc($sql);
		$this->check($r);

		return $r;
	}

	public function get_price_list_for_guest() {
		$tbl_prefix = $this->tbl_prefix;

		$sql = "select id_list AS id from ${tbl_prefix}price_list where default_for_guest = '1'";
		$r = $this->DB->getOne($sql);
		$this->check($r);
		return $r;
	}

	public function get_price_list_for_user($id_user = null) {
		$tbl_prefix = $this->tbl_prefix;

		if ($id_user) {
			$r = $this->DB->getOne("select id_price_list AS id from ${tbl_prefix}users where id_user = $id_user");
			$this->check($r);
			if ((int) $r > 0) return (int) $r;
		}
		$r = $this->DB->getOne("select id_list AS id from ${tbl_prefix}price_list where default_for_user = '1'");
		$this->check($r);

		return $r;
	}

	public function set_price_list_for_guest($id_list) {
		$tbl_prefix = $this->tbl_prefix;

		$r = $this->DB->query("update ${tbl_prefix}price_list set default_for_guest = '0';");
		$this->check($r);
		$r = $this->DB->query("
			update ${tbl_prefix}price_list set default_for_guest = '1'
			where id_list = ?
		", array(
			(int) $id_list
		));
		$this->check($r);
		return true;
	}

	public function set_price_list_for_user($id_list) {
		$tbl_prefix = $this->tbl_prefix;

		$r = $this->DB->query("update ${tbl_prefix}price_list set default_for_user = '0';");
		$this->check($r);
		$r = $this->DB->query("
			update ${tbl_prefix}price_list set default_for_user = '1'
			where id_list = ?
		", array(
			(int) $id_list
		));
		$this->check($r);
		return true;
	}

	public function price_list_add($name, $kod, $sleva, $visible) {
		$tbl_prefix = $this->tbl_prefix;
		$r = $this->DB->query("
			insert into ${tbl_prefix}price_list (name, kod, sleva, visible)
			values (?, ?, ?, ?);
		", array(
			$name,
			$kod,
			(int) $sleva,
			$visible ? "1" : "0"
		));
		$this->check($r);
		return true;
	}

	public function price_list_edit($id_list, $name, $kod, $sleva, $visible) {
		$tbl_prefix = $this->tbl_prefix;
		$id_step = (int) $id_step;
		// TODO: osetrit, nebo ne?
		$r = $this->DB->getOne("
			select id_list from ${tbl_prefix}price_list WHERE id_list = ?;
		", array($id_list));
		$this->check($r);
		if ($r == null) {
			$this->spawn_error("Ceník $id_list neexistuje!", ERROR::ERR);
			return false;
		}

		$r = $this->DB->query("
			update ${tbl_prefix}price_list set name = ?, kod = ?, sleva = ?, visible = ?
			where id_list = ?;
		", array(
			$name,
			$kod,
			(int) $sleva,
			$visible ? "1" : "0",
			$id_list
		));
		$this->check($r);

		return true;
	}

	public function price_list_delete($id_list) {
		$tbl_prefix = $this->tbl_prefix;
		$r = $this->DB->query("
			delete from ${tbl_prefix}price_list
			where id_list = ?
			;
		", array(
			(int) $id_list
		));
		$this->check($r);
		return true;
	}

	public function get_enum_options($table, $col) {
		$tbl_prefix = $this->tbl_prefix;
		$info = $this->DB->getassoc("SHOW COLUMNS FROM " . $table . " LIKE '" . $col . "'");
		$row = $info["show"];
		$res = ($row ? explode("','", preg_replace("/(enum|set)\('(.+?)'\)/", "\\2", $row->Type)) : array(0 => 'None'));
		foreach ($res as $option) {
			$result[$option] = $option;
		}
		return $result;
	}

	public function search_users($id_price_list, $find_what, $find_where, $letter, $pager, $id_role) {
		$tbl_prefix = $this->tbl_prefix;

		//  TODO doresit hledani v enumech

		$sql = " FROM {$tbl_prefix}users AS u ";

		$join = array();
		$where = array();
		if ($letter) {
			$join[1] = " INNER JOIN {$tbl_prefix}user_map_property AS ump ON u.id_user = ump.id_user";
			$where[] = " ump.id_property = 9 AND ump.value LIKE  '" . $letter . "%'";
		}

		if ($id_price_list) {
			$where[] = " u.id_price_list = " . (int) $id_price_list;
		}
		if ($id_role) {
			$where[] = " u.id_role = " . (int) $id_role;
		}

		if ($find_what AND $find_where) {
			$join[1] = " INNER JOIN {$tbl_prefix}user_map_property AS ump ON u.id_user = ump.id_user";
			$join[2] = " INNER JOIN {$tbl_prefix}user_property AS up ON ump.id_property = up.id_property";
			$where[] = " up.prop_name = '$find_where'";
			$where[] = " ump.value LIKE  '%$find_what%'";
		}

		$sql = $sql . implode(' ', $join);
		if (count($where)) {
			$sql .= " WHERE " . implode(' AND ', $where);
		}

		$count = "SELECT COUNT(1) as pocet " . $sql;
		$pocet = $this->DB->getOne($count);
		$pager->pocet = $pocet;

		$select = "SELECT u.id_user AS id, u.* " . $sql;
		$select .= " ORDER BY enabled, id DESC LIMIT $pager->offset, $pager->limit";

		$r = $this->DB->getAssoc($select);
		$this->check($r);

		return $r;
	}

	/*
	 * prida uzivatele a vrati id pokud pridani probehlo v poradku
	 *
	 *
	 */

	public function user_add($login, $pass, $id_price_list) {
		global $auth;
		if (!PEAR::isError($res = $auth->addUser($login, $pass))) {
			$this->user_map_price_list($this->get_last_user_id(), $id_price_list);
			return $this->get_last_user_id();
		} else {
			return false; // asi uz uzivatel existuje nebo nejakej jinej problem
		}
	}

	public function get_last_user_id() {
		$tbl_prefix = $this->tbl_prefix;
		$r = $this->DB->getOne("select max(id_user) from ${tbl_prefix}users;");
		$this->check($r);
		return $r;
	}

	public function user_map_price_list($id_user, $id_price_list) {
		$tbl_prefix = $this->tbl_prefix;
		$r = $this->DB->query("
			update ${tbl_prefix}users set id_price_list = ?
			where id_user = ?;
		", array(
			$id_price_list,
			$id_user
		));
		$this->check($r);
		return true;
	}

	public function get_user_id_by_name($username) {
		$res = $this->DB->getone("select id_user from s3n_users where login = '$username'");
		$this->check($res);
		return $res;
	}

	public function get_users_for_select() {
		$r = $this->DB->getAssoc("select u.id_user AS id, concat_ws(' ',ump.value, ump1.value) from s3n_users as u
		left join s3n_user_map_property AS ump ON ump.id_property = 9 AND u.id_user = ump.id_user
		left join s3n_user_map_property AS ump1 ON ump1.id_property = 8 AND u.id_user = ump1.id_user
		WHERE u.login not like '%guest%'
		ORDER by ump.value ");
		$this->check($r);
		return $r;
	}

	/**
	 *
	 * @param int|string $idZdroje
	 * @param int $contentId
	 * @param string $pravo
	 * @param int $idUzivatele
	 * @param int $idRole
	 */
	public function is_allowed($idZdroje, $contentId, $pravo = null, $idUzivatele = null, $idRole = null) {
		global $ACL;
		if (NULL === $idRole) {
			$idRole = 2;
			if (null != $idUzivatele) {
				$idRole = $this->get_role_by_id_user($idUzivatele);
			} else {
				if (isset($this->data['id_role'])) {
					$idRole = $this->data['id_role'];
				}
			}
		}
		if (!is_numeric($idZdroje)) {
			$nazevZdroje = $idZdroje;
			if (!is_string($idZdroje)) {
				$this->spawn_error('Zdroj musí být zadán jako id nebo retezec', ERROR::CRIT);
			}
			$idZdroje = $ACL->vratitIdZdrojePodleNazvu($nazevZdroje);
			if (!$idZdroje) {
				$this->spawn_error("Zdroj s názvem $nazevZdroje neexistuje", ERROR::CRIT);
			}
		}
		return $ACL->isAllowed($idRole, $idZdroje, $contentId, $pravo);
	}

	public function get_roles() {
		return $this->DB->getAll("SELECT * FROM s3n_roles");
	}

	/**
	 * Podle id roli vrati prirazene uzivatele
	 * $showInfo - v poli PROPERTIES se u kazdeho uzivatele vrati jeho parametry
	 * $separate - pokud je TRUE rozpradnou se uzivatele do poli s indexem role
	 *
	 * $USER->get_users_by_id_roles(1)
	 * // vrati vsechny uzivatele pro roli 1
	 * Array
	 * (
	 *     [666] => stdClass Object
	 *     ()
	 *
	 *     [999] => stdClass Object
	 *     ()
	 * )
	 * $USER->get_users_by_id_roles(array(1))
	 * // vrati ty same uzivatele ale v poli kde index je id role
	 * Array
	 * (
	 *    [1] => Array
	 *         (
	 *            [666] => stdClass Object
	 *            ()
	 *
	 *            [999] => stdClass Object
	 *            ()
	 *         )
	 * )
	 *
	 * @param array|int $idRoles
	 * @param bool $showInfo
	 * @param bool $separate
	 * @return array
	 */
	public function get_users_by_id_roles($idRoles = array(), $showInfo = false, $separate = true) {
		$ids = $idRoles;
		if (!is_array($idRoles)) {
			$ids = array($idRoles);
		}
		$users = $this->DB->getAll("SELECT * FROM s3n_users WHERE id_role IN (" . implode(',', $ids) . ")");

		$temp = array();
		foreach ($users as $user) {
			$temp[$user->id_user] = $user;
		}
		$users = $temp;

		$return = array();
		foreach ($ids as $idRole) {
			$return[$idRole] = array();
		}

		if ($showInfo) {
			$users = $this->get_users_info(array_keys($users));
		}

		if ($separate) {
			foreach ($users as $user) {
				$idRole = $user->id_role;
				$return[$idRole][$user->id_user] = $user;
			}

			if (!is_array($idRoles)) {
				$return = $return[$idRoles];
			}
		} else {
			$return = $users;
		}

		return $return;
	}

	/**
	 * Vrati informace o uzivatelich
	 *
	 * @param array|int $usersId
	 * @return array
	 */
	public function get_users_info($usersId = array()) {
		if (!is_array($usersId)) {
			$usersId = array($usersId);
		}
		if (!count($usersId)) {
			return array();
		}

		$users = $this->DB->getAll("SELECT * FROM s3n_users WHERE id_user IN (" . implode(',', $usersId) . ")");

		$temp = array();
		foreach ($users as $user) {
			$temp[$user->id_user] = $user;
		}
		$users = $temp;

		$propertyMap = $this->DB->getAll("SELECT * FROM s3n_user_map_property WHERE `id_user` IN (" . implode(',', $usersId) . ")");

		$propertyIds = array();
		$fileIds = array();
		$enumIds = array();
		foreach ($propertyMap as $property) {
			$propertyIds[] = $property->id_property;
			if ($property->id_file) {
				$fileIds[] = $property->id_file;
			}
			if ($property->id_enumeration) {
				$enumIds[] = $property->id_enumeration;
			}
		}

		// pripravim si pole propert, pokud byly nejake vyzadovany
		$properties = array();
		if (count($propertyIds)) {
			$properties = $this->DB->getAll("SELECT * FROM s3n_user_property WHERE `id_property` IN (" . implode(',', $propertyIds) . ")");
			$temp = array();
			foreach ($properties as $property) {
				$temp[$property->id_property] = $property;
			}
			$properties = $temp;
		}

		// pripravim si pole souboru, pokud byly nejake pozadovany
		$files = array();
		if (count($fileIds)) {
			$files = $this->DB->getAll("SELECT * FROM s3n_files WHERE `id_file` IN (" . implode(',', $fileIds) . ")");
			$temp = array();
			foreach ($files as $file) {
				foreach ($file as $index => $value) {
					if ($index == 'url' || $index == 'thumbnail_url' || $index == 'preview_url' || $index == 'email_url') {
						$file->$index = '/images_user/' . $value;
					}
				}

				$temp[$file->id_file] = $file;
			}
			$files = $temp;
		}



		foreach ($propertyMap as $property) {
			$userId = $property->id_user;
			$propertyId = $property->id_property;
			if (!array_key_exists('PROPERTIES', $users[$userId])) {
				$users[$userId]->PROPERTIES = array();
			}
			$users[$userId]->PROPERTIES[$propertyId] = clone $properties[$propertyId];
			if ($properties[$propertyId]->prop_type == 'STRING') {
				$users[$userId]->PROPERTIES[$propertyId]->VALUES = $property->value;
			}
			if ($properties[$propertyId]->prop_type == 'IMAGE') {
				$users[$userId]->PROPERTIES[$propertyId]->VALUES = $files[$property->id_file];
			}
		}
		return $users;
	}

	/**
	 * vrati id role prislusneho uzivatele
	 *
	 * @param int $userId
	 * @return int
	 */
	public function get_role_by_id_user($userId) {
		return $this->DB->getOne("SELECT id_role FROM s3n_users WHERE id_user = $userId");
	}

	/**
	 * nastavi uzivateli roli
	 *
	 * @param int $idRole
	 * @param int $idUzivatele
	 * @return bool
	 */
	public function set_role($idRole, $idUzivatele = null) {
		if (null == $idUzivatele) {
			$idUzivatele = $this->data['id_user'];
		}
		if (!$idUzivatele || !is_numeric($idUzivatele)) {
			$this->spawn_error('není zadáno id uživatele', ERROR::CRIT);
		}

		if (!$idRole || !is_numeric($idRole)) {
			$this->spawn_error('není zadáno id role', ERROR::CRIT);
		}
		return dbI::query("UPDATE s3n_users SET id_role = $idRole WHERE id_user = $idUzivatele")->result();
	}

	public function vratNejnovejsiInzeraty($pocet = 0) {
		$select = "SELECT * FROM `s3n_user_map_property`
	            WHERE `id_property` IN ('44')
                AND NOW() < ADDDATE(value, INTERVAL 14 DAY)
                ORDER BY value DESC
                LIMIT $pocet";

		$r = $this->DB->getAll($select);
		$this->check($r);
		return $this->_detailInzeratu($r);
	}

	public function existujeNick($nick, $idUzivatele = null) {
		if ($idUzivatele) {
			$res = $this->DB->getRow("SELECT * FROM s3n_user_map_property
		                              WHERE id_property = 34
		                              AND id_user <> $idUzivatele
		                              AND value = '$nick'");
		} else {
			$res = $this->DB->getRow("SELECT * FROM s3n_user_map_property
			                          WHERE id_property = 34
			                          AND value = '$nick'");
		}
		$this->check($res);
		return $res ? true : false;
	}

	public function vratAktivniInzeraty($pager) {
		$sql = " FROM `s3n_user_map_property`
	            WHERE `id_property` IN ('44')
                AND NOW() < ADDDATE(value, INTERVAL 14 DAY)";

		$count = "SELECT COUNT(1) as pocet " . $sql;
		$pocet = $this->DB->getOne($count);
		$pager->pocet = $pocet;

		$select = "SELECT id_user" . $sql;
		$select .= " LIMIT $pager->offset, $pager->limit";
		$r = $this->DB->getAll($select);
		$this->check($r);
		return $this->_detailInzeratu($r);
	}

	private function _detailInzeratu($r) {
		$idUsers = array();
		$return = array();
		foreach ($r as $item) {
			$idUsers[] = $item->id_user;
			$return[$item->id_user] = new stdClass();
		}

		if (count($idUsers)) {
			$sql = "SELECT * FROM `s3n_user_map_property`
                    WHERE id_property IN ('39', '23', '44', '34')
                    AND id_user IN (" . implode(',', $idUsers) . ")";
			$r = $this->DB->getAll($sql);
			$this->check($r);
			foreach ($r as $item) {
				$userId = $item->id_user;
				$return[$userId]->id_user = $userId;
				if ($item->id_property == 39) {
					$return[$userId]->text = $item->value;
				}
				if ($item->id_property == 23) {
					$return[$userId]->email = $item->value;
				}
				if ($item->id_property == 44) {
					$return[$userId]->vlozeno = $item->value;
				}
				if ($item->id_property == 34) {
					$return[$userId]->nick = $item->value;
				}
			}
		}
		return $return;
	}

	public function nastavTypDodaciAdresy($typ) {
		$this->DB->query("UPDATE s3n_users SET dodaci_adresa_typ = ? WHERE id_user = ?
		", array(
			$typ,
			$this->data['id_user']
		));
	}

	public function vratTypDodaciAdresy() {
		return $this->DB->getOne("
            SELECT dodaci_adresa_typ FROM s3n_users WHERE id_user = ?
        ", array(
					$this->data['id_user']
		));
	}

	public function get_user_property_string_value($id_user, $prop_name) {
		if (!$id_user) return false;

		$retVal = $this->DB->getOne("
				select ump.value as PROP_VALUE from s3n_user_map_property as ump
				inner join s3n_user_property as p on ump.id_property = p.id_property
				where ump.id_user = ? and p.prop_name = ?
				limit 0,1;
		", array(
			(int) $id_user,
			$prop_name
		));
// 		FB::log($this->DB->last_query);
		$this->check($retVal);
		return $retVal;
	}

	public function get_user_property_enum_value($id_user, $prop_name) {
		if (!$id_user) return false;
		$retVal = $this->DB->getOne("
				select pe.value from s3n_user_property_enumeration as pe
				inner join s3n_user_map_property as ump on pe.id_enumeration = ump.id_enumeration and ump.id_user = ?
				inner join s3n_user_property as p on ump.id_property = p.id_property and p.prop_name = ?
				order by pe.value
				limit 0,1;
		", array(
			(int) $id_user,
			$prop_name,
		));
		$this->check($retVal);
		return $retVal;
	}

	public function get_user_property_enum_display_value($id_user, $prop_name) {
		if (!$id_user) return false;
		$retVal = $this->DB->getOne("
				select pe.display_value from s3n_user_property_enumeration as pe
				inner join s3n_user_map_property as ump on pe.id_enumeration = ump.id_enumeration and ump.id_user = ?
				inner join s3n_usre_property as p on ump.id_property = p.id_property and p.prop_name = ?
				order by pe.value
				limit 0,1;
		", array(
			(int) $id_user,
			$prop_name,
		));
		$this->check($retVal);
		return $retVal;
	}

	public function get_users_emails($only_registered = false, $onlyNewsletter = true) {
		$sql = "SELECT trim(ump.value) as email from s3n_users as u
				INNER JOIN s3n_user_map_property AS ump on ump.id_user = u.id_user and ump.id_property = " . dbProperty::getByName('email', 'user') . " and value like '%@%' and value REGEXP '^[A-Z0-9._%-]+@[A-Z0-9.-]+\.[A-Z]{2,4}$' ";
		$sql .= ' where 1=1 ';
		if ($only_registered) $sql .= " and login not like 'guest%' ";
		if ($onlyNewsletter) $sql .= " and newsletter = '1' ";
		$sql .= " GROUP BY email order by email";
		$r = $this->DB->getCol($sql);

		return $r;
	}

	public function send_registration_email($recipient, $login, $pass, $idUser) {
		$info = $this->get_user_info($idUser);

		$mime = new Mail_mime("\n");
		$mail = & Mail::factory('mail');

		$params['head_encoding'] = 'base64';
		$params['text_encoding'] = 'base64';
		$params['html_encoding'] = 'base64';
		$params['head_charset'] = 'UTF-8';
		$params['text_charset'] = 'UTF-8';
		$params['html_charset'] = 'UTF-8';

		$hdrs = array(
			'From' => SUMMARY_EMAIL_FROM,
			'Subject' => 'Registrace uživatele ' . Registry::getDomainName(),
			'To' => $recipient,
			'Content-Type' => 'multipart/related;charset="UTF-8"',
			'Content-Transfer-Encoding' => '8bit'
		);
		$hdrs = $mime->headers($hdrs);

//		$mime->addHTMLImage(PROJECT_DIR . "images/email_top.jpg", 'image/jpeg', "email_top.jpg", true); //hlavicka

		$html_container = '
			<html>
				<head>
					<meta http-equiv="content-type" content="text/html; charset=UTF-8">
					<title>Registrace</title>
				</head>
					<body>
						<table border="0" width="50%" style="font-size: 11px;">
							<tr>
								<th colspan="6" style="background-color: white;"><img src="email_top.jpg" alt="hlavicka" border="0"></th>
							</tr>
					   </table>
					   <div>
						Dobrý den,<br/>
						děkujeme Vám za přihlášku na webové stránky: '.Registry::getDomain().'<br/>
						Na uvedený e-mail Vám přijde autorizace Vašeho přístupu.<br/><br/>

						Děkujeme Vám.<br/>
					   </div>
				</body>
			</html>';
		$mime->setHTMLBody($html_container);

		//$mime -> addHTMLImage(PROJECT_DIR."images/email_top.jpg",'image/jpeg',"email_top.jpg",true);    //hlavicka

		$body = $mime->get($params);
		$hdrs = $mime->headers($hdrs);

		$mail->send($recipient, $hdrs, $body);
		$mail->send("pulkrabek@3nicom.cz", $hdrs, $body);
//		$mail->send(REGISTRATION_EMAIL_FROM, $hdrs, $body);
	}

	public function nastavTypFiremnichUdaju($typ) {
		$this->DB->query("
            UPDATE {$this->tbl_prefix}users SET firemni_udaje_typ = ? WHERE id_user = ?
        ", array(
			$typ,
			$this->data['id_user']
		));
	}

	public function user_edit($idUser, $login = null, $pass = null) {
		if ($login == null) {
			$r = $this->DB->query("
                update {$this->tbl_prefix}users set pass = ?
                where id_user = ?;
            ", array(
				$pass,
				$idUser,
			));
			$this->check($r);
		} else {
			$r = $this->DB->query("
	            update {$this->tbl_prefix}users set login = ?, pass = ?
	            where id_user = ?;
	        ", array(
				$login,
				$pass,
				$idUser,
			));
			$this->check($r);
		}
		return true;
	}

}

?>