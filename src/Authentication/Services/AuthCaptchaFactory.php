<?php

namespace Authentication\Services;

use Traversable;
use Zend\Captcha\Factory as CaptchaFactory;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use Zend\Stdlib\ArrayUtils;

/**
 * Factory for providing Captcha. Make sure to have configured this 
 * in the module config. This Factory is called by the AuthFormFactory.
 * 
 * @author Dr.Holger Maerz <grrompf@gmail.com> 
 */
class AuthCaptchaFactory implements FactoryInterface
{

    /**
     * creating a captcha from configuration. You have to provide the 
     * neccessary options in the module.config or in the local configuration
     * file. 
     * 
     * @param \Zend\ServiceManager\ServiceLocatorInterface $services
     * @return AdapterInterface Captcha
     */
    public function createService(ServiceLocatorInterface $services)
    {
        $config     = $services->get('config');
        if ($config instanceof Traversable) {
            $config = ArrayUtils::iteratorToArray($config);
        }
        
        $spec       = $config['NakadeAuth']['captcha'];
        
        $captcha    = CaptchaFactory::factory($spec);
        
        return $captcha;
    }
}
