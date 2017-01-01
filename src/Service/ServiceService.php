<?php
namespace Pacificnm\Module\Service;

use Zend\Code\Generator\ClassGenerator;
use Zend\Code\Generator\PropertyGenerator;
use Zend\Code\Generator\PropertyValueGenerator;
use Zend\Code\Generator\FileGenerator;
use Zend\Code\Generator\DocBlockGenerator;
use Zend\Code\Generator\DocBlock\Tag\ParamTag;
use Zend\Code\Generator\ParameterGenerator;
use Zend\Code\Generator\MethodGenerator;
use Zend\Code\Generator\DocBlock\Tag\ReturnTag;
use Zend\Code\Generator\InterfaceGenerator;

class ServiceService implements ServiceServiceInterface
{

    /**
     *
     * @var ClassGenerator
     */
    protected $code;

    /**
     *
     * @var string
     */
    protected $moduleName;

    /**
     *
     * @var string
     */
    protected $moduleDir;

    /**
     *
     * {@inheritdoc}
     *
     * @see \Module\Service\ServiceServiceInterface::createService()
     */
    public function createService($moduleDir, $moduleName)
    {
        $this->moduleDir = ucfirst($moduleDir) . '/src/Service';
        
        if (! is_dir($this->moduleDir) || ! is_writable($this->moduleDir)) {
            throw new \Exception("Can not write to directory: {$moduleDir}");
        }
        
        $this->moduleName = ucfirst($moduleName);
        
        // name space
        $namespaceName = 'Pacificnm\\' . ucfirst($this->moduleName) . '\Service';
        
        $this->code = new ClassGenerator();
        
        $this->code->setName('Service');
        
        $this->code->setNamespaceName($namespaceName);
        
        $this->code->addUse('Pacificnm\\' . $this->moduleName . '\Entity\Entity');
        
        $this->code->addUse('Pacificnm\\' . $this->moduleName . '\Mapper\MysqlMapperInterface');
        
        $this->code->setImplementedInterfaces(array(
            'ServiceInterface'
        ));
        
        $this->code->addProperty('mapper', new PropertyValueGenerator(), PropertyGenerator::FLAG_PROTECTED);
        
        $this->code->addMethods(array(
            $this->createConstruct(),
            $this->createGetAll(),
            $this->createGet(),
            $this->createSave(),
            $this->createDelete()
        ));
        
        $file = new FileGenerator(array(
            'classes' => array(
                $this->code
            )
        ));
        
        file_put_contents($this->moduleDir . '/Service.php', $file->generate());
        
        $this->createInterface();
        
        $this->createFactory();
    }

    /**
     *
     * @return \Zend\Code\Generator\MethodGenerator
     */
    protected function createConstruct()
    {
        // create docblock
        $dockBlock = new DocBlockGenerator();
        
        $dockBlock->setShortDescription('Service Construct');
        
        $dockBlock->setTags(array(
            new ParamTag('mapper', 'MysqlMapperInterface')
        ));
        
        $body = '$this->mapper = $mapper;';
        
        $mapper = new ParameterGenerator('mapper', 'MysqlMapperInterface');
        
        $method = new MethodGenerator('__construct', array(
            $mapper
        ), MethodGenerator::FLAG_PUBLIC, $body, $dockBlock);
        
        return $method;
    }

    /**
     *
     * @return \Zend\Code\Generator\MethodGenerator
     */
    protected function createSave()
    {
        // create docblock
        $dockBlock = new DocBlockGenerator();
        
        $dockBlock->setShortDescription(' {@inheritDoc}');
        
        $dockBlock->setLongDescription('@see \Pacificnm\\' . $this->moduleName . '\Service\ServiceInterface::save()');
        
        $body = 'return $this->mapper->save($entity);';
        
        $entity = new ParameterGenerator('entity', 'Entity');
        
        $method = new MethodGenerator('save', array(
            $entity
        ), MethodGenerator::FLAG_PUBLIC, $body, $dockBlock);
        
        return $method;
    }

    /**
     *
     * @return \Zend\Code\Generator\MethodGenerator
     */
    protected function createGet()
    {
        // create docblock
        $dockBlock = new DocBlockGenerator();
        
        $dockBlock->setShortDescription(' {@inheritDoc}');
        
        $dockBlock->setLongDescription('@see \Pacificnm\\' . $this->moduleName . '\Service\ServiceInterface::get()');
        
        $body = 'return $this->mapper->get($id);';
        
        $id = new ParameterGenerator('id');
        
        $method = new MethodGenerator('get', array(
            $id
        ), MethodGenerator::FLAG_PUBLIC, $body, $dockBlock);
        
        return $method;
    }

    /**
     *
     * @return \Zend\Code\Generator\MethodGenerator
     */
    protected function createGetAll()
    {
        // create docblock
        $dockBlock = new DocBlockGenerator();
        
        $dockBlock->setShortDescription(' {@inheritDoc}');
        
        $dockBlock->setLongDescription('@see \Pacificnm\\' . $this->moduleName . '\Service\ServiceInterface::getAll()');
        
        $body = 'return $this->mapper->getAll($filter);';
        
        $method = new MethodGenerator('getAll', array(
            new ParameterGenerator('filter', 'array')
        ), MethodGenerator::FLAG_PUBLIC, $body, $dockBlock);
        
        return $method;
    }

    /**
     *
     * @return \Zend\Code\Generator\MethodGenerator
     */
    protected function createDelete()
    {
        // create docblock
        $dockBlock = new DocBlockGenerator();
        
        $dockBlock->setShortDescription(' {@inheritDoc}');
        
        $dockBlock->setLongDescription('@see \Pacificnm\\' . $this->moduleName . '\Service\ServiceInterface::delete()');
        
        $body = 'return $this->mapper->delete($entity);';
        
        $entity = new ParameterGenerator('entity', 'Entity');
        
        $method = new MethodGenerator('delete', array(
            $entity
        ), MethodGenerator::FLAG_PUBLIC, $body, $dockBlock);
        
        return $method;
    }

    /**
     *
     * @return \Module\Service\ServiceService
     */
    protected function createInterface()
    {
        $namespaceName = 'Pacificnm\\' . ucfirst($this->moduleName) . '\Service';
        
        $code = new InterfaceGenerator();
        
        $code->setName('ServiceInterface');
        
        $code->setNamespaceName($namespaceName);
        
        $code->addUse('Pacificnm\\' . ucfirst($this->moduleName) . '\Entity\Entity');
        
        // getAll
        $dockBlock = new DocBlockGenerator();
        
        $dockBlock->setTags(array(
            new ParamTag('filter', 'array'),
            new ReturnTag('Paginator')
        ));
        
        $code->addMethod('getAll', array(
            new ParameterGenerator('filter', 'array')
        ), MethodGenerator::FLAG_PUBLIC, null, $dockBlock);
        
        // get
        $dockBlock = new DocBlockGenerator();
        
        $dockBlock->setTags(array(
            new ParamTag('id', 'number'),
            new ReturnTag('Entity')
        ));
        
        $code->addMethod('get', array(
            new ParameterGenerator('id')
        ), MethodGenerator::FLAG_PUBLIC, null, $dockBlock);
        
        // save
        $dockBlock = new DocBlockGenerator();
        
        $dockBlock->setTags(array(
            new ParamTag('entity', 'Entity'),
            new ReturnTag('Entity')
        ));
        
        $code->addMethod('save', array(
            new ParameterGenerator('entity', 'Entity')
        ), MethodGenerator::FLAG_PUBLIC, null, $dockBlock);
        
        // delete
        $dockBlock = new DocBlockGenerator();
        
        $dockBlock->setTags(array(
            new ParamTag('entity', 'Entity'),
            new ReturnTag('Boolean')
        ));
        
        $code->addMethod('delete', array(
            new ParameterGenerator('entity', 'Entity')
        ), MethodGenerator::FLAG_PUBLIC, null, $dockBlock);
        
        $file = new FileGenerator(array(
            'classes' => array(
                $code
            )
        ));
        
        file_put_contents($this->moduleDir . '/ServiceInterface.php', $file->generate());
        
        return $this;
    }

    /**
     *
     * @return \Module\Service\ServiceService
     */
    protected function createFactory()
    {
        $namespaceName = ucfirst('Pacificnm\\' . $this->moduleName) . '\Service\Factory';
        
        $dockBlock = new DocBlockGenerator();
        
        $dockBlock->setTags(array(
            new ParamTag('serviceLocator', 'ServiceLocatorInterface'),
            new ReturnTag('Pacificnm\\' . $this->moduleName . '\Service\Service')
        ));
        
        $code = new ClassGenerator();
        
        $code->setName('ServiceFactory');
        
        $code->setNamespaceName($namespaceName);
        
        $code->addUse('Zend\ServiceManager\ServiceLocatorInterface');
        
        $code->addUse('Pacificnm\\' . $this->moduleName . '\Service\Service');
        
        $serviceLocator = new ParameterGenerator('serviceLocator', 'ServiceLocatorInterface');
        
        $body = '$mapper = $serviceLocator->get(\'Pacificnm\\' . $this->moduleName . '\Mapper\MysqlMapperInterface\');

return new Service($mapper);';
        
        $method = new MethodGenerator('__invoke', array(
            $serviceLocator
        ), MethodGenerator::FLAG_PUBLIC, $body, $dockBlock);
        
        $code->addMethods(array(
            $method
        ));
        
        $file = new FileGenerator(array(
            'classes' => array(
                $code
            )
        ));
        
        file_put_contents($this->moduleDir . '/Factory/ServiceFactory.php', $file->generate());
        
        return $this;
    }
}

