<?php
namespace Pacificnm\Module\Controller\Factory;

use Zend\ServiceManager\ServiceLocatorInterface;
use Pacificnm\Module\Controller\IndexController;

class IndexControllerFactory
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
        
        return new IndexController($service);
    }
}

