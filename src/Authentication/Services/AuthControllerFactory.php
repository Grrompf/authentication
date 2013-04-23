<?php

namespace Authentication\Services;

use Authentication\Controller\AuthController;
use Authentication\Session\FailureContainer;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

/**
 * Creates the controller used for authentication.
 * make sure, you have configured the factory in the module configuration
 * file as a controller factory. 
 * 
 * @author Dr.Holger Maerz <grrompf@gmail.com>
 */
class AuthControllerFactory implements FactoryInterface
{
    
    /**
     * creates the authController. Binds the authentication service and
     * the authentication form.
     *   
     * @param \Zend\ServiceManager\ServiceLocatorInterface $services
     * @return \Authentication\Controller\AuthController
     */
    public function createService(ServiceLocatorInterface $services)
    {
     
        $serviceManager = $services->getServiceLocator();
        
        $config  = $serviceManager->get('config');
        if ($config instanceof Traversable) {
            $config = ArrayUtils::iteratorToArray($config);
        }
        
        $maxAuthAttempts = isset($config['NakadeAuth']['max_auth_attempts']) ? 
              $config['NakadeAuth']['max_auth_attempts'] : 0;

        $form           = $serviceManager->get('AuthForm');
        $auth           = $serviceManager->get(
                'Zend\Authentication\AuthenticationService');
        
        $controller = new AuthController($auth, $form);
        
        //set max auth attempts as configured before showing up captcha
        $controller->setMaxAuthAttempts($maxAuthAttempts);
        
        return $controller;
    }
}
