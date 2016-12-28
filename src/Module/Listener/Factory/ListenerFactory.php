<?php
namespace Module\Listener\Factory;

use Zend\ServiceManager\ServiceLocatorInterface;
use Module\Listener\Listener;

class ListenerFactory
{
    /**
     * 
     * @param ServiceLocatorInterface $serviceLocator
     * @return \Module\Listener\Listener
     */
    public function __invoke(ServiceLocatorInterface $serviceLocator)
    {
        $pageService = $serviceLocator->get('Page\Service\ServiceInterface');
               
        $moduleService = $serviceLocator->get('Module\Service\ModuleServiceInterface');

        return new Listener($pageService, $moduleService);
    }
}

