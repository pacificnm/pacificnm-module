<?php
namespace Pacificnm\Module\Controller\Factory;

use Zend\ServiceManager\ServiceLocatorInterface;
use Pacificnm\Module\Controller\RestController;

class RestControllerFactory
{

    /**
     *
     * @param ServiceLocatorInterface $serviceLocator            
     * @return \Pacificnm\Module\Controller\IndexController
     */
    public function __invoke(ServiceLocatorInterface $serviceLocator)
    {
        $realServiceLocator = $serviceLocator->getServiceLocator();
        
        $service = $realServiceLocator->get('Pacificnm\Module\Service\ServiceInterface');
        
        return new RestController($service);
    }
}

