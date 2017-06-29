<?php namespace igniteStack\System\Core;


class TimeDate
{
    public static $startTime;
    public static $endTime;

    // Gets the epoch time
    final public function epoch() { return time(); }
}
