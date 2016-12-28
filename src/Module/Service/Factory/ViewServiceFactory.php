<?php
namespace Module\Service\Factory;
use Zend\ServiceManager\ServiceLocatorInterface;
use Module\Service\ViewService;

class ViewServiceFactory
{
    
    public function __invoke(ServiceLocatorInterface $serviceLocator)
    {
        return new ViewService();
    }
}

