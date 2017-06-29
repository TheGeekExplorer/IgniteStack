<?php namespace igniteStack\system\Flow\Authentication;

use igniteStack\System\ErrorHandling\Exception;
use igniteStack\System\Flow\Authentication\Session;
use igniteStack\System\Crypt\Hash;
use igniteStack\app\Models\usercontrol;
use igniteStack\app\Models\authed_sessions;


class Authenticator
{
	
    /**
     * Generates a random SHA256 Token
     * @return string
     */
    final public static function generate_Session_ID () {
        return Hash::generate_random_hash();
    }



    /**
     * Log the user in
     * @param $username
     * @param $password
     * @param $expiry
     * @return array
     */
    final public static function login ($username, $password, $expire) {

        # Trim details of trailing spaces
        $username = ltrim(rtrim($username));
        $password = ltrim(rtrim($password));

# CHECK FIELDS ARE OK :-
        if (empty($username) or empty($password))
            return ['status' => 'not_authed', 'timestamp' => time()];

# GET USER FROM MODEL :-
        $Users = new usercontrol();
        $u = $Users->findallwhere('username')->equals($username);
        $User = $u[0];

        # TODO : Put a check to see whether data was returned

# CHECK AUTH :-
        if ($User['username'] != $username or $User['active'] != '1')
            return ['status' => 'not_authed', 'timestamp' => time()];

        # Check password is ok for stored hash
        if(!Hash::hash_password_verify($password, $User['password']))
            return ['status' => 'not_authed', 'timestamp' => time()];

# Generate and Issue new Token
        $token = self::issue_auth_token($User['userid'], $expire);

        # Check token returned
        if (empty($token) or !$token)
            return ['status' => 'not_authed', 'timestamp' => time()];

# Put token and remote IP into the session
        Session::setSessionValue('auth_token', $token);
        Session::setSessionValue('authed_client', $_SERVER['REMOTE_ADDR']);
        Session::setSessionValue('userid', $User['userid']);
        Session::setSessionValue('access_level', $User['access_level']);

# RETURN AUTH TOKEN :-
        return ['status' => 'authed', 'timestamp' => time(), 'auth_token' => $token, 'access_level' => $User['access_level']];
    }




    /**
     * Checks user is still logged in, and valid, then issues new auth_token
     * @param bool $username
     * @param bool $auth_token
     * @param bool $expire
     * @return array
     */
    final public static function is_authed ($access_level=0, $auth_token=false, $expire=false) {

        # default not authed return
        $not_authed = ['status' => 'not_authed', 'timestamp' => time()];


        if (!$auth_token)
            $auth_token = $_SESSION['auth_token'];

        if (!$expire)
            $expire = 600;

        
# Checks that code exists - stops someone using an old cookie and gaining access to an old session.
        if(empty($auth_token))
            return $not_authed;

# Check that auth_token is still valid in auth_sessions model
        $AuthedSessions = new authed_sessions();

        # Find authed session record
        $s = $AuthedSessions->findallwhere('auth_token')->equals($auth_token);
        $AuthedSession = $s[0];

        # Delete all expired sessions
        $AuthedSessions->deleteallwhere('expire')->lessthan(time());

# check if details are valid
        if (empty($AuthedSession['userid']))
            return $not_authed;

        $user_id = $AuthedSession['userid'];

# Check that remote IP matches
        if ($AuthedSession['remote_ip'] != $_SERVER['REMOTE_ADDR'])
            return $not_authed;

# Check token not expired
        if (!isset($AuthedSession['expire']) or time() >= $AuthedSession['expire'])
            return $not_authed;

# Check that user has the right access_level
        $Users = new usercontrol();
        $u = $Users->findallwhere('userid')->equals($user_id);
        $User = $u[0];

        # If access level not set or not returned then not authed
        if (!isset($User['access_level']) or empty($User['access_level']))
            return $not_authed;

        # Check that user has appropriate access
        if ($User['access_level'] < $access_level)
            return $not_authed;

/**
# Now extend expiry...
        $auth_token = self::issue_auth_token($username, $expire);

# Check token is returned
        if (empty($auth_token) or !$auth_token)
            return $not_authed;

# Save token into session
        Session::setSessionValue('auth_token', $auth_token);
**/

# Return token
        return [
            'status'       => 'authed',
            'timestamp'    =>  time(),
            'auth_token'   =>  $auth_token,
            'userid'       =>  $User['userid'],
            'access_level' =>  $User['access_level']
        ];
    }



    /**
     * Generates and Issues new auth_token
     * @param $username
     * @param $expire
     * @return bool|string
     */
    final protected static function issue_auth_token ($user_id, $expire) {

        $token = Hash::generate_random_hash();

        # Check token is not empty
        if (empty($token))
            return false;

        # PUT AUTH_TOKEN INTO AUTHED_SESSION TABLE :-
        //$hashed_token = Hash::hash_password($token);  # Hash token (See Note '1.0')
        $hashed_token = $token;

        # Save hashed token into the Model
        $Sessions = new authed_sessions (time(), $user_id, $_SERVER['REMOTE_ADDR'], $hashed_token, time()+$expire);
        $Sessions->save();

        return $hashed_token;
    }
}
