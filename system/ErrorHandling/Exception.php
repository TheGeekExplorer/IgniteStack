<?php namespace igniteStack\System\ErrorHandling;

use igniteStack\System\Flow\Response;


class Exception
{
    final public static function cast ($t, $c=500)
    {
        // Cast response code
        (new Response)->setResponseCode ($c);
        
        // Include error definitions and cast
        include_once('../config/Core/errors.php');

        // Include error view
        include_once("../app/Views/Error/view.php");
        die();
    }
    
    final public function cast401($t) { $this->cast($t, 401); }
    final public function cast403($t) { $this->cast($t, 403); }
    final public function cast404($t) { $this->cast($t, 404); }
    final public function cast500($t) { $this->cast($t, 500); }
}
