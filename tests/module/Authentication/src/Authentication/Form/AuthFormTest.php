<?php
namespace Authentication\Form;

use Authentication\Form\AuthForm;
use Authentication\Form\AuthFilter;
use PHPUnit_Framework_TestCase;
use Zend\Captcha\Factory as CaptchaFactory;
use Zend\I18n\Translator\Translator;

/**
 * Authentication form with ReCaptcha, translation option and
 * csrf token.  
 */
class AuthFormTest extends PHPUnit_Framework_TestCase
{
   protected $_object;
   protected $_translator;
   protected $_textDomain; 
   protected $_dumbCaptcha;
   protected $_filter;
   
   protected function setup() 
   {
       $this->_object      = new AuthForm();
       $this->_translator  = new Translator();
       $this->_txtDomain   = "default";
       $this->_dumbCaptcha = CaptchaFactory::factory(
           array('class' => 'dumb')
       );
       $this->_filter      = new AuthFilter();
        
   }        
   
   public function testInitialState()
   {

        $this->assertNull(
                  $this->_object->getFilter(),
                  '"filter" should initially be null'
        );
        $this->assertNull(
                  $this->_object->getTranslator(),
                  '"translator" should initially be null'
        ); 
        $this->assertSame(
                  $this->_object->getTextDomain(),
                  'Auth',
                  '"textDomain" should initially be "Auth"'
        );
        $this->assertFalse(
                  $this->_object->isCaptcha(),
                  '"isCaptcha" should initially be false'
        );
        $this->assertEquals(
                  $this->_object->getCaptcha(),
                  $this->_dumbCaptcha,
                  '"captcha" should initially be a dumbCaptcha'
        );
      
   }
   
   public function testSetsPropertiesCorrectly()
   {

        $this->_object->setTranslator($this->_translator);
        $this->_object->setTextDomain($this->_txtDomain);
        $this->_object->setShowCaptcha(true);
        $this->_object->setFilter($this->_filter);
        
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
        $this->assertTrue(
                  $this->_object->isCaptcha(),
                  '"isCaptcha" was not set correctly'
        );
        $this->assertSame(
                  $this->_object->getFilter(),
                  $this->_filter, 
                  '"filter" was not set correctly'
        );
       
    }      
}
