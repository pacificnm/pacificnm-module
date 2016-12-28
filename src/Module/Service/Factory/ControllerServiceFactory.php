<?php
namespace Module\Service\Factory;

use Zend\ServiceManager\ServiceLocatorInterface;
use Module\Service\ControllerService;

class ControllerServiceFactory
{
    /**
     * 
     * @param ServiceLocatorInterface $serviceLocator
     * @return \Module\Service\ControllerService
     */
    public function __invoke(ServiceLocatorInterface $serviceLocator)
    {
        
        return new ControllerService();
    }
}

