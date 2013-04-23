<?php
namespace Authentication\Services;

use Authentication\Services\AuthServiceFactory;
use PHPUnit_Framework_TestCase;

class AuthServiceFactoryTest extends PHPUnit_Framework_TestCase
{
   
    
    protected $_serviceManager;
    
    public function testServiceFactoryFunctionality()
    {
        
        $factory = new AuthServiceFactory();
        $result  = $factory->createService($this->_serviceManager);
        
        $this->assertInstanceOf(
            'Zend\Authentication\AuthenticationService',
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


