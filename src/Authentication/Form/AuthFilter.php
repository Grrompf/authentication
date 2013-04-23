<?php
namespace Authentication\Form;

use Zend\InputFilter\InputFilter;

/**
 * Filter for the form.
 */
class AuthFilter extends InputFilter
{
    public function __construct()
    {
        $this->add(
            array(
                'name'       => 'identity',
                'required'   => true,
                'filters'    => array(
                    array('name'    => 'StripTags'),
                ),    
            )    
        );

        $this->add(
            array(
                'name'       => 'password',
                'required'   => true,
                'filters'    => array(
                    array('name'    => 'StripTags'),
                ),
            
            )
        );

       
    }
}
