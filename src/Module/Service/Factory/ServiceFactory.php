<?php
namespace Module\Service\Factory;

use Zend\ServiceManager\ServiceLocatorInterface;
use Module\Service\Service;

class ServiceFactory
{
    /**
     * 
     * @param ServiceLocatorInterface $service
     * @return \Module\Service\Service
     */
    public function __invoke(ServiceLocatorInterface $service)
    {
        $mapper = $service->get('Module\Mapper\MysqlMapperInterface');
        
        return new Service($mapper);
    }
}

