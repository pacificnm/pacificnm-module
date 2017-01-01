<?php
namespace Pacificnm\Module\Service;

use Zend\Code\Generator\ClassGenerator;
use Zend\Code\Generator\FileGenerator;
use Zend\Code\Generator\MethodGenerator;
use Zend\Filter\Word\CamelCaseToDash;
use Zend\Code\Generator\DocBlockGenerator;
use Zend\Code\Generator\DocBlock\Tag\ParamTag;
use Zend\Code\Generator\DocBlock\Tag\ReturnTag;
use Zend\Code\Generator\ParameterGenerator;

class FormService implements FormServiceInterface
{

    /**
     *
     * @var string
     */
    protected $moduleName;

    /**
     *
     * {@inheritdoc}
     *
     * @see \Pacificnm\Module\Service\FormServiceInterface::createForm()
     */
    public function createForm($moduleDir, $moduleName)
    {
        $moduleDir = ucfirst($moduleDir) . '/src/Form';
        
        if (! is_dir($moduleDir) || ! is_writable($moduleDir)) {
            throw new \Exception("Can not write to directory: {$moduleDir}");
        }
        
        $this->moduleName = ucfirst($moduleName);
        
        $namespaceName = ucfirst('Pacificnm\\' . $moduleName) . '\Form';
        
        $code = new ClassGenerator();
        
        $code->setNamespaceName($namespaceName);
        
        $code->setName('Form');
        
        $code->addUse('Zend\Form\Form', 'ZendForm');
        
        $code->addUse('Zend\InputFilter\InputFilterProviderInterface');
        
        $code->addUse('Pacificnm\\' . ucfirst($moduleName) . '\Entity\Entity');
        
        $code->addUse('Pacificnm\\' . ucfirst($moduleName) . '\Hydrator\Hydrator');
        
        $code->setExtendedClass('ZendForm');
        
        $code->setImplementedInterfaces(array(
            'InputFilterProviderInterface'
        ));
        
        $filter = new CamelCaseToDash();
        
        // construct
        $code->addMethod('__construct', array(
            'name = \'' . $filter->filter(strtolower($moduleName)) . '-form\'',
            'options = array()'
        ), MethodGenerator::FLAG_PUBLIC, $this->getConstructBody(), $this->getConstructDocBlock());
        
        // filter
        $code->addMethod('getInputFilterSpecification', array(), MethodGenerator::FLAG_PUBLIC, 'return array();', $this->getFilterDocBlock());
        
        $file = new FileGenerator(array(
            'classes' => array(
                $code
            )
        ));
        
        file_put_contents($moduleDir . '/Form.php', $file->generate());
        
        // create factory
        $factory = new ClassGenerator();
        
        $factory->setNamespaceName('Pacificnm\\' . $this->moduleName . '\Form\Factory');
        
        $factory->setName('FormFactory');
        
        $factory->addUse('Zend\ServiceManager\ServiceLocatorInterface');
        
        $factory->addUse('Pacificnm\\' . $this->moduleName . '\Form\Form');
        
        $factory->addMethod('__invoke', array(
            new ParameterGenerator('serviceLocator', 'ServiceLocatorInterface')
        ), MethodGenerator::FLAG_PUBLIC, $this->getInvokeBody(), $this->getFactoryDocBlock());
        
        $file = new FileGenerator(array(
            'classes' => array(
                $factory
            )
        ));
        
        file_put_contents($moduleDir . '/Factory/FormFactory.php', $file->generate());
    }

    /**
     *
     * @return string
     */
    protected function getConstructBody()
    {
        $body = 'parent::__construct($name, $options);' . "\n\n";
        
        $body .= '$this->setHydrator(new Hydrator(false));' . "\n\n";
        
        $body .= '$this->setObject(new Entity());' . "\n\n";
        
        $body .= '$this->add(array('. "\n";
        $body .= "\t" . '\'name\' => \'submit\',' . "\n";
        $body .= "\t" . '\'type\' => \'button\',' . "\n";
        $body .= "\t" . '\'attributes\' => array(' . "\n";
        $body .= "\t\t" . '\'value\' => \'Submit\',' . "\n";
        $body .= "\t\t" . '\'id\' => \'submit\',' . "\n";
        $body .= "\t\t" . '\'class\' => \'btn btn-primary btn-flat\'' . "\n";
        $body .= "\t" . ')' . "\n";
        $body .= '));' . "\n";
        
        return $body;
    }

    /**
     * 
     * @return string
     */
    protected function getInvokeBody()
    {
        $body = 'return new Form();';
        
        return $body;
    }

    /**
     *
     * @return \Zend\Code\Generator\DocBlockGenerator
     */
    protected function getConstructDocBlock()
    {
        $dockBlock = new DocBlockGenerator();
        
        $dockBlock->setTags(array(
            new ParamTag('name', 'string'),
            new ParamTag('options', 'array')
        ));
        
        return $dockBlock;
    }

    /**
     *
     * @return \Zend\Code\Generator\DocBlockGenerator
     */
    protected function getFilterDocBlock()
    {
        $dockBlock = new DocBlockGenerator();
        
        $dockBlock->setShortDescription('{@inheritdoc}');
        
        $dockBlock->setLongDescription('@see \Zend\InputFilter\InputFilterProviderInterface::getInputFilterSpecification()');
        
        return $dockBlock;
    }

    /**
     *
     * @return \Zend\Code\Generator\DocBlockGenerator
     */
    protected function getFactoryDocBlock()
    {
        $dockBlock = new DocBlockGenerator();
        
        $dockBlock->setTags(array(
            new ParamTag('serviceLocator', 'ServiceLocatorInterface'),
            new ReturnTag('\\' . $this->moduleName . '\Form\Form')
        ));
        
        return $dockBlock;
    }
}

