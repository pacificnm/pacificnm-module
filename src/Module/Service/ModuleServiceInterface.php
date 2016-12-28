<?php
namespace Module\Service;

interface ModuleServiceInterface
{

    /**
     *
     * @param string $moduleName            
     */
    public function createModule($moduleName);

    /**
     *
     * @param string $moduleDir            
     */
    public function createFolders($moduleDir, $moduleName);

    /**
     *
     * @param string $moduleDir            
     */
    public function createConfig($moduleDir, $moduleName);

    /**
     *
     * @param string $moduleDir            
     * @param string $moduleName            
     * @param string $moduleVersion            
     * @return \Module\Service\ModuleService
     */
    public function createComposer($moduleDir, $moduleName);

    /**
     *
     * @param string $moduleDir            
     * @return \Module\Service\ModuleService
     */
    public function createConduct($moduleDir);

    /**
     *
     * @param string $moduleDir            
     * @return \Module\Service\ModuleService
     */
    public function createContributing($moduleDir);

    /**
     *
     * @param string $moduleDir            
     * @return \Module\Service\ModuleService
     */
    public function createLicense($moduleDir);

    /**
     *
     * @param string $moduleDir            
     * @param string $moduleName            
     * @return \Module\Service\ModuleService
     */
    public function createModuleFile($moduleDir, $moduleName);

    /**
     *
     * @param string $moduleDir            
     * @param string $moduleName            
     * @return \Module\Service\ModuleService
     */
    public function createPhpUnit($moduleDir, $moduleName);

    /**
     *
     * @param string $moduleDir            
     * @param string $moduleName            
     * @return \Module\Service\ModuleService
     */
    public function createReadMe($moduleDir, $moduleName);

    /**
     *
     * @param string $moduleDir            
     * @return \Module\Service\ModuleService
     */
    public function createTodo($moduleDir);

    /**
     *
     * @param string $moduleDir            
     * @param string $moduleName            
     * @return \Module\Service\ModuleService
     */
    public function createSqlFile($moduleDir, $moduleName);
}

