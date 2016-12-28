<?php
namespace Module\Form;

use Zend\Form\Form as ZendForm;
use Zend\InputFilter\InputFilterProviderInterface;
use Module\Hydrator\Hydrator;
use Module\Entity\Entity;

class Form extends ZendForm implements InputFilterProviderInterface
{
    /**
     * 
     * @param string $name
     * @param array $options
     */
    public function __construct($name = 'module-form', $options = array())
    {
        parent::__construct($name, $options);
        
        $this->setHydrator(new Hydrator(false));
        
        $this->setObject(new Entity());
        
        // moduleId
        $this->add(array(
            'name' => 'moduleId',
            'type' => 'hidden',
            'attributes' => array(
                'id' => 'moduleId'
            )
        ));
        
        // moduleName
        $this->add(array(
            'name' => 'moduleName',
            'type' => 'Text',
            'options' => array(
                'label' => 'Module Name:'
            ),
            'attributes' => array(
                'class' => 'form-control',
                'id' => 'moduleName'
            )
        ));
        
        // moduleVersion
        $this->add(array(
            'name' => 'moduleVersion',
            'type' => 'Text',
            'options' => array(
                'label' => 'Module Version:'
            ),
            'attributes' => array(
                'class' => 'form-control',
                'id' => 'moduleVersion'
            )
        ));
        
        // submit
        $this->add(array(
            'name' => 'submit',
            'type' => 'button',
            'attributes' => array(
                'value' => 'Submit',
                'id' => 'submit',
                'class' => 'btn btn-primary btn-flat'
            )
        ));
    }
    
    /**
     * {@inheritDoc}
     * @see \Zend\InputFilter\InputFilterProviderInterface::getInputFilterSpecification()
     */
    public function getInputFilterSpecification()
    {
        return array(
            // moduleId
            
            // moduleName
            
            // moduleVersion
        );
    }

}

