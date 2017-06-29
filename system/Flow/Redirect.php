<?php namespace igniteStack\System\Flow;

use igniteStack\System\ErrorHandling\Exception;


class Redirect
{
    /**
     * Redirects to specific URL with a specific Response Code
     * @param $url
     * @param int $response_code
     */
    final public static function to ($url, $response_code=302)
    {
        // If destination has not been set then error 500
        if (!isset($url) || empty($url))
            Exception::cast('NoRedirectURL', 500);
        
        // Set the 301 response code
        Response::setResponseCode ($response_code);
        
        // Redirect to url
        header ("Location: $url");
        exit;
    }
}
