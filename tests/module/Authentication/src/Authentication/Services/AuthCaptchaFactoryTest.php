<?php

namespace Authentication\Services;

use Authentication\Services\AuthCaptchaFactory;
use PHPUnit_Framework_TestCase;


class AuthCaptchaFactoryTest extends PHPUnit_Framework_TestCase
{
    protected $_serviceManager;
    
    public function testCaptchaFactoryFunctionality()
    {
        
        $factory = new AuthCaptchaFactory();
        $result  = $factory->createService($this->_serviceManager);
        
        $this->assertInstanceOf('Zend\Captcha\AdapterInterface', $result);
        
    }
    
    
    protected function setUp()
    {
        $bootstrap        = \Zend\Mvc\Application::init(
            include 'config/application.config.php'
        );
        $this->_serviceManager =  $bootstrap->getServiceManager();
        
        
    }
    
}
