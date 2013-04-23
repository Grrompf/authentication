<?php
namespace Authentication\Entity;

use Authentication\Entity\Credential;
use PHPUnit_Framework_TestCase;

class CredentialTest extends PHPUnit_Framework_TestCase
{
     protected $_options;
     protected $_object;
     protected $_newObject;
    
    protected function setup()
    {
        $this->_object  = new Credential();
        $this->_options = array(
              'id' => 123,
              'email'  => 'grrompf@gmail.com',
              'firstLogin' => new \DateTime(),
              'lastLogin' => new \DateTime(),
              'uid' => 23,
              'password' => 'blue234',
              'username' => 'Albert Zweistein',
              'verified' => true,
              'active' => true,

        );
        $this->_newObject = new Credential($this->_options);
    }
 
  
    
    /**
     * getter
     * 
     * @return array 
     */
    public function getOptions()
    {
        return $this->_options;
    }
    
    /**
     * setter
     * 
     * @param array $value
     * @return \Authentication\Entity\CredentialTest
     */
    public function setOptions($value)
    {
        $this->_options = $value;
        return $this;
    }
  
    public function testInitialState()
    {

        $methods = get_class_methods($this->_object);
        
        foreach ($this->_options as $key => $value) {
        
            $method = 'get' . ucfirst($key);
            if (in_array($method, $methods)) {
                $this->assertNull(
                  $this->_object->$method(),
                  '"'.$key.'" should initially be null'
                );        
            }
        }
        
        $this->assertNull(
            $this->_object->isActive(), 
            '"active" should initially be null'
        );
        $this->assertNull(
            $this->_object->isVerified(), 
            '"verified" should initially be null'
        );
        
    }

    public function testSetsPropertiesCorrectly()
    {
        
        $methods = get_class_methods($this->_newObject);
        
        foreach ($this->_options as $key => $value) {
        
            $method = 'get' . ucfirst($key);
            if (in_array($method, $methods)) {
                $this->assertSame(
                  $this->_options[$key],
                  $this->_newObject->$method(),
                  '"'.$key.'" was not set correctly'
                );        
            }
        }
        
        //bool
        $this->assertSame(
            $this->_newObject->isVerified(),
            $this->_options['verified'],    
            '"verified" was not set correctly'
        );
        
         //bool
        $this->assertSame(
            $this->_newObject->isActive(),
            $this->_options['active'],    
            '"active" was not set correctly'
        );
        
       
    }

}