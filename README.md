Nakade Authentication
====

This is an extended ZF2 module implementing an authentication. 
Based on the example of a simple ZF2 authentication, this module uses 
a customized authentication adapter, captcha and doctrine2.

Features 
----

* md5 encryption of the password
* session storing as a cookie 
* proving flags, ie active and verified account
* saving date as first and last login
* translation of messages and labels
* supporting Captcha
* triggering Captcha usage after failed attempts as configured 


Requirements
----

* PHP >= 5.3.3
* Zend Framework 2, beta4 or later, specifically:
    * Zend\Authentication\AuthenticationService
    * Zend\Authentication\Storage
    * Zend\I18n\Translator\TranslatorServiceFactory 
    * Zend\Captcha (used for CAPTCHA functionality)
    * Zend\InputFilter 
    * Zend\Filter
    * Zend\Form
    * Zend\ModuleManager (implements a ZF2 module)
    * Zend\Mvc (provides a controller)
    * Zend\ServiceManager (provides service factories)
    * Zend\Session\Container (for session handling)
    * Zend\View
* Doctrine 2
    * Doctrine ORM Module 
        * Doctrine\ORM\EntityManager (for database connection) 
        * Doctrine\ORM\Mapping (entity) 
        * DoctrineModule\Authentication\Adapter\ObjectRepository

Installation
----

Install the module by cloning it into ./vendor/ and enabling it in your
application.config.php file.

You will need to configure the following:

* The CAPTCHA to use, and any options related to it.
* In order to use ReCaptcha, you will need to sign up for an account and register
your domains to get the required key pair.
* If you wish, you can alter the text domain. The text domain is used for the 
translation files. It has to be identical as the one in the view script.  
* If you wish, you can alter the number of failed authentication attempts before 
showing up a Captcha. If you want to have always a Captcha for authentication, 
set the amount to 0. 

Sample configuration for use in your application autoload configuration is
provided, demonstrating usage of the ReCaptcha CAPTCHA adapter and text domain
and failed authentication attempts defaults. This is in
`config\module.Authentication.local.php`.


You will need to configure your DataBase connection:

* Make sure, you have Doctrine2 installed and configured to work with your database.
* Execute the SQL statements for making a new table 'credentials'.
* Import Test Data SQL statements for unit testing

* optional: relate your (existing?) user table id with the field uid

REMARK: all SQL statements do work with MySQL. If you use another database, you
probably have to adapt the provided SQL statements  


Problems
----

* no database connection: see installation 
* no doctrine: see installation 
* unit test AuthenticationTest failure: import the required test data 


License
----

Copyright (c) 2013, Dr. Holger Maerz
All rights reserved.

Redistribution and use in source and binary forms, with or without modification,
are permitted provided that the following conditions are met:

* Redistributions of source code must retain the above copyright notice, this
  list of conditions and the following disclaimer.

* Redistributions in binary form must reproduce the above copyright notice, this
  list of conditions and the following disclaimer in the documentation and/or
  other materials provided with the distribution.

THIS SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDERS AND CONTRIBUTORS "AS IS" AND
ANY EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT LIMITED TO, THE IMPLIED
WARRANTIES OF MERCHANTABILITY AND FITNESS FOR A PARTICULAR PURPOSE ARE
DISCLAIMED. IN NO EVENT SHALL THE COPYRIGHT HOLDER OR CONTRIBUTORS BE LIABLE FOR
ANY DIRECT, INDIRECT, INCIDENTAL, SPECIAL, EXEMPLARY, OR CONSEQUENTIAL DAMAGES
(INCLUDING, BUT NOT LIMITED TO, PROCUREMENT OF SUBSTITUTE GOODS OR SERVICES;
LOSS OF USE, DATA, OR PROFITS; OR BUSINESS INTERRUPTION) HOWEVER CAUSED AND ON
ANY THEORY OF LIABILITY, WHETHER IN CONTRACT, STRICT LIABILITY, OR TORT
(INCLUDING NEGLIGENCE OR OTHERWISE) ARISING IN ANY WAY OUT OF THE USE OF THIS
SOFTWARE, EVEN IF ADVISED OF THE POSSIBILITY OF SUCH DAMAGE.
