<?php

namespace Authentication\Controller;

use Authentication\Controller\AuthController;
use Authentication\Form\AuthForm;
use Zend\Authentication\AuthenticationService;
use Zend\Http\Request;
use Zend\Mvc\Router\RouteMatch;
use PHPUnit_Framework_TestCase;
use Zend\Mvc\Router\Http\TreeRouteStack as HttpRouter;


class AuthControllerTest extends PHPUnit_Framework_TestCase
{
    protected $_controller;
    protected $_request;
    protected $_response;
    protected $_routeMatch;
    protected $_event;


    public function testIndexActionCanBeAccessed()
    {
        $this->_routeMatch->setParam('action', 'login');

        $result   = $this->_controller->dispatch($this->_request);
        $response = $this->_controller->getResponse();

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertInstanceOf('Zend\View\Model\ViewModel', $result);
    }
    
    /**
     * Initially proving the default value of max auth attempts, 
     * no catpcha is set and therefore not added to the form.
     * In addition, no identity is found 
     */
    public function testInitialState()
    {
        $this->assertSame(
            $this->_controller->getMaxAuthAttempts(),
            5,
            '"max_failed_attempts" should initially be "5"'
        );
        
        $this->assertFalse(
            $this->_controller->getForm()->isCaptcha(),
            '"isCaptcha" should initially be false'         
        );
        
        $this->assertFalse(
            $this->_controller->getForm()->has('captcha'),
            '"Captcha" should initially be not set'         
        );
        
         $this->assertFalse(
            $this->_controller->getAuthService()->hasIdentity(),
            '"identity" should initially be not set'         
        );
         
    }
    
    public function testAuthenticateCanBeAcCessed(){
        
        $this->_routeMatch->setParam('action', 'authenticate');
        $this->_controller->dispatch($this->_request);
        $response = $this->_controller->getResponse();
        
        //redirecting
        $this->assertEquals(302, $response->getStatusCode());
        
    }
    
     /**
     * proves if the captcha is added to the form after failed auth attempts.
     * 
     */
    public function testShowCaptchaFunctionality(){
        
        for (
                $attempts=0;
                $attempts < $this->_controller->getMaxAuthAttempts(); 
                $attempts++
             ) {
                    
            $this->_controller->getSession()->addAuthFailure();
        }
        
        $this->assertSame(
            $this->_controller->getSession()->getAuthFailure(),
            5,    
            '"MaxAuthAttempts" was not set correctly'         
        );
        
        
        $this->_routeMatch->setParam('action', 'login');
        $this->_controller->dispatch($this->_request);
        
        
        $this->assertTrue(
            $this->_controller->getForm()->isCaptcha(),
            '"isCaptcha" was not set correctly'         
        );
        
        $this->assertTrue(
            $this->_controller->getForm()->has('captcha'),
            '"Captcha" was not set correctly'         
        );
        
    }
  
    /**
     * Test the Login state by manipulating session storage.
     * After fire the logout action, the identity is cleared and
     * redirected to login.  
     */
    public function testLogoutFunctionality(){
        
        
        $this->_controller->getAuthService()->getStorage()->write("test");
        
        $this->assertTrue(
            $this->_controller->getAuthService()->hasIdentity(),
            '"identity" was not set correctly'         
        );
        
        $this->_routeMatch->setParam('action', 'logout');
        $this->_controller->dispatch($this->_request);
        $response = $this->_controller->getResponse();
        
        //redirecting
        $this->assertEquals(302, $response->getStatusCode());
        
        $this->assertFalse(
            $this->_controller->getAuthService()->hasIdentity(),
            '"identity" was not cleared'         
        );
     
    }
    
    protected function setUp()
    {
        $bootstrap        = \Zend\Mvc\Application::init(
            include 'config/application.config.php'
        );
        $serviceManager =  $bootstrap->getServiceManager();
        
        $auth = new AuthenticationService();
        $form = new AuthForm();
        
        $this->_controller = new AuthController($auth, $form);
        $this->_request    = new Request();
        $this->_routeMatch = new RouteMatch(array('controller' => 'login'));
        $this->_event      = $bootstrap->getMvcEvent();
        
        //module routes
        $config = $serviceManager->get('Config');
        $routerConfig = isset($config['router']) ? $config['router']  : array();
        $router = HttpRouter::factory($routerConfig);
    
        $this->_event->setRouter($router);
        $this->_event->setRouteMatch($this->_routeMatch);
        $this->_controller->setEvent($this->_event);
        $this->_controller->setEventManager($bootstrap->getEventManager());
        $this->_controller->setServiceLocator($serviceManager);
        
       
    }
    
   
}