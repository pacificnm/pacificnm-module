<?php
namespace Pacificnm\Module\Service\Factory;

use Zend\ServiceManager\ServiceLocatorInterface;
use Pacificnm\Module\Service\Service;

class ServiceFactory
{
    /**
     * 
     * @param ServiceLocatorInterface $service
     * @return \Pacificnm\Module\Service\Service
     */
    public function __invoke(ServiceLocatorInterface $service)
    {
        $mapper = $service->get('Pacificnm\Module\Mapper\MysqlMapperInterface');
        
        return new Service($mapper);
    }
}

