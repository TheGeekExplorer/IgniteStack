<?php namespace igniteStack\System\Storage\MemoryStore;

use igniteStack\System\ErrorHandling\Exception;


class Memento
{
    final public function add ($s, $k, $v, $exp, $persist)
    {
        (new MemoryStore)->Memcached($s)
            ->set($k, $v, $exp);
        return true;
    }

    final public function set ($s, $k, $v, $exp, $persist)
    {
        (new MemoryStore)->Memcached($s)
            ->set($k, $v, $exp);
        return true;
    }

    final public function get ($s, $k)
    {
        (new MemoryStore)->Memcached($s)
            ->get($k);
        return true;
    }

    final public function remove ($s, $k)
    {
        (new MemoryStore)->Memcached($s)
            ->delete($k);
        return true;
    }

    final public function setExpiry ($s, $k, $exp)
    {
        return true;
    }
}
