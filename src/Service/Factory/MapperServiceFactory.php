<?php
namespace Pacificnm\Module\Service\Factory;

use Zend\ServiceManager\ServiceLocatorInterface;
use Pacificnm\Module\Service\MapperService;

class MapperServiceFactory
{
    /**
     * 
     * @param ServiceLocatorInterface $serviceLocator
     * @return \Pacificnm\Module\Service\MapperService
     */
    public function __invoke(ServiceLocatorInterface $serviceLocator)
    {
        return new MapperService();
    }
}

