<?php
//module/Authentication/src/Authentication/Services/AuthServiceFactory.php
namespace Authentication\Services;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use Zend\Stdlib\ArrayUtils;
use RuntimeException;

use Authentication\Adapter\AuthAdapter;
use Authentication\Adapter\AuthStorage;
use Zend\Authentication\AuthenticationService;
use DoctrineModule\Options\Authentication as AuthOptions;

/**
 * Factory for creating the Zend Authentication Service. Using customized
 * Adapter and Storage instances. 
 * 
 * @author Dr. Holger Maerz <grrompf@gmail.com>
 */
class AuthServiceFactory implements FactoryInterface {
   
    
    /**
     * Creating Zend Authentication Service for logIn and logOut action.
     * Making use of customized adapters for more action as by default.
     * Integration of optional translation feature (i18N)
     * 
     * @param \Zend\ServiceManager\ServiceLocatorInterface $services
     * @return \Zend\Authentication\AuthenticationService
     * @throws RuntimeException
     * 
     */
    public function createService(ServiceLocatorInterface $services)
    {
      
        $config  = $services->get('config');
        if ($config instanceof Traversable) {
            $config = ArrayUtils::iteratorToArray($config);
        }
        
        //EntityManager for database access by doctrine
        $EntityManager = $services->get('Doctrine\ORM\EntityManager');
        
        //configuration options as set in module.config
        $key  = 'authentication';
        $name = 'orm_default';
        $options = isset($config['doctrine'][$key][$name]) ? 
            $config['doctrine'][$key][$name] : null;

        if (null === $options) {
            throw new RuntimeException(sprintf(
                'Options with name "%s" could not be found in "doctrine.%s".',
                $name,
                $key
            ));
        }
        
        //auth Options instance and setting the entityManager
        $AuthOptions = new AuthOptions($options);
        $AuthOptions->setObjectManager($EntityManager);
        
        //optional translator
        $translator = $services->get('translator');
        $textDomain = $config['NakadeAuth']['text_domain'];
        
        //creating authentication and storage adapter
        $adapter = new AuthAdapter($AuthOptions);
        $storage = new AuthStorage($AuthOptions);
        
        //set translator
        $adapter->setTranslator($translator);
        $adapter->setTextDomain($textDomain);
        
        //Zend Authentication Service
        return new AuthenticationService($storage,$adapter );
        
    }
    
    
    
    
}


