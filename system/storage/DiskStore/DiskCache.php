<?php namespace igniteStack\System\Storage\DiskStore;

use igniteStack\System\Storage\DiskStore\IO;


class DiskCache
{
    /**
     * Add a Cache Key/Value Pair
     * @param $database
     * @param $key
     * @param $value
     * @param $expiry
     * @param $persist
     * @return bool
     */
    final public static function add ($database, $key, $value, $expiry=3600, $persist=0)
    {
        return true;
    }

    /**
     * Set/Overwrite a Key/Value Pair
     * @param $database
     * @param $key
     * @param $value
     * @param $expiry
     * @param $persist
     * @return bool
     */
    final public static function set ($database, $key, $value, $expiry=3600, $persist=0)
    {
        return true;
    }

    /**
     * Get/Read a Key/Value Pair
     * @param $database
     * @param $key
     * @return mixed
     */
    final public static function get ($database, $key)
    {
        $file = '../cache/' . $database . '_' . $key . '.cache';

        // Retrieve the cache file parts
        $key      =  (string)  IO::readCacheFile($file, 0, 79);
        $expiry   =  (int)     IO::readCacheFile($file, 80, 84);
        $persist  =  (int)     IO::readCacheFile($file, 85, 85);
        $content  =            IO::readCacheFile($file, 86, "END");

        return $content;
    }

    /**
     * Remove a Key/Value Pair
     * @param $database
     * @param $key
     * @return bool
     */
    final public static function remove ($database, $key)
    {
        return true;
    }

    /**
     * Set the Expiry on a Key/Value Pair
     * @param $database
     * @param $key
     * @param $expiry
     * @return bool
     */
    final public static function setExpiry ($database, $key, $expiry=3600)
    {
        return true;
    }
}