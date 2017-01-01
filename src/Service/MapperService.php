<?php
namespace Pacificnm\Module\Service;

use Zend\Code\Generator\ClassGenerator;
use Zend\Code\Generator\FileGenerator;
use Zend\Code\Generator\MethodGenerator;
use Zend\Code\Generator\DocBlockGenerator;
use Zend\Code\Generator\InterfaceGenerator;
use Zend\Code\Generator\ParameterGenerator;
use Zend\Code\Generator\DocBlock\Tag\ParamTag;
use Zend\Filter\Word\CamelCaseToUnderscore;
use Zend\Code\Generator\DocBlock\Tag\ReturnTag;

class MapperService implements MapperServiceInterface
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
     * @var string
     */
    protected $tableName;

    /**
     *
     * {@inheritdoc}
     *
     * @see \Module\Service\MapperServiceInterface::createMapper()
     */
    public function createMapper($moduleDir, $moduleName)
    {
        
        
        $this->moduleDir = ucfirst($moduleDir) . '/src/Mapper';
        
        if (! is_dir($this->moduleDir) || ! is_writable($this->moduleDir)) {
            throw new \Exception("Can not write to directory: {$moduleDir}");
        }
        
        $this->moduleName = ucfirst($moduleName);
        
        // set table name
        $filter = new CamelCaseToUnderscore();
        
        $this->tableName = strtolower($filter->filter($moduleName));
        
        // name space
        $namespaceName = ucfirst('Pacificnm\\' .$this->moduleName) . '\Mapper';
        
        $this->code = new ClassGenerator();
        
        $this->code->setName('MysqlMapper');
        
        $this->code->setNamespaceName($namespaceName);
        
        $this->code->addUse('Zend\Hydrator\HydratorInterface');
        
        $this->code->addUse('Zend\Db\Adapter\AdapterInterface');
        
        $this->code->addUse('Zend\Db\Sql\Update');
        
        $this->code->addUse('Zend\Db\Sql\Insert');
        
        $this->code->addUse('Zend\Db\Sql\Delete');
        
        $this->code->addUse('Pacificnm\Mapper\AbstractMysqlMapper');
        
        $this->code->addUse('Pacificnm\\' .$this->moduleName . '\Entity\Entity');
        
        $this->code->setExtendedClass('AbstractMysqlMapper');
        
        $this->code->setImplementedInterfaces(array(
            'MysqlMapperInterface'
        ));
        
        $this->code->addMethods(array(
            $this->createConstruct(),
            $this->createGetAll(),
            $this->createGet(),
            $this->createSave(),
            $this->createDelete(),
            $this->createFilter()
        ));
        
        $file = new FileGenerator(array(
            'classes' => array(
                $this->code
            )
        ));
        
        file_put_contents($this->moduleDir . '/MysqlMapper.php', $file->generate());
        
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
        
        $dockBlock->setShortDescription('Mysql Mapper Construct');
        
        $dockBlock->setTags(array(
            new ParamTag('readAdapter', 'AdapterInterface'),
            new ParamTag('writeAdapter', 'AdapterInterface'),
            new ParamTag('hydrator', 'HydratorInterface'),
            new ParamTag('prototype', 'Entity')
        ));
        
        $construct = '$this->hydrator = $hydrator;
    
$this->prototype = $prototype;
    
parent::__construct($readAdapter, $writeAdapter);';
        
        // set params
        $readAdapter = new ParameterGenerator('readAdapter', 'AdapterInterface');
        
        $writeAdapter = new ParameterGenerator('writeAdapter', 'AdapterInterface');
        
        $hydrator = new ParameterGenerator('hydrator', 'HydratorInterface');
        
        $prototype = new ParameterGenerator('prototype', 'Entity');
        
        // add method
        $method = new MethodGenerator('__construct', array(
            $readAdapter,
            $writeAdapter,
            $hydrator,
            $prototype
        ), MethodGenerator::FLAG_PUBLIC, $construct, $dockBlock);
        
        return $method;
    }

    /**
     *
     * @return \Zend\Code\Generator\MethodGenerator
     */
    protected function createGetAll()
    {
        $dockBlock = new DocBlockGenerator();
        
        $dockBlock->setShortDescription('{@inheritdoc}');
        
        $dockBlock->setLongDescription('@see \\Pacificnm\\' . $this->moduleName . '\Mapper\MysqlMapperInterface::getAll()');
        
        // set parameters
        $filter = new ParameterGenerator('filter', 'array');
        
        $body = '$this->select = $this->readSql->select(\'' . $this->tableName . '\');
            
$this->filter($filter); 

if (array_key_exists(\'pagination\', $filter)) {
    if ($filter[\'pagination\'] == \'off\') {  
        return $this->getRows();    
    }
}

return $this->getPaginator();
';
        
        $method = new MethodGenerator('getAll', array(
            $filter
        ), MethodGenerator::FLAG_PUBLIC, $body, $dockBlock);
        
        return $method;
    }

    /**
     *
     * @return \Zend\Code\Generator\MethodGenerator
     */
    protected function createGet()
    {
        $dockBlock = new DocBlockGenerator();
        
        $dockBlock->setShortDescription('{@inheritdoc}');
        
        $dockBlock->setLongDescription('@see \\Pacificnm\\' . $this->moduleName . '\Mapper\MysqlMapperInterface::get()');
        
        // set parameters
        $id = new ParameterGenerator('id');
        
        $body = '$this->select = $this->readSql->select(\'' . $this->tableName . '\');

$this->select->where(array(
    \'' . $this->tableName . '.' . $this->tableName . '_id = ?\' => $id  
));
            
return $this->getRow();            
';
        
        $method = new MethodGenerator('get', array(
            $id
        ), MethodGenerator::FLAG_PUBLIC, $body, $dockBlock);
        
        return $method;
    }

    /**
     *
     * @return \Zend\Code\Generator\MethodGenerator
     */
    protected function createSave()
    {
        $dockBlock = new DocBlockGenerator();
        
        $dockBlock->setShortDescription('{@inheritdoc}');
        
        $dockBlock->setLongDescription('@see \\Pacificnm\\' . $this->moduleName . '\Mapper\MysqlMapperInterface::save()');
        
        // set parameters
        $entity = new ParameterGenerator('entity', 'Entity');
        
        $body = '$postData = $this->hydrator->extract($entity);
            
if ($entity->get' . $this->moduleName . 'Id()) {
    $this->update = new Update(\'' . $this->tableName . '\'); 
        
    $this->update->set($postData);  
        
    $this->update->where(array(
        \'' . $this->tableName . '.' . $this->tableName . '_id = ?\' => $entity->get' . $this->moduleName . 'Id()
    ));
            
    $this->updateRow();            
} else {
    $this->insert = new Insert(\'' . $this->tableName . '\'); 
        
    $this->insert->values($postData);
        
    $id = $this->createRow();
        
    $entity->set' . $this->moduleName . 'Id($id);        
}
            
return $this->get($entity->get' . $this->moduleName . 'Id());';
        
        $method = new MethodGenerator('save', array(
            $entity
        ), MethodGenerator::FLAG_PUBLIC, $body, $dockBlock);
        
        return $method;
    }

    /**
     *
     * @return \Zend\Code\Generator\MethodGenerator
     */
    protected function createDelete()
    {
        $dockBlock = new DocBlockGenerator();
        
        $dockBlock->setShortDescription('{@inheritdoc}');
        
        $dockBlock->setLongDescription('@see \\Pacificnm\\' . $this->moduleName . '\Mapper\MysqlMapperInterface::delete()');
        
        // set parameters
        $entity = new ParameterGenerator('entity', 'Entity');
        
        $body = '$this->delete = new Delete(\'' . $this->tableName . '\');
$this->delete->where(array(
     \'' . $this->tableName . '.' . $this->tableName . '_id = ?\' => $entity->get' . $this->moduleName . 'Id()
));
         
return $this->deleteRow();';
        
        $method = new MethodGenerator('delete', array(
            $entity
        ), MethodGenerator::FLAG_PUBLIC, $body, $dockBlock);
        
        return $method;
    }

    /**
     *
     * @return \Zend\Code\Generator\MethodGenerator
     */
    protected function createFilter()
    {
        $dockBlock = new DocBlockGenerator();
        
        $dockBlock->setShortDescription('Filters and search');
        
        $dockBlock->setTags(array(
            new ParamTag('filter', 'array'),
            new ReturnTag('\\' . $this->moduleName . '\Mapper\MysqlMapper')
        ));
        
        $filter = new ParameterGenerator('filter', 'array');
        
        $body = 'return $this;';
        
        $method = new MethodGenerator('filter', array(
            $filter
        ), MethodGenerator::FLAG_PROTECTED, $body, $dockBlock);
        
        return $method;
    }

    /**
     *
     * @return \Module\Service\MapperService
     */
    protected function createInterface()
    {
        $namespaceName = ucfirst('Pacificnm\\' . $this->moduleName) . '\Mapper';
        
        $code = new InterfaceGenerator();
        
        $code->setName('MysqlMapperInterface');
        
        $code->setNamespaceName($namespaceName);
        
        $code->addUse('Zend\Paginator\Paginator');
        
        $code->addUse('Pacificnm\\' .ucfirst($this->moduleName) . '\Entity\Entity');
        
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
        
        file_put_contents($this->moduleDir . '/MysqlMapperInterface.php', $file->generate());
        
        return $this;
    }

    /**
     *
     * @return \Module\Service\MapperService
     */
    protected function createFactory()
    {
        $namespaceName = ucfirst('Pacificnm\\' . $this->moduleName) . '\Mapper\Factory';
        
        $dockBlock = new DocBlockGenerator();
        
        $dockBlock->setTags(array(
            new ParamTag('serviceLocator', 'ServiceLocatorInterface'),
            new ReturnTag('\\Pacificnm\\' . $this->moduleName . '\Mapper\MysqlMapper')
        ));
        
        $code = new ClassGenerator();
        
        $code->setName('MysqlMapperFactory');
        
        $code->setNamespaceName($namespaceName);
        
        $code->addUse('Zend\ServiceManager\ServiceLocatorInterface');
        
        $code->addUse('Zend\Hydrator\Aggregate\AggregateHydrator');
        
        $code->addUse('Pacificnm\\' . $this->moduleName . '\Hydrator\Hydrator');
        
        $code->addUse('Pacificnm\\' .$this->moduleName . '\Entity\Entity');
        
        $code->addUse('Pacificnm\\' .$this->moduleName . '\Mapper\MysqlMapper');
        
        $serviceLocator = new ParameterGenerator('serviceLocator', 'ServiceLocatorInterface');
        
        $body = '$hydrator = new AggregateHydrator();
            
$hydrator->add(new Hydrator());  
            
$prototype = new Entity();
            
$writeAdapter = $serviceLocator->get(\'db1\');
            
$readAdapter = $serviceLocator->get(\'db2\');
            
return new MysqlMapper($readAdapter, $writeAdapter, $hydrator, $prototype);
';
        
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
        
        file_put_contents($this->moduleDir . '/Factory/MysqlMapperFactory.php', $file->generate());
        
        return $this;
    }
}

