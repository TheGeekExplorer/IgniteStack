<?php namespace igniteStack\System\Resources;

use igniteStack\System\ErrorHandling\Exception;
use igniteStack\System\Storage\DiskStore\IO;


class Plugins
{
    final public function Frontend ($buffer)
    {
        # Include the Front End Config File
        $c = '../app/Plugins/Frontend/config.php';
        if(!IO::exists($c))
            Exception::cast('IncludeExists');
        @include_once ($c);


        // If cannot load Plugins config file then throw exception
        if (!isset($_PLUGINS))
            Exception::cast('ResponseCodeNotValid');

        $header = '';  $footer = '';
        
        foreach ($_PLUGINS as $k => $v)
        {
            // If plugin is enabled then get the header and footer includes
            if ($v == 1) {
                
                $pluginConfig = "../app/Plugins/Frontend/$k/config.php";
                
                if (!file_exists($pluginConfig))
                    Exception::cast('CouldNotLoadPlugin');
                
                // Load plugin config file
                $c = '../config/Core/Flow/ResponseCodes.php';
                if(!IO::exists($pluginConfig))
                    Exception::cast('IncludeExists');
                include_once ($pluginConfig);
                
                $assetRoot = "../app/Plugins/Frontend/$k/Assets/";
                
                $header .= @file_get_contents($assetRoot . $_PLUGIN['assets']['header']);
                $footer .= @file_get_contents($assetRoot . $_PLUGIN['assets']['footer']);
            }
        }
        return $this->LoadPlugins ($buffer, $header, $footer);    
    }
    
    final private function LoadPlugins ($buffer, $header, $footer)
    {
        $buffer = str_replace("</head>", "\n\n<!-- Plugin Dependencies -->\n\n$header\n<!-- -->\n\n\n</head>", $buffer);    // Header Injections
        $buffer = str_replace("</body>", "\n\n<!-- Plugin Dependencies -->\n\n$footer\n<!-- -->\n\n\n</body>", $buffer);    // Header Injections
        return ($buffer);
    }
}