<?php
/**
 * The config information is passed to the relevant components by the 
 * ServiceManager. The controllers section provides a list of all the 
 * controllers provided by the module. 
 * 
 * Within the view_manager section, we add our view directory to the 
 * TemplatePathStack configuration. 
 * 
 * @return array 
 */
namespace Authentication;

return array(
    
    'NakadeAuth' => array(
        'text_domain'   => 'Auth',
        'captcha' => array(
            'class'   => 'dump',
        )    
    ),
    
    'controllers' => array(
        'factories' => array(
            'Authentication\Controller\Auth' => 
                    'Authentication\Services\AuthControllerFactory',
        ),
        
        'invokables' => array(
            'Authentication\Controller\Success' => 
                'Authentication\Controller\SuccessController',
            ),
        ),
    //The name of the route is ‘login’ and has a type of ‘literal’. The literal 
    //route is for doing the exact match of the URI path. 
    //The next segment will be an optional action name, and then finally the 
    //next segment will be mapped to an optional id. 
    //The square brackets indicate that a segment is optional. 
    'router' => array(
        'routes' => array(
            
            'login' => array(
                'type'    => 'Literal',
                'options' => array(
                    'route'    => '/login',
                    'defaults' => array(
                        '__NAMESPACE__' => 'Authentication\Controller',
                        'controller'    => 'Auth',
                        'action'        => 'login',
                    ),
                ),
                'may_terminate' => true,
                'child_routes' => array(
                    'process' => array(
                        'type'    => 'Segment',
                        'options' => array(
                            'route'    => '/[:action]',
                            'constraints' => array(
                                'controller' => '[a-zA-Z][a-zA-Z0-9_-]*',
                                'action'     => '[a-zA-Z][a-zA-Z0-9_-]*',
                            ),
                            'defaults' => array(
                            ),
                        ),
                    ),
                ),
            ),
            
            
            'success' => array(
                'type'    => 'Literal',
                'options' => array(
                    'route'    => '/success',
                    'defaults' => array(
                        '__NAMESPACE__' => 'Authentication\Controller',
                        'controller'    => 'Success',
                        'action'        => 'index',
                    ),
                ),
                'may_terminate' => true,
                'child_routes' => array(
                    'default' => array(
                        'type'    => 'Segment',
                        'options' => array(
                            'route'    => '/[:action]',
                            'constraints' => array(
                                'controller' => '[a-zA-Z][a-zA-Z0-9_-]*',
                                'action'     => '[a-zA-Z][a-zA-Z0-9_-]*',
                            ),
                            'defaults' => array(
                            ),
                        ),
                    ),
                ),
            ),
            
        ),
    ),
    
    
    'view_manager' => array(
        'display_not_found_reason' => true,
        'display_exceptions'       => true,
        'doctype'                  => 'HTML5',
                
        'template_path_stack'   => array(
            __DIR__ . '/../view',
        ),
        
    ),
    
    'service_manager' => array(
        'factories' => array(
            
            //neccessary for using authentication in ViewHelper and Controller
            'Zend\Authentication\AuthenticationService'       => 
                'Authentication\Services\AuthServiceFactory',
            'AuthCaptcha'       => 
                'Authentication\Services\AuthCaptchaFactory',
            'AuthForm'   => 
                'Authentication\Services\AuthFormFactory',
            'translator'        => 
                'Zend\I18n\Translator\TranslatorServiceFactory',
        ),
    ),
    
    'translator' => array(
        'translation_file_patterns' => array(
            array(
                'type'          => 'gettext',
                'base_dir'      => __DIR__ . '/../language',
                'pattern'       => '%s.mo',
                'text_domain'   => 'Auth',
            ),
             array( 
                'type'        => 'phparray', 
                'base_dir'    => __DIR__ . '/../resources/languages', 
                'pattern'     => '%s.php',
             
             ), 
        ),
        
    ),
    
    //Doctrine Authentication provided by DoctrineModule\Options\Authentication
    //identity class => performing authentication ; this has to be done
    //identity_property => username or email
    //credential_property => password
    'doctrine' => array(
        'driver' => array(
            __NAMESPACE__ . '_driver' => array(
                'class' => 'Doctrine\ORM\Mapping\Driver\AnnotationDriver',
                'cache' => 'array',
                'paths' => array(
                    __DIR__ . '/../src/' . __NAMESPACE__ . '/Entity')
           ),
           'orm_default' => array(
               'drivers' => array(
                __NAMESPACE__ . '\Entity' => __NAMESPACE__ . '_driver'
               )
           )
        ),
        'authentication' => array(
            'orm_default' => array(
                'object_manager' => 'Doctrine\ORM\EntityManager',
                'identity_class' => 'Authentication\Entity\Credential',
                'identity_property' => 'username',
                'credential_property' => 'password',
            ),
        ),
    ),
    
);
