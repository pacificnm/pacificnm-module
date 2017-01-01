<?php
namespace Pacificnm\Module\Service\Factory;


use Zend\ServiceManager\ServiceLocatorInterface;
use Pacificnm\Module\Service\ServiceService;

class ServiceServiceFactory
{
    /**
     * 
     * @param ServiceLocatorInterface $serviceLocator
     * @return \Pacificnm\Module\Service\ServiceService
     */
    public function __invoke(ServiceLocatorInterface $serviceLocator)
    {
        return new ServiceService();
    }
}

