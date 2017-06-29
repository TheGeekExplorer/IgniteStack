<?php namespace igniteStack\Interfaces;

use igniteStack\System\ErrorHandling\Exception;
use igniteStack\System\Core\TimeDate;


abstract class Core
{
    //// Object Factories ///////////////////////

    final public function Routes () {
        include('../config/Routes/config.php');
        return $_ROUTES;
    }

    final public function version () {
        include_once('../config/Core/version.php');
        return $_IGNITESTACK_VERSION;
    }
}
