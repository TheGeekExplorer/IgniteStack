<?php
namespace ignitestack\app\Taglibs;

use igniteStack\Interfaces\BaseTaglib;


class Books extends BaseTaglib {

    public function navigation ($data) {
        $nav = '';

        foreach ($data as $label => $link) {
            $nav .= "<a href='$link'>$label</a> | ";
        }
        return $nav;
    }
} 