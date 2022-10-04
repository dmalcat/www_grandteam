<?php

class Cache {

    const TURNED_ON = CACHE_ON;
    const SYSTEM_HOST = CACHE_HOST;
    const SYSTEM_PORT = CACHE_PORT;
    const SYSTEM_PREFIX = CACHE_PREFIX;
    const SHORT = CACHE_SHORT;
    const MEDIUM = CACHE_MEDIUM;
    const LONG = CACHE_LONG;

    /** Memcache connection */
    private static $conn;

    /**
     * prebere parametry z konfigurace a vytvori konstanty, ktere jsou potreba
     * kvuli zpetne kompatibilite. CACHE_ON a podobne.
     *
     * @param Config $config
     * @author jhajek
     */
    public static function init() {
        define('CACHE_ON', (bool) 1);
        define('CACHE_HOST', '127.0.0.1');
        define('CACHE_PORT', (int) 11211);
        define('CACHE_PREFIX', Registry::getDomainName());

        define('CACHE_SHORT', (int) 300);
        define('CACHE_MEDIUM', (int) 900);
        define('CACHE_LONG', (int) 1800);
    }

    /**
     * Returns a value from cache
     * @param string $key identifier of value
     * @throws InvalidArgumentException
     * @return string|false - false when result not found, boolean value is converted to 0 or 1
     */
    public static function get($key) {
        if ($key == '') {
            throw new InvalidArgumentException('Invalid key.');
        }

        if (!self::TURNED_ON) {
            return false;
        }

        return self::getConn()->get(self::SYSTEM_PREFIX . $key);
    }

    /**
     * Sets a value in cache
     * @param string $key identifier of value
     * @param string $value value to be stored - must be string (do the damn serialization yourself)
     * @param int $mode caching mode to be used
     * @throws InvalidArgumentException
     * @return void
     */
    public static function set($key, $value, $interval) {
        if ($key == '') {
            throw new InvalidArgumentException('Invalid key.');
        }

        if (!is_string($value) && !is_numeric($value)) {
            throw new InvalidArgumentException('Any value must be stored in serialized string form.');
        }

        if (!self::TURNED_ON) {
            return true;
        }

        $key = self::SYSTEM_PREFIX . $key;

        self::getConn()->add($key, $value, false, (int) $interval);
        return true;
    }

    /**
     * increment value in cache
     *
     * @param string $key
     * @throws InvalidArgumentException
     * @return bool
     */
    public static function increment($key) {
        if ($key == '') {
            throw new InvalidArgumentException('Invalid key.');
        }

        if (!self::TURNED_ON) {
            return false;
        }

        return self::getConn()->increment(self::SYSTEM_PREFIX . $key);
    }

    /**
     * Flushes cache
     * @return boolean
     */
    public static function flush() {
        return self::getConn()->flush();
    }

    /**
     * Returns connection to caching daemon
     * @return Memcache
     */
    public static function getConn() {
        if (!self::$conn) {
            self::$conn = new Memcached();
            self::$conn->addServer('localhost', 11211) or die("Could not connect to memcache");
//				print_p(self::$conn->connect(self::SYSTEM_HOST, self::SYSTEM_PORT));
        }
        return self::$conn;
    }

}
