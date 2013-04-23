<?php
//module/Authentication/src/Authentication/Adapter/AuthAdapter.php
namespace Authentication\Adapter;

use DoctrineModule\Authentication\Adapter\ObjectRepository;
use Zend\Authentication\Adapter\Exception;
use Zend\Authentication\Result as AuthenticationResult;
use Zend\I18n\Translator\Translator;

/**
 * Doctrine authentication with md5 encryption, checking verified and active
 * flag. Furthermore, date of login is saved if authenticated.
 * 
 * @author Dr. Holger Maerz
 */
class AuthAdapter extends ObjectRepository {
    
    protected $_translator;
    protected $_textDomain="Auth";
    
    
    public function __construct($options = array()) 
    {
        
        parent::__construct($options);
       
    }
    
    
     /**
     * Setter for translator in form. Enables the usage of i18N.
     * 
     * @param \Zend\I18n\Translator\Translator $translator
     * @return ObjectRepository
     */
    public function setTranslator(Translator $translator)
    {
        $this->_translator = $translator;
        return $this;
    }
    
    /**
    * getter 
    * 
    * @return \Zend\I18n\Translator\Translator $translator
    */
    public function getTranslator()
    {
        return $this->_translator;
    }
    
    /**
     * Setter for text domain neccessary for translation.
     * Default value is 'Auth'. 
     * 
     * @param string $textDomain
     * @return ObjectRepository
     */
    public function setTextDomain($textDomain)
    {
        if (null !== $textDomain) {
            $this->_textDomain = $textDomain;
        }
        return $this;
    }
    
    /**
    * getter 
    * 
    * @return string $textDomain
    */
    public function getTextDomain()
    {
        return $this->_textDomain;
    }
    
    /**
     * l18n translation.
     * 
     * @param type $message
     * @return string
     */
    public function translate($message)
    {
        if (null === $this->_translator) {
           return $message;
        }
        
        return $this->_translator->translate(
                $message, 
                $this->_textDomain 
        );
    }
    
    /**
     * Set the credential value to be used.
     * using md5 encryption
     *
     * @param  mixed $credentialValue
     * @return ObjectRepository
     */
    public function setCredentialValue($credentialValue)
    {
        $this->credentialValue = md5($credentialValue);
        return $this;
    }
    
    
    /**
     * Overwritten method for validating the record in the resultset. 
     * Additional action proves if the account is verified and active. 
     *
     * @param  object $identity
     * @throws Exception\UnexpectedValueException
     * @return AuthenticationResult
     */
    protected function validateIdentity($identity)
    {
      
        $credentialProperty = $this->options->getCredentialProperty();
        $getter = 'get' . ucfirst($credentialProperty);
        $documentCredential = null;

        if (method_exists($identity, $getter)) {
            $documentCredential = $identity->$getter();
        } elseif (property_exists($identity, $credentialProperty)) {
            $documentCredential = $identity->{$credentialProperty};
        } else {
            throw new Exception\UnexpectedValueException(sprintf(
                'Property (%s) in (%s) is not accessible. 
                You should implement %s::%s()',
                $credentialProperty,
                get_class($identity),
                get_class($identity),
                $getter
            ));
        }

        $credentialValue = $this->credentialValue;
        $callable = $this->options->getCredentialCallable();

        if ($callable) {
            $credentialValue = call_user_func($callable, $identity, $credentialValue);
        }

        if ($credentialValue !== true && 
                $credentialValue != $documentCredential) {
            $this->authenticationResultInfo['code'] = 
                AuthenticationResult::FAILURE_CREDENTIAL_INVALID;
            $this->authenticationResultInfo['messages'][] = 
                $this->translate('Supplied credential is invalid.');

            return $this->createAuthenticationResult();
        }
        
       //Verified Account
       if(!$identity->isVerified()) {
           
            $this->authenticationResultInfo['code'] = 
                    AuthenticationResult::FAILURE_UNCATEGORIZED ;
            $this->authenticationResultInfo['messages'][] = 
                $this->translate('Account is not verified. '.
                    'Please check your email.');
            
            return $this->createAuthenticationResult();
        }
        
       //Active Account
       if(!$identity->isActive()) {
           
            $this->authenticationResultInfo['code'] = 
                    AuthenticationResult::FAILURE_UNCATEGORIZED ;
            $this->authenticationResultInfo['messages'][] = 
                $this->translate("Account is not active. " .
                     "Please refer an administrator.");
            
            return $this->createAuthenticationResult();
        }

        //save LoginDate
        $date = new \DateTime();

        if(is_null($identity->getFirstLogin()))
            $identity->setFirstLogin($date);
        
        $identity->setLastLogin($date);
        
        //get entitity and save it
        $entityManager=$this->options->getObjectManager();
        $entityManager->flush($identity);
        
        
        $this->authenticationResultInfo['code']       = 
                AuthenticationResult::SUCCESS;
        $this->authenticationResultInfo['identity']   = 
                $identity;
        $this->authenticationResultInfo['messages'][] = 
                $this->translate('Authentication successful.');

        return $this->createAuthenticationResult();
    }

    
    
}
