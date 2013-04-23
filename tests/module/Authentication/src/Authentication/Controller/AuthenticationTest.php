<?php

namespace Authentication\Controller;

use Authentication\Controller\AuthController;
use Zend\Http\Request;
use Zend\Mvc\Router\RouteMatch;
use PHPUnit_Framework_TestCase;
use Zend\Mvc\Router\Http\TreeRouteStack as HttpRouter;


class AuthenticationTest extends PHPUnit_Framework_TestCase
{
    protected $_controller;
    protected $_request;
    protected $_response;
    protected $_routeMatch;
    protected $_event;
  
    /**
    * proves expected authentication failure with not existing uid
    */
    public function testAuthenticationWithNoUidFailures()
    {
       $response = $this->isAuthenticated('NoUid', 'password');
            
       //identity was not set
       $this->assertFalse(
           $response,
          '"authentication" should not be granted'         
       );
    }
    
    /**
    * proves expected authentication failure with wrong password
    */
    public function testAuthenticationWithWrongPwd()
    {
       $response = $this->isAuthenticated('user', 'noPassword');
            
       //identity was not set
       $this->assertFalse(
           $response,
          '"authentication" should not be granted'         
       );
    }
    
    /**
    * proves expected authentication failure with not verified account
    */
    public function testAuthenticationWithNotVerifiedAccount()
    {
       $response = $this->isAuthenticated('NotVerifiedUser', 'password');
            
       //identity was not set
       $this->assertFalse(
           $response,
          '"authentication" should not be granted'         
       );
    }
    
    /**
     * proves authentication success
     */
    public function testAuthenticationSuccess()
    {
       
       $response = $this->isAuthenticated('user', 'password');
            
       //identity is set
       $this->assertTrue(
           $response,
          '"authentication" should be granted'         
       );
        
    }
    
    
    /**
    * proves expected authentication failure with inactive user
    */
    public function testAuthenticationWithInactiveUser()
    {
       $response = $this->isAuthenticated('InactiveUser', 'password');
            
       //identity was not set
       $this->assertFalse(
           $response,
          '"authentication" should not be granted'         
       );
    }
    
     /**
      * proves authentication with the provided credentials.
      * Returns true if authenticated.
      * 
      * @param string $user
      * @param string $password
      * @return bool
      */
    protected function isAuthenticated($user, $password)
    {
       
            $this->_request->getPost()->identity = $user;
            $this->_request->getPost()->password = $password;

            $this->_controller->dispatch($this->_request);
            
            return $this->_controller->getAuthService()->hasIdentity();
        
    }        


    protected function setUp()
    {
        $bootstrap        = \Zend\Mvc\Application::init(
            include 'config/application.config.php'
        );
        $serviceManager =  $bootstrap->getServiceManager();
        
        $form           = $serviceManager->get('AuthForm');
        $auth           = $serviceManager->get(
                'Zend\Authentication\AuthenticationService');
        
        $this->_controller = new AuthController($auth, $form);
        $this->_request    = new Request();
        $this->_request->setMethod(Request::METHOD_POST);
        $this->_request->getPost()->rememberMe = true;
        
        $this->_routeMatch = new RouteMatch(array('controller' => 'login'));
        $this->_routeMatch->setParam('action', 'authenticate');
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