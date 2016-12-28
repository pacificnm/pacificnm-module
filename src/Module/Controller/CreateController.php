<?php
namespace Module\Controller;

use Application\Controller\AbstractApplicationController;
use Module\Form\Form;
use Zend\View\Model\ViewModel;
use Module\Service\ServiceInterface;

class CreateController extends AbstractApplicationController
{

    /**
     *
     * @var ServiceInterface
     */
    protected $service;

    /**
     *
     * @var Form
     */
    protected $form;

    /**
     *
     * @param ServiceInterface $service            
     * @param Form $form            
     */
    public function __construct(ServiceInterface $service, Form $form)
    {
        $this->service = $service;
        
        $this->form = $form;
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
        
        $request = $this->getRequest();
        
        // if we have a post
        if ($request->isPost()) {
            
            $postData = $request->getPost();
            
            $this->form->setData($postData);
            
            // if the form is valid
            if ($this->form->isValid()) {
                $entity = $this->form->getData();
                
                $moduleEntity = $this->service->save($entity);
                
                $this->getEventManager()->trigger('moduleCreate', $this, array(
                    'authId' => $this->identity()->getAuthId(),
                    'requestUrl' => $this->getRequest()->getUri(),
                    'moduleEntity' => $entity
                ));
                
                $this->flashMessenger()->addSuccessMessage("Module {$moduleEntity->getModuleName()} was saved.");
                
                return $this->redirect()->toRoute('module-view', array(
                    'id' => $moduleEntity->getModuleId()
                ));
            }
        }
        
        return new ViewModel(array(
            'form' => $this->form
        ));
    }
}

