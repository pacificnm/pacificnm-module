<?php
namespace Pacificnm\Module\Service;

use Pacificnm\Module\Entity\Entity;
use Pacificnm\Module\Mapper\MysqlMapperInterface;

class Service implements ServiceInterface
{
    /**
     * 
     * @var MysqlMapperInterface
     */
    protected $mapper;
    
    /**
     * 
     * @param MysqlMapperInterface $mapper
     */
    public function __construct(MysqlMapperInterface $mapper)
    {
        $this->mapper = $mapper;
    }
    
    /**
     * 
     * {@inheritDoc}
     * @see \Module\Service\ServiceInterface::getAll()
     */
    public function getAll($filter)
    {
        return $this->mapper->getAll($filter);
    }

    /**
     * 
     * {@inheritDoc}
     * @see \Module\Service\ServiceInterface::get()
     */
    public function get($id)
    {
        return $this->mapper->get($id);
    }

    /**
     * 
     * {@inheritDoc}
     * @see \Module\Service\ServiceInterface::save()
     */
    public function save(Entity $entity)
    {
        return $this->mapper->save($entity);
    }

    /**
     * 
     * {@inheritDoc}
     * @see \Module\Service\ServiceInterface::getModuleByName()
     */
    public function getModuleByName($moduleName)
    {
        return $this->mapper->getModuleByName($moduleName);
    }

    /**
     * 
     * {@inheritDoc}
     * @see \Module\Service\ServiceInterface::delete()
     */
    public function delete(Entity $entity)
    {
        return $this->mapper->delete($entity);
    }
}

