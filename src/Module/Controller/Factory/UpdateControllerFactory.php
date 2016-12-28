<?php
namespace Module\Controller\Factory;

use Zend\ServiceManager\ServiceLocatorInterface;
use Module\Controller\UpdateController;

class UpdateControllerFactory
{

    /**
     *
     * @param ServiceLocatorInterface $serviceLocator            
     * @return \Module\Controller\UpdateController
     */
    public function __invoke(ServiceLocatorInterface $serviceLocator)
    {
        $realServiceLocator = $serviceLocator->getServiceLocator();
        
        $service = $realServiceLocator->get('Module\Service\ServiceInterface');
        
        $form = $realServiceLocator->get('Module\Form\Form');
        
        return new UpdateController($service, $form);
    }
}

