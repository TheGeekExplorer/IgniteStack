<?php namespace igniteStack\System\Flow;

use igniteStack\System\ErrorHandling\Exception;
use igniteStack\System\Storage\DiskStore\IO;


class Response
{
    /**
     * Returns a 200 OK
     * @param string $d
     * @param string $mime
     * @return string
     */
    final public static function ok ($content='', $mime='text/html')
    {
        self::setHeader ("Content-type: $mime");
        self::setResponseCode (200);
        return $content;
    }

    /**
     * Returns an ERROR 500
     * @param string $d
     * @param string $mime
     * @return string
     */
    final public static function error ($content='', $mime='text/html')
    {
        self::setHeader ("Content-type: $mime");
        self::setResponseCode (500);
        return $content;
    }

    /**
     * Returns an ERROR 404
     * @param string $d
     * @param string $mime
     * @return string
     */
    final public static function notfound ($content='', $mime='text/html')
    {
        self::setHeader ("Content-type: $mime");
        self::setResponseCode (404);
        return $content;
    }

    /**
     * Returns an ERROR 400 (Bad Request)
     * @param string $d
     * @param string $mime
     * @return string
     */
    final public static function badrequest ($content='', $mime='text/html')
    {
        self::setHeader ("Content-type: $mime");
        self::setResponseCode (400);
        return $content;
    }

    /**
     * Returns an ERROR 401 (Not Authorised)
     * @param string $d
     * @param string $mime
     * @return string
     */
    final public static function notauthorised ($content='', $mime='text/html')
    {
        self::setHeader ("Content-type: $mime");
        self::setResponseCode (401);
        return $content;
    }

    /**
     * Returns an ERROR 403 (Forbidden)
     * @param string $d
     * @param string $mime
     * @return string
     */
    final public static function forbidden ($content='', $mime='text/html')
    {
        self::setHeader ("Content-type: $mime");
        self::setResponseCode (403);
        return $content;
    }

    /**
     * Returns an ERROR 405 (Method not Allowed)
     * @param string $d
     * @param string $mime
     * @return string
     */
    final public static function disallowedmethod ($content='', $mime='text/html')
    {
        self::setHeader ("Content-type: $mime");
        self::setResponseCode (405);
        return $content;
    }

    /**
     * Returns an ERROR 503 (Unavailable)
     * @param string $d
     * @param string $mime
     * @return string
     */
    final public static function unavailable ($content='', $mime='text/html')
    {
        self::setHeader ("Content-type: $mime");
        self::setResponseCode (503);
        return $content;
    }
    
    /**
     * Sets the response code provided
     * @param type $c
     * @return type Sets response code to browser
     */
    final public static function setResponseCode ($response_code)
    {
        # Cast ot integer
        $response_code = (int) $response_code;

        # Include ResponseCodes configuration array
        $c = '../config/Core/Flow/ResponseCodes.php';
        if(!IO::exists($c))
            Exception::cast('IncludeExists');
        include_once ($c);

        # Check whether response code is present in the
        # response headers list
        if (!isset($ResponseCodes) || !isset($ResponseCodes[$response_code]))
            Exception::cast('ResponseCodeNotValid', 500);

        # Set the response header
        self::setHeader ($ResponseCodes[$response_code]);
    }

    /**
     * Header response based on code given (Example: 404)
     * @param integer $c
     * @return null
     */
    final public static function setHeader ($h) {
        if (!isset($h) || empty($h))
            Exception::cast('HeaderTextNotSpecified', 500);
        header ($h);
    }
}
