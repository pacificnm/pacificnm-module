<?php
namespace Pacificnm\Module\Service\Factory;

use Zend\ServiceManager\ServiceLocatorInterface;
use Pacificnm\Module\Service\HydratorService;

class HydratorServiceFactory
{
    
    /**
     * 
     * @param ServiceLocatorInterface $serviceLocator
     * @return \Pacificnm\Module\Service\HydratorService
     */
    public function __invoke(ServiceLocatorInterface $serviceLocator)
    {
        return new HydratorService();
    }
}

