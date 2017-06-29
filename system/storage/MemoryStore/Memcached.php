<?php namespace igniteStack\System\Storage\MemoryStore;

use igniteStack\System\ErrorHandling\Exception;


class MemoryStore
{
    public function Memcached ($store)
    {
        // If no store then choose temporary name
        if(empty($store))
            $store = md5(sha1(time));

        // Load configration
        include_once ('../config/Datasource/memcached.php');

        // Instantiate new Memcached object
        $memCached = new \Memcached($store);

        // If server list is empty then add new one
        if (!count($memCached->getServerList())) {
            $memCached->addServer(
                $_MEMCACHED['host'], $_MEMCACHED['port'], 100
            );
        }
        return $memCached;
    }
} 