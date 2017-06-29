<?php namespace igniteStack\system\Converters;


class Minify {

    // Minify resource content
    final public function minifyCSS($inContent)
    {
        $outContent = str_replace("\r\n","",$inContent);
        $outContent = str_replace("\t","",$outContent);
        $outContent = str_replace("  "," ",$outContent);
        $outContent = str_replace("; ",";",$outContent);
        $outContent = str_replace(": ",":",$outContent);
        return $outContent;
    }
}
