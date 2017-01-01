<?php
namespace Pacificnm\Module\Service;

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
        
        $moduleDir = $moduleDir . '/src/';
        
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
        $baseDir = getcwd() . '/vendor/pacificnm';
        
        $filter = new CamelCaseToDash();
        
        if (! is_writable($baseDir)) {
            throw new \Exception("Module directory {$baseDir} is not writeable");
        }
        
        $moduleDir = $baseDir . '/pacificnm-' . strtolower($filter->filter($moduleName));
        
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
            'Pacificnm\\{$moduleName}\Controller\ConsoleController' => 'Pacificnm\\{$moduleName}\Controller\Factory\ConsoleControllerFactory',
            'Pacificnm\\{$moduleName}\Controller\CreateController' => 'Pacificnm\\{$moduleName}\Controller\Factory\CreateControllerFactory',
            'Pacificnm\\{$moduleName}\Controller\DeleteController' => 'Pacificnm\\{$moduleName}\Controller\Factory\DeleteControllerFactory',
            'Pacificnm\\{$moduleName}\Controller\IndexController' => 'Pacificnm\\{$moduleName}\Controller\Factory\IndexControllerFactory',
            'Pacificnm\\{$moduleName}\Controller\RestController' => 'Pacificnm\\{$moduleName}\Controller\Factory\RestControllerFactory',
            'Pacificnm\\{$moduleName}\Controller\UpdateController' => 'Pacificnm\\{$moduleName}\Controller\Factory\UpdateControllerFactory',
            'Pacificnm\\{$moduleName}\Controller\ViewController' => 'Pacificnm\\{$moduleName}\Controller\Factory\ViewControllerFactory'
        )
    ),
    'service_manager' => array(
        'factories' => array(
            'Pacificnm\\{$moduleName}\Service\ServiceInterface' => 'Pacificnm\\{$moduleName}\Service\Factory\ServiceFactory',
            'Pacificnm\\{$moduleName}\Mapper\MysqlMapperInterface' => 'Pacificnm\\{$moduleName}\Mapper\Factory\MysqlMapperFactory',
            'Pacificnm\\{$moduleName}\Form\Form' => 'Pacificnm\\{$moduleName}\Form\Factory\FormFactory',
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
                        'controller' => 'Pacificnm\\{$moduleName}\Controller\CreateController',
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
                        'controller' => 'Pacificnm\\{$moduleName}\Controller\DeleteController',
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
                        'controller' => 'Pacificnm\\{$moduleName}\Controller\IndexController',
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
                        'controller' => 'Pacificnm\\{$moduleName}\Controller\RestController'
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
                        'controller' => 'Pacificnm\\{$moduleName}\Controller\UpdateController',
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
                        'controller' => 'Pacificnm\\{$moduleName}\Controller\ViewController',
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
                            'controller' => 'Pacificnm\\{$moduleName}\Controller\ConsoleController',
                            'action' => 'index'
                        )
                    )
                )
            )
        ),
    ),
    'view_manager' => array(
        'controller_map' => array(
            'Pacificnm\\{$moduleName}' => true
        ),
        'template_map' => array(
            'pacificnm/{$viewName}/create/index' => __DIR__ . '/../view/{$viewName}/create/index.phtml',
            'pacificnm/{$viewName}/delete/index' => __DIR__ . '/../view/{$viewName}/delete/index.phtml',
            'pacificnm/{$viewName}/index/index' => __DIR__ . '/../view/{$viewName}/index/index.phtml',
            'pacificnm/{$viewName}/update/index' => __DIR__ . '/../view/{$viewName}/update/index.phtml',
            'pacificnm/{$viewName}/view/index' => __DIR__ . '/../view/{$viewName}/view/index.phtml'
        ),
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
        
        file_put_contents($moduleDir . '/config/pacificnm.'.$viewName.'.global.php', $content);
        
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
        $filter = new CamelCaseToDash();
        
        $configName = strtolower($filter->filter($moduleName));
        
        $code = new ClassGenerator();
        
        $code->setNamespaceName('Pacificnm\\'.ucfirst($moduleName));
        
        $code->setName('Module');
        
        $getConfig = "return include __DIR__ . '/../config/pacificnm.{$configName}.global.php';";
        
        $getAutoloaderConfig = "return array(
    'Zend\Loader\StandardAutoloader' => array(
        'namespaces' => array(
            __NAMESPACE__ => __DIR__ . '/src/'
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
        
        file_put_contents($moduleDir . '/src/Module.php', $file->generate());
        
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

