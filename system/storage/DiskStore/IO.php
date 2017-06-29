<?php namespace igniteStack\System\Storage\DiskStore;

use igniteStack\System\ErrorHandling\Exception;


class IO
{
    final public static function fileAppend($inFile,$inContent)
    {
        if( !file_put_contents( $inFile, $inContent ) )
            return false;
        return true;
    }

    final public static function fileRead($inFile)
    {
        if( !is_array( $inFile ) )
            Exception::cast('FileReadNotArray', 500);
        
        if( !isset( $inFile['FILE'] ) || empty( $inFile['FILE'] ) )
            Exception::cast('FileReadNoPath', 500);
        
        if( !$response = file_get_contents( $args['FILE'] ) )
            return false;
        return $response;
    }

    /**
     * Test that the view exists
     * @param $f
     * @return boolean
     */
    final public static function exists ($f)
    {
        if (!file_exists ($f))
            return false;
        return true;
    }

    /**
     * Reads in file from Disk with specific start and end bits
     * @param $file
     * @param $start
     * @param $end
     * @return string
     */
    final public static function readCacheFile ($file, $start, $end)
    {
        $buff='';

        if ($end == "END")
            $end = filesize($file);

        $fp=fopen($file,'rb');
        $i=$start;
        do{
            fseek($fp,$i);
            $buff .= fread($fp,1);

            $i++;
        }while($i<=$end);

        return rtrim($buff);
    }

    /**
     * Write in file on Disk with specific start and end bits
     * @param $file
     * @param $start
     * @param $end
     * @return bool
     */
    final public static function writeCacheFile ($file, $start, $end)
    {
        // TODO
    }
    
}
