<?php
namespace Module\Form\Factory;

use Zend\ServiceManager\ServiceLocatorInterface;
use Module\Form\Form;

class FormFactory
{
    /**
     * 
     * @param ServiceLocatorInterface $serviceLocator
     * @return \Module\Form\Form
     */
    public function __invoke(ServiceLocatorInterface $serviceLocator)
    {
        return new Form();
    }
}

