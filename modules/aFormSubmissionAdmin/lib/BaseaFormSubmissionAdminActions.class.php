<?php
require_once dirname(__FILE__).'/aFormSubmissionAdminGeneratorConfiguration.class.php';
require_once dirname(__FILE__).'/aFormSubmissionAdminGeneratorHelper.class.php';
/**
 * Base actions for the apostropheFormBuilderPlugin aFormSubmissionPlugin module.
 * 
 * @package     apostropheFormBuilderPlugin
 * @subpackage  aFormSubmissionPlugin
 * @author      Your name here
 * @version     SVN: $Id: BaseActions.class.php 12534 2008-11-01 13:38:27Z Kris.Wallsmith $
 */
abstract class BaseaFormSubmissionAdminActions extends autoAFormSubmissionAdminActions
{
  
  public function preExecute()
  {
    parent::preExecute();
    
    $q = Doctrine::getTable('aForm')->createQuery('f')
      ->leftJoin('f.aFormLayouts fl INDEXBY fl.id')
  		->leftJoin('fl.aFormLayoutOptions flo INDEXBY flo.id')
      ->leftJoin('fl.aFormFields ff INDEXBY ff.id');

    if ($form_id = $this->getRequest()->getParameter('form_id'))
    {
      $q->addWhere('f.id = ?', $form_id);

      $this->setFilters($this->configuration->getFilterDefaults());      
      
      // add the shit to the session
      
    }
      
    $this->a_form = $q->fetchOne();
  }
  
  protected function buildQuery()
  {
    $tableMethod = $this->configuration->getTableMethod();
    if (is_null($this->filters))
    {
      $this->filters = $this->configuration->getFilterForm($this->getFilters(), array('a_form' => $this->a_form));
    }

    $this->filters->setTableMethod($tableMethod);

    $query = $this->filters->buildQuery($this->getFilters());

    $this->addSortQuery($query);

    $event = $this->dispatcher->filter(new sfEvent($this, 'admin.build_query'), $query);
    $query = $event->getReturnValue();
    
    return $query;
  }
  
  public function executeFilter(sfWebRequest $request)
  {
    $this->setPage(1);

    if ($request->hasParameter('_reset'))
    {
      $this->setFilters($this->configuration->getFilterDefaults());

      $this->redirect('@a_form_submission_admin');
    }

    $this->filters = $this->configuration->getFilterForm($this->getFilters(), array('a_form' => $this->a_form));

    $this->filters->bind($request->getParameter($this->filters->getName()));
    if ($this->filters->isValid())
    {
      $this->setFilters($this->filters->getValues());

      $this->redirect('@a_form_submission_admin');
    }

    $this->pager = $this->getPager();
    $this->sort = $this->getSort();

    $this->setTemplate('index');
  }
  
  public function executeNew(sfWebRequest $request)
  {
    $this->form = $this->configuration->getForm(array(), array('a_form' => $this->a_form));
    $this->a_form_submission = $this->form->getObject();
  }
  
  public function executeCreate(sfWebRequest $request)
  {
    $this->form = $this->configuration->getForm(array(), array('a_form' => $this->a_form));
    $this->a_form_submission = $this->form->getObject();

    $this->processForm($request, $this->form);

    $this->setTemplate('new');
  }
	
	public function executeExport(sfWebRequest $request)
	{
		$query = $this->buildQuery();
		$out = fopen('php://temp/maxmemory:'. (5*1024*1024), 'r+');
		$this->result = $query->execute(array(), Doctrine::HYDRATE_ARRAY);
		
		$headers = array();
		$headers[] = 'Timestamp';
    $headers[] = 'IP Address';
		foreach($this->a_form->aFormLayouts as $aFormLayout)
		{
			if(count($aFormLayout->aFormFields) == 1)
			{
				$headers[] = $aFormLayout->getLabel();
			}
			else
			{
				foreach($aFormLayout->aFormFields as $aFormField)
				{
					$headers[] = $aFormLayout->getLabel().' '.$aFormField->getName();
				}
			}
		}
		fputcsv($out, $headers);
		
		foreach($this->result as $submission)
		{
			$row = array();
			$row[] = $submission['created_at'];
      $row[] = $submission['ip_address'];
			foreach($this->a_form->aFormLayouts as $aFormLayout)
			{
				foreach($aFormLayout->aFormFields as $aFormField)
				{
					$row[] = $submission['field_'.$aFormField->getId()];
				}
			}
			fputcsv($out, $row);
		}
		rewind($out);

    $this->getResponse()->setContentType('text/plain');
    $this->getResponse()->setHttpHeader('Content-Disposition', 'attachment; filename='.urlencode($this->a_form->getName()).'.csv');
    $this->getResponse()->setContent(stream_get_contents($out));
		return sfView::NONE;
	}
}
