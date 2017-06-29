<?php namespace igniteStack\Interfaces;

use igniteStack\Interfaces\Core;


abstract class BaseController extends Core
{
    //// Controller Stacktrace //////////////////

    final public function stacktrace ()
    {
        // TODO
    }
    
    // Some sort of log?
    final public function log ($m)
    {
        echo $m;
    }
}
