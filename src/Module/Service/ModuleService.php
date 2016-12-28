<?php
namespace Module\Service;

use Zend\Filter\Word\CamelCaseToDash;
use Zend\Filter\Word\CamelCaseToUnderscore;
use Zend\Code\Generator\ClassGenerator;
use Zend\Code\Generator\MethodGenerator;
use Zend\Code\Generator\FileGenerator;

class ModuleService implements ModuleServiceInterface
{

    /**
     *
     * @var ControllerServiceInterface
     */
    protected $controllerService;

    /**
     *
     * @var EntityServiceInterface
     */
    protected $entityService;

    /**
     *
     * @var FormServiceInterface
     */
    protected $formService;

    /**
     *
     * @var HydratorServiceInterface
     */
    protected $hydratorService;

    /**
     *
     * @var MapperServiceInterface
     */
    protected $mapperService;

    /**
     *
     * @var ServiceServiceInterface
     */
    protected $serviceService;

    /**
     *
     * @var ViewServiceInterface
     */
    protected $viewService;

    protected $actionService;
    /**
     *
     * @param ControllerServiceInterface $controllerService            
     * @param EntityServiceInterface $entityService            
     * @param HydratorServiceInterface $hydratorService            
     * @param FormServiceInterface $formService            
     * @param MapperServiceInterface $mapperService            
     * @param ServiceServiceInterface $serviceService            
     * @param ViewServiceInterface $viewService            
     */
    public function __construct(ControllerServiceInterface $controllerService, EntityServiceInterface $entityService, HydratorServiceInterface $hydratorService, FormServiceInterface $formService, MapperServiceInterface $mapperService, ServiceServiceInterface $serviceService, ViewServiceInterface $viewService)
    {
        $this->controllerService = $controllerService;
        
        $this->entityService = $entityService;
        
        $this->hydratorService = $hydratorService;
        
        $this->formService = $formService;
        
        $this->mapperService = $mapperService;
        
        $this->serviceService = $serviceService;
        
        $this->viewService = $viewService;
    }

    /**
     *
     * {@inheritdoc}
     *
     * @see \Module\Service\ModuleServiceInterface::createFolders()
     */
    public function createFolders($moduleDir, $moduleName)
    {
        if (is_dir($moduleDir)) {
            throw new \Exception("Directiry {$moduleDir} is not empty");
        }
        
        $filter = new CamelCaseToDash();
        
        mkdir($moduleDir . '/config', 0775, true);
        
        mkdir($moduleDir . '/doc', 0775, true);
        
        mkdir($moduleDir . '/language', 0775, true);
        
        mkdir($moduleDir . '/sql', 0775, true);
        
        mkdir($moduleDir . '/test', 0775, true);
        
        $viewDir = $moduleDir . '/view';
        
        $moduleDir = $moduleDir . '/src/' . $moduleName;
        
        // module directory
        mkdir($moduleDir);
        
        // controller directory
        mkdir($moduleDir . '/Controller' . '/Factory', 0775, true);
        
        // entity
        mkdir($moduleDir . '/Entity');
        
        // form
        mkdir($moduleDir . '/Form' . '/Factory', 0775, true);
        
        // hydrator
        mkdir($moduleDir . '/Hydrator', 0775, true);
        
        // listener
        mkdir($moduleDir . '/Listener' . '/Factory', 0775, true);
        
        // mapper
        mkdir($moduleDir . '/Mapper' . '/Factory', 0775, true);
        
        // service
        mkdir($moduleDir . '/Service' . '/Factory', 0775, true);
        
        // view
        mkdir($moduleDir . '/View' . '/Helper' . '/Factory', 0775, true);
        
        mkdir($viewDir . '/partials', 0775, true);
        
        mkdir($viewDir . '/' . strtolower($filter->filter($moduleName)) . '/create', 0775, true);
        
        mkdir($viewDir . '/' . strtolower($filter->filter($moduleName)) . '/delete', 0775, true);
        
        mkdir($viewDir . '/' . strtolower($filter->filter($moduleName)) . '/index', 0775, true);
        
        mkdir($viewDir . '/' . strtolower($filter->filter($moduleName)) . '/update', 0775, true);
        
        mkdir($viewDir . '/' . strtolower($filter->filter($moduleName)) . '/view', 0775, true);
        
        return $this;
    }

    /**
     *
     * {@inheritdoc}
     *
     * @see \Module\Service\ModuleServiceInterface::createModule()
     */
    public function createModule($moduleName)
    {
        $baseDir = getcwd() . '/module';
        
        if (! is_writable($baseDir)) {
            throw new \Exception("Module directory {$baseDir} is not writeable");
        }
        
        $moduleDir = $baseDir . '/' . $moduleName;
        
        // create folders and config
        $this->createFolders($moduleDir, $moduleName);
        
        // create files
        $this->createComposer($moduleDir, $moduleName)
            ->createConduct($moduleDir, $moduleName)
            ->createConfig($moduleDir, $moduleName)
            ->createContributing($moduleDir, $moduleName)
            ->createLicense($moduleDir, $moduleName)
            ->createModuleFile($moduleDir, $moduleName)
            ->createPhpUnit($moduleDir, $moduleName)
            ->createReadMe($moduleDir, $moduleName)
            ->createTodo($moduleDir, $moduleName)
            ->createSqlFile($moduleDir, $moduleName);
        
        // create controllers
        $this->controllerService->createController($moduleDir, $moduleName);
        
        // create entity
        $this->entityService->createEntity($moduleDir, $moduleName);
        
        // create form
        $this->formService->createForm($moduleDir, $moduleName);
        
        // create hydrator
        $this->hydratorService->createHydrator($moduleDir, $moduleName);
        
        // create mapper
        $this->mapperService->createMapper($moduleDir, $moduleName);
        
        // create service
        $this->serviceService->createService($moduleDir, $moduleName);
        
        // create views
        $this->viewService->createActions($moduleDir, $moduleName);
    }

    /**
     *
     * {@inheritdoc}
     *
     * @see \Module\Service\ModuleServiceInterface::createCongig()
     */
    public function createConfig($moduleDir, $moduleName)
    {
        $filter = new CamelCaseToDash();
        
        $sqlFileName = strtolower($filter->filter($moduleName)) . '.sql';
        
        $viewName = strtolower($filter->filter($moduleName));
        
        $moduleName = ucfirst($moduleName);
        
        $content = "<?php 
return array(
    'module' => array(
        '{$moduleName}' => array(
            'name' => '{$moduleName}',
            'version' => '1.0.0',
            'install' => array(
                'require' => array(),
                'sql' => 'sql/{$sqlFileName}'
            )
        )
    ),
    'controllers' => array(
        'factories' => array(
            '{$moduleName}\Controller\ConsoleController' => '{$moduleName}\Controller\Factory\ConsoleControllerFactory',
            '{$moduleName}\Controller\CreateController' => '{$moduleName}\Controller\Factory\CreateControllerFactory',
            '{$moduleName}\Controller\DeleteController' => '{$moduleName}\Controller\Factory\DeleteControllerFactory',
            '{$moduleName}\Controller\IndexController' => '{$moduleName}\Controller\Factory\IndexControllerFactory',
            '{$moduleName}\Controller\RestController' => '{$moduleName}\Controller\Factory\RestControllerFactory',
            '{$moduleName}\Controller\UpdateController' => '{$moduleName}\Controller\Factory\UpdateControllerFactory',
            '{$moduleName}\Controller\ViewController' => '{$moduleName}\Controller\Factory\ViewControllerFactory'
        )
    ),
    'service_manager' => array(
        'factories' => array(
            '{$moduleName}\Service\ServiceInterface' => '{$moduleName}\Service\Factory\ServiceFactory',
            '{$moduleName}\Mapper\MysqlMapperInterface' => '{$moduleName}\Mapper\Factory\MysqlMapperFactory',
            '{$moduleName}\Form\Form' => '{$moduleName}\Form\Factory\FormFactory',
        )
    ),
    'router' => array(
        'routes' => array(
            '{$viewName}-create' => array(
                'pageTitle' => '{$moduleName}',
                'pageSubTitle' => 'New',
                'activeMenuItem' => 'admin-index',
                'activeSubMenuItem' => '{$viewName}-index',
                'icon' => 'fa fa-gear',
                'layout' => 'admin',
                'type' => 'literal',
                'options' => array(
                    'route' => '/admin/{$viewName}/create',
                    'defaults' => array(
                        'controller' => '{$moduleName}\Controller\CreateController',
                        'action' => 'index'
                    )
                )
            ),
            '{$viewName}-delete' => array(
                'pageTitle' => '{$moduleName}',
                'pageSubTitle' => 'Delete',
                'activeMenuItem' => 'admin-index',
                'activeSubMenuItem' => '{$viewName}-index',
                'icon' => 'fa fa-gear',
                'layout' => 'admin',
                'type' => 'segment',
                'options' => array(
                    'route' => '/admin/{$viewName}/delete/[:id]',
                    'defaults' => array(
                        'controller' => '{$moduleName}\Controller\DeleteController',
                        'action' => 'index'
                    )
                )
            ),
            '{$viewName}-index' => array(
                'pageTitle' => '{$moduleName}',
                'pageSubTitle' => 'Home',
                'activeMenuItem' => 'admin-index',
                'activeSubMenuItem' => '{$viewName}-index',
                'icon' => 'fa fa-gear',
                'layout' => 'admin',
                'type' => 'literal',
                'options' => array(
                    'route' => '/admin/{$viewName}',
                    'defaults' => array(
                        'controller' => '{$moduleName}\Controller\IndexController',
                        'action' => 'index'
                    )
                )
            ),
            '{$viewName}-rest' => array(
                'pageTitle' => '{$moduleName}',
                'pageSubTitle' => 'Rest',
                'activeMenuItem' => 'admin-index',
                'activeSubMenuItem' => '{$viewName}-index',
                'icon' => 'fa fa-gear',
                'layout' => 'rest',
                'type' => 'segment',
                'options' => array(
                    'route' => '/api/{$viewName}[/:id]',
                    'defaults' => array(
                        'controller' => '{$moduleName}\Controller\RestController'
                    )
                )
            ),
            '{$viewName}-update' => array(
                'pageTitle' => '{$moduleName}',
                'pageSubTitle' => 'Edit',
                'activeMenuItem' => 'admin-index',
                'activeSubMenuItem' => '{$viewName}-index',
                'icon' => 'fa fa-gear',
                'layout' => 'admin',
                'type' => 'segment',
                'options' => array(
                    'route' => '/admin/{$viewName}/update/[:id]',
                    'defaults' => array(
                        'controller' => '{$moduleName}\Controller\UpdateController',
                        'action' => 'index'
                    )
                )
            ),
            '{$viewName}-view' => array(
                'pageTitle' => '{$moduleName}',
                'pageSubTitle' => 'View',
                'activeMenuItem' => 'admin-index',
                'activeSubMenuItem' => '{$viewName}-index',
                'icon' => 'fa fa-gear',
                'layout' => 'admin',
                'type' => 'segment',
                'options' => array(
                    'route' => '/admin/{$viewName}/view/[:id]',
                    'defaults' => array(
                        'controller' => '{$moduleName}\Controller\ViewController',
                        'action' => 'index'
                    )
                )
            )
        )
    ),
    'console' => array(
        'router' => array(
            'routes' => array(
                '{$viewName}-console-index' => array(
                    'options' => array(
                        'route' => '{$viewName}',
                        'defaults' => array(
                            'controller' => '{$moduleName}\Controller\ConsoleController',
                            'action' => 'index'
                        )
                    )
                )
            )
        ),
    ),
    'view_manager' => array(
        'template_path_stack' => array(
            __DIR__ . '/../view'
        )
    ),
    'acl' => array(
        'default' => array(
            'guest' => array(),
            'administrator' => array(
                '{$viewName}-create',
                '{$viewName}-delete',
                '{$viewName}-index',
                '{$viewName}-update',
                '{$viewName}-view'
            )
        )
    ),
    'menu' => array(
        'default' => array(
            array(
                'key' => 'admin',
                'name' => 'Admin',
                'icon' => 'fa fa-gear',
                'order' => 99,
                'active' => true,
                'location' => 'left',
                'items' => array(
                    array(
                        'key' => '{$viewName}-index',
                        'name' => '{$moduleName}',
                        'route' => '{$viewName}-index',
                        'icon' => 'fa fa-gear',
                        'order' => 100,
                        'active' => true
                    )
                )
            )
        )
    ),
    'navigation' => array(
        'default' => array(
            array(
                'label' => 'Admin',
                'route' => 'admin-index',
                'useRouteMatch' => true,
                'pages' => array(
                    array(
                        'label' => '{$moduleName}',
                        'route' => '{$viewName}-index',
                        'useRouteMatch' => true,
                        'pages' => array(
                            array(
                                'label' => 'View',
                                'route' => '{$viewName}-view',
                                'useRouteMatch' => true,
                                'pages' => array(
                                    array(
                                        'label' => 'Edit',
                                        'route' => '{$viewName}-update',
                                        'useRouteMatch' => true,
                                    ),
                                    array(
                                        'label' => 'Delete',
                                        'route' => '{$viewName}-delete',
                                        'useRouteMatch' => true,
                                    )
                                )
                            ),
                            array(
                                'label' => 'New',
                                'route' => '{$viewName}-create',
                                'useRouteMatch' => true,
                            )
                        )
                    )
                )
            )
        )
    )
);";
        
        file_put_contents($moduleDir . '/config/module.config.php', $content);
        
        return $this;
    }

    /**
     *
     * {@inheritdoc}
     *
     * @see \Module\Service\ModuleServiceInterface::createComposer()
     */
    public function createComposer($moduleDir, $moduleName)
    {
        $filter = new CamelCaseToDash();
        
        $moduleName = strtolower($filter->filter($moduleName));
        
        $content = '{
  "name" : "pacificnm/pacificnm-' . $moduleName . '",
  "description" : "Pacific NM module",
  "version" : "1.0.0",
  "require" : {
    "php" : ">=5.6",
    "zendframework/zendframework" : "~2.5"
  },
  "license" : "BSD-3-Clause",
  "keywords" : [ "PacificNM", "Pacific Network Management" ],
  "homepage" : "http://www.pacificnm.com"
}';
        
        file_put_contents($moduleDir . '/composer.json', $content);
        
        return $this;
    }

    /**
     *
     * {@inheritdoc}
     *
     * @see \Module\Service\ModuleServiceInterface::createConduct()
     */
    public function createConduct($moduleDir)
    {
        $content = file_get_contents(getcwd() . '/CONDUCT.md');
        
        file_put_contents($moduleDir . '/CONDUCT.md', $content);
        
        return $this;
    }

    /**
     *
     * {@inheritdoc}
     *
     * @see \Module\Service\ModuleServiceInterface::createContributing()
     */
    public function createContributing($moduleDir)
    {
        $content = file_get_contents(getcwd() . '/CONTRIBUTING.md');
        
        file_put_contents($moduleDir . '/CONTRIBUTING.md', $content);
        
        return $this;
    }

    /**
     *
     * {@inheritdoc}
     *
     * @see \Module\Service\ModuleServiceInterface::createLicense()
     */
    public function createLicense($moduleDir)
    {
        $content = file_get_contents(getcwd() . '/LICENSE.md');
        
        file_put_contents($moduleDir . '/LICENSE.md', $content);
        
        return $this;
    }

    /**
     *
     * {@inheritdoc}
     *
     * @see \Module\Service\ModuleServiceInterface::createModuleFile()
     */
    public function createModuleFile($moduleDir, $moduleName)
    {
        $code = new ClassGenerator();
        
        $code->setNamespaceName($moduleName);
        
        $code->setName('Module');
        
        $getConfig = "return include __DIR__ . '/config/module.config.php';";
        
        $getAutoloaderConfig = "return array(
    'Zend\Loader\StandardAutoloader' => array(
        'namespaces' => array(
            __NAMESPACE__ => __DIR__ . '/src/' . __NAMESPACE__,
        ),
    ),
);";
        $getConsoleUsage = "return array();";
        
        $code->addMethods(array(
            new MethodGenerator('getConsoleUsage', array(), MethodGenerator::FLAG_PUBLIC, $getConsoleUsage),
            new MethodGenerator('getConfig', array(), MethodGenerator::FLAG_PUBLIC, $getConfig),
            new MethodGenerator('getAutoloaderConfig', array(), MethodGenerator::FLAG_PUBLIC, $getAutoloaderConfig)
        ));
        
        $file = new FileGenerator(array(
            'classes' => array(
                $code
            )
        ));
        
        file_put_contents($moduleDir . '/Module.php', $file->generate());
        
        return $this;
    }

    /**
     *
     * {@inheritdoc}
     *
     * @see \Module\Service\ModuleServiceInterface::createPhpUnit()
     */
    public function createPhpUnit($moduleDir, $moduleName)
    {
        $content = '<?xml version="1.0" encoding="UTF-8"?>
<phpunit colors="true">
    <testsuites>
        <testsuite name="Pacificnm ' . $moduleName . ' Resource Test Suite">
            <directory>./module/' . $moduleName . '/test</directory>
        </testsuite>
    </testsuites>
</phpunit>';
        
        file_put_contents($moduleDir . '/phpunit.xml.dst', $content);
        
        return $this;
    }

    /**
     *
     * {@inheritdoc}
     *
     * @see \Module\Service\ModuleServiceInterface::createReadMe()
     */
    public function createReadMe($moduleDir, $moduleName)
    {
        $filter = new CamelCaseToDash();
        
        $moduleName = strtolower($filter->filter($moduleName));
        
        $content = "# pacificnm-{$moduleName}\n
File issues at https://github.com/pacificnm/pacificnm-{$moduleName}/issues\n
Documentation is at https://github.com/pacificnm/pacificnm-{$moduleName}\n";
        
        file_put_contents($moduleDir . '/README.md', $content);
        
        return $this;
    }

    /**
     *
     * {@inheritdoc}
     *
     * @see \Module\Service\ModuleServiceInterface::createTodo()
     */
    public function createTodo($moduleDir)
    {
        $content = "# TODO\n
This is a TODO list.\n
## Documentation";
        
        file_put_contents($moduleDir . '/TODO.md', $content);
        
        return $this;
    }

    /**
     *
     * {@inheritdoc}
     *
     * @see \Module\Service\ModuleServiceInterface::createSqlFile()
     */
    public function createSqlFile($moduleDir, $moduleName)
    {
        $filter = new CamelCaseToDash();
        
        $sqlFilter = new CamelCaseToUnderscore($moduleName);
        
        $sqlFileName = strtolower($sqlFilter->filter($moduleName)) . '.sql';
        
        $moduleName = strtolower($filter->filter($moduleName));
        
        $content = "-- {$moduleName} sql file\n";
        
        file_put_contents($moduleDir . '/sql/' . $sqlFileName, $content);
        
        return $this;
    }
}

