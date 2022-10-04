<?php

require_once PROJECT_DIR . 'res/Zend/Acl.php';
require_once PROJECT_DIR . 'res/Zend/Acl/Resource.php';
require_once PROJECT_DIR . 'res/Zend/Acl/Role.php';

class Class_Acl extends Zend_Acl {

	/**
	 * Enter description here...
	 *
	 * @var DB
	 */
	private $_db = null;
	private $_tblPrefix = null;
	private $_celeNazvyZdroju = array();
	private $_vsechnyZdroje = array();
	private $ERROR = null;

	/**
	 * @param String $msg Popis chyby
	 * @param int $severity Zavazost chyby podle ERROR::severity
	 * @return null
	 */
	private function spawn_error($msg, $severity, $svrcode = ERROR::OK) {
		$this->ERROR->spawn("User_3n", 1, $svrcode, $severity, $msg);
	}

	/**
	 * Provede zalozeni zdroju, roli a prav
	 *
	 */
	public function __construct() {
		global $ERROR;
		$this->ERROR = $ERROR;
		$this->_db = $db;
		$this->_tblPrefix = "s3n_";
//	$this->allow();

		$vsechnyZdroje = $this->vratVsechnyZdroje();
		$this->_zalozZdroje($vsechnyZdroje);
		$this->_vsechnyZdroje = $vsechnyZdroje;

		$vsechnyRole = $this->vratVsechnyRole();
		$this->_zalozRole($vsechnyRole);

		$vsechnaPrava = $this->vratVsechnaPrava();
		$this->_ulozPrava($vsechnaPrava);

		foreach ($vsechnyZdroje as $zdroj) {
			$this->_ulozCelyNazevZdroje($zdroj, $vsechnyZdroje);
		}
	}

	/////////////////////////////////////////////////////////
	// verejne metody
	/////////////////////////////////////////////////////////

	public function isAllowed($idRole, $idZdroje, $contentId = null, $pravo = null) {
		$allowed = parent::isAllowed($idRole, $idZdroje, $pravo);
		if (!$allowed) {
			return false;
		}
		$zdroj = $this->vratZdrojPodleId($idZdroje);
		if ($zdroj->type == 'content') {
			if ($contentId === null) {
				return $allowed;
			}

			// prava se zjistuji pouze u kategorie horni menu == 2(nevim proc)
			// vsechno ostatni paticka, styly, je povoleno
//			$content = $this->_vratZaznamyZTabulkyContent('s3n_content_category', $contentId, 'id_content_category', 'id_content_category');
//			if (!isset($content[$contentId])) {
//				return true;
//			}
//			if ($content[$contentId]->id_content_type != 2) {
//				return true;
//			}

			$contentZaznamy = $this->_vratZaznamyZTabulkyResourceMapContent($idZdroje, $idRole);

			// pokud existuje primo na pozadovany zaznam
			if (array_key_exists($contentId, $contentZaznamy)) {
				$zaznam = $contentZaznamy[$contentId];
				return false; // zakazano
			}



			foreach ($contentZaznamy as $zaznam) { // tak tohle netusime proc tu je ...
				if ($zaznam->content_id == null) {
					return false; // zakazano
				}
			}

			$idParentu = array_keys($contentZaznamy);
			$i = 0;
			do {
				$potomci = $this->_vratZaznamyZTabulkyContent('s3n_content_category', $idParentu, 'id_content_category', 'id_parent');
				if (array_key_exists($contentId, $potomci)) {
					$zaznam = $potomci[$contentId];
					return false; // zakazano
				}
				$idParentu = array_keys($potomci);
				// zabraneni zacykleni
				if (++$i > 10) break;
			}while (count($potomci));

			return true;  // zakazano nenalezeno
		}
		return $allowed;
	}

	const ONLY_ALLOW = 'only_allow';
	const ONLY_DENY = 'only_deny';
	const ALL = 'all';

	/**
	 * Podle id(nebo nazvu) zdroje vrati pole id roli.
	 * Pokud je zadan retezec, pokusim se dohledat id zdroje.
	 * Podle promenne $typ se vraci bud role ktere maji povoleno nebo nikoliv
	 *
	 * $ACL->vratRolePodleIdZdroje(4, Class_Acl::ONLY_ALLOW)
	 * // vrati vsechny role ktere maji pravo na zdroj 4
	 * array (1, 3, 8)
	 *
	 * @param int|string $idZdroje
	 * @param string $typ
	 * @return array
	 */
	public function vratRolePodleIdZdroje($idZdroje, $typ = self::ONLY_ALLOW) {
		if (is_string($idZdroje) && !is_numeric($idZdroje)) {
			$idZdroje = $this->vratitIdZdrojePodleNazvu($idZdroje);
		}
		$return = array();

		foreach (array_keys($this->_roleRegistry->getRoles()) as $idRole) {
			$return[$idRole] = 0;
		}

		foreach ($this->_rules['allResources']['byRoleId'] as $idRole => $value) {
			if ($value['allPrivileges']['type'] == 'TYPE_ALLOW') {
				$return[$idRole] = 1;
			} else {
				$return[$idRole] = 0;
			}
		}

		if (isset($this->_rules['byResourceId'][$idZdroje])) {
			foreach ($this->_rules['byResourceId'][$idZdroje]['byRoleId'] as $idRole => $value) {
				if ($value['allPrivileges']['type'] == 'TYPE_ALLOW') {
					$return[$idRole] = 1;
				} else {
					$return[$idRole] = 0;
				}
			}
		}

		if ($typ == self::ONLY_DENY) {
			foreach ($return as $index => $value) {
				if ($value == 1) {
					unset($return[$index]);
				}
			}
		}
		if ($typ == self::ONLY_ALLOW) {
			foreach ($return as $index => $value) {
				if ($value == 0) {
					unset($return[$index]);
				}
			}
		}

		return array_keys($return);
	}

	public function vratZdrojPodleId($idZdroje) {
		if (is_string($idZdroje) && !is_numeric($idZdroje)) {
			$idZdroje = $this->vratitIdZdrojePodleNazvu($idZdroje);
		}
		if (!is_numeric($idZdroje)) {
			$this->spawn_error("Špatně zadané id zdroje: '$idZdroje'", ERROR::CRIT);
		}
		if (array_key_exists($idZdroje, $this->_vsechnyZdroje)) {
			return $this->_vsechnyZdroje[$idZdroje];
		} else {
			return null;
		}
	}

	public function vratitIdZdrojePodleNazvu($nazevZdroje = '') {
		$index = array_search($nazevZdroje, $this->_celeNazvyZdroju);
		if (false === $index) {
			return null;
		} else {
			return $index;
		}
	}

	public function vratZdrojePodleTypu($typ) {
		$select = "SELECT * FROM {$this->_tblPrefix}acl_resources"
				. " WHERE type='$typ'";
//        $zdroje = $this->_db->getAssoc($select);
		$zdroje = dbI::query($select)->fetchAssoc('dbBase', 'id');
		return $zdroje;
	}

	public function vratObsahPodleIdZdrojeIdRoleAIdContent($idZdroju, $idRole) {
		if (!is_array($idZdroju)) {
			$idZdroju = array($idZdroju);
		}

		$select = "SELECT * FROM {$this->_tblPrefix}acl_resource_content_map"
				. " WHERE acl_resource_id IN(" . implode(', ', $idZdroju) . ")"
				. " AND role_id = $idRole";
//        $content = $this->_db->getAssoc($select);
		$content = dbI::query($select)->fetchAssoc('dbBase', 'id');
		$return = array();
		foreach ($idZdroju as $idZdroje) {
			$return[$idZdroje] = array();
		}

		foreach ($content as $item) {
			$return[$item->acl_resource_id][] = $item->content_id;
		}


		return $return;
	}

	public function ulozitContentOpravneni($idZdroje, $idRole, $contentId, $state = true) {
		$select = "SELECT id FROM {$this->_tblPrefix}acl_resource_content_map WHERE acl_resource_id = $idZdroje AND role_id = $idRole AND content_id = $contentId";
		$content = dbI::query($select)->fetchSingle();
		if ($content && $state == false) {
			FB::info("mazeme");
			$delete = "DELETE FROM {$this->_tblPrefix}acl_resource_content_map WHERE id=$content LIMIT 1";
			dbI::query($delete)->result();
		} elseif (!$content && $state == true) {
			FB::info("ukladame");
			$insert = "INSERT INTO {$this->_tblPrefix}acl_resource_content_map (acl_resource_id, role_id, content_id)"
					. " VALUES ($idZdroje, $idRole, $contentId)";
			dbI::query($insert)->result();
		}
	}

	public function ulozitSystemOpravneni($idZdroje, $idRole, $state = true) {

		$select = "SELECT id FROM {$this->_tblPrefix}role_access"
				. " WHERE acl_resource_id = $idZdroje"
				. " AND role_id = $idRole";
//        $content = $this->_db->getOne($select);
		$content = dbi::query($select)->fetchSingle();
		if ($content && $state == false) {
			$delete = "DELETE FROM {$this->_tblPrefix}role_access"
					. " WHERE id=$content LIMIT 1";
			dbI::query($delete)->result();
		} elseif (!$content && $state == true) {
			$insert = "INSERT INTO {$this->_tblPrefix}role_access (acl_resource_id, role_id, allow)"
					. " VALUES ($idZdroje, $idRole, '1')";
			dbI::query($insert)->result();
		}
	}

	////////////////////////////////
	// sql dotazy na nacteni prav, roli, zdroju, atd.
	////////////////////////////////

	public function vratVsechnyRole() {
		$select = "SELECT * FROM {$this->_tblPrefix}roles";
//        $vsechnyRole = $this->_db->getAssoc($select);
		$vsechnyRole = dbI::query($select)->fetchAssoc('dbBase', 'id');
		return $vsechnyRole;
	}

	public function vratVsechnyZdroje() {
		$select = "SELECT * FROM {$this->_tblPrefix}acl_resources";
//        $vsechnyZdroje = $this->_db->getAssoc($select);
		$vsechnyZdroje = dbI::query($select)->fetchAssoc('dbBase', 'id');
		return $vsechnyZdroje;
	}

	public function vratVsechnaPrava() {
		$select = "SELECT * FROM {$this->_tblPrefix}role_access";
//        $vsechnaPrava = $this->_db->getAssoc($select);
		$vsechnaPrava = dbI::query($select)->fetchAssoc('dbBase', 'id');
		return $vsechnaPrava;
	}

	private function _vratZaznamyZTabulkyResourceMapContent($idZdroje, $idRole) {
		$select = "SELECT arcm.content_id, arcm.* FROM {$this->_tblPrefix}acl_resource_content_map arcm"
				. " WHERE arcm.acl_resource_id = $idZdroje"
				. " AND arcm.role_id = $idRole";
//        $zaznamy = $this->_db->getAssoc($select);
		$zaznamy = dbI::query($select)->fetchAssoc('dbBase', 'content_id');
		return $zaznamy;
	}

	private function _vratZaznamyZTabulkyContent($nazevTabulky, $idZaznamu, $nazevIdSloupce, $nazevParentSloupce) {
		if (!is_array($idZaznamu)) {
			$idZaznamu = array($idZaznamu);
		}
		if (!count($idZaznamu)) return array();

		$select = "SELECT temp.$nazevIdSloupce, temp.* FROM $nazevTabulky temp"
				. " WHERE temp.$nazevParentSloupce IN(" . implode(', ', $idZaznamu) . ")";
//        $zaznamy = $this->_db->getAssoc($select);
		$zaznamy = dbI::query($select)->fetchAssoc('dbBase', $nazevIdSloupce);
		return $zaznamy;
	}

	/////////////////////////////////////////////////////////
	// ulozeni vystupu sql dotazu do struktury Zend_Acl
	/////////////////////////////////////////////////////////

	private function _zalozZdroje($vsechnyZdroje) {
//		print_p($vsechnyZdroje);
		foreach ($vsechnyZdroje as $zdroj) {
			$idZdroje = $zdroj->id;
			$idRodice = $zdroj->parent_id;
			if (!$this->has($idZdroje)) {
				if (null !== $idRodice) {
					if (!$this->has($idRodice)) {
						$this->_zalozRodiceZdroje($idRodice, $vsechnyZdroje);
					}
				}
				$idZdroje = new Zend_Acl_Resource($idZdroje);
				$this->addResource($idZdroje, $idRodice);
			}
		}
	}

	private function _zalozRodiceZdroje($idRodice, $vsechnyZdroje) {
		if (!$this->has($idRodice)) {
			if (!isset($vsechnyZdroje[$idRodice])) {
				$this->spawn_error("Zdroj id '$idRodice' neexistuje", ERROR::CRIT);
			}
			$zdroj = $vsechnyZdroje[$idRodice];
			$idZdroje = $zdroj->id;
			$idRodice = $zdroj->parent_id;
			if (null !== $idRodice) {
				if (!$this->has($idRodice)) {
					$this->_zalozRodiceZdroje($idRodice, $vsechnyZdroje);
				}
			}
			$this->addResource($idZdroje, $idRodice);
		}
	}

	private function _zalozRole($vsechnyRole) {
		foreach ($vsechnyRole as $role) {
			$idRole = $role->id;
			$idRodice = $role->parent_id;
			if (!$this->hasRole($idRole)) {
				if (null !== $idRodice) {
					if (!$this->hasRole($idRodice)) {
						$this->_zalozRodiceRole($idRodice, $vsechnyRole);
					}
				}
				$idRole = new Zend_Acl_Role($idRole);
				$this->addRole($idRole, $idRodice);
			}
		}
	}

	private function _zalozRodiceRole($idRodice, $vsechnyRole) {
		if (!$this->hasRole($idRodice)) {
			if (!isset($vsechnyRole[$idRodice])) {
				$this->spawn_error("Role id '$idRodice' neexistuje", ERROR::CRIT);
			}
			$role = $vsechnyRole[$idRodice];
			$idRole = $role->id;
			$idRodice = $role->parent_id;
			if (null !== $idRodice) {
				if (!$this->hasRole($idRodice)) {
					$this->_zalozRodiceRole($idRodice, $vsechnyRole);
				}
			}
			$this->addRole($idRole, $idRodice);
		}
	}

	private function _ulozPrava($prava) {
		foreach ($prava as $konkretniPravo) {
			if (!$konkretniPravo->published) {
				continue;
			}
			$idRole = $konkretniPravo->role_id;
			$idZdroje = $konkretniPravo->acl_resource_id;
			$pravo = $konkretniPravo->privilege;
			$jePovoleno = $konkretniPravo->allow;
			$pridruzenaTrida = $konkretniPravo->assert_class;
			// vytvorim jednotliva prava
			if (trim($pridruzenaTrida) != "" && class_exists($pridruzenaTrida)) {
				if ($jePovoleno) {
					$this->allow($idRole, $idZdroje, $pravo, new $pridruzenaTrida());
				} else {
					$this->deny($idRole, $idZdroje, $pravo, new $pridruzenaTrida());
				}
			} else {
				if ($jePovoleno) {
					$this->allow($idRole, $idZdroje, $pravo);
				} else {
					$this->deny($idRole, $idZdroje, $pravo);
				}
			}
		}
	}

	private function _ulozCelyNazevZdroje($zdroj, $vsechnyZdroje) {
		$nazevZdroje = $zdroj->resource;
		$idZdroje = $zdroj->id;
		$idRodice = $zdroj->parent_id;

		if (null !== $idRodice) {
			if (!isset($vsechnyZdroje[$idRodice])) {
				$this->spawn_error("Zdroj id '$idRodice' neexistuje", ERROR::CRIT);
			}
			$nazevZdroje = $this->_celeNazvyZdroju[$idRodice] . "_" . $nazevZdroje;
		}
		if (!array_key_exists($idZdroje, $this->_celeNazvyZdroju)) {
			$this->_celeNazvyZdroju[$idZdroje] = $nazevZdroje;
		}
	}

}
