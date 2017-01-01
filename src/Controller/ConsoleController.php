<?php
namespace Pacificnm\Module\Controller;

use Zend\Console\Adapter\AdapterInterface;
use Zend\Mvc\Controller\AbstractActionController;
use Pacificnm\Module\Service\ServiceInterface;

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
     * {@inheritdoc}
     *
     * @see \Zend\Mvc\Controller\AbstractActionController::indexAction()
     */
    public function indexAction()
    {}
}

