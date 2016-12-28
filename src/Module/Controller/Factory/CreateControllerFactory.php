<?php
namespace Module\Controller\Factory;

use Zend\ServiceManager\ServiceLocatorInterface;
use Module\Controller\CreateController;

class CreateControllerFactory
{
    /**
     * 
     * @param ServiceLocatorInterface $serviceLocator
     * @return \Module\Controller\CreateController
     */
    public function __invoke(ServiceLocatorInterface $serviceLocator)
    {
        $realServiceLocator = $serviceLocator->getServiceLocator();
        
        $service = $realServiceLocator->get('Module\Service\ServiceInterface');
        
        $form = $realServiceLocator->get('Module\Form\Form');
        
        return new CreateController($service, $form);
    }
}

