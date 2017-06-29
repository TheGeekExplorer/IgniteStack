<?php namespace igniteStack\System\Flow;


class Requests
{
    final public static function post ($key)
    {
        if (isset($_POST[$key]))
            return $_POST[$key];
        return false;
    }

    final public static function get ($key)
    {
        if (isset($_GET[$key]))
            return $_GET[$key];
        return false;
    }

    final public static function request ($key)
    {
        if (isset($_REQUEST[$key]))
            return $_REQUEST[$key];
        return false;
    }
    
    /**
     * Gets the requested page path from mvcReqPath in the query
     * 
     * @return string
     */
    final public static function getRequestedPath ()
    {
        $p='';

        // If in REQUEST_URI
        if (isset($_SERVER['REQUEST_URI']))
            $p = urldecode ($_SERVER['REQUEST_URI']);

        // If Routed to MVC REQ PATH Query String
        if (isset($_REQUEST['mvcReqPath']))
            $p = urldecode ($_REQUEST['mvcReqPath']);

        // Trim directory operators
        $p = str_replace("../", "", $p);
        $p = str_replace("./", "", $p);
        
        // If no path then set to /
        if (empty($p))
            $p = '/';

        return (String) $p;
    }

    /**
     * Values stored in the $_SERVER global
     */
    public static function userIP ()         {  return (String) $_SERVER['REMOTE_ADDR'];      }
    public static function userAgent ()      {  return (String) $_SERVER['HTTP_USER_AGENT'];  }
    public static function serverIP ()       {  return (String) $_SERVER['SERVER_ADDR'];      }
    public static function httpReferrer ()   {  return (String) $_SERVER['HTTP_REFERER'];     }
    public static function documentRoot ()   {  return (String) $_SERVER['DOCUMENT_ROOT'];    }
    public static function requestTime ()    {  return (String) $_SERVER['REQUEST_TIME'];     }
    public static function scriptFilename () {  return (String) $_SERVER['SCRIPT_FILENAME'];  }
    public static function pathTranslated () {  return (String) $_SERVER['PATH_TRANSLATED'];  }
    public static function requestURI ()     {  return (String) $_SERVER['REQUEST_URI'];      }
    public static function pathInfo ()       {  return (String) $_SERVER['PATH_INFO'];        }
}

