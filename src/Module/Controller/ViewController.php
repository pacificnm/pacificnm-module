<?php
namespace Module\Controller;

use Application\Controller\AbstractApplicationController;
use Zend\View\Model\ViewModel;
use Module\Service\ServiceInterface;
use Controller\Service\ServiceInterface as ControllerServiceInterface;
use Page\Service\ServiceInterface as PageServiceInterface;

class ViewController extends AbstractApplicationController
{

    /**
     *
     * @var ServiceInterface
     */
    protected $service;

    /**
     *
     * @var ControllerServiceInterface
     */
    protected $controllerService;

    /**
     * 
     * @var PageServiceInterface
     */
    protected $pageService;
    
    /**
     * 
     * @param ServiceInterface $service
     * @param ControllerServiceInterface $controllerService
     * @param PageServiceInterface $pageService
     */
    public function __construct(ServiceInterface $service, ControllerServiceInterface $controllerService, PageServiceInterface $pageService)
    {
        $this->service = $service;
        
        $this->controllerService = $controllerService;
        
        $this->pageService = $pageService;
    }

    /**
     *
     * {@inheritdoc}
     *
     * @see \Application\Controller\AbstractApplicationController::indexAction()
     */
    public function indexAction()
    {
        parent::indexAction();
        
        $id = $this->params()->fromRoute('id');
        
        $entity = $this->service->get($id);
        
        if (! $entity) {
            $this->flashMessenger()->addErrorMessage('Module was not found');
            
            return $this->redirect()->toRoute('module-index');
        }
        
        $controllerEntitys = $this->controllerService->getAll(array(
            'pagination' => 'off',
            'moduleId' => $id
        ));
        
        $pageEntitys = $this->pageService->getAll(array(
            'pagination' => 'off',
            'moduleId' => $id
        ));
        
        $this->getEventManager()->trigger('moduleView', $this, array(
            'authId' => $this->identity()
                ->getAuthId(),
            'requestUrl' => $this->getRequest()
                ->getUri(),
            'moduleEntity' => $entity
        ));
        
        return new ViewModel(array(
            'entity' => $entity,
            'controllerEntitys' => $controllerEntitys,
            'pageEntitys' => $pageEntitys
        ));
    }
}

