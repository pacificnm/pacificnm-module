<?php
namespace Pacificnm\Module\Service\Factory;

use Zend\ServiceManager\ServiceLocatorInterface;
use Pacificnm\Module\Service\ModuleService;

class ModuleServiceFactory
{

    /**
     *
     * @param ServiceLocatorInterface $serviceLocator            
     * @return \Module\Service\ModuleService
     */
    public function __invoke(ServiceLocatorInterface $serviceLocator)
    {
        $controllerService = $serviceLocator->get('Pacificnm\Module\Service\ControllerServiceInterface');
        
        $entityService = $serviceLocator->get('Pacificnm\Module\Service\EntityServiceInterface');
        
        $hydratorService = $serviceLocator->get('Pacificnm\Module\Service\HydratorServiceInterface');
        
        $formService = $serviceLocator->get('Pacificnm\Module\Service\FormServiceInterface');
        
        $mapperService = $serviceLocator->get('Pacificnm\Module\Service\MapperServiceInterface');
        
        $serviceService = $serviceLocator->get('Pacificnm\Module\Service\ServiceServiceInterface');
        
        $viewService = $serviceLocator->get('Pacificnm\Module\Service\ViewServiceInterface');
        
        return new ModuleService($controllerService, $entityService, $hydratorService, $formService, $mapperService, $serviceService, $viewService);
    }
}

