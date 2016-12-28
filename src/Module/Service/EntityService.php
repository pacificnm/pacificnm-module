<?php
namespace Module\Service;

use Zend\Code\Generator\ClassGenerator;
use Zend\Code\Generator\FileGenerator;

class EntityService implements EntityServiceInterface
{

    /**
     * 
     * {@inheritDoc}
     * @see \Module\Service\EntityServiceInterface::createEntity()
     */
    public function createEntity($moduleDir, $moduleName)
    {
        $moduleDir = ucfirst($moduleDir) . '/src/' . ucfirst($moduleName);
        
        if (! is_dir($moduleDir) || ! is_writable($moduleDir)) {
            throw new \Exception("Can not write to directory: {$moduleDir}");
        }
        
        $namespaceName = ucfirst($moduleName) . '\Entity';
        
        $code = new ClassGenerator();
        
        $code->setNamespaceName($namespaceName);
        
        $code->setName('Entity');
        
        $file = new FileGenerator(array(
            'classes' => array(
                $code
            )
        ));
        
        file_put_contents($moduleDir . '/Entity/Entity.php', $file->generate());
    }
}

