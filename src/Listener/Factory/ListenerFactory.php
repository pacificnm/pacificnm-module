<?php
namespace Pacificnm\Module\Listener\Factory;

use Zend\ServiceManager\ServiceLocatorInterface;
use Pacificnm\Module\Listener\Listener;

class ListenerFactory
{
    /**
     * 
     * @param ServiceLocatorInterface $serviceLocator
     * @return \Module\Listener\Listener
     */
    public function __invoke(ServiceLocatorInterface $serviceLocator)
    {
        $pageService = $serviceLocator->get('Pacificnm\Page\Service\ServiceInterface');
               
        $moduleService = $serviceLocator->get('Pacificnm\Module\Service\ModuleServiceInterface');

        return new Listener($pageService, $moduleService);
    }
}

