<?php namespace igniteStack\System\Flow;

use igniteStack\System\ErrorHandling\Exception;


class State
{
    private $state;

    final public function set ($s) {
       $this->state = $s;
    }

    final public function get () {
        return $this->state;
    }
}
