<?php
namespace Pacificnm\Module\Controller\Factory;

use Zend\ServiceManager\ServiceLocatorInterface;
use Pacificnm\Module\Controller\ViewController;

class ViewControllerFactory
{

    /**
     *
     * @param ServiceLocatorInterface $serviceLocator            
     * @return \Pacificnm\Module\Controller\IndexController
     */
    public function __invoke(ServiceLocatorInterface $serviceLocator)
    {
        $realServiceLocator = $serviceLocator->getServiceLocator();
        
        $service = $realServiceLocator->get('Pacificnm\Module\Service\ServiceInterface');
        
        $controllerService = $realServiceLocator->get('Pacificnm\Controller\Service\ServiceInterface');
        
        $pageService = $realServiceLocator->get('Pacificnm\Page\Service\ServiceInterface');
        
        return new ViewController($service, $controllerService, $pageService);
    }
}

