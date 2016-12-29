<?php
return array(
    'module' => array(
        'Module' => array(
            'name' => 'Module',
            'version' => '1.0.4',
            'install' => array(
                'require' => array(),
                'sql' => 'sql/module.sql'
            )
        )
    ),
    'controllers' => array(
        'factories' => array(
            'Module\Controller\ConsoleController' => 'Module\Controller\Factory\ConsoleControllerFactory',
            'Module\Controller\CreateController' => 'Module\Controller\Factory\CreateControllerFactory',
            'Module\Controller\IndexController' => 'Module\Controller\Factory\IndexControllerFactory',
            'Module\Controller\RestController' => 'Module\Controller\Factory\RestControllerFactory',
            'Module\Controller\UpdateController' => 'Module\Controller\Factory\UpdateControllerFactory',
            'Module\Controller\ViewController' => 'Module\Controller\Factory\ViewControllerFactory'
        )
    ),
    'service_manager' => array(
        'factories' => array(
            'Module\Mapper\MysqlMapperInterface' => 'Module\Mapper\Factory\MysqlMapperFactory',
            'Module\Service\ServiceInterface' => 'Module\Service\Factory\ServiceFactory',
            'Module\Form\Form' => 'Module\Form\Factory\FormFactory',
            'Module\Listener\Listener' => 'Module\Listener\Factory\ListenerFactory',
            'Module\Service\ControllerServiceInterface' => 'Module\Service\Factory\ControllerServiceFactory',
            'Module\Service\EntityServiceInterface' => 'Module\Service\Factory\EntityServiceFactory',
            'Module\Service\FormServiceInterface' => 'Module\Service\Factory\FormServiceFactory',
            'Module\Service\HydratorServiceInterface' => 'Module\Service\Factory\HydratorServiceFactory',
            'Module\Service\MapperServiceInterface' => 'Module\Service\Factory\MapperServiceFactory',
            'Module\Service\ModuleServiceInterface' => 'Module\Service\Factory\ModuleServiceFactory',
            'Module\Service\ServiceServiceInterface' => 'Module\Service\Factory\ServiceServiceFactory',
            'Module\Service\ViewServiceInterface' => 'Module\Service\Factory\ViewServiceFactory',
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
                        'controller' => 'Module\Controller\CreateController',
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
                        'controller' => 'Module\Controller\DeleteController',
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
                        'controller' => 'Module\Controller\IndexController',
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
                        'controller' => 'Module\Controller\RestController',
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
                        'controller' => 'Module\Controller\UpdateController',
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
                        'controller' => 'Module\Controller\ViewController',
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
                            'controller' => 'Module\Controller\ConsoleController',
                            'action' => 'index'
                        )
                    )
                ),
                'module-console-view' => array(
                    'options' => array(
                        'route' => 'module --view [--id=]',
                        'defaults' => array(
                            'controller' => 'Module\Controller\ConsoleController',
                            'action' => 'view'
                        )
                    )
                )
            )
        )
    ),
    'view_manager' => array(
        'template_path_stack' => array(
            __DIR__ . '/../view'
        )
    ),
    'view_helpers' => array(
        'factories' => array(
            'ModuleSearchForm' => 'Module\View\Helper\Factory\ModuleSearchFormFactory'
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