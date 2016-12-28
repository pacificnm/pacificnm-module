<?php
namespace Module\Controller\Factory;

use Zend\ServiceManager\ServiceLocatorInterface;
use Module\Controller\ViewController;

class ViewControllerFactory
{

    /**
     *
     * @param ServiceLocatorInterface $serviceLocator            
     * @return \Module\Controller\IndexController
     */
    public function __invoke(ServiceLocatorInterface $serviceLocator)
    {
        $realServiceLocator = $serviceLocator->getServiceLocator();
        
        $service = $realServiceLocator->get('Module\Service\ServiceInterface');
        
        $controllerService = $realServiceLocator->get('Controller\Service\ServiceInterface');
        
        $pageService = $realServiceLocator->get('Page\Service\ServiceInterface');
        
        return new ViewController($service, $controllerService, $pageService);
    }
}

