<?php
namespace Module\Mapper;

use Zend\Hydrator\HydratorInterface;
use Zend\Db\Adapter\AdapterInterface;
use Zend\Db\Sql\Update;
use Zend\Db\Sql\Insert;
use Zend\Db\Sql\Delete;
use Application\Mapper\AbstractMysqlMapper;
use Module\Entity\Entity;

class MysqlMapper extends AbstractMysqlMapper implements MysqlMapperInterface
{

    /**
     *
     * @param AdapterInterface $readAdapter            
     * @param AdapterInterface $writeAdapter            
     * @param HydratorInterface $hydrator            
     * @param Entity $prototype            
     */
    public function __construct(AdapterInterface $readAdapter, AdapterInterface $writeAdapter, HydratorInterface $hydrator, Entity $prototype)
    {
        $this->hydrator = $hydrator;
        
        $this->prototype = $prototype;
        
        parent::__construct($readAdapter, $writeAdapter);
    }

    /**
     *
     * {@inheritdoc}
     *
     * @see \Module\Mapper\MysqlMapperInterface::getAll()
     */
    public function getAll($filter)
    {
        $this->select = $this->readSql->select('module');
        
        $this->filter($filter);
        
        $this->select->order('module_name');
        
        // if pagination is disabled
        if (array_key_exists('pagination', $filter)) {
            if ($filter['pagination'] == 'off') {
                return $this->getRows();
            }
        }
        
        return $this->getPaginator();
    }

    /**
     *
     * {@inheritdoc}
     *
     * @see \Module\Mapper\MysqlMapperInterface::get()
     */
    public function get($id)
    {
        $this->select = $this->readSql->select('module');
        
        $this->select->where(array(
            'module.module_id = ?' => $id
        ));
        
        return $this->getRow();
    }

    /**
     *
     * {@inheritdoc}
     *
     * @see \Module\Mapper\MysqlMapperInterface::getModuleByName()
     */
    public function getModuleByName($moduleName)
    {
        $this->select = $this->readSql->select('module');
        
        $this->select->where(array(
            'module.module_name = ?' => $moduleName
        ));
        
        return $this->getRow();
    }

    /**
     *
     * {@inheritdoc}
     *
     * @see \Module\Mapper\MysqlMapperInterface::save()
     */
    public function save(Entity $entity)
    {
        $postData = $this->hydrator->extract($entity);
        
        // if we have id then its an update
        if ($entity->getModuleId()) {
            $this->update = new Update('module');
            
            $this->update->set($postData);
            
            $this->update->where(array(
                'module.module_id = ?' => $entity->getModuleId()
            ));
            
            $this->updateRow();
        } else {
            $this->insert = new Insert('module');
            
            $this->insert->values($postData);
            
            $id = $this->createRow();
            
            $entity->setModuleId($id);
        }
        
        return $this->get($entity->getModuleId());
    }

    /**
     *
     * {@inheritdoc}
     *
     * @see \Module\Mapper\MysqlMapperInterface::delete()
     */
    public function delete(Entity $entity)
    {
        $this->delete = new Delete('module');
        
        $this->delete->where(array(
            'module.module_id = ?' => $entity->getModuleId()
        ));
        
        return $this->deleteRow();
    }

    /**
     *
     * @param array $filer            
     * @return \Module\Mapper\MysqlMapper
     */
    protected function filter($filer)
    {
        return $this;
    }
}

