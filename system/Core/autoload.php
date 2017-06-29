<?php

spl_autoload_register(function($className)
{
    # Convert Slashes
    $className = str_replace('/', '', $className);
    $className = str_replace('\\', '/', $className);

    # Plugin Load
    if (strpos($className,'igniteStack') === false)
        include_once ("../app/Plugins/Backend/$className.php");

    # igniteStack Class Load
    $className = str_replace("\\","/",$className);
    $class = __DIR__ . '/../../' . str_replace('igniteStack/', '', $className) . ".php";
    if (file_exists($class))
        include_once ($class);	
});
