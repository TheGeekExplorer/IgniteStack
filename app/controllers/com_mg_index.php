<?php namespace igniteStack\app\Controllers;

use igniteStack\Interfaces\Controllers;
use igniteStack\Interfaces\BaseController;
use igniteStack\System\Flow\Response;
use igniteStack\System\Flow\Authentication\Session;
use igniteStack\System\Flow\Authentication\CSRF;


class com_mg_index extends BaseController implements Controllers
{
    public function __construct () {}
    public function __destruct () {}
    
    
    ///// LOGIN PAGE ////////////////////////////////////////
    public function index ()
    {
    	# Clear all old sessions
    	Session::end();
    	Session::start();

        # Return 200 OK to client
        return Response::ok([
            'csrf_token'  =>  CSRF::create_CSRF_Object('csrf_token', CSRF::generate_Tokens(1)[0])
        ]);
    }
}


