<?php
namespace Module;

use Zend\Mvc\MvcEvent;
use Zend\Console\Adapter\AdapterInterface;
class Module
{
    public function getConsoleUsage(AdapterInterface $console)
    {
        return array(
            'module' => 'Module help',
            'module --list' => 'Lists installed modules'
        );
    }
    
    /**
     *
     * @param MvcEvent $e
     */
    public function onBootstrap(MvcEvent $e)
    {
        $eventManager = $e->getApplication()->getEventManager();
    
        $sharedEventManager = $eventManager->getSharedManager();
    
        $sharedEventManager->attach('Zend\Mvc\Controller\AbstractActionController', 'dispatch', array(
            $this,
            'moduleEventController'
        ), 99);
    }
    
    /**
     *
     * @param MvcEvent $e
     */
    public function moduleEventController(MvcEvent $e)
    {
        $controller = $e->getTarget();
    
        $controller->getEventManager()->attachAggregate($controller->getServiceLocator()
            ->get('Module\Listener\Listener'));
    }
    
    public function getConfig()
    {
        return include __DIR__ . '/config/module.config.php';
    }
    
    public function getAutoloaderConfig()
    {
        return array(
            'Zend\Loader\StandardAutoloader' => array(
                'namespaces' => array(
                    __NAMESPACE__ => __DIR__ . '/src/' . __NAMESPACE__,
                ),
            ),
        );
    }
}

