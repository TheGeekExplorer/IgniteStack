<?php namespace igniteStack\System\Crypt;

use igniteStack\System\ErrorHandling\Exception;


class Hash
{
    /**
     * Returns an MD5 of given string
     * @param $v
     * @return string
     */
    final public static function MD5 ($v)
    {
        return md5($v);
    }

    /**
     * Returns an SHA1 hash of given string
     * @param $v
     * @return string
     */
    final public static function SHA1 ($v)
    {
        return sha1($v);
    }


    /**
     * Returns an SHA1 hash of given string
     * @param $v
     * @return string
     */
    final public static function SHA512 ($v)
    {
    	# Hash string into a SHA256 Hash string
    	$token = hash('sha512', $v);                              # Hash using SHA512 Algorithm
   	 	
    	# Check sufficient random characters have been generated
    	if(strlen($token) <= 100 || !isset($token) || $token == $v)
    		Exception::cast('FAILURE: CSRF Failure [78sdf]', 500);
    		
    	return $token;
    }


    /**
     * Returns an SHA1 hash of given string
     * @param $v
     * @return string
     */
    final public static function generate_random_hash ()
    {
    	# Get random number for hash - crude implementation using a
    	# time-based approach producing a number between 1400 and 2500
    	# for randomness. Should implement urandom and Mcrypt_IV for
    	# a hardened approach.
    	$s = ceil(time()/1000000);                                  # Starting Number
    	$f = ceil(time()/500000);                                   # Finishing Number
    	if($s >= $f) { $tmp=$s; $s=$f; $f=$tmp; $tmp=""; }          # If 'f' is less than 's' then swap
    	$rand = mt_rand($s, $f);                                    # Get random number between 's' and 'f'
    	 
    	# Check sufficient random number length has been generated
    	if($rand <= 1000 || !isset($rand))
    		Exception::cast('FAILURE: Hash Failure [78v8x]', 500);
    		 
    	# Generate a random bytes from random number
    	$bytes = openssl_random_pseudo_bytes($rand);                # Pseudo-random bytes using OpenSSL
    	$hex   = bin2hex($bytes);                                   # Convert Bytes to Hexadecimal
    	 
    	# Check sufficient random characters have been generated
    	if(strlen($hex) <= 100 || !isset($hex))
    		Exception::cast('FAILURE: Hash Failure [a56fg]', 500);
    	
    	return self::SHA512($hex);
    }

    /**
     * Hashes passwords using PHP-in-built hashing functionality
     * @param $p
     * @param $c
     * @return bool|string
     */
    final public static function hash_password ($p, $c=12) {
        $options = [
            'cost' => $c
        ];

        # Hash password
        $o = password_hash($p, PASSWORD_DEFAULT, $options);

        # Check if successful
        if (!$o)
            Exception::cast('Error while hashing password!', 500);

        # Return hash
        return $o;
    }

    /**
     *
     * @param $p
     * @param $h
     * @return bool
     */
    final public static function hash_password_verify ($p, $h) {
        if (password_verify($p, $h))
            return true;
        return false;
    }
}
