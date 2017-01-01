<?php
namespace Pacificnm\Module\Service\Factory;

use Zend\ServiceManager\ServiceLocatorInterface;
use Pacificnm\Module\Service\ViewService;

class ViewServiceFactory
{

    /**
     *
     * @param ServiceLocatorInterface $serviceLocator            
     * @return \Pacificnm\Module\Service\ViewService
     */
    public function __invoke(ServiceLocatorInterface $serviceLocator)
    {
        return new ViewService();
    }
}

