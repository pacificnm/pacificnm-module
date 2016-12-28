<?php
namespace Module\Service\Factory;

use Zend\ServiceManager\ServiceLocatorInterface;
use Module\Service\HydratorService;

class HydratorServiceFactory
{
    
    
    public function __invoke(ServiceLocatorInterface $serviceLocator)
    {
        return new HydratorService();
    }
}

