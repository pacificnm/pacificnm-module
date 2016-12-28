<?php
namespace Module\Service;

use Zend\Filter\Word\CamelCaseToDash;

class ViewService implements ViewServiceInterface
{
    
    /**
     *
     * @var string
     */
    protected $viewDir;
    
    /**
     *
     * @var string
     */
    protected $moduleName;
    
    /**
     * 
     * @var string
     */
    protected $viewName;
    
    /**
     *
     * {@inheritdoc}
     *
     * @see \Module\Service\ActionServiceInterface::createActions()
     */
    public function createActions($moduleDir, $moduleName)
    {
        $filter = new CamelCaseToDash();
    
        $this->viewDir = ucfirst($moduleDir) . '/view/' . strtolower($filter->filter($moduleName));
    
        if (! is_dir($this->viewDir) || ! is_writable($this->viewDir)) {
            throw new \Exception("Can not write to directory: {$this->viewDir}");
        }
    
        $this->moduleName = ucfirst($moduleName);
        
        $this->viewName = strtolower($filter->filter($moduleName));
        
        $this->createAction()
        ->deleteAction()
        ->indexAction()
        ->updateAction()
        ->viewAction();
    
        return $this;
    }
    
    /**
     *
     * @return \Module\Service\ActionService
     */
    protected function createAction()
    {
        $body = $this->getDocBloc();
        $body .='
<div class="row">
	<div class="col-xs-12">
		<div class="box box-primary">
			<div class="box-header with-border">
				<h3 class="box-title">
                    <i class="<?php echo $this->layout()->pageIcon; ?>" aria-hidden="true"></i>
					<?php echo $this->translate($this->layout()->pageTitle); ?> 
					<small><?php echo $this->translate("New"); ?></small>
				</h3>
				<div class="box-tools"></div>
			</div>
			<div class="box-body">
                <?php echo $this->form()->openTag($this->form); ?>
				<?php echo $this->partial("partials/form-errors.phtml", array("errorMsg" => $this->form->getMessages())); ?>
		
                <div class="row">
					<div class="col-xs-12">
						<?php echo $this->formSubmit($this->form->get("submit")); ?>
					</div>
				</div>
				
				<?php echo $this->form()->closeTag(); ?>
			</div>
		</div>
	</div>
</div>';
        
        file_put_contents($this->viewDir . '/create/index.phtml', $body);
    
        return $this;
    }
    
    /**
     *
     * @return \Module\Service\ActionService
     */
    protected function deleteAction()
    {
        $body = $this->getDocBloc();
    
        $body .= '
<div class="row">
	<div class="col-xs-12">
		<div class="box box-primary">
			<div class="box-header with-border">
				<h3 class="box-title">
					<i class="<?php echo $this->layout()->pageIcon; ?>" aria-hidden="true"></i>
					<?php echo $this->translate($this->layout()->pageTitle); ?> 
					<small><?php echo $this->translate("Delete"); ?></small>
				</h3>
				<div class="box-tools"></div>
			</div>
			<div class="box-body">
				<div class="alert alert-warning">
					<p><i class="fa fa-warning fa-fw"></i> <?php echo $this->translate("Are you sure you want to delete the following?"); ?></p>
				</div>
				<h3 class="profile-username"></h3>
				<p class="text-muted"></p>
				<form method="post">
                     <input type="submit" name="delete_confirmation" class="btn btn-danger" value="yes">
                     <input type="submit" name="delete_confirmation" class="btn btn-primary" value="no">
                 </form>
			</div>
		</div>
	</div>
</div>';
        
        file_put_contents($this->viewDir . '/delete/index.phtml', $body);
        
        return $this;
    }
    
    /**
     *
     * @return \Module\Service\ActionService
     */
    protected function indexAction()
    {
        $body = $this->getDocBloc();
    
        $body .= '
<div class="row">
	<div class="col-xs-12">
		<div class="box box-primary">
			<div class="box-header with-border">
				<h3 class="box-title">
					<i class="<?php echo $this->layout()->pageIcon; ?>" aria-hidden="true"></i>
					<?php echo $this->translate($this->layout()->pageTitle); ?> 
					<small><?php echo $this->translate("Page"); ?>: <?php echo $this->page; ?></small>
				</h3>
				<div class="box-tools">
					<?php echo $this->searchButton("'.$this->viewName.'-search"); ?>
					
					<?php echo $this->createButton("'.$this->viewName.'-create"); ?>
				</div>
			</div> 
            <?php if($this->paginator->count() == 0): ?>
			<div class="box-body">
				<div class="alert alert-info">
					<p>
						<i class="fa fa-info-circle" aria-hidden="true"></i> 
						<?php echo $this->translate("No entities found"); ?>
					</p>
				</div>
			</div>
			<?php else: ?>
			<div class="box-body  no-padding">
				<div class="row">
					<div class="col-xs-12">
						<table class="table table-bordered table-hover table-striped table-condensed">
							<thead>
								<tr>
                                    <th></th>
                                </tr>
							</thead>
							<tbody>
							<?php foreach($this->paginator as $entity): ?>
								<tr>
									<td></td>
                                </tr>
                            <?php endforeach; ?>
							</tbody>
						</table>
					</div>
				</div>
				
				<div class="row">
					<div class="col-xs-12 text-center">
						<?php echo $this->Paginator(
							$this->itemCountPerPage, 
							$this->itemCount, 
							$this->pageCount, 
                            $this->page, 
                            $this->routeParams,
                            $this->queryParams);
                        ?>
					</div>
				</div>
			</div>
			<?php endif;?>
		</div>
	</div>
</div>';
        
        file_put_contents($this->viewDir . '/index/index.phtml', $body);
        
        return $this;
    }
    
    /**
     *
     * @return \Module\Service\ActionService
     */
    protected function updateAction()
    {
        $body = $this->getDocBloc();
    
        $body .= '
<div class="row">
	<div class="col-xs-12">
		<div class="box box-primary">
			<div class="box-header with-border">
				<h3 class="box-title">
                    <i class="<?php echo $this->layout()->pageIcon; ?>" aria-hidden="true"></i>
					<?php echo $this->translate($this->layout()->pageTitle); ?> 
					<small><?php echo $this->translate("Edit"); ?></small>
				</h3>
				<div class="box-tools"></div>
			</div>
			<div class="box-body">
                <?php echo $this->form()->openTag($this->form); ?>
				<?php echo $this->partial("partials/form-errors.phtml", array("errorMsg" => $this->form->getMessages())); ?>
		
                <div class="row">
					<div class="col-xs-12">
						<?php echo $this->formSubmit($this->form->get("submit")); ?>
					</div>
				</div>
				
				<?php echo $this->form()->closeTag(); ?>
			</div>
		</div>
	</div>
</div>';
        
        file_put_contents($this->viewDir . '/update/index.phtml', $body);
        
        return $this;
    }
    
    /**
     *
     * @return \Module\Service\ActionService
     */
    protected function viewAction()
    {
        $body = $this->getDocBloc();
    
        $body .= '
<div class="row">
	<div class="col-xs-12">
		<div class="box box-primary">
			<div class="box-header with-border">
				<h3 class="box-title">
					<i class="<?php echo $this->layout()->pageIcon; ?>" aria-hidden="true"></i>
					<?php echo $this->translate($this->layout()->pageTitle); ?> 
					<small><?php echo $this->translate("View"); ?></small>
				</h3>
				<div class="box-tools">
					<?php echo $this->deleteButton("'.$this->viewName.'-delete", array("id" => $this->entity->get'.$this->moduleName.'Id())); ?>
					
					<?php echo $this->updateButton("'.$this->viewName.'-update", array("id" => $this->entity->get'.$this->moduleName.'Id())); ?>
				</div>
			</div>
			<div class="box-body box-profile">
                <h3 class="profile-username text-center"></h3>
                <p class="text-muted text-center"></p>
                <ul class="list-group list-group-unbordered">
                    <li class="list-group-item"></li>
                </ul>
            </div>
		</div>
	</div>
</div>';
        
        file_put_contents($this->viewDir . '/view/index.phtml', $body);
        
        return $this;
    }
    
    /**
     *
     * @return string
     */
    protected function getDocBloc()
    {
        $body = '<?php' . "\n";
        $body .= '/**' . "\n";
        $body .= '* Pacific NM (https://www.pacificnm.com)' . "\n";
        $body .= '*' . "\n";
        $body .= '* @link      https://github.com/pacificnm/pnm for the canonical source repository' . "\n";
        $body .= '* @copyright Copyright (c) 20011-2016 Pacific NM USA Inc. (https://www.pacificnm.com)' . "\n";
        $body .= '* @license' . "\n";
        $body .= '*/' . "\n";
        $body .= '?>';
    
        return $body;
    }
}

