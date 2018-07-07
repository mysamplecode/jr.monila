<?php

use Config\Central;
use Config\Constants;

class  Access implements \rocketsled\Runnable
{
    //constants - defines action associated with this class
    const LOGIN_ATTEMPT = 'login';
    const LOGIN_STATUS = 'status';
    const SIGNUP_ATTEMPT = 'signup';
    //constants - for hashing
    const HASH_CYCLES = 1000;
    const SALT_RANDOM = 'e31f453ab964ec17e1e68faacbb64f05bccceb179858b4c482c1b182ff1e440e';
    //----private varibales
    private $central;
    private $esc;
    private $profile = "access";

    public function __construct()
    {
        @session_start();
        if ( !isset( $_SESSION[  Constants::LOGIN_FLAG ] ) )
        {
            $_SESSION[  Constants::LOGIN_FLAG ] = array( );
        }
         Central::pr( "Getting the central" );
        $this->central =  Central::instance();
        $this->central->set_alias_connection( $this->profile );
         Central::pr( "Got the central" );
    }

    //escape function
    public function __call( $closure, $args )
    {
        $f = Plusql::escape( $this->profile );
        return $f( $args[ 0 ] );
    }

    public function run()
    {
        try
        {
            Central::pr( "Login run function call" );
            $this->update_main_contents();
        }
        catch ( Exception $e )
        {
            throw $e;
        }
    }

    //update main contents
    private function update_main_contents()
    {
        Central::pr( "In the update main contents" );
        try
        {//used mainly to handle the AJAX calls from the index_template.
            $token = $this->central->getargs( 'rocket_sled', $_GET, $this->corrupt );
            if ( !$this->corrupt )
            {
                if ( $this->central->validate_csrf_token( $token ) )
                {
                    Central::pr( "token passed.... " );
                    $action = $this->central->getargs( 'action', $_GET, $this->corrupt );
                    if ( !$this->corrupt )
                    {
                        $name = $this->central->getargs( 'inputEmail', $_GET, $this->corrupt );
                        $password = $this->central->getargs( 'inputPassword', $_GET, $this->corrupt );
                        if ( !$this->corrupt )
                        {
                            switch ( $action )
                            {
                                case self::LOGIN_ATTEMPT:
                                    $this->validate_login_attempt( $name, $password, true );
                                    break;
                                case self::LOGIN_STATUS:
                                    $this->login_status(true);
                                    break;
                                case self::SIGNUP_ATTEMPT:
                                    $details = $this->central->getargs( 'details', $_GET, $this->corrupt );
                                    $detail  = json_decode(utf8_encode($details),true);
                                    if ( !$this->corrupt && !empty($detail))
                                    {
                                        $this->sign_up_new_user( $name, $password, $detail ,true );
                                    }
                                    else throw new Exception( "CSRF attack" );
                                    //$this->sign_up_new_user( /* dont know what fucking params to put here */ );
                                    break;
                                default:
                                    //this is some bullshit - raise the expcetion
                                    throw new Exception( "CSRF attack" );
                                    break;
                            }
                        }
                        else 
                            throw new Exception( "CSRF attack" );
                    }
                }
                else throw new Exception( "CSRF attack" );
            }
            else throw new Exception( "CSRF attack" );
        }
        catch ( Exception $e )
        {
            throw $e;
        }
    }

    //function which validates the login attempt
    public function validate_login_attempt( $name, $password, $as_json = false)
    {
        Central::pr("Login Validate funtcion ************");
        $username = $this -> esc($name);
        $password = $this -> esc($password);
        $result = array();
        $result['rocket_sled'] = $this->central->add_csrf_token();
        try
        {
            $usr = PluSQL::from($this -> profile)->users->select('*')->where("email = '$username'")->run()->users;
            Central::pr("************");
            Central::pr($usr->email.' = '.$username);
            Central::pr($usr->hash.' = '.$password);
            if( (strcmp($usr->email,$username)==0) && (strcmp($usr->hash,$password)==0) )
            {
                $result['pass'] = true;
                $result['email'] = $usr -> email;
                $_SESSION[  Constants::LOGIN_FLAG ] = $result;
            }
            else
            {
                $result['pass'] = false;
                $_SESSION[  Constants::LOGIN_FLAG ] = $result;
            }
            /*
            // The first 64 characters of the hash is the salt
            $salt = substr( $usr -> hash, 0, 64 );
            $hash = $salt . $password;
            // Hash the password as we did before
            for ( $i = 0; $i < self::HASH_CYCLES; $i++ )
            {
                $hash = hash( 'sha256', $hash );
            }
            $hash = $salt . $hash;
            if ( $hash == $r[ 'hash' ] )
            {
                // Ok!
            }
            */
        }
        catch(EmptySetException $e)
        {
            //the name was not found
            $result['pass'] = false;
            $_SESSION[  Constants::LOGIN_FLAG ] = $result;
        }
        Central::pr("Login Validate funtcion ************ ENDING");
        if($as_json)
            echo json_encode( $result );
        else 
            return $result;
    }

    //function which sign ups the new users
    public function sign_up_new_user($name, $password, $details/*fuck'in array*/,$as_json)
    {
        $username = $this -> esc($name);
        $password = $this -> esc($password);
        
        $salt = hash('sha256', uniqid(mt_rand(), true) . self::SALT_RANDOM . strtolower($username));
        $hash = $salt . $password;
        for ( $i = 0; $i < self::HASH_CYCLES; $i ++ ) 
        {
            $hash = hash('sha256', $hash);
        }
        $hash = $salt . $hash;
    }
    
    //check login status
    public function login_status($as_json = false)
    {
        Central::pr("Login Status funtcion ************");
        $data = array();
        try
        {
            $data[ 'rocket_sled' ] = $this->central->add_csrf_token();
            if($_SESSION[  Constants::LOGIN_FLAG ]['pass'] == 1)
                $data[ 'status' ] = 1;
            else
                $data[ 'status' ] = 0;
            $data['result'] = $_SESSION[  Constants::LOGIN_FLAG ];
        }
        catch(Exception $e)
        {
            throw $e;
        }
        if($as_json)
            echo json_encode( $data );
        else
            return $data;
    }

}

?>