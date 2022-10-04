<?php

/**
 * dbIndex basic functionality layer
 * @author Error
 */
class dbI {

    /** @var DibiConnection */
    private static $conn;

    /**
     * Manufactures db object with provided SQL arguments
     * @return dbI
     */
    public static function query() {
        return new dbI(func_get_args());
    }

    /**
     * Manufactures dbIndex object with provided SQL arguments with dynamic caching enabled
     * @return dbI
     */
    public static function cachedQuery() {
        return new dbI(func_get_args(), Registry::getConfig()->cache->medium);
    }

    /**
     * Starts transaction and manufactures dbIndex object with provided SQL arguments
     * Caching is not supported within transactions
     * @return dbI
     */
    public static function beginQuery() {
        self::begin();
        return new dbI(func_get_args());
    }

    /**
     * Creates or returns already created database connection
     * @return DibiConnection
     */
    private static function getConn() {
        if (!isset(self::$conn)) {
            try {
                $namespace = Registry::getConfig()->database->namespace;
                $configArray = Registry::getConfig()->database->$namespace->toArray();

                if (Registry::isXmlRequest() && !Registry::getConfig()->log->showLogInXmlRequest) {
                    $configArray['profiler'] = false;
                }
                dibi::connect($configArray);
                self::$conn = dibi::getConnection();
            } catch (DibiException $e) {
                self::logError($e->getMessage(), 'Database connection error.');
                throw new Exception('Database connection failed.');
            }
        }
        return self::$conn;
    }

    // GLOBAL CONSTANTS
    // ENCRYPTION

    /**
     * Encrypts a string
     * @param $string String string to be encrypted
     * @return String encrypted string
     */
    public static function encrypt($string) {
        return Cipher::encrypt($string);
    }

    /**
     * Decrypts a string
     * @param $string String string to be decrypted
     * @return String decrypted string
     */
    public static function decrypt($string) {
        return Cipher::decrypt($string);
    }

    // QUERY TRANSLATION

    /**
     * Translates dibi query into native query
     * @param array $query dibi query in array form
     * @return string translated query
     */
    public static function translate($query) {
        try {
            $query = func_get_args();
            if (count($query) == 1) {
                $query = $query[0];
            }
            $conn = self::getConn();
            $translator = new \Dibi\Translator($conn);
            return $translator->translate($query);
        } catch (DibiException $e) {
            self::logError($e->getMessage() . ' ' . print_r($query, true), 'Query translation error.');
//				throw new Exception('Query translation error: ' . print_r($query, true));
            throw new Exception('Query translation error: ' . print_r($query, true));
        }
    }

    /**
     * Tests SQL query
     * @param array $query dibi query in array form
     * @return result
     */
    public static function test($query) {
        ob_start();
        self::getConn()->test($query);
        return ob_get_clean();
    }

    // USEFUL SHORTCUTS

    /**
     * Returns current database time
     * @throws Exception
     * @return string
     */
    public static function now() {
        return self::query("SELECT NOW()")->fetchSingle();
    }

    /**
     * Returns current database name
     * @throws Exception
     * @return string
     */
    public static function database() {
        return self::query("SELECT DATABASE()")->fetchSingle();
    }

    // LATEST AUTOINCREMENT ID GENERATION

    /**
     * Returns autoincrement value of last insert query
     * @throws Exception
     * @return int
     */
    private static function getInsertId() {
        try {
            return self::getConn()->getInsertId();
        } catch (DibiException $e) {
            self::logError($e->getMessage(), 'Getting insert id failed.');
            throw new Exception('Getting insert id failed.');
        }
    }

    // WORK WITH TRANSACTIONS

    /**
     * Begins a transaction
     * @throws Exception
     * @return void
     */
    public static function begin() {
        try {
            self::getConn()->begin(NULL);
        } catch (DibiException $e) {
            self::logError($e->getMessage(), 'Transaction error.');
            throw new Exception('Transaction error.');
        }
        self::logDebug('Last SQL: ' . self::getLastSQL(), 'Transaction started.');
    }

    /**
     * Commits statements in a transaction
     * @throws Exception
     * @return void
     */
    public static function commit() {
        try {
            self::getConn()->commit(NULL);
        } catch (DibiException $e) {
            self::logError($e->getMessage(), 'Transaction error.');
            throw new Exception('Transaction error.');
        }
        self::logDebug('Last SQL: ' . self::getLastSQL(), 'Transaction commited.');
    }

    /**
     * Rollback changes in a transaction
     * @throws Exception
     * @return void
     */
    public static function rollback() {
        try {
            self::getConn()->rollback(NULL);
        } catch (DibiException $e) {
            self::logError($e->getMessage(), 'Transaction error.');
            throw new Exception('Transaction error.');
        }
        self::logDebug('Last SQL: ' . self::getLastSQL(), 'Transaction rolled back.');
    }

    // DYNAMIC MODE

    private $query = NULL;
    private $cache_mode = NULL;
    private $cache_static_use = false;
    private $cache_static_store = NULL;
    private $updates = array();

    /**
     * Translates and prepares query for execution
     * @param array of arguments passed to translator
     * @throws Exception
     */
    private function __construct($args, $cache_mode = NULL) {
        $this->query = $args;

        if ((Registry::getConfig()->cache->enabled == 0) or ! $cache_mode) {
            $cache_mode = NULL;
        }
        $this->cache_mode = $cache_mode;
    }

//		private function __construct($args, $cache_mode = NULL) {
//			$this->query = $args;
//			$this->cache_mode = $cache_mode;
//		}

    /**
     * Adds a variable to list of updatables
     * @param reference $var refernce to variable to update
     * @param mixed $value value to update variable with
     * @throws Exception
     */
    public function update(&$var, $value) {
        $c = count($this->updates);
        $this->updates[] = array('ref' => NULL, 'val' => $value);
        $this->updates[$c]['ref'] = & $var;
        return $this;
    }

    /**
     * Enables static caching
     * @param reference $store refernce to static variable to store the reults
     * @throws Exception
     */
    public function cache(&$store) {
        $this->cache_static_use = true;
        $this->cache_static_store = & $store;
        return $this;
    }

    /**
     * Executes query and returns result
     * @param int $result_mode
     * @param mixed
     * @param mixed
     * @throws Exception
     * @return mixed
     */
    private function doQuery($result_mode, $param1 = NULL, $param2 = NULL) {
        if ($this->cache_static_use and ( $this->cache_static_store !== NULL)) {
            return $this->cache_static_store;
        }

        if ($this->cache_mode) {

            $cache_id = 'DB' . date('Ymd') . md5(serialize($this->query));
            $result = Cache::get($cache_id);
            if ($result !== false) {
                self::logDebug($this->query, 'Cached query');
                return unserialize($result);
            }
        }

        $mt = microtime(true);

        try {
            $qresult = self::getConn()->nativeQuery(self::translate($this->query));
        } catch (DibiDriverException $e) {
            self::logError($e->getMessage() . ', Last SQL: ' . self::getLastSQL(), 'Query failed.');
            throw new Exception('Query failed, Message: ' . $e->getMessage() . ', Last sql: ' . self::getLastSQL(), 0, $e);
        } catch (DibiException $e) {
            self::logError($e->getMessage() . ', Last SQL: ' . self::getLastSQL(), 'Query failed.');
            throw new Exception('Query failed, Message: ' . $e->getMessage() . ', Last sql: ' . self::getLastSQL(), 0, $e);
        }

        try {

            switch ($result_mode) {
                case 'result':
                    if ($qresult === false) {
                        $result = false;
                    } else {
                        $result = true;
                    }

                    break;
                case 'insert':
                    if ($qresult === false) {
                        $result = false;
                    } else {
                        $result = self::getInsertId();
                    }

                    break;
                case 'value':
                    $result = $qresult->fetchSingle();
                    break;
                case 'row':
                    $qresult->setRowClass($param1);
                    $result = $qresult->fetch();
                    break;
                case 'rows':
                    $qresult->setRowClass($param1);
                    $result = $qresult->fetchAll();

                    if (!$result) {
                        $result = array();
                    }

                    break;
                case 'assoc':
                    $qresult->setRowClass($param1);
                    $result = $qresult->fetchAssoc($param2);

                    if (!$result) {
                        $result = array();
                    }

                    break;
                case 'pairs':
                    $result = $qresult->fetchPairs($param1, $param2);

                    if (!$result) {
                        $result = array();
                    }

                    break;
            }
        } catch (DibiDriverException $e) {
            self::logError($e->getMessage() . ', Last SQL: ' . self::getLastSQL(), 'Query failed.');
            throw new Exception('Query failed: ' . $e->getMessage());
        } catch (DibiException $e) {
            self::logError($e->getMessage() . ', Last SQL: ' . self::getLastSQL(), 'Fetching results failed.');
            throw new Exception('Fetching results failed.');
        } catch (InvalidArgumentException $e) {
            self::logError($e->getMessage() . ', Last SQL: ' . self::getLastSQL(), 'Invalid arguments.');
            throw new Exception('Invalid arguments.');
        }

        foreach ($this->updates as $v) {
            $v['ref'] = $v['val'];
        }


        $mtr = microtime(true) - $mt;
        self::logDebug('Last SQL: ' . self::getLastSQL(), "Uncached query [query time: {$mtr}]");

        if ($this->cache_mode) {
            Cache::set($cache_id, serialize($result), $this->cache_mode);
        }

        if ($this->cache_static_use) {
            $this->cache_static_store = $result;
        }

        return $result;
    }

    /**
     * Returns boolean result of INSERT or UPDATE queries
     * @return bool
     */
    public function result() {
        return $this->doQuery('result');
    }

    /**
     * Determines result of a query and if it succeeded runs a next one or else throws an exception
     * @throws Exception
     * @return db
     */
    public function resultQuery() {
        if ($this->doQuery('result')) {
            return new db(func_get_args());
        } else {
            throw new Exception('Transaction failed.');
        }
    }

    /**
     * Determines result of a query and if it succeeded commits transaction and runs another query
     * @throws Exception
     * @return db
     */
    public function commitQuery() {
        if ($this->doQuery('result')) {
            self::commit();
            return new db(func_get_args());
        } else {
            throw new Exception('Transaction failed.');
        }
    }

    /**
     * Determines result of a query and if it succeeded commits transaction
     * @throws Exception
     * @return bool
     */
    public function resultCommit() {
        if ($this->doQuery('result')) {
            self::commit();
            return true;
        } else {
            throw new Exception('Transaction failed.');
        }
    }

    /**
     * Determines result of a query and if it succeeded commits transaction
     * @throws Exception
     * @return int
     */
    public function insertCommit() {
        if ($id = $this->doQuery('insert')) {
            self::commit();
            return $id;
        } else {
            throw new Exception('Transaction failed.');
        }
    }

    /**
     * Returns INSERT id
     * @return int|false
     */
    public function insert() {
        return $this->doQuery('insert');
    }

    /**
     * Returns one field (and discards the rest)
     * @return mixed value on success, FALSE if no record
     */
    public function fetchSingle() {
        return $this->doQuery('value');
    }

    /**
     * Fetches one row (and discards the rest)
     * @return mixed  array of predefined class on success, FALSE if no next record
     */
    public function fetch($class = 'dbBase') {
        return $this->doQuery('row', $class);
    }

    /**
     * Fetches all records from table
     * @param string $class of result
     * @param int $offset
     * @param int $limit
     * @return mixed array of predefined class
     */
    public function fetchAll($class = 'dbBase') {
        return $this->doQuery('rows', $class);
    }

    /**
     * Fetches all records from table and returns associative tree.
     * Associative descriptor:  assoc1,#,assoc2,=,assoc3,@
     * builds a tree:           $data[assoc1][index][assoc2]['assoc3']->value = {record}
     * @param  string  class of result
     * @param  string  associative descriptor
     * @return mixed  result of predefined class
     * @throws Exception
     */
    public function fetchAssoc($class = 'dbBase', $assoc) {
        return $this->doQuery('assoc', $class, $assoc);
    }

    /**
     * Fetches all records from table like $key => $value pairs.
     * @param  string $key associative key
     * @param  string $value value
     * @return array
     * @throws Exception
     */
    public function fetchPairs($key = NULL, $value = NULL) {
        return $this->doQuery('pairs', $key, $value);
    }

    private static function logError($message, $title) {
//			global $ERROR;
//			$ERROR->spawn("Shop_3n", 1, $svrcode, ERROR::CRIT, $title.": ".$message);
        throw new Exception($message);
//			return Log::getProvider('db')->log($message, '[' . db::getUsername() . '@' . db::getHost() . '/' . db::getDatabase() . "] " . $title, Log::TYPE_ERROR);
    }

    private static function logDebug($message, $title) {
//			global $ERROR;
//			$ERROR->spawn("Shop_3n", 1, $svrcode, ERROR::DEBUG, $title.": ".$message);
//			throw new Exception($message, $code, $previous);
//			return Log::getProvider('db')->log($message, '[' . db::getUsername() . '@' . db::getHost() . '/' . db::getDatabase() . "] " . $title, Log::TYPE_DEBUG);
    }

    public static function debug($message) {
//			global $ERROR;
//			$ERROR->spawn("Shop_3n", 1, $svrcode, ERROR::DEBUG, $title.": ".$message);
//			throw new Exception($message, $code, $previous);
//			return Log::getProvider('db')->log($message, '<<<MANUAL>>>', Log::TYPE_DEBUG);
    }

    /**
     * Returns last SQL queried
     * @return string
     */
    public static function getLastSQL() {
        return dibi::$sql;
    }

}
