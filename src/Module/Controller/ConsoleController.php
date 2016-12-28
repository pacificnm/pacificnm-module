<?php
namespace Module\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Module\Service\ServiceInterface;
use Zend\Console\Adapter\AdapterInterface;

class ConsoleController extends AbstractActionController
{
    /**
     * 
     * @var ServiceInterface
     */
    protected $service;
    
    /**
     * 
     * @var AdapterInterface
     */
    protected $console;
    
    /**
     * 
     * @param ServiceInterface $service
     * @param AdapterInterface $console
     */
    public function __construct(ServiceInterface $service, AdapterInterface $console)
    {
        $this->service = $service;
        
        $this->console = $console;
    }
    
    /**
     * 
     * {@inheritDoc}
     * @see \Zend\Mvc\Controller\AbstractActionController::indexAction()
     */
    public function indexAction()
    {
       
    }
}

