<?php
namespace Pacificnm\Module\Controller\Factory;

use Zend\ServiceManager\ServiceLocatorInterface;
use Pacificnm\Module\Controller\CreateController;

class CreateControllerFactory
{
    /**
     * 
     * @param ServiceLocatorInterface $serviceLocator
     * @return \Pacificnm\Module\Controller\CreateController
     */
    public function __invoke(ServiceLocatorInterface $serviceLocator)
    {
        $realServiceLocator = $serviceLocator->getServiceLocator();
        
        $service = $realServiceLocator->get('Pacificnm\Module\Service\ServiceInterface');
        
        $form = $realServiceLocator->get('Pacificnm\Module\Form\Form');
        
        return new CreateController($service, $form);
    }
}

