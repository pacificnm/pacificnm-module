<?php
namespace Module\Service\Factory;

use Zend\ServiceManager\ServiceLocatorInterface;
use Module\Service\MapperService;

class MapperServiceFactory
{
    public function __invoke(ServiceLocatorInterface $serviceLocator)
    {
        return new MapperService();
    }
}

