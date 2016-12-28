<?php
namespace Module\Service\Factory;

use Zend\ServiceManager\ServiceLocatorInterface;
use Module\Service\ModuleService;

class ModuleServiceFactory
{

    /**
     *
     * @param ServiceLocatorInterface $serviceLocator            
     * @return \Module\Service\ModuleService
     */
    public function __invoke(ServiceLocatorInterface $serviceLocator)
    {
        $controllerService = $serviceLocator->get('Module\Service\ControllerServiceInterface');
        
        $entityService = $serviceLocator->get('Module\Service\EntityServiceInterface');
        
        $hydratorService = $serviceLocator->get('Module\Service\HydratorServiceInterface');
        
        $formService = $serviceLocator->get('Module\Service\FormServiceInterface');
        
        $mapperService = $serviceLocator->get('Module\Service\MapperServiceInterface');
        
        $serviceService = $serviceLocator->get('Module\Service\ServiceServiceInterface');
        
        $viewService = $serviceLocator->get('Module\Service\ViewServiceInterface');
        
        return new ModuleService($controllerService, $entityService, $hydratorService, $formService, $mapperService, $serviceService, $viewService);
    }
}

