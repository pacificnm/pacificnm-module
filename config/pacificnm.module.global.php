<?php
return array(
    'module' => array(
        'Module' => array(
            'name' => 'Module',
            'version' => '1.0.5',
            'install' => array(
                'require' => array(),
                'sql' => 'sql/module.sql'
            )
        )
    ),
    'controllers' => array(
        'factories' => array(
            'Pacificnm\Module\Controller\ConsoleController' => 'Pacificnm\Module\Controller\Factory\ConsoleControllerFactory',
            'Pacificnm\Module\Controller\CreateController' => 'Pacificnm\Module\Controller\Factory\CreateControllerFactory',
            'Pacificnm\Module\Controller\DeleteController' => 'Pacificnm\Module\Controller\Factory\DeleteControllerFactory',
            'Pacificnm\Module\Controller\IndexController' => 'Pacificnm\Module\Controller\Factory\IndexControllerFactory',
            'Pacificnm\Module\Controller\RestController' => 'Pacificnm\Module\Controller\Factory\RestControllerFactory',
            'Pacificnm\Module\Controller\UpdateController' => 'Pacificnm\Module\Controller\Factory\UpdateControllerFactory',
            'Pacificnm\Module\Controller\ViewController' => 'Pacificnm\Module\Controller\Factory\ViewControllerFactory'
        )
    ),
    'service_manager' => array(
        'factories' => array(
            'Pacificnm\Module\Mapper\MysqlMapperInterface' => 'Pacificnm\Module\Mapper\Factory\MysqlMapperFactory',
            'Pacificnm\Module\Service\ServiceInterface' => 'Pacificnm\Module\Service\Factory\ServiceFactory',
            'Pacificnm\Module\Form\Form' => 'Pacificnm\Module\Form\Factory\FormFactory',
            'Pacificnm\Module\Listener\Listener' => 'Pacificnm\Module\Listener\Factory\ListenerFactory',
            'Pacificnm\Module\Service\ControllerServiceInterface' => 'Pacificnm\Module\Service\Factory\ControllerServiceFactory',
            'Pacificnm\Module\Service\EntityServiceInterface' => 'Pacificnm\Module\Service\Factory\EntityServiceFactory',
            'Pacificnm\Module\Service\FormServiceInterface' => 'Pacificnm\Module\Service\Factory\FormServiceFactory',
            'Pacificnm\Module\Service\HydratorServiceInterface' => 'Pacificnm\Module\Service\Factory\HydratorServiceFactory',
            'Pacificnm\Module\Service\MapperServiceInterface' => 'Pacificnm\Module\Service\Factory\MapperServiceFactory',
            'Pacificnm\Module\Service\ModuleServiceInterface' => 'Pacificnm\Module\Service\Factory\ModuleServiceFactory',
            'Pacificnm\Module\Service\ServiceServiceInterface' => 'Pacificnm\Module\Service\Factory\ServiceServiceFactory',
            'Pacificnm\Module\Service\ViewServiceInterface' => 'Pacificnm\Module\Service\Factory\ViewServiceFactory',
        )
    ),
    'router' => array(
        'routes' => array(
            'module-create' => array(
                'pageTitle' => 'Module',
                'pageSubTitle' => 'New',
                'activeMenuItem' => 'admin-index',
                'activeSubMenuItem' => 'module-index',
                'icon' => 'fa fa-cogs',
                'layout' => 'admin',
                'type' => 'literal',
                'options' => array(
                    'route' => '/admin/module/create',
                    'defaults' => array(
                        'controller' => 'Pacificnm\Module\Controller\CreateController',
                        'action' => 'index'
                    )
                )
            ),
            'module-delete' => array(
                'pageTitle' => 'Module',
                'pageSubTitle' => 'Delete',
                'activeMenuItem' => 'admin-index',
                'activeSubMenuItem' => 'module-index',
                'icon' => 'fa fa-cogs',
                'layout' => 'admin',
                'type' => 'segment',
                'options' => array(
                    'route' => '/admin/module/delete/[:id]',
                    'defaults' => array(
                        'controller' => 'Pacificnm\Module\Controller\DeleteController',
                        'action' => 'index'
                    )
                )
            ),
            'module-index' => array(
                'pageTitle' => 'Module',
                'pageSubTitle' => 'Home',
                'activeMenuItem' => 'admin-index',
                'activeSubMenuItem' => 'module-index',
                'icon' => 'fa fa-cogs',
                'layout' => 'admin',
                'type' => 'literal',
                'options' => array(
                    'route' => '/admin/module',
                    'defaults' => array(
                        'controller' => 'Pacificnm\Module\Controller\IndexController',
                        'action' => 'index'
                    )
                )
            ),
            'module-rest' => array(
                'pageTitle' => 'Module',
                'pageSubTitle' => 'Rest',
                'activeMenuItem' => 'admin-index',
                'activeSubMenuItem' => 'module-index',
                'icon' => 'fa fa-cogs',
                'layout' => 'rest',
                'type' => 'literal',
                'options' => array(
                    'route' => '/api/module[/:id]',
                    'defaults' => array(
                        'controller' => 'Pacificnm\Module\Controller\RestController',
                    ),
                    'constraints' => array(
                        'id' => '[0-9]+'
                    )
                )
            ),
            'module-update' => array(
                'pageTitle' => 'Module',
                'pageSubTitle' => 'Edit',
                'activeMenuItem' => 'admin-index',
                'activeSubMenuItem' => 'module-index',
                'icon' => 'fa fa-cogs',
                'layout' => 'admin',
                'type' => 'segment',
                'options' => array(
                    'route' => '/admin/module/update/[:id]',
                    'defaults' => array(
                        'controller' => 'Pacificnm\Module\Controller\UpdateController',
                        'action' => 'index'
                    )
                )
            ),
            'module-view' => array(
                'pageTitle' => 'Module',
                'pageSubTitle' => 'View',
                'activeMenuItem' => 'admin-index',
                'activeSubMenuItem' => 'module-index',
                'icon' => 'fa fa-cogs',
                'layout' => 'admin',
                'type' => 'segment',
                'options' => array(
                    'route' => '/admin/module/view/[:id]',
                    'defaults' => array(
                        'controller' => 'Pacificnm\Module\Controller\ViewController',
                        'action' => 'index'
                    )
                )
            )
        )
    ),
    'console' => array(
        'router' => array(
            'routes' => array(
                'module-console-index' => array(
                    'options' => array(
                        'route' => 'module --list',
                        'defaults' => array(
                            'controller' => 'Pacificnm\Module\Controller\ConsoleController',
                            'action' => 'index'
                        )
                    )
                ),
                'module-console-view' => array(
                    'options' => array(
                        'route' => 'module --view [--id=]',
                        'defaults' => array(
                            'controller' => 'Pacificnm\Module\Controller\ConsoleController',
                            'action' => 'view'
                        )
                    )
                )
            )
        )
    ),
    'view_manager' => array(
        'controller_map' => array(
            'Pacificnm\Module' => true
        ),
        'template_map' => array(
            'pacificnm/module/create/index' => __DIR__ . '/../view/module/create/index.phtml',
            'pacificnm/module/delete/index' => __DIR__ . '/../view/module/delete/index.phtml',
            'pacificnm/module/index/index' => __DIR__ . '/../view/module/index/index.phtml',
            'pacificnm/module/update/index' => __DIR__ . '/../view/module/update/index.phtml',
            'pacificnm/module/view/index' => __DIR__ . '/../view/module/view/index.phtml'
        ),
        'template_path_stack' => array(
            __DIR__ . '/../view'
        )
    ),
    'view_helpers' => array(
        'factories' => array(
            'ModuleSearchForm' => 'Pacificnm\Module\View\Helper\Factory\ModuleSearchFormFactory'
        )
    ),
    'acl' => array(
        'default' => array(
            'guest' => array(),
            'user' => array(),
            'administrator' => array(
                'module-create',
                'module-delete',
                'module-index',
                'module-update',
                'module-view'
            )
        )
    ),
    'menu' => array(
        'default' => array(
            array(
                'name' => 'Admin',
                'route' => 'admin-index',
                'icon' => 'fa fa-gear',
                'order' => 99,
                'location' => 'left',
                'active' => true,
                'items' => array(
                    array(
                        'name' => 'Module',
                        'route' => 'module-index',
                        'icon' => 'fa fa-cogs',
                        'order' => 7,
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
                        'label' => 'Modules',
                        'route' => 'module-index',
                        'useRouteMatch' => true,
                        'pages' => array(
                            array(
                                'label' => 'View',
                                'route' => 'module-view',
                                'useRouteMatch' => true,
                                'pages' => array(
                                    array(
                                        'label' => 'Edit',
                                        'route' => 'module-update',
                                        'useRouteMatch' => true,
                                    ),
                                    array(
                                        'label' => 'Delete',
                                        'route' => 'module-delete',
                                        'useRouteMatch' => true,
                                    )
                                )
                            ),
                            array(
                                'label' => 'New',
                                'route' => 'module-create',
                                'useRouteMatch' => true,
                            )
                        )
                    )
                )
            )
        )
    )
);