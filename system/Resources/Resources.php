<?php namespace igniteStack\System\Resources;

use igniteStack\System\Converters\Sanitizer;
use igniteStack\System\Storage\DiskStore\IO;
use igniteStack\System\ErrorHandling\Exception;


class Resources {

    /**
     * Loads the requested resource file
     * (Checks exists, sets MIME type)
     * @param $r
     * @return void
     */
    final static public function loadResource ($url)
    {
        // Sanitise requested URL
        $url = Sanitizer::sanitizeURL($url);

        // Build full path for resource
        $url = str_replace("\\", "/", __DIR__) . '/../../index' . $url;
		
        // Test if resource exists
        if (!IO::exists($url))
            Exception::cast("The resource you have requested does not exit.", 404);

        // TODO: Set MIME type for resource        
        $parts = explode(".", $url);
        $len = sizeof($parts);
        $ext = $parts[$len-1];
        
        switch ($ext) {
            case 'htm':
            case 'html':
        		header('Content-type:text/html');
        		break;
            case 'xml':
                header('Content-type:text/xml');
                break;
        	case 'css':
        		header('Content-type:text/css');
        		break;
        	case 'js':
        		header('Content-type:application/javascript');
        		break;
            case 'json':
                header('Content-type:application/json');
                break;
        	case 'jpg':
        	case 'jpeg':
        		header('Content-type:image/jpeg');
        		break;
        	case 'gif':
        		header('Content-type:image/gif');
        		break;
        	case 'png':
        		header('Content-type:image/png');
        		break;
        	default:
        		header('Content-type:application/octet-stream');
        		break;
        }

        // Load the resource
        die(file_get_contents($url));
    }
}
