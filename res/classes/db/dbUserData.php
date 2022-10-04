<?php

	/**
	* User data
	* @author Error
	*/
	class dbUserData extends dbBase {

		public $id;
		public $id_user;
		public $firstname;
		public $surname;
		public $company;
		public $email;
		public $address;
		public $psc;
		public $town;
		public $ico;
		public $dic;
		public $id_country;

		/**
		* Constructor with decryption
		* @param array $array
		*/
		public function __construct(Array $array) {
			foreach ($array as $key => $var) {
				switch ($key) {
					case 'firstname':
					case 'surname':
					case 'company':
					case 'address':
					case 'psc':
					case 'town':
					case 'ico':
					case 'dic':
					case 'delivery_addressee':
					case 'delivery_street':
					case 'delivery_psc':
					case 'delivery_town':
						$this->$key = db::decrypt($var);
						break;
					default: $this->$key = $var;
				}
			}
		}

		/**
		* Returns valid user's data in a specified time or now
		* @param dbIUser $user
		* @param DateTime|int|string $dt
		* @throws dbException
		* @return dbUserData|false
		*/
		public static function getByUser(dbIUser $user) {
			return dbI::query("
				SELECT *, id_user AS id
				FROM s3n_user_map_property
				WHERE id_user = %i
				LIMIT 1
			", $user->getId())->fetch('dbUserData');
		}

		/**
		* Creates or replaces existing user data
		* @param dbIUser $user
		* @param string $firstname
		* @param string $surname
		* @param string $company
		* @param string $address
		* @param string $psc
		* @param string $town
		* @param string $ico
		* @param string $dic
		* @param dbIUserMsisdn $msisdn
		* @param dbICountry $country
		* @param boolean $use_delivery_address;
		* @param string $delivery_addressee;
		* @param string $delivery_street;
		* @param string $delivery_psc;
		* @param string $delivery_town;
		* @param dbICountry $country_delivery
		* @return dbUserData|false
		*/
		public static function create(dbIUser $user, $firstname, $surname, $company, $address, $psc, $town, $ico, $dic, dbIUserMsisdn $msisdn = NULL, dbICountry $country = NULL, $use_delivery_address = false, $delivery_addressee = NULL, $delivery_street = NULL, $delivery_psc = NULL, $delivery_town = NULL, dbICountry $country_delivery = NULL) {
			$id_msisdn = ($msisdn ? $msisdn->getId() : NULL);

			if (!$country) {
				$cnt = dbCountry::getCurrent();
				$id_country = ($cnt ? $cnt->getId() : NULL);
			} else {
				$id_country = $country->getId();
			}

			if ($use_delivery_address and $country_delivery) {
				$id_country_delivery = $country_delivery->getId();
			} else {
				$id_country_delivery = NULL;
			}

			if (
				$c = $user->getCurrentData() and
				($c->firstname == $firstname) and
				($c->surname == $surname) and
				($c->company == $company) and
				($c->address == $address) and
				($c->psc == $psc) and
				($c->town == $town) and
				($c->ico == $ico) and
				($c->dic == $dic) and
				($c->id_msisdn == $id_msisdn) and
				($c->id_country == $id_country) and
				($c->use_delivery_address == $use_delivery_address) and
				($c->delivery_addressee == $delivery_addressee) and
				($c->delivery_street == $delivery_street) and
				($c->delivery_psc == $delivery_psc) and
				($c->delivery_town == $delivery_town) and
				($c->id_country_delivery == $id_country_delivery)
			) {
				return $c;
			} else {
				return dbUserData::getById(db::beginQuery("
					UPDATE user_data
					SET valid_to = SUBTIME(NOW(), '0:0:1')
					WHERE id_user = %i
					AND COALESCE(valid_to, NOW()) >= NOW()
				", $user->getId())->resultQuery("
					INSERT INTO user_data
					(id_user, valid_from, valid_to, firstname, surname, company, address, psc, town, ico, dic, id_msisdn, id_country, use_delivery_address, delivery_addressee, delivery_street, delivery_psc, delivery_town, id_country_delivery)
					VALUES
					(%i, NOW(), NULL, %s, %s, %s, %s, %s, %s, %s, %s, %in, %in, %b, %s, %s, %s, %s, %in)
				", $user->getId(), db::encrypt($firstname), db::encrypt($surname), db::encrypt($company), db::encrypt($address), db::encrypt($psc), db::encrypt($town), db::encrypt($ico), db::encrypt($dic), $id_msisdn, $id_country,
					$use_delivery_address, db::encrypt($delivery_addressee), db::encrypt($delivery_street), db::encrypt($delivery_psc), db::encrypt($delivery_town), $id_country_delivery
				)->insertCommit());
			}
		}

		/**
		* Returns a user data by ID
		* @param int $id
		* @throws dbException
		* @return dbUserData|false
		*/
		public static function getById($id) {
			return dbI::query("
				SELECT *
				FROM user_data
				WHERE id = %i
			", $id)->fetch('dbUserData');
		}
	}