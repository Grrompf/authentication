<?php
//module/Authentication/src/Authentication/Session/FailureContainer.php
namespace Authentication\Session;

use Authentication\Session\FailureContainer;
use PHPUnit_Framework_TestCase;

class FailureContainerTest extends PHPUnit_Framework_TestCase
{
    
    protected $_object;
    
    protected function setup() 
    {
        $this->_object = new FailureContainer();
        
    }        


    public function testInitialState()
    {

         $this->assertNull(
                  $this->_object->getAuthFailure(),
                  '"failures" should initially be null'
        ); 
    }      

    public function testFunctionality()
    {

        for($i=0;$i<5;$i++) {
           $this->_object->addAuthFailure(); 
        }
        $this->assertSame(
                  $this->_object->getAuthFailure(),
                  5,
                  '"failures" was not set correctly'
        ); 
        $this->_object->clear(); 
        $this->assertSame(
                  $this->_object->getAuthFailure(),
                  0,
                  '"failures" was not cleared'
        ); 
    }      
    
   
}
