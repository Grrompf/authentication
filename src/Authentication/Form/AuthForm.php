<?php
namespace Authentication\Form;

use Zend\Captcha\AdapterInterface as CaptchaAdapter;
use Zend\Form\Element;
use Zend\Form\Form;
use Zend\I18n\Translator\Translator;
use Zend\InputFilter\InputFilter;
use Zend\Captcha\Factory as CaptchaFactory;

/**
 * Authentication form with ReCaptcha, translation option and
 * csrf token.  
 */
class AuthForm extends Form
{
    protected $_captchaAdapter;
    protected $_csrfToken;
    protected $_translator;
    protected $_textDomain="Auth";
    protected $_filter=null;
    protected $_isCaptchaShowing = false;
    
    /**
     * Constructor
     */
    public function __construct() 
    {
        //form name is AuthForm
        parent::__construct($name='AuthForm');
       
    }

    /**
     * Setter for filtering the form input
     * @param \Zend\InputFilter\InputFilter $filter
     */
    public function setFilter(InputFilter $filter) 
    {
        $this->_filter = $filter;
    }
    
    /**
     * getter
     * 
     * @return \Zend\InputFilter\InputFilter $filter
     */
    public function getFilter() 
    {
        return $this->_filter;
    }
    
    /**
     * Setter for translator in form. Enables the usage of i18N.
     * 
     * @param \Zend\I18n\Translator\Translator $translator
     */
    public function setTranslator(Translator $translator)
    {
        $this->_translator = $translator;
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
     */
    public function setTextDomain($textDomain)
    {
        if (null !== $textDomain) {
            $this->_textDomain = $textDomain;
        }
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
     * Setter for Captcha in form
     * @param \Zend\Captcha\AdapterInterface $captchaAdapter
     */
    public function setCaptcha(CaptchaAdapter $captchaAdapter)
    {
        $this->_captchaAdapter = $captchaAdapter;
    }
    
    /**
     * getter for Captcha in form. If no captcha is set, a dumb captcha is
     * set.
     * 
     * @return \Zend\Captcha\AdapterInterface $captchaAdapter
     */
    public function getCaptcha()
    {
        
        if(!$this->_captchaAdapter) {
            
          $this->_captchaAdapter=CaptchaFactory::factory(
              array('class' => 'dumb')
          );
        }
        
        return $this->_captchaAdapter;
    }
    
    /**
     * Setter for filtering the form input
     * @param \Zend\InputFilter\InputFilter $filter
     */
    public function setShowCaptcha($show) 
    {
        $this->_isCaptchaShowing = $show;
    }
    
    /**
     * getter
     * @return bool $_isCaptchaShowing
     */
    public function isCaptcha() 
    {
        return $this->_isCaptchaShowing;
    }
    
    /**
     * translator function. l18n
     * 
     * @param type $message
     * @return string $message
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
     * Initializing the form. Call this method for receiving the formular.
     * This enables toggling the Captcha 
     */
    public function init()
    {
               
        //identity
        $this->add(
            array(
                'name' => 'identity',
                'type' => 'Zend\Form\Element\Text',
                'options' => array(
                    'label' =>  $this->translate('Username:'),
                ),
            )
        );

        //password
        $this->add(
            array(
                'name'  => 'password',
                'type' => 'Zend\Form\Element\Password',
                'options' => array(
                    'label' =>  $this->translate('Password:'),
                ),
            )
        );


        //checkbox remember Me
        $this->add(
            array(
                'name'  => 'rememberme',
                'type'  => 'Zend\Form\Element\Checkbox',
                'options' => array(
                    'label' =>  $this->translate('Remember Me ?:'),
                ),
            )
        );

        //captcha
        // DO NOT CHANGE THE NAME. IT IS IMPORTANT FOR TESTING 
        $captcha = new Element\Captcha('captcha');
        $captcha->setCaptcha($this->getCaptcha());
        $captcha->setOptions(
            array('label' => $this->translate('Please verify you are human.'))
        );
        
        //showing captcha
        if($this->isCaptcha()) {
         
            $this->add($captcha);
        }   
        
        
        //cross-site scripting hash protection
        //this is handled by ZF2 in the background - no need for server-side 
        //validation 
        $this->add(
            array(
                'name' => 'csrf',
                'type'  => 'Zend\Form\Element\Csrf',
                'options' => array(
                    'csrf_options' => array(
                        'timeout' => 600
                    )
                )
            )    
        );
       
        //submit button
        $this->add(
            array(
                'name' => 'Send',
                'type'  => 'Zend\Form\Element\Submit',
                'attributes' => array(
                    'value' =>   $this->translate('Submit'),

                ),
            )
        );
    }
}
