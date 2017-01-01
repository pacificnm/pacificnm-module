<?php
namespace Pacificnm\Module\Form\Factory;

use Zend\ServiceManager\ServiceLocatorInterface;
use Pacificnm\Module\Form\Form;

class FormFactory
{
    /**
     * 
     * @param ServiceLocatorInterface $serviceLocator
     * @return \Pacificnm\Module\Form\Form
     */
    public function __invoke(ServiceLocatorInterface $serviceLocator)
    {
        return new Form();
    }
}

