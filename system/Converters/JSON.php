<?php namespace igniteStack\System\Converters;


class JSON
{
    
    /**
     * Purpose: Converts input into well-formed JSON
     * 
     * @param  string $d
     * @return string $d
     */
    final public static function encode ($d)
    {
        return json_encode ($d);
    }

    final public static function decode ($d)
    {
        return json_encode ($d);
    }
    
}
