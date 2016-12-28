<?php
namespace Module\Service\Factory;


use Zend\ServiceManager\ServiceLocatorInterface;
use Module\Service\ServiceService;

class ServiceServiceFactory
{
    public function __invoke(ServiceLocatorInterface $serviceLocator)
    {
        return new ServiceService();
    }
}

