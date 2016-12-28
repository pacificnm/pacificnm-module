<?php
namespace Module\Service\Factory;

use Zend\ServiceManager\ServiceLocatorInterface;
use Module\Service\FormService;

class FormServiceFactory
{
    public function __invoke(ServiceLocatorInterface $serviceLocator)
    {
        return new FormService();
    }
}

