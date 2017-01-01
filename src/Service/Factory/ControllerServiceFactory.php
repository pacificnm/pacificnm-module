<?php
namespace Pacificnm\Module\Service\Factory;

use Zend\ServiceManager\ServiceLocatorInterface;
use Pacificnm\Module\Service\ControllerService;

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

