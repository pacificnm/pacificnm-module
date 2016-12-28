<?php
namespace Module\Controller;

use Zend\Mvc\Controller\AbstractRestfulController;
use Module\Service\ServiceInterface;

class RestController extends AbstractRestfulController
{

    /**
     *
     * @var ServiceInterface
     */
    protected $service;

    /**
     *
     * @param ServiceInterface $service            
     */
    public function __construct(ServiceInterface $service)
    {
        $this->service = $service;
    }
}

