<?php
namespace Module\Service\Factory;

use Zend\ServiceManager\ServiceLocatorInterface;
use Module\Service\EntityService;

class EntityServiceFactory
{
    public function __invoke(ServiceLocatorInterface $serviceLocator)
    {
        return new EntityService();
    }
}

