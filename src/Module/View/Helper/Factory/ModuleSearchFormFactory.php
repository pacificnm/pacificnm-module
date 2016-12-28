<?php
namespace Module\View\Helper\Factory;

use Zend\ServiceManager\ServiceLocatorInterface;
use Module\View\Helper\ModuleSearchForm;

class ModuleSearchFormFactory
{
    /**
     * 
     * @param ServiceLocatorInterface $serviceLocator
     * @return \Module\View\Helper\ModuleSearchForm
     */
    public function __invoke(ServiceLocatorInterface $serviceLocator)
    {
        $realServiceLocator = $serviceLocator->getServiceLocator();
        
        return new ModuleSearchForm();
    }
}

