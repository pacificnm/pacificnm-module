<?php
namespace Pacificnm\Module\Service\Factory;

use Zend\ServiceManager\ServiceLocatorInterface;
use Pacificnm\Module\Service\FormService;

class FormServiceFactory
{
    /**
     * 
     * @param ServiceLocatorInterface $serviceLocator
     * @return \Pacificnm\Module\Service\FormService
     */
    public function __invoke(ServiceLocatorInterface $serviceLocator)
    {
        return new FormService();
    }
}

