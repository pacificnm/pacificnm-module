<?php
namespace Module\Controller\Factory;

use Zend\ServiceManager\ServiceLocatorInterface;
use Module\Controller\IndexController;

class IndexControllerFactory
{

    /**
     *
     * @param ServiceLocatorInterface $serviceLocator            
     * @return \Module\Controller\IndexController
     */
    public function __invoke(ServiceLocatorInterface $serviceLocator)
    {
        $realServiceLocator = $serviceLocator->getServiceLocator();
        
        $service = $realServiceLocator->get('Module\Service\ServiceInterface');
        
        return new IndexController($service);
    }
}

