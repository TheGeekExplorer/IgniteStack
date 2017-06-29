<?php namespace igniteStack\system\Flow\Authentication;

use igniteStack\System\Storage\DiskStore\IO;
use igniteStack\System\ErrorHandling\Exception;
use igniteStack\System\Flow\Authentication\Authenticator;


class Session
{
    /**
     * Starts a session
     * @return void
     */
    final static public function start ()
    {
        # Configure php session
        self::configureSession();

        # Start the session
        session_start();

        # Add AUTH key to Session  (Stops someone using an old cookie)
        if (!isset($_SESSION['authentication_code']))
            self::setSessionValue('authentication_code', Authenticator::generate_Session_ID());

        # Add AUTH key to Session (Only allows this IP to connect on this session)
        if (!isset($_SESSION['AUTHED_CLIENT']))
            self::setSessionValue('AUTHED_CLIENT', $_SERVER['REMOTE_ADDR']);
    }

    /**
     * Destroys session
     * @return void
     */
    final static public function end ()
    {
        session_destroy();
    }

    /**
     * Updates session and reports status
     * @return int
     */
    final static public function status ()
    {
    	return session_status();
    }

    /**
     * Configures the session
     * @return void
     */
    final public static function configureSession () {

        # Configuration file path
        $c = __DIR__ . '/../../../config/Session/SessionConfig.php';

        # Load the Session Config file
        if(!IO::exists($c))
            Exception::cast('IncludeExists');
        include_once ($c);
        

        # Configure session
        session_name($SessionConfig['name']);
        session_cache_expire($SessionConfig['cache_expire']);
        session_cache_limiter($SessionConfig['cache_limiter']);
    }

    /**
     * Sets a Session value
     * @param $key
     * @param $value
     * @return bool
     */
    final public static function setSessionValue ($key, $value)
    {
        # If empty key then cast exception
        if (!isset($key) || empty($key))
            Exception::cast("Cannot set session value of empty key");

        # Set session value
        $_SESSION[$key] = $value;

        return true;
    }
}
