<?php
namespace Module\Service;

interface ControllerServiceInterface
{
    /**
     * Creates controllers and factories
     * 
     * @param string $moduleDir
     * @param string $moduleName
     */
    public function createController($moduleDir, $moduleName);
}

