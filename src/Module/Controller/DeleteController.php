<?php
namespace Module\Controller;

use Application\Controller\AbstractApplicationController;
use Zend\View\Model\ViewModel;
use Module\Service\ServiceInterface;

class DeleteController extends AbstractApplicationController
{
    /**
     *
     * @var ServiceInterface
     */
    protected $service;

    /**
     *
     * @param ServiceInterface $service            
     */
    public function __construct(ServiceInterface $service)
    {
        $this->service = $service;
    }
    
    /**
     *
     * {@inheritDoc}
     * @see \Application\Controller\AbstractApplicationController::indexAction()
     */
    public function indexAction()
    {
        parent::indexAction();
    
        return new ViewModel(array(
    
        ));
    }
}

