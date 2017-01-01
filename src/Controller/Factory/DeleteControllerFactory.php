<?php
namespace Pacificnm\Module\Controller\Factory;

use Zend\ServiceManager\ServiceLocatorInterface;
use Pacificnm\Module\Controller\DeleteController;

class DeleteControllerFactory
{

    /**
     *
     * @param ServiceLocatorInterface $serviceLocator            
     * @return \Pacificnm\Module\Controller\DeleteController
     */
    public function __invoke(ServiceLocatorInterface $serviceLocator)
    {
        $realServiceLocator = $serviceLocator->getServiceLocator();
        
        $service = $realServiceLocator->get('Pacificnm\Module\Service\ServiceInterface');
        
        return new DeleteController($service);
    }
}

