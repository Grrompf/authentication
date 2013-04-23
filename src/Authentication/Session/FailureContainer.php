<?php
//module/Authentication/src/Authentication/Session/FailureContainer.php
namespace Authentication\Session;

use Zend\Session\Container;

/**
 * The amount of failed authentication attempts are collected in a session.
 * Basically, this is used for showing up a Captcha after too many failed 
 * attempts. You can still access the data as usual: $_SESSION[name][key] 
 * 
 * @author Dr.Holger Maerz <grrompf@gmail.com> 
 */
class FailureContainer extends Container
{
    
    /**
     * constructor sets the namespace for the session
     */
    public function __construct() {
        
       parent::__construct('FailedAuthAttempts');
    }


    /**
     * Sets the amount of failed authentication, adding one 
     * each time the method is called.
     *    
     */
    public function addAuthFailure()
    {
         if($this->attempts===NULL) {
             
             $this->attempts=0;
         }
        
         $this->attempts++;
         
    }
    
    /**
     * Getting ammount of failed authentications
     *    
     * @return int 
     */
    public function getAuthFailure()
    {
         return $this->attempts;
    }
     
    /**
     * Resets the session to 0. 
     */
    public function clear()
    {
        $this->attempts=0;
    } 
    
   
}
