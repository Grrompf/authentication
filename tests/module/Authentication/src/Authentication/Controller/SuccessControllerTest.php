<?php

namespace Authentication\Controller;

use Authentication\Controller\SuccessController;
use Zend\Http\Request;
use Zend\Http\Response;
use Zend\Mvc\MvcEvent;
use Zend\Mvc\Router\RouteMatch;
use PHPUnit_Framework_TestCase;

class SuccessControllerTest extends PHPUnit_Framework_TestCase
{
    protected $_controller;
    protected $_request;
    protected $_response;
    protected $_routeMatch;
    protected $_event;

    
    public function testIndexActionCanBeAccessed()
    {
        $this->_routeMatch->setParam('action', 'index');

        $result   = $this->_controller->dispatch($this->_request);
        $response = $this->_controller->getResponse();

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertInstanceOf('Zend\View\Model\ViewModel', $result);
    }

    protected function setUp()
    {
        $bootstrap        = \Zend\Mvc\Application::init(
            include 'config/application.config.php'
        );
        $this->_controller = new SuccessController();
        $this->_request    = new Request();
        $this->_routeMatch = new RouteMatch(array('controller' => 'success'));
        $this->_event      = $bootstrap->getMvcEvent();
        $this->_event->setRouteMatch($this->_routeMatch);
        $this->_controller->setEvent($this->_event);
        $this->_controller->setEventManager($bootstrap->getEventManager());
        $this->_controller->setServiceLocator($bootstrap->getServiceManager());
    }
    
   
}