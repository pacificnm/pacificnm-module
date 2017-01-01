<?php
namespace Pacificnm\Module\View\Helper;

use Zend\View\Helper\AbstractHelper;

class ModuleSearchForm extends AbstractHelper
{
   
    public function __invoke(array $queryParams = array())
    {
        $view = $this->getView();
        
        $partialHelper = $view->plugin('partial');
        
        $data = new \stdClass();
        
        $data->queryParams = $queryParams;
        
        return $partialHelper('partials/module-search-form.phtml', $data);
    }
}

