<?php

namespace Authentication\Services;

use Traversable;
use Authentication\Form\AuthFilter;
use Authentication\Form\AuthForm;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use Zend\Stdlib\ArrayUtils;

/**
 * Factory providing a Form for authentification
 * 
 * @author Dr. Holger Maerz <grrompf@gmail.com>
 */
class AuthFormFactory implements FactoryInterface
{
    
    /**
     * Creating a form with Filter, Captcha and optional translation. 
     * You have to provide your Captcha specification in the configuration 
     * file.  
     * 
     * @param \Zend\ServiceManager\ServiceLocatorInterface $services
     * @return \Authentication\Form\AuthForm
     */
    public function createService(ServiceLocatorInterface $services)
    {
      
        $config     = $services->get('config');
        if ($config instanceof Traversable) {
            $config = ArrayUtils::iteratorToArray($config);
        }
        
        //get text domain from module config
        $textDomain = $config['NakadeAuth']['text_domain'];
        
        $captcha    = $services->get('AuthCaptcha');
        $translator = $services->get('translator');
        $filter     = new AuthFilter();
        $form       = new AuthForm($textDomain);
        
        $form->setCaptcha($captcha);
        $form->setTranslator($translator);
        $form->setTextDomain($textDomain);
        $form->setInputFilter($filter);
      
        return $form;
    }
}
