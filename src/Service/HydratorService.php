<?php
namespace Pacificnm\Module\Service;

use Zend\Code\Generator\ClassGenerator;
use Zend\Code\Generator\FileGenerator;
use Zend\Code\Generator\MethodGenerator;
use Zend\Code\Generator\DocBlockGenerator;
use Zend\Code\Generator\ParameterGenerator;

class HydratorService implements HydratorServiceInterface
{
    /**
     * 
     * @param unknown $moduleDir
     * @param unknown $moduleName
     * @throws \Exception
     */
    public function createHydrator($moduleDir, $moduleName)
    {
        $moduleDir = ucfirst($moduleDir) . '/src/Hydrator';
        
        if (! is_dir($moduleDir) || ! is_writable($moduleDir)) {
            throw new \Exception("Can not write to directory: {$moduleDir}");
        }
        
        $namespaceName = ucfirst('Pacificnm\\' . $moduleName) . '\Hydrator';
        
        $code = new ClassGenerator();
        
        $code->setName('Hydrator');
        
        $code->setNamespaceName($namespaceName);
        
        $code->addUse('Zend\Hydrator\ClassMethods');
        
        $code->addUse('Pacificnm\\' .ucfirst($moduleName) . '\Entity\Entity');
        
        $code->setExtendedClass('ClassMethods');
        
        
        $code->addMethods(array(
            new MethodGenerator('__construct', array(
                'underscoreSeparatedKeys = true'
            ), MethodGenerator::FLAG_PUBLIC, $this->getConstructBody(), $this->getConstructDocBlock()),
            new MethodGenerator('hydrate', array(
                new ParameterGenerator('data', 'array'),
                'object'
            ), MethodGenerator::FLAG_PUBLIC, $this->getHydrateBody(), $this->getHydrateDockBlock()),
            new MethodGenerator('extract', array(
                'object'
            ), MethodGenerator::FLAG_PUBLIC, $this->getExtractBody(), $this->getExtractDockBlock())
        ));
        
        $file = new FileGenerator(array(
            'classes' => array(
                $code
            )
        ));
        
        file_put_contents($moduleDir . '/Hydrator.php', $file->generate());
    }

    /**
     *
     * @return string
     */
    protected function getConstructBody()
    {
        return 'parent::__construct($underscoreSeparatedKeys);';
    }

    /**
     *
     * @return \Zend\Code\Generator\DocBlockGenerator
     */
    protected function getConstructDocBlock()
    {
        $dockBlock = new DocBlockGenerator();
        
        $dockBlock->setShortDescription('@param string $underscoreSeparatedKeys');
        
        return $dockBlock;
    }

    /**
     *
     * @return string
     */
    protected function getHydrateBody()
    {
        return 'if (! $object instanceof Entity) {
    return $object;
}
        
parent::hydrate($data, $object);
        
return $object;';
    }

    /**
     *
     * @return \Zend\Code\Generator\DocBlockGenerator
     */
    protected function getHydrateDockBlock()
    {
        $dockBlock = new DocBlockGenerator();
        
        $dockBlock->setShortDescription('{@inheritdoc}');
        
        $dockBlock->setLongDescription('@see \Zend\Stdlib\Hydrator\ClassMethods::hydrate()');
        
        return $dockBlock;
    }

    /**
     *
     * @return string
     */
    protected function getExtractBody()
    {
        return 'if (! $object instanceof Entity) {
    return $object;
}
            
$data = parent::extract($object);
            
            
return $data;';
    }

    protected function getExtractDockBlock()
    {
        $dockBlock = new DocBlockGenerator();
        
        $dockBlock->setShortDescription('{@inheritdoc}');
        
        $dockBlock->setLongDescription('@see \Zend\Stdlib\Hydrator\ClassMethods::extract()');
        
        return $dockBlock;
    }
}

