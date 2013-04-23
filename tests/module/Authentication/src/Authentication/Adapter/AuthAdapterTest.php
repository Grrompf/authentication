<?php
//module/Authentication/src/Authentication/Adapter/AuthAdapter.php
namespace Authentication\Adapter;

use Authentication\Adapter\AuthAdapter;
use PHPUnit_Framework_TestCase;
use Zend\I18n\Translator\Translator;


class AuthAdapterTest extends PHPUnit_Framework_TestCase {
   
   protected $_object;
   protected $_translator;
   protected $_textDomain; 
    
   public function testInitialState()
   {

        $this->assertNull(
                  $this->_object->getTranslator(),
                  '"translator" should initially be null'
        ); 
        
        $this->assertSame(
                  $this->_object->getTextDomain(),
                  'Auth',
                  '"textDomain" should initially be "Auth"'
        ); 
      
   }      
    
   public function testSetsPropertiesCorrectly()
   {

        $this->_object->setTranslator($this->_translator);
        $this->_object->setTextDomain($this->_txtDomain);
        
        $this->assertSame(
                  $this->_object->getTranslator(),
                  $this->_translator,
                  '"translator" was not set correctly'
        ); 
        
        $this->assertSame(
                  $this->_object->getTextDomain(),
                  $this->_txtDomain,
                  '"textDomain" was not set correctly'
        ); 
    }  
    
    protected function setUp()
    {
        $this->_object     = new AuthAdapter();
        $this->_translator = new Translator();
        $this->_txtDomain  = "default";
        
    }
}
