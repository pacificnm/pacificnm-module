<?php
namespace Pacificnm\Module\Controller\Factory;

use Zend\ServiceManager\ServiceLocatorInterface;
use Pacificnm\Module\Controller\UpdateController;

class UpdateControllerFactory
{

    /**
     *
     * @param ServiceLocatorInterface $serviceLocator            
     * @return \Pacificnm\Module\Controller\UpdateController
     */
    public function __invoke(ServiceLocatorInterface $serviceLocator)
    {
        $realServiceLocator = $serviceLocator->getServiceLocator();
        
        $service = $realServiceLocator->get('Pacificnm\Module\Service\ServiceInterface');
        
        $form = $realServiceLocator->get('Pacificnm\Module\Form\Form');
        
        return new UpdateController($service, $form);
    }
}

