<?php namespace igniteStack\System\Flow\Authentication;

use igniteStack\System\ErrorHandling\Exception;
use igniteStack\System\Crypt\Hash;

class CSRF {
        
    /**
     * @description Retrieves a given amount of tokens into an array
     * @param int $amount
     * @return array $tokens
     */
    final public static function init () {
        if(!isset($_SESSION))
            session_start();
    }
        
    /**
     * @description Retrieves a given amount of tokens into an array
     * @param int $amount
     * @return array $tokens
     */
    final public static function generate_Tokens ($amount=1) {
    
        for($i=0; $i<$amount; $i++) {
            $tokens[] = self::generate();
        }
        return $tokens;
    }
        
    /**
     * @description Generates a random SHA256 Token
     * @return string $token
     */
    final public static function generate () {
        return Hash::generate_random_hash();
    }
        
    /**
     * @description Retrieves a given amount of tokens into an array
     * @param string $CSRF_OBJECT_NAME
     * @param string $CSRF_TOKEN
     * @return string
     */
    final public static function create_CSRF_Object ($CSRF_OBJECT_NAME=false, $CSRF_TOKEN=false) {
        
        if(!$CSRF_OBJECT_NAME || !$CSRF_TOKEN)
            Exception::cast('FAILURE: CSRF Failure [dfg5c]', 500);
            
        # Create object in 
        $_SESSION["csrf_object_$CSRF_OBJECT_NAME"] = $CSRF_TOKEN;
        
        # Verify object not empty
        if(empty($_SESSION["csrf_object_$CSRF_OBJECT_NAME"]))
            Exception::cast('FAILURE: CSRF Failure [2dfx4]', 500);
        
        return (string) $CSRF_TOKEN;
    }
    
    /**
     * @description Verifies if a given tokens exists in SESSION
     * @param string $CSRF_OBJECT_NAME
     * @param string $CSRF_TOKEN
     * @return bool
     */
    final public static function verify_CSRF_Object ($CSRF_OBJECT_NAME=false, $CSRF_TOKEN=false) {
    	
        if(!$CSRF_OBJECT_NAME || !$CSRF_TOKEN)
            Exception::cast('[AUTHENTICATION_FAILURE] You did not provide a CSRF token in your request.', 401);
        
        # Verify object not empty
        if(!isset($_SESSION["csrf_object_$CSRF_OBJECT_NAME"]))
            Exception::cast('[AUTHENTICATION_FAILURE] Your CSRF token may have expired.', 401);
        
        # Create object in         
        if($CSRF_TOKEN !== $_SESSION["csrf_object_$CSRF_OBJECT_NAME"])
            Exception::cast('[AUTHENTICATION_FAILURE] Your token is invalid.', 401);
            
        # Destroy CSRF Objects in the SESSION
        # so tokens cannot be re-used
        self::destroy_CSRF_Object($CSRF_OBJECT_NAME);
        
        return true;
    }
    
    /**
     * @description Verifies if a given tokens exists in SESSION
     * @param array $CSRF_TOKENS
     * @return bool
     */
    final public static function verify_CSRF_Objects ($CSRF_TOKENS=false) {
        
        if(!$CSRF_TOKENS || empty($CSRF_TOKENS))
            Exception::cast('FAILURE: CSRF Failure [38sd9]', 500);
        
        # Run through CSRF objects in provided Array,
        # and verify against the SESSION object
        foreach ($CSRF_TOKENS as $token_key => $token_value) {
            
            # Verify CSRF Objects against SESSION
            self::verify_CSRF_Object($token_key, $token_key);
            
            # Destroy CSRF Objects in the SESSION
            # so tokens cannot be re-used
            self::destroy_CSRF_Object($token_key);
        }
        return true;
    }
    
    /**
     * @description Destroys an CRSF object
     * @param string $CSRF_OBJECT_NAME
     * @return bool
     */
    final public static function destroy_CSRF_Object ($CSRF_OBJECT_NAME=false) {
        if(!$CSRF_OBJECT_NAME)
            Exception::cast('FAILURE: CSRF Failure [d89dd]', 500);
            
        # Create object in 
        if(isset($_SESSION["csrf_object_$CSRF_OBJECT_NAME"]));
            unset($_SESSION["csrf_object_$CSRF_OBJECT_NAME"]);
        return true;
    }
}
