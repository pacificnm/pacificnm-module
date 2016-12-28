<?php
namespace Module\Listener;

use Zend\EventManager\ListenerAggregateInterface;
use Zend\EventManager\EventManagerInterface;
use Zend\EventManager\EventInterface;
use Module\Entity\Entity;
use Page\Service\ServiceInterface as PageServiceInterface;
use Module\Service\ModuleServiceInterface;

class Listener implements ListenerAggregateInterface
{
    /**
     * 
     * @var array
     */
    protected $listeners = array();
    
    /**
     * 
     * @var PageServiceInterface
     */
    protected $pageService;
    
    /**
     * 
     * @var ModuleServiceInterface
     */
    protected $moduleService;
    
    public function __construct(PageServiceInterface $pageService, ModuleServiceInterface $moduleService)
    {
        $this->pageService = $pageService;
        
        $this->moduleService = $moduleService;
    }
    
    /**
     * 
     * @param EventInterface $event
     * @throws \Exception
     * @return \Module\Listener\Listener
     */
    public function moduleCreate(EventInterface $event)
    {
        $moduleEntity = $event->getParam('moduleEntity');
        
        if(! $moduleEntity || ! $moduleEntity instanceof Entity) {
            throw new \Exception('Module Entity was not defined');
        }
        
        // create module
        $this->moduleService->createModule($moduleEntity->getModuleName());
        
        return $this;
    }

    /**
     *
     * {@inheritdoc}
     *
     * @see \Zend\EventManager\ListenerAggregateInterface::attach()
     */
    public function attach(\Zend\EventManager\EventManagerInterface $events)
    {
        $this->listeners = array(
            $events->attach('moduleCreate', array(
                $this,
                'moduleCreate'
            ))
        );
        
        return $this;
    }

    /**
     *
     * {@inheritdoc}
     *
     * @see \Zend\EventManager\ListenerAggregateInterface::detach()
     */
    public function detach(\Zend\EventManager\EventManagerInterface $events)
    {
        foreach ($this->listeners as $index => $listener) {
            if ($events->detach($listener)) {
                unset($this->listeners[$index]);
            }
        }
        
        return $this;
    }
}

