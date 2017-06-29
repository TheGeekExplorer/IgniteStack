<?php namespace igniteStack\Interfaces;

use igniteStack\System\ErrorHandling\Exception;


abstract class BaseConfiguration {
	
	/**
	 * Returns the value of the configuration setting
	 * @param string $name
	 */
	final public static function get ($name) {
		if(!isset(static::$$name))
			Exception::cast("Requested configuration setting ($name) does not exist.", 500);
		return static::$$name;
	}
}
