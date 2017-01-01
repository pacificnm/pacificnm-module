<?php
namespace Pacificnm\Module\Entity;

class Entity
{

    /**
     *
     * @var number
     */
    protected $moduleId;

    /**
     *
     * @var string
     */
    protected $moduleName;

    /**
     *
     * @var string
     */
    protected $moduleVersion;

    /**
     *
     * @return the $moduleId
     */
    public function getModuleId()
    {
        return $this->moduleId;
    }

    /**
     *
     * @return the $moduleName
     */
    public function getModuleName()
    {
        return $this->moduleName;
    }

    /**
     *
     * @return the $moduleVersion
     */
    public function getModuleVersion()
    {
        return $this->moduleVersion;
    }

    /**
     *
     * @param number $moduleId            
     */
    public function setModuleId($moduleId)
    {
        $this->moduleId = $moduleId;
    }

    /**
     *
     * @param string $moduleName            
     */
    public function setModuleName($moduleName)
    {
        $this->moduleName = $moduleName;
    }

    /**
     *
     * @param string $moduleVersion            
     */
    public function setModuleVersion($moduleVersion)
    {
        $this->moduleVersion = $moduleVersion;
    }
}

