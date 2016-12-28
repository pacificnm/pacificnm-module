<?php
namespace Module\Service;

use Zend\Code\Generator\ClassGenerator;
use Zend\Code\Generator\MethodGenerator;
use Zend\Code\Generator\FileGenerator;
use Zend\Code\Generator\ParameterGenerator;
use Zend\Code\Generator\PropertyGenerator;
use Zend\Code\Generator\PropertyValueGenerator;
use Zend\Code\Generator\DocBlockGenerator;
use Zend\Code\Generator\DocBlock\Tag\ParamTag;
use Zend\Code\Generator\DocBlock\Tag\ReturnTag;
use Zend\Filter\Word\CamelCaseToDash;

class ControllerService implements ControllerServiceInterface
{

    /**
     *
     * @var ClassGenerator
     */
    protected $code;

    /**
     *
     * @var ClassGenerator
     */
    protected $factory;

    /**
     *
     * @var string
     */
    protected $moduleDir;

    /**
     *
     * @var string
     */
    protected $moduleName;

    /**
     *
     * @var string
     */
    protected $classNameSpace;

    /**
     *
     * @var string
     */
    protected $factoryNamespace;

    /**
     *
     * @var string
     */
    protected $public = MethodGenerator::FLAG_PUBLIC;

    /**
     *
     * {@inheritdoc}
     *
     * @see \Module\Service\ControllerServiceInterface::createController()
     */
    public function createController($moduleDir, $moduleName)
    {
        $this->moduleDir = ucfirst($moduleDir) . '/src/' . ucfirst($moduleName);
        
        if (! is_dir($moduleDir) || ! is_writable($moduleDir)) {
            throw new \Exception("Can not write to directory: {$moduleDir}");
        }
        
        $this->moduleName = ucfirst($moduleName);
        
        $this->classNameSpace = $this->moduleName . '\Controller';
        
        $this->factoryNamespace = $this->moduleName . '\Controller\Factory';
        
        $this->createConsole()
            ->createCreate()
            ->createDelete()
            ->createIndex()
            ->createRest()
            ->createUpdate()
            ->createView();
    }

    /**
     * Creates the UpdateController and Factory
     *
     * @return \Module\Service\ControllerService
     */
    public function createUpdate()
    {
        // class
        $this->code = new ClassGenerator();
        
        $this->code->setNamespaceName($this->classNameSpace);
        
        $this->code->setName('UpdateController');
        
        $this->getFormUse();
        
        $this->code->addProperties($this->getFormProperties());
        
        // construct
        $this->code->addMethod('__construct', $this->getFormParameters(), $this->public, $this->getFormConstruct(), $this->getFormDocBlock());
        
        // indexAction
        $this->code->addMethod('indexAction', array(), $this->public, $this->getUpdateBody(), $this->getIndexDocBlock());
        
        $this->writeClassFile('UpdateController.php');
        
        // factory
        $this->createFactory('UpdateControllerFactory', 'UpdateControllerFactory.php', 'UpdateController', true);
        
        return $this;
    }

    /**
     *
     * @return \Module\Service\ControllerService
     */
    public function createCreate()
    {
        // class
        $this->code = new ClassGenerator();
        
        $this->code->setNamespaceName($this->classNameSpace);
        
        $this->code->setName('CreateController');
        
        $this->getFormUse();
        
        $this->code->addProperties($this->getFormProperties());
        
        // construct
        $this->code->addMethod('__construct', $this->getFormParameters(), $this->public, $this->getFormConstruct(), $this->getFormDocBlock());
        
        // indexAction
        $this->code->addMethod('indexAction', array(), $this->public, $this->getCreateBody(), $this->getIndexDocBlock());
        
        $this->writeClassFile('CreateController.php');
        
        // factory
        $this->createFactory('CreateControllerFactory', 'CreateControllerFactory.php', 'CreateController', true);
        
        return $this;
    }

    /**
     *
     * @return \Module\Service\ControllerService
     */
    public function createDelete()
    {
        $this->code = new ClassGenerator();
        
        $this->code->setNamespaceName($this->classNameSpace);
        
        $this->code->setName('DeleteController');
        
        $this->getUse();
        
        $this->code->addProperty('service', new PropertyValueGenerator(), PropertyGenerator::FLAG_PROTECTED);
        
        // contruct
        $this->code->addMethod('__construct', array(
            new ParameterGenerator('service', 'ServiceInterface')
        ), $this->public, $this->getContruct(), $this->getDocBlock());
        
        // index
        $this->code->addMethod('indexAction', array(), $this->public, $this->getDeleteBody(), $this->getIndexDocBlock());
        
        // write file
        $this->writeClassFile('DeleteController.php');
        
        // factory
        $this->createFactory('DeleteControllerFactory', 'DeleteControllerFactory.php', 'DeleteController');
        
        return $this;
    }

    /**
     *
     * @return \Module\Service\ControllerService
     */
    public function createView()
    {
        $this->code = new ClassGenerator();
        
        $this->code->setNamespaceName($this->classNameSpace);
        
        $this->code->setName('ViewController');
        
        $this->getUse();
        
        $this->code->addProperty('service', new PropertyValueGenerator(), PropertyGenerator::FLAG_PROTECTED);
        
        // construct
        $this->code->addMethod('__construct', array(
            new ParameterGenerator('service', 'ServiceInterface')
        ), $this->public, $this->getContruct(), $this->getDocBlock());
        
        // indexAction
        $this->code->addMethod('indexAction', array(), $this->public, $this->getViewBody(), $this->getIndexDocBlock());
        // write file
        $this->writeClassFile('ViewController.php');
        
        // create factory
        $this->createFactory('ViewControllerFactory', 'ViewControllerFactory.php', 'ViewController');
        
        return $this;
    }

    /**
     *
     * @return \Module\Service\ControllerService
     */
    public function createIndex()
    {
        $this->code = new ClassGenerator();
        
        $this->code->setNamespaceName($this->classNameSpace);
        
        $this->code->setName('IndexController');
        
        $this->getUse();
        
        $this->code->addProperty('service', new PropertyValueGenerator(), PropertyGenerator::FLAG_PROTECTED);
        
        // construct
        $this->code->addMethod('__construct', array(
            new ParameterGenerator('service', 'ServiceInterface')
        ), $this->public, $this->getContruct(), $this->getDocBlock());
        
        // indexAction
        $this->code->addMethod('indexAction', array(), $this->public, $this->getIndexBody(), $this->getIndexDocBlock());
        
        // write file
        $this->writeClassFile('IndexController.php');
        
        // create factory
        $this->createFactory('IndexControllerFactory', 'IndexControllerFactory.php', 'IndexController');
        
        return $this;
    }

    /**
     *
     * @return \Module\Service\ControllerService
     */
    public function createConsole()
    {
        $this->code = new ClassGenerator();
        
        $this->code->setNamespaceName($this->classNameSpace);
        
        $this->code->setName('ConsoleController');
        
        $this->code->addUse('Zend\Mvc\Controller\AbstractActionController');
        
        $this->code->addUse('Zend\Console\Adapter\AdapterInterface');
        
        $this->code->addUse($this->moduleName . '\Service\ServiceInterface');
        
        $this->code->setExtendedClass('AbstractActionController');
        
        $this->code->addProperty('service', new PropertyValueGenerator(), PropertyGenerator::FLAG_PROTECTED);
        
        $this->code->addProperty('console', new PropertyValueGenerator(), PropertyGenerator::FLAG_PROTECTED);
        
        // construct
        $body = '$this->service = $service;' . "\n\n";
        $body .= '$this->console = $console;';
        
        $dockBlock = new DocBlockGenerator();
        
        $dockBlock->setTags(array(
            new ParamTag('service', 'ServiceInterface'),
            new ParamTag('console', 'AdapterInterface')
        ));
        
        $this->code->addMethods(array(
            new MethodGenerator('__construct', array(
                new ParameterGenerator('service', 'ServiceInterface'),
                new ParameterGenerator('console', 'AdapterInterface')
            ), $this->public, $body, $dockBlock)
        ));
        
        // index
        $this->code->addMethod('indexAction', array(), $this->public, "", $this->getIndexDocBlock());
        
        // write file
        $this->writeClassFile('ConsoleController.php');
        
        // factory
        $this->factory = new ClassGenerator();
        
        $this->factory->setNamespaceName($this->factoryNamespace);
        
        $this->factory->setName('ConsoleControllerFactory');
        
        $this->factory->addUse('Zend\ServiceManager\ServiceLocatorInterface');
        
        $this->factory->addUse($this->moduleName . '\Controller\ConsoleController');
        
        $dockBlock = new DocBlockGenerator();
        
        $dockBlock->setTags(array(
            new ParamTag('serviceLocator', 'ServiceLocatorInterface'),
            new ReturnTag('\\' . $this->moduleName . '\Controller\ConsoleContorller')
        ));
        
        $body = '$realServiceLocator = $serviceLocator->getServiceLocator();' . "\n";
        $body .= '$service = $realServiceLocator->get(\'' . $this->moduleName . '\Service\ServiceInterface\');' . "\n";
        $body .= '$console = $realServiceLocator->get(\'console\');' . "\n";
        $body .= 'return new ConsoleController($service, $console);';
        
        $this->factory->addMethod('__invoke', array(
            new ParameterGenerator('serviceLocator', 'ServiceLocatorInterface')
        ), $this->public, $body, $dockBlock);
        
        $this->writeFactoryFile('ConsoleControllerFactory.php');
        
        return $this;
    }

    /**
     *
     * @return \Module\Service\ControllerService
     */
    public function createRest()
    {
        $this->code = new ClassGenerator();
        
        $this->code->setNamespaceName($this->classNameSpace);
        
        $this->code->setName('RestController');
        
        $this->code->addUse('Zend\Mvc\Controller\AbstractRestfulController');
        
        $this->code->addUse($this->moduleName . '\Service\ServiceInterface');
        
        $this->code->addUse('Zend\View\Model\JsonModel');
        
        $this->code->setExtendedClass('AbstractRestfulController');
        
        $this->code->addProperty('service', new PropertyValueGenerator(), PropertyGenerator::FLAG_PROTECTED);
        
        $construct = '$this->service = $service;';
        
        $service = new ParameterGenerator('service', 'ServiceInterface');
        
        $this->code->addMethods(array(
            new MethodGenerator('__construct', array(
                $service
            ), MethodGenerator::FLAG_PUBLIC, $construct),
            new MethodGenerator('create', array(
                'data'
            ), MethodGenerator::FLAG_PUBLIC, '$this->response->setStatusCode(405);' . "\n" . 'return new JsonModel(array("content" => "Method Not Allowed"));'),
            new MethodGenerator('delete', array(
                'id'
            ), MethodGenerator::FLAG_PUBLIC, '$this->response->setStatusCode(405);' . "\n" . 'return new JsonModel(array("content" => "Method Not Allowed"));'),
            new MethodGenerator('deleteList', array(
                'data'
            ), MethodGenerator::FLAG_PUBLIC, '$this->response->setStatusCode(405);' . "\n" . 'return new JsonModel(array("content" => "Method Not Allowed"));'),
            new MethodGenerator('get', array(
                'id'
            ), MethodGenerator::FLAG_PUBLIC, '$this->response->setStatusCode(405);' . "\n" . 'return new JsonModel(array("content" => "Method Not Allowed"));'),
            new MethodGenerator('getList', array(
                'params'
            ), MethodGenerator::FLAG_PUBLIC, '$this->response->setStatusCode(405);' . "\n" . 'return new JsonModel(array("content" => "Method Not Allowed"));'),
            new MethodGenerator('head', array(
                'id'
            ), MethodGenerator::FLAG_PUBLIC, '$this->response->setStatusCode(405);' . "\n" . 'return new JsonModel(array("content" => "Method Not Allowed"));'),
            new MethodGenerator('options', array(), MethodGenerator::FLAG_PUBLIC, '$this->response->setStatusCode(405);' . "\n" . 'return new JsonModel(array("content" => "Method Not Allowed"));'),
            new MethodGenerator('patch', array(
                'id',
                'data'
            ), MethodGenerator::FLAG_PUBLIC, '$this->response->setStatusCode(405);' . "\n" . 'return new JsonModel(array("content" => "Method Not Allowed"));'),
            new MethodGenerator('replaceList', array(
                'data'
            ), MethodGenerator::FLAG_PUBLIC, '$this->response->setStatusCode(405);' . "\n" . 'return new JsonModel(array("content" => "Method Not Allowed"));'),
            new MethodGenerator('patchList', array(
                'data'
            ), MethodGenerator::FLAG_PUBLIC, '$this->response->setStatusCode(405);' . "\n" . 'return new JsonModel(array("content" => "Method Not Allowed"));'),
            new MethodGenerator('update', array(
                'id',
                'data'
            ), MethodGenerator::FLAG_PUBLIC, '$this->response->setStatusCode(405);' . "\n" . 'return new JsonModel(array("content" => "Method Not Allowed"));'),
            new MethodGenerator('notFoundAction', array(), MethodGenerator::FLAG_PUBLIC, '$this->response->setStatusCode(404);' . "\n" . 'return new JsonModel(array("content" => "Method Not Allowed"));')
        ));
        
        $this->writeClassFile('RestController.php');
        
        // create factory
        $this->createFactory('RestControllerFactory', 'RestControllerFactory.php', 'RestController');
        
        return $this;
    }

    /**
     * Creates the Index Action doc block
     *
     * @return \Zend\Code\Generator\DocBlockGenerator
     */
    protected function getIndexDocBlock()
    {
        $dockBlock = new DocBlockGenerator();
        
        $dockBlock->setShortDescription('{@inheritdoc}');
        
        $dockBlock->setLongDescription('@see \Zend\Mvc\Controller\AbstractActionController::indexAction()');
        
        return $dockBlock;
    }

    /**
     * Creates doc block for controller class with a forsm
     *
     * @return \Zend\Code\Generator\DocBlockGenerator
     */
    protected function getFormDocBlock()
    {
        $docBlock = new DocBlockGenerator();
        
        $docBlock->setTags(array(
            new ParamTag('service', 'ServiceInterface'),
            new ParamTag('form', 'Form')
        ));
        
        return $docBlock;
    }

    /**
     * Creates doc block for controller class
     *
     * @return \Zend\Code\Generator\DocBlockGenerator
     */
    protected function getDocBlock()
    {
        $docBlock = new DocBlockGenerator();
        
        $docBlock->setTags(array(
            new ParamTag('service', 'ServiceInterface')
        ));
        
        return $docBlock;
    }

    /**
     * Creates the method parameters for construct with form
     *
     * @return \Zend\Code\Generator\ParameterGenerator[]
     */
    protected function getFormParameters()
    {
        return array(
            new ParameterGenerator('service', 'ServiceInterface'),
            new ParameterGenerator('form', 'Form')
        );
    }

    /**
     * Creates the class properties for a class with a form
     *
     * @return \Zend\Code\Generator\PropertyGenerator[]
     */
    protected function getFormProperties()
    {
        return array(
            new PropertyGenerator('service', new PropertyValueGenerator(), PropertyGenerator::FLAG_PROTECTED),
            new PropertyGenerator('form', new PropertyValueGenerator(), PropertyGenerator::FLAG_PROTECTED)
        );
    }

    /**
     * Creates the Use statements for a class that has a form
     *
     * @return \Module\Service\ControllerService
     */
    protected function getFormUse()
    {
        $this->code->addUse('Application\Controller\AbstractApplicationController');
        
        $this->code->addUse('Zend\View\Model\ViewModel');
        
        $this->code->addUse($this->moduleName . '\Service\ServiceInterface');
        
        $this->code->addUse($this->moduleName . '\Form\Form');
        
        $this->code->setExtendedClass('AbstractApplicationController');
        
        return $this;
    }

    /**
     * Create the Use statements for the class
     *
     * @return \Module\Service\ControllerService
     */
    protected function getUse()
    {
        $this->code->addUse('Application\Controller\AbstractApplicationController');
        
        $this->code->addUse('Zend\View\Model\ViewModel');
        
        $this->code->addUse($this->moduleName . '\Service\ServiceInterface');
        
        $this->code->setExtendedClass('AbstractApplicationController');
        
        return $this;
    }

    /**
     * Creats the contruct body with a form
     *
     * @return string
     */
    protected function getFormConstruct()
    {
        $body = '$this->service = $service;' . "\n\n";
        $body .= '$this->form = $form;';
        
        return $body;
    }

    /**
     * Creates the construct body
     *
     * @return string
     */
    protected function getContruct()
    {
        return '$this->service = $service;';
    }

    /**
     *
     * @return string
     */
    protected function getUpdateBody()
    {
        $filter = new CamelCaseToDash();
        
        $moduleName = $filter->filter(strtolower($this->moduleName));
        
        $body = 'parent::indexAction();' . "\n\n";
        
        $body .= '$request = $this->getRequest();' . "\n\n";
        
        $body .= '$id = $this->params()->fromRoute(\'id\');' . "\n\n";
        
        $body .= '$entity = $this->service->get($id);' . "\n\n";
        
        $body .= 'if(! $entity) {' . "\n";
        $body .= "\t" . '$this->flashMessenger()->addErrorMessage(\'Object was not found\');' . "\n";
        $body .= "\t" . 'return $this->redirect()->toRoute(\'' . $moduleName . '-index\');' . "\n";
        $body .= '}' . "\n\n";
        
        $body .= 'if ($request->isPost()) {' . "\n";
        $body .= "\t" . '$postData = $request->getPost();' . "\n\n";
        
        $body .= "\t" . '$this->form->setData($postData);' . "\n\n";
        
        $body .= "\t" . 'if ($this->form->isValid()) {' . "\n";
        $body .= "\t\t" . '$entity = $this->form->getData();' . "\n\n";
        
        $body .= "\t\t" . '$' . $moduleName . 'Entity = $this->service->save($entity);' . "\n\n";
        
        $body .= "\t\t" . '$this->getEventManager()->trigger(\'' . $moduleName . 'Create\', $this, array(' . "\n";
        $body .= "\t\t\t" . '\'authId\' => $this->identity()->getAuthId(),' . "\n";
        $body .= "\t\t\t" . '\'requestUrl\' => $this->getRequest()->getUri(),' . "\n";
        $body .= "\t\t\t" . '\'' . $moduleName . 'Entity\' => $entity' . "\n";
        $body .= "\t\t" . '));' . "\n\n";
        
        $body .= "\t\t" . '$this->flashMessenger()->addSuccessMessage(\'Object was saved\');' . "\n\n";
        
        $body .= "\t\t" . 'return $this->redirect()->toRoute(\'' . $moduleName . '-view\', array(' . "\n";
        $body .= "\t\t\t" . '\'id\' => $' . $moduleName . 'Entity->get' . $this->moduleName . 'Id()' . "\n";
        $body .= "\t\t" . '));' . "\n";
        $body .= "\t" . '}' . "\n";
        $body .= '}' . "\n\n";
        
        $body .= '$this->form->bind($entity);' . "\n\n";
        
        $body .= 'return new ViewModel(array(' . "\n";
        $body .= "\t" . '\'form\' => $this->form' . "\n";
        $body .= '));' . "\n";
        return $body;
    }

    /**
     *
     * @return string
     */
    protected function getCreateBody()
    {
        $filter = new CamelCaseToDash();
        
        $moduleName = $filter->filter(strtolower($this->moduleName));
        
        $body = 'parent::indexAction();' . "\n\n";
        
        $body .= '$request = $this->getRequest();' . "\n\n";
        
        $body .= 'if ($request->isPost()) {' . "\n";
        $body .= "\t" . '$postData = $request->getPost();' . "\n\n";
        
        $body .= "\t" . '$this->form->setData($postData);' . "\n\n";
        
        $body .= "\t" . 'if ($this->form->isValid()) {' . "\n";
        $body .= "\t\t" . '$entity = $this->form->getData();' . "\n\n";
        
        $body .= "\t\t" . '$' . $moduleName . 'Entity = $this->service->save($entity);' . "\n\n";
        
        $body .= "\t\t" . '$this->getEventManager()->trigger(\'' . $moduleName . 'Create\', $this, array(' . "\n";
        $body .= "\t\t\t" . '\'authId\' => $this->identity()->getAuthId(),' . "\n";
        $body .= "\t\t\t" . '\'requestUrl\' => $this->getRequest()->getUri(),' . "\n";
        $body .= "\t\t\t" . '\'' . $moduleName . 'Entity\' => $entity' . "\n";
        $body .= "\t\t" . '));' . "\n\n";
        
        $body .= "\t\t" . '$this->flashMessenger()->addSuccessMessage(\'Object was saved\');' . "\n\n";
        
        $body .= "\t\t" . 'return $this->redirect()->toRoute(\'' . $moduleName . '-view\', array(' . "\n";
        $body .= "\t\t\t" . '\'id\' => $' . $moduleName . 'Entity->get' . $this->moduleName . 'Id()' . "\n";
        $body .= "\t\t" . '));' . "\n";
        $body .= "\t" . '}' . "\n";
        $body .= '}' . "\n\n";
        
        $body .= 'return new ViewModel(array(' . "\n";
        $body .= "\t" . '\'form\' => $this->form' . "\n";
        $body .= '));' . "\n";
        
        return $body;
    }

    /**
     *
     * @return string
     */
    protected function getDeleteBody()
    {
        $filter = new CamelCaseToDash();
        
        $moduleName = $filter->filter(strtolower($this->moduleName));
        
        $body = 'parent::indexAction();' . "\n\n";
        
        $body .= '$id = $this->params()->fromRoute(\'id\');' . "\n\n";
        
        $body .= '$entity = $this->service->get($id);' . "\n\n";
        
        $body .= 'if (! $entity) {' . "\n";
        $body .= "\t" . '$this->flashmessenger()->addErrorMessage(\'Object was not found.\');' . "\n";
        $body .= "\t" . 'return $this->redirect()->toRoute(\'' . $moduleName . '-index\');' . "\n";
        $body .= '}' . "\n\n";
        
        $body .= '$request = $this->getRequest();' . "\n\n";
        
        $body .= 'if ($request->isPost()) {' . "\n";
        $body .= "\t" . '$del = $request->getPost(\'delete_confirmation\', \'no\');' . "\n";
        $body .= "\t" . 'if ($del === \'yes\') {' . "\n";
        $body .= "\t\t" . '$this->service->delete($entity);' . "\n\n";
        
        $body .= "\t\t" . '$this->getEventManager()->trigger(\'' . $moduleName . 'Delete\', $this, array(' . "\n";
        $body .= "\t\t\t" . '\'authId\' => $this->identity()->getAuthId(),' . "\n";
        $body .= "\t\t\t" . '\'requestUrl\' => $this->getRequest()->getUri(),' . "\n";
        $body .= "\t\t\t" . '\'' . $moduleName . 'Entity\' => $entity' . "\n";
        $body .= "\t\t" . '));' . "\n\n";
        
        $body .= "\t\t" . '$this->flashmessenger()->addSuccessMessage(\'Object was deleted\');' . "\n\n";
        
        $body .= "\t\t" . 'return $this->redirect()->toRoute(\'' . $moduleName . '-index\');' . "\n";
        $body .= "\t" . '}' . "\n\n";
        $body .= "\t" . 'return $this->redirect()->toRoute(\'' . $moduleName . '-view\', array(\'id\' => $id));' . "\n";
        $body .= '}' . "\n\n";
        
        $body .= 'return new ViewModel(array(' . "\n";
        $body .= "\t" . '\'entity\' => $entity' . "\n";
        $body .= '));';
        
        return $body;
    }

    /**
     *
     * @return string
     */
    protected function getViewBody()
    {
        $filter = new CamelCaseToDash();
        
        $moduleName = $filter->filter(strtolower($this->moduleName));
        
        $body = 'parent::indexAction();' . "\n\n";
        
        $body .= '$id = $this->params()->fromRoute(\'id\');' . "\n\n";
        
        $body .= '$entity = $this->service->get($id);' . "\n\n";
        
        $body .= 'if(! $entity) {' . "\n";
        $body .= "\t" . '$this->flashMessenger()->addErrorMessage(\'Object was not found\');' . "\n";
        $body .= "\t" . 'return $this->redirect()->toRoute(\'' . $moduleName . '-index\');' . "\n";
        $body .= '}' . "\n\n";
        
        $body .= '$this->getEventManager()->trigger(\'' . $moduleName . 'View\', $this, array(' . "\n";
        $body .= "\t" . '\'authId\' => $this->identity()->getAuthId(),' . "\n";
        $body .= "\t" . '\'requestUrl\' => $this->getRequest()->getUri(),' . "\n";
        $body .= "\t" . '\'' . $moduleName . 'Entity\' => $entity' . "\n";
        $body .= '));' . "\n\n";
        
        $body .= 'return new ViewModel(array(' . "\n";
        $body .= "\t" . '\'entity\' => $entity' . "\n";
        $body .= '));';
        
        return $body;
    }

    /**
     *
     * @return string
     */
    protected function getIndexBody()
    {
        $filter = new CamelCaseToDash();
        
        $moduleName = $filter->filter(strtolower($this->moduleName));
        
        $body = 'parent::indexAction();' . "\n\n";
        
        $body .= '$this->getEventManager()->trigger(\'' . $moduleName . 'Index\', $this, array(' . "\n";
        $body .= "\t" . '\'authId\' => $this->identity()->getAuthId(),' . "\n";
        $body .= "\t" . '\'requestUrl\' => $this->getRequest()->getUri()' . "\n";
        $body .= '));' . "\n\n";
        
        $body .= '$filter = array(' . "\n";
        $body .= "\t" . '\'page\' => $this->page,' . "\n";
        $body .= "\t" . '\'count-per-page\' => $this->countPerPage' . "\n";
        $body .= ');' . "\n\n";
        
        $body .= '$paginator = $this->service->getAll($filter);' . "\n\n";
        
        $body .= '$paginator->setCurrentPageNumber($filter[\'page\']);' . "\n\n";
        
        $body .= '$paginator->setItemCountPerPage($filter[\'count-per-page\']);' . "\n\n";
        
        $body .= 'return new ViewModel(array(' . "\n";
        $body .= "\t" . '\'paginator\' => $paginator,' . "\n";
        $body .= "\t" . '\'page\' => $filter[\'page\'],' . "\n";
        $body .= "\t" . '\'count-per-page\' => $filter[\'count-per-page\'],' . "\n";
        $body .= "\t" . '\'itemCount\' => $paginator->getTotalItemCount(),' . "\n";
        $body .= "\t" . '\'pageCount\' => $paginator->count(),' . "\n";
        $body .= "\t" . '\'queryParams\' => $this->params()->fromQuery(),' . "\n";
        $body .= "\t" . '\'routeParams\' => $this->params()->fromRoute()' . "\n";
        $body .= '));';
        
        return $body;
    }

    /**
     * Creates the factory class and writes it to disk
     *
     * @param string $name
     *            The factory class name
     * @param string $filename
     *            The factory file name
     * @param string $controller
     *            The controller name
     * @param boolean $includeForm
     *            If we include the form in the body
     */
    protected function createFactory($name, $filename, $controller, $includeForm = false)
    {
        $this->factory = new ClassGenerator();
        
        $this->factory->setNamespaceName($this->factoryNamespace);
        
        $this->factory->setName($name);
        
        $this->factory->addUse('Zend\ServiceManager\ServiceLocatorInterface');
        
        $this->factory->addUse($this->moduleName . '\Controller\\' . $controller);
        
        $dockBlock = new DocBlockGenerator();
        
        $dockBlock->setTags(array(
            new ParamTag('serviceLocator', 'ServiceLocatorInterface'),
            new ReturnTag('\\' . $this->moduleName . '\Controller\\' . $controller)
        ));
        
        $body = '$realServiceLocator = $serviceLocator->getServiceLocator();' . "\n\n";
        $body .= '$service = $realServiceLocator->get(\'' . $this->moduleName . '\Service\ServiceInterface\');' . "\n\n";
        
        if ($includeForm) {
            $body .= '$form = $realServiceLocator->get(\'' . $this->moduleName . '\Form\Form\');' . "\n\n";
            $body .= 'return new ' . $controller . '($service, $form);' . "\n\n";
        } else {
            $body .= 'return new ' . $controller . '($service);' . "\n\n";
        }
        
        $this->factory->addMethod('__invoke', array(
            new ParameterGenerator('serviceLocator', 'ServiceLocatorInterface')
        ), $this->public, $body, $dockBlock);
        
        $this->writeFactoryFile($filename);
    }

    /**
     * Writes class file to disk
     *
     * @param srting $filename            
     */
    protected function writeClassFile($filename)
    {
        // write file
        $file = new FileGenerator(array(
            'classes' => array(
                $this->code
            )
        ));
        
        file_put_contents($this->moduleDir . '/Controller/' . $filename, $file->generate());
    }

    /**
     * Writes factory file to disk
     *
     * @param string $filename            
     */
    protected function writeFactoryFile($filename)
    {
        // write file
        $file = new FileGenerator(array(
            'classes' => array(
                $this->factory
            )
        ));
        
        file_put_contents($this->moduleDir . '/Controller/Factory/' . $filename, $file->generate());
    }
}

