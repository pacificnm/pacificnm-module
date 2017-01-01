<?php
namespace Pacificnm\Module\Service\Factory;

use Zend\ServiceManager\ServiceLocatorInterface;
use Pacificnm\Module\Service\EntityService;

class EntityServiceFactory
{
    /**
     * 
     * @param ServiceLocatorInterface $serviceLocator
     * @return \Pacificnm\Module\Service\EntityService
     */
    public function __invoke(ServiceLocatorInterface $serviceLocator)
    {
        return new EntityService();
    }
}

