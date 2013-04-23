<?php

namespace Authentication\Services;

use Authentication\Services\AuthFormFactory;
use PHPUnit_Framework_TestCase;

class AuthFormFactoryTest extends PHPUnit_Framework_TestCase
{
    
    protected $_serviceManager;
    
    public function testFormFactoryFunctionality()
    {
        
        $factory = new AuthFormFactory();
        $result  = $factory->createService($this->_serviceManager);
        
        $this->assertInstanceOf(
            'Authentication\Form\AuthForm',
            $result);
        
    }
    
    
    protected function setUp()
    {
        $bootstrap        = \Zend\Mvc\Application::init(
            include 'config/application.config.php'
        );
        $this->_serviceManager =  $bootstrap->getServiceManager();
        
        
    }

}
