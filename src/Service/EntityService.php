<?php
namespace Pacificnm\Module\Service;

use Zend\Code\Generator\ClassGenerator;
use Zend\Code\Generator\FileGenerator;

class EntityService implements EntityServiceInterface
{

    /**
     * 
     * {@inheritDoc}
     * @see \Pacificnm\Module\Service\EntityServiceInterface::createEntity()
     */
    public function createEntity($moduleDir, $moduleName)
    {
        $moduleDir = ucfirst($moduleDir) . '/src/Entity';
        
        if (! is_dir($moduleDir) || ! is_writable($moduleDir)) {
            throw new \Exception("Can not write to directory: {$moduleDir}");
        }
        
        $namespaceName = ucfirst('Pacificnm\\' .$moduleName) . '\Entity';
        
        $code = new ClassGenerator();
        
        $code->setNamespaceName($namespaceName);
        
        $code->setName('Entity');
        
        $file = new FileGenerator(array(
            'classes' => array(
                $code
            )
        ));
        
        file_put_contents($moduleDir . '/Entity.php', $file->generate());
    }
}

