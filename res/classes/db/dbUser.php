<?php

/**
 * Users
 * @author Error
 */
class dbUser extends dbBase implements dbIUser {

    public $id;
    public $id_parent;
    public $login;
    private $pass;
    public $pass_plain;
    private $vip;
    private $admin;
    public $id_role;
    public $id_price_list;
    public $firemni_udaje_typ;
    public $dodaci_adresa_typ;
    public $id_forum_author;
    public $date_created;
    public $enabled;
    public $last_login;
    public $mlist;
    public $id_pozice;
    public $id_odbor;
    private static $cache = array();

    const GUEST_UID = 0;

    /**
     * For compatibility reasons
     * @param array $array
     */
    public function __construct(Array $array) {
        foreach ($array as $key => $var) {
            $this->$key = $var;
        }
        $this->id = $this->id_user;
    }

    public function __destruct() {

    }

    public function getPoziceName() {
        if (!$this->poziceName)
            $this->poziceName = dbI::cachedQuery("SELECT name FROM s3n_pozice WHERE id_pozice = %i", $this->id_pozice)->cache(self::$cache[$this->id_pozice]["name"])->fetchSingle();
        return $this->poziceName;
    }

    /**
     * @param dbProperty
     * @throws dbException
     * @return dbUserProperty|false
     */
    public function property(dbProperty $dbProperty) {
        return dbUserProperty::create($dbProperty, $this->id);
    }

    /**
     * Returns a property ba Name
     * @throws dbException
     * @return dbUserProperty|false
     */
    public function propertyByName($propName) {
        return dbUserProperty::create(dbProperty::getByName($propName, "user"), $this->id);
    }

    /**
     * Returns a property by Id
     * @throws dbException
     * @return dbUserProperty|false
     */
    public function propertyById($idProperty) {
        return dbUserProperty::create(dbProperty::getById($idProperty, "user"), $this->id);
    }

    /**
     * Returns a property value
     * @throws dbException
     * @return array|false
     */
    public function getPropertyValue($propName) {
//		if ($propName == "telefon") $propName = "tel";
        $dbProp = dbProperty::getByName($propName, "user");
        if (!$dbProp)
            throw new Exception("Nenalzezena vlastnost " . $propName);
        return dbUserProperty::create($dbProp, $this->id)->getValue();
    }

    public function setPropertyValue($propName, $value) {
        return dbUserProperty::create(dbUserProperty::getByName($propName, "user"), $this->id)->setValue($value);
    }

    /**
     * Sets user login while checking for uniqueness
     * @param string $login
     * @throws dbException
     * @return bool
     */
    public function setLogin($login) {
        if (!dbI::query("SELECT count(*) FROM s3n_users WHERE login = %s AND id_user != %i", $login, $this->id)->fetchSingle()) {
            return dbI::query("UPDATE s3n_users SET login = %s WHERE id_user = %i", $login, $this->id)->update($this->login, $login)->result();
        }
        return false;
    }

    /**
     * Sets user password
     * @param string $password
     * @throws dbException
     * @return bool
     */
    public function setPassword($password) {
        if (dbI::query("UPDATE user SET password = %s WHERE id_user = %i", md5($password), $this->id)->update($this->password, sha1($password))->result()) {
            $this->password = sha1($password);
            return true;
        }
        return false;
    }

    /**
     * Creates user
     * @param string $login
     * @param string $password
     * @param string $email
     * @param string $changeable_login
     * @return dbUser|false
     */
    public static function create($data) {
        $data["pass_plain"] = $data["pass"];
        $data["pass"] = md5($data["pass"]);
        if (dbI::query("SELECT login FROM s3n_users WHERE login = %s", $data["login"])->fetchSingle()) {
            return false;
        }
        return self::getById(dbI::query("INSERT INTO s3n_users ", $data)->insert());
    }

    // CHECKS

    /**
     * Returns a user by login
     * @param string $login
     * @throws dbException
     * @return dbUser|false
     */
    public static function getByLogin($login) {
//		if(!$login) throw new Exception("Prazdny login pro zjisteni uzivatele");
        $res = dbI::query("SELECT * FROM s3n_users WHERE login = %s", $login)->fetch('dbUser');
//		if(!$res) throw new Exception("Nepodarilo se dohledat uzivatele podle loginu");
        return $res;
    }

    /**
     * Returns a user by ID
     * @param int $id
     * @throws dbException
     * @return dbUser|false
     */
    public static function getById($id) {
        return dbI::Query("SELECT *, id_user AS id FROM s3n_users WHERE id_user = %i", $id)->fetch('dbUser');
    }

    /**
     * Returns a dbUser fro guest
     * @throws dbException
     * @return dbUser|false
     */
    public static function getGuest() {
        if (!dbI::query("SELECT login FROM s3n_users WHERE id_user = %i", self::GUEST_UID)->fetchSingle()) {
            if (dbI::query("SELECT id_user FROM s3n_users WHERE login = %s", 'guest')->fetchSingle()) {
                dbI::query("UPDATE s3n_users SET id_user = %i WHERE login = %s", self::GUEST_UID, 'guest')->result();
            } else {
                dbI::query("INSERT INTO s3n_users (id_user, login) VALUES(%i, %s)", self::GUEST_UID, 'guest')->insert();
            }
        }
        return dbI::Query("SELECT * FROM s3n_users WHERE id_user = %i", 0)->fetch('dbUser');
    }

    /**
     * Returns a user RK
     * @throws dbException
     * @return dbUser|false
     */
    public function getParent() {
        return $this->getById($this->id_parent ? $this->id_parent : $this->id);
    }

    public function getRole() {
        return dbRole::getById($this->id_role);
    }

    public function isAdmin() {
        return 1 === intval($this->getRole()->id);
    }

    public function isEditor() {
        return 4 === intval($this->getRole()->id);
    }

    public static function searchFull($text) {
        return dbI::query("SELECT u.* FROM s3n_users u, s3n_user_map_property ump WHERE (ump.`value` LIKE '%$text%' AND ump.id_user = u.id_user) OR u.login LIKE '%$text%' GROUP BY u.id_user")->fetchAll('dbUser', 'id_user');
    }

    /**
     *
     * @param int|string $idZdroje
     * @param int $contentId
     * @param string $pravo
     * @param int $idUzivatele
     * @param int $idRole
     */
    public function isAllowed($idZdroje, $contentId = null, $pravo = null) {
//		echo $idZdroje;
        global $ACL; /* @var $ACL Class_Acl */
        if (!is_numeric($idZdroje)) {
            $nazevZdroje = $idZdroje;
            if (!is_string($idZdroje)) {
                throw new Exception('Zdroj musí být zadán jako id nebo retezec');
            }
            $idZdroje = $ACL->vratitIdZdrojePodleNazvu($nazevZdroje);
            if (!$idZdroje) {
                throw new Exception("Zdroj s názvem $nazevZdroje neexistuje");
            }
        }

        return $ACL->isAllowed($this->id_role, $idZdroje, $contentId, $pravo);
    }

    public function getAclCCEntries($idRole = NULL) {
        return dbI::query("SELECT arcm.*, ar.resource FROM s3n_acl_resource_content_map arcm LEFT JOIN s3n_acl_resources ar ON ar.id = arcm.acl_resource_id WHERE role_id = %i ORDER BY arcm.content_id", $idRole ? $idRole : $this->id_role)->fetchAssoc('dbBase', 'content_id,resource');
    }

    public static function getOdbory() {
        return dbProperty::getByName('odbor', 'user')->getEnumarations();
    }

    public static function getByOdbor($odbor) {
        return new dbArray(dbI::query("SELECT u.* FROM s3n_users u, s3n_user_map_property ump, s3n_user_property_enumeration upe WHERE u.id_user = ump.id_user AND ump.id_property = %i AND ump.id_enumeration = upe.id_enumeration AND upe.`value` = %s
								ORDER BY (SELECT upe2.`value` FROM s3n_user_map_property ump2, s3n_user_property_enumeration upe2 WHERE ump2.id_user = u.id_user AND ump2.id_enumeration = upe2.id_enumeration AND ump2.id_property = %i) DESC", dbProperty::getByName('odbor', 'user')->id, $odbor, dbProperty::getByName('funkce', 'user')->id)->fetchAll('dbUser'));
    }

    public static function getByOdborId($idOdbor) {
        return new dbArray(dbI::query("SELECT u.* FROM s3n_user_map_property ump, s3n_users u
								LEFT JOIN s3n_user_map_property ump3 ON ump3.id_user = u.id_user AND ump3.id_property = %i
								WHERE u.id_user = ump.id_user AND ump.id_property = %i AND ump.id_enumeration = %i
								ORDER BY (SELECT upe2.`value` FROM s3n_user_map_property ump2, s3n_user_property_enumeration upe2 WHERE ump2.id_user = u.id_user AND ump2.id_enumeration = upe2.id_enumeration AND ump2.id_property = %i) DESC, ump3.value
								", dbProperty::getByName('prijmeni', 'user')->id, dbProperty::getByName('odbor', 'user')->id, $idOdbor, dbProperty::getByName('funkce', 'user')->id)->fetchAll('dbUser'));
    }

    public static function getZamestnanci() {
        return new dbArray(dbI::query("SELECT u.* FROM s3n_users u
					LEFT JOIN s3n_user_map_property ump2 ON ump2.id_user = u.id_user AND ump2.id_property = %i
					INNER JOIN s3n_user_map_property ump3 ON ump3.id_user = u.id_user AND ump3.id_property = %i
					LEFT JOIN s3n_user_map_property ump4 ON ump4.id_user = u.id_user AND ump4.id_property = %i
					ORDER BY ump2.value
					", dbProperty::getByName('prijmeni', 'user')->id, dbProperty::getByName('odbor', 'user')->id, dbProperty::getByName('jmeno', 'user')->id)->fetchAll('dbUser'));
    }

    public static function checkLoginExists($login) {
        return dbI::query("SELECT id_user FROM s3n_user_map_property WHERE value = %s AND id_property = %i", $login, dbUserProperty::getByName('email', 'user')->id)->fetchSingle();
    }

    public static function getUserLoginByHash($hash) {
        $idUser = dbI::query("SELECT id_user FROM s3n_user_map_property WHERE SHA1(value) = %s ORDER by id_user DESC LIMIT 0, 1", $hash)->fetchSingle();
        if ($idUser) {
            return self::getById($idUser);
        } else {
            return false;
        }
    }

    /**
     *
     * @param int $importId
     * @return dbUser
     */
    public static function getByImportId($importId) {
        return dbI::query("SELECT * FROM s3n_users WHERE id_import = %i", $importId)->fetch("dbUser");
    }

    public static function importCLients() {
        dbI::query("DELETE FROM s3n_users WHERE id_import IS NOT NULL")->result();
        $xml = simplexml_load_file(PROJECT_DIR . "doc/export_clients.xml");
        $pClients = $xml->xpath("Clients");
        foreach ($pClients as $pClient) {
            $pClient = (array) $pClient;
            $dbUser = self::getByImportId($pClient["id"]);
            if (!$dbUser)
                $dbUser = dbUser::create(array(
                            "id_import" => $pClient["id"],
                            "login" => $pClient["username"],
                            "date_created" => date_create($pClient["date_created"])->format("Y-m-d H:i:s"),
                            "enabled" => $pClient["enabled"] == "true" ? 1 : 0,
                            "last_login" => date_create($pClient["last_login"])->format("Y-m-d H:i:s"),
                            "pass" => $pClient["password"],
                            "mlist" => $pClient["mlist"] == "true" ? 1 : 0,
                            "id_role" => 100,
                ));
            if ($dbUser) {
                $dbUser->setPropertyValue("jmeno", $pClient["first_name"]);
                $dbUser->setPropertyValue("prijmeni", $pClient["last_name"]);
                $dbUser->setPropertyValue("mesto", $pClient["city"]);
                $dbUser->setPropertyValue("stat", $pClient["state"]);
                $dbUser->setPropertyValue("psc", $pClient["psc"]);
                $dbUser->setPropertyValue("ulice", $pClient["street"]);
                $dbUser->setPropertyValue("email", $pClient["email"]);
                $dbUser->setPropertyValue("firma", $pClient["company"]);
                $dbUser->setPropertyValue("telefon", $pClient["tel"]);
                $dbUser->setPropertyValue("fax", $pClient["fax"]);
                $dbUser->setPropertyValue("ico", $pClient["ico"]);
                $dbUser->setPropertyValue("dic", $pClient["dic"]);
                $dbUser->setPropertyValue("web", $pClient["web"]);
                $dbUser->setPropertyValue("sex", $pClient["sex"]);
                $dbUser->setPropertyValue("age", $pClient["age"]);
                $dbUser->setPropertyValue("note", $pClient["note"]);
                $dbUser->setPropertyValue("description", $pClient["description"]);

                $dbUser->setPropertyValue("detail_fname", $pClient["detail_fname"]);
                $dbUser->setPropertyValue("detail_lname", $pClient["detail_lname"]);
                $dbUser->setPropertyValue("detail_tel", $pClient["detail_tel"]);
                $dbUser->setPropertyValue("detail_fax", $pClient["detail_fax"]);
                $dbUser->setPropertyValue("detail_email", $pClient["detail_email"]);
                $dbUser->setPropertyValue("detail_date_created", $pClient["detail_date_created"]);
                $dbUser->setPropertyValue("detail_type", $pClient["detail_type"]);
                $dbUser->setPropertyValue("detail_position", $pClient["detail_position"]);
                $dbUser->setPropertyValue("other1", $pClient["other1"]);
                $dbUser->setPropertyValue("other2", $pClient["other2"]);
                $dbUser->setPropertyValue("other3", $pClient["other3"]);
                $dbUser->setPropertyValue("other4", $pClient["other4"]);
                $dbUser->setPropertyValue("other5", $pClient["other5"]);
                $dbUser->setPropertyValue("latitude", $pClient["latitude"]);
                $dbUser->setPropertyValue("longitude", $pClient["longitude"]);
                $dbUser->setPropertyValue("DateOfBirth", $pClient["DateOfBirth"]);
                $dbUser->setPropertyValue("TitleBefore", $pClient["TitleBefore"]);
                $dbUser->setPropertyValue("TitleAfter", $pClient["TitleAfter"]);
                $dbUser->setPropertyValue("Other6", $pClient["Other6"]);
                $dbUser->setPropertyValue("detail_DateOfBirth", $pClient["detail_DateOfBirth"]);
                $dbUser->setPropertyValue("detail_TitleAfter", $pClient["detail_TitleAfter"]);
                $dbUser->setPropertyValue("TitleBefore1", $pClient["TitleBefore1"]);
                $dbUser->setPropertyValue("detail_street", $pClient["detail_street"]);
                $dbUser->setPropertyValue("detail_City", $pClient["detail_City"]);
                $dbUser->setPropertyValue("detail_PSC", $pClient["detail_PSC"]);
                $dbUser->setPropertyValue("detail_State", $pClient["detail_State"]);
                $dbUser->setPropertyValue("detail_Age", $pClient["detail_Age"]);
                $dbUser->setPropertyValue("detail_Sex", $pClient["detail_Sex"]);
                $dbUser->setPropertyValue("detail_photo", $pClient["detail_photo"]);
                $dbUser->setPropertyValue("photo", $pClient["photo"]);
            } else {
                throw new Exception("Nepodarilo se naimportovat uzivatele");
            }
        }
        print_p($pClients);
    }

    public function getEnabled() {
        return $this->enabled;
    }

    public function setEnabled($state) {
        return dbI::query("UPDATE s3n_users SET enabled = %i WHERE id_user = %i", $state, $this->id)->update($this->enabled, $state)->result();
    }

    public function setMList($state) {
        $state = $state ? 1 : 0;
        return dbI::query("UPDATE s3n_users SET mlist = %i WHERE id_user = %i", $state, $this->id)->update($this->mlist, $state)->result();
    }

    public function updateLastLogin() {
        return dbI::query("UPDATE s3n_users SET last_login = %s WHERE id_user = %i", date("Y-m-d H:i:s"), $this->id)->result();
    }

//	public static function getZpravodajEmails() {
//		$emails = array();
//		$pUsers = dbI::query("SELECT * FROM s3n_users WHERE mlist = %i", 1)->fetchAll("dbUser");
//		/* @var $dbUser dbUser */
//		foreach ($pUsers as $dbUser) {
//			$email = $dbUser->getPropertyValue("email");
//			if (strpos($email, "@")) {
//				$emails[$email] = $email;
//			}
//		}
//		return $emails;
//	}


    public static function getZpravodajEmails() {
        $emails = dbI::query("SELECT DISTINCT(email) FROM s3n_emails")->fetchPairs();
        return $emails;
    }

    public static function getZpravodajUsers() {
        return dbI::query("SELECT * FROM s3n_emails")->fetchAll();
    }

    public function logLogin() {
        dbUserLog::create($this->id);
    }

    public static function export() {
        $pLines = dbI::query("SELECT * FROM s3n_users WHERE login <> 'guest' ORDER BY id_user")->fetchAll('dbUser');
//		$pProperties = dbI::query("SELECT prop_name FROM s3n_user_property WHERE prop_name NOT IN ('obchodni_informace', 'ostatni_informace', 'obrazek', 'firemni_udaje_typ', 'dodaci_adresa_typ', 'id_odbor', 'id_import', 'zustatek')  ")->fetchPairs();
        $pAllowedProperties = array(
            "jmeno",
            "prijmeni",
            "firma",
            "ulice",
            "mesto",
            "psc",
            "stat",
            "ico",
//			"description",
//			"dic",
//			"dod_firma",
//			"email",
//			"fax",
//			"note",
//			"telefon",
//			"titul",
//			"web",
        );
//		$pProperties = dbI::query("SELECT prop_name FROM s3n_user_property WHERE prop_name IN (%in)  ", $pAllowedProperties)->fetchPairs();
        $pProperties = $pAllowedProperties;
        $line = "";
        $comma = "";
        $cnt = 0;
        foreach ($pLines as $dbUser) {
            /* @var $dbUser dbUser */
            unset($dbUser->pass);
            unset($dbUser->id_parent);
            unset($dbUser->int_cislo);
            unset($dbUser->last_activity);
            unset($dbUser->id_pobocka);
            unset($dbUser->id_pozice);
            unset($dbUser->id_vedouci);
            unset($dbUser->vip);
            unset($dbUser->id_price_list);
            unset($dbUser->id_forum_author);
            unset($dbUser->admin);
            unset($dbUser->poziceName);
            unset($dbUser->source);
            unset($dbUser->active);
            unset($dbUser->id_user);
            unset($dbUser->type);
            unset($dbUser->id_role);
            unset($dbUser->firemni_udaje_typ);
            unset($dbUser->dodaci_adresa_typ);
            unset($dbUser->id_odbor);
            unset($dbUser->id_import);
            unset($dbUser->last_login);
            unset($dbUser->mlist);
            unset($dbUser->enabled);
//			print_p($dbUser); die();
            $line = "";
            $comma = "";
            $pReplace = array(
                "\t" => " ",
                '"' => "",
                ';' => " ",
            );
            if ($cnt == 0) {
                foreach ($dbUser AS $fieldName => $col) {
                    $line .= $comma . '"' . str_replace('"', '""', $fieldName) . '"';
// 					$comma = "\t";
                    $comma = ";";
                }
                foreach ($pProperties as $propName) {
                    $line .= $comma . '"' . str_replace('"', '""', $propName) . '"';
                }
                $line .= "\n";
                $out .= $line;
                $cnt++;
            }
            $line = "";
            $comma = "";
            foreach ($dbUser as $col) {
                $line .= $comma . '"' . str_replace('"', '""', $col) . '"';
// 				$comma = "\t";
                $comma = ";";
            }
//			$line = "";
//			$comma = "";
            foreach ($pProperties as $propName) {
                $line .= $comma . '"' . str_replace('"', '""', str_replace(array_keys($pReplace), array_values($pReplace), strip_tags($dbUser->getPropertyValue($propName)))) . '"';
// 				$comma = "\t";
                $comma = ";";
            }
//			}
            $line .= "\n";
            $out .= $line;
        }

//		print_p($out);
//		die();

        header("Content-type: text/csv");
        header("Content-Disposition: attachment; filename=export.csv");
        echo iconv("utf-8", "windows-1250//TRANSLIT", $out);
        exit;
    }

}
