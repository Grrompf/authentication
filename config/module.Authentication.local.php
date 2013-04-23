<?php
/**
 * This is a sample "local" configuration for your application. To use it, copy 
 * it to your config/autoload/ directory of your application, and edit to suit
 * your application.
 *
 * This configuration example demonstrates using an SMTP mail transport, a
 * ReCaptcha CAPTCHA adapter, and setting the to and sender addresses for the
 * mail message.
 */
return array(
    
    'NakadeAuth' => array(
        
        //your text domain for translation
        'text_domain' => 'Auth',
        
        //show captcha after n failed attempts 
        'max_auth_attempts' => 5,
        
        //example google ReCaptcha data
        'captcha' => array(
            'class'   => 'recaptcha', 
            'options' => array(
                'pubkey'  => 'PUT YOUR PUBLIC KEY HERE',
                'privkey' => 'PUT YOUR PRIVATE KEY HERE',
            ),
        ),
    ),
);
