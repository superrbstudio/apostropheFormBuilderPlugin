<?php

/**
 * Base actions for the apostropheFormBuilderPlugin aForm module.
 * 
 * @package     apostropheFormBuilderPlugin
 * @subpackage  aForm
 * @author      Alex Gilbert
 * @version     SVN: $Id: BaseActions.class.php 12534 2008-11-01 13:38:27Z Kris.Wallsmith $
 */
abstract class BaseaFormActions extends sfActions
{ 
  public function preExecute()
  {
    if($this->getRequest()->isXmlHttpRequest())
    {
      $this->setLayout(false);
    }
  }

	public function executeIndex()
	{
		$this->aForms = $this->getRoute()->getObjects();
	}
	
  public function executeNew(sfWebRequest $request)
  {
    $this->aForm = new aForm();
    $this->aFormForm = new aFormForm($this->aForm);
  }
  
  public function executeCreate(sfWebRequest $request)
  {
    $aFormForm = new aFormForm();
    $aFormForm->bind($request->getParameter($aFormForm->getName()));

    if($aFormForm->isValid())
    {
      $aFormForm->save();
      $this->redirect('@a_form_edit?id='.$aFormForm->getObject()->getId());
    }
  }
 
  public function executeEdit(sfWebRequest $request)
  {    
    $this->aForm = $this->getObject();
    $this->aFormForm = new aFormForm($this->aForm);
    
    $this->aFormLayout = new aFormLayout();
    $this->aFormLayoutForm = new aFormLayoutForm($this->aFormLayout, array('a_form' => $this->aForm));    
   
		$this->form = new aFormBuilder(array(), array('a_form' => $this->aForm));
  }
  
  public function executeUpdate(sfWebRequest $request)
  {
    
  }
  
  public function executeShowLayout(sfWebRequest $request)
  {
    $this->aForm = $this->getObject();
    $this->aFormForm = new aFormForm($this->aForm, array('a_form' => $this->aForm));

    $this->aFormLayout = Doctrine::getTable('aFormLayout')->find($request->getParameter('layout_id'));    
    $this->forward404Unless($this->aFormLayout);

    $this->aFormLayoutForm = new aFormLayoutForm($this->aFormLayout);

    return $this->renderPartial('aForm/aFormLayoutEdit', array('aForm' => $this->aForm, 'aFormLayout' => $this->aFormLayout, 'aFormLayoutForm' => $this->aFormLayoutForm));
  }
  
  public function executeAddLayout(sfWebRequest $request)
  {
    $this->aForm = $this->getObject();
    $this->aFormForm = new aFormForm($this->aForm);

    $this->aFormLayoutForm = new aFormLayoutForm();
    $this->aFormLayoutForm->bind($request->getParameter($this->aFormLayoutForm->getName()));
    
    $this->aFormLayout = $this->aFormLayoutForm->getObject();

    if($this->aFormLayoutForm->isValid())
    {
      $this->aFormLayoutForm->save();
      
      $this->aFormLayout = new aFormLayout();
      $this->aFormLayoutForm = new aFormLayoutForm($this->aFormLayout, array('a_form' => $this->aForm));    
    }

    $this->setTemplate('edit');
  }
  
  public function executeUpdateLayout(sfWebRequest $request)
  {
    $this->aForm = $this->getObject();

    $this->aFormLayout = Doctrine::getTable('aFormLayout')->find($request->getParameter('layout_id'));
    $this->forward404Unless($this->aFormLayout);
    
    $this->aFormLayoutForm = new aFormLayoutForm($this->aFormLayout);

    $this->aFormLayoutForm->bind($request->getParameter($this->aFormLayoutForm->getName()));

    if ($this->aFormLayoutForm->isValid())
    {
      $this->aFormLayout = $this->aFormLayoutForm->save();
      
      return $this->renderPartial('aForm/aFormLayoutEdit', array('aForm' => $this->aForm, 'aFormLayout' => $this->aFormLayout, 'aFormLayoutForm' => $this->aFormLayoutForm));
    }
  }
  
  public function executeEditLayout(sfWebRequest $request)
  {    
    $this->aForm = $this->getObject();

    $this->aFormLayout = Doctrine::getTable('aFormLayout')->find($request->getParameter('layout_id'));
    $this->forward404Unless($this->aFormLayout);

    $this->aFormLayoutForm = new aFormLayoutForm($this->aFormLayout);

    return $this->renderPartial('aForm/aFormLayoutForm', array('aForm' => $this->aForm, 'aFormLayout' => $this->aFormLayout, 'aFormLayoutForm' => $this->aFormLayoutForm));
  }
  
  public function executeDeleteLayout(sfWebRequest $request)
  {
    $this->aForm = $this->getObject();
    
    $this->aFormLayout = Doctrine::getTable('aFormLayout')->find($request->getParameter('layout_id'));
    $this->forward404Unless($this->aFormLayout);
    
    $this->aFormLayout->delete();

    return sfView::NONE;
  }
  
  public function executeSortLayouts(sfRequest $request)
  {
    $aForm = $this->getObject();
    $order = $request->getParameter('a-form-layout');
    Doctrine::getTable('aFormLayout')->doSort($order);
    
    return sfView::NONE;
  }

  /**
   * getObject 
   * helper method to retrieve a form object from the routing class and check if
   * the user has permission to access the object.
   * @return 
   */
  public function getObject()
  {
    $object = $this->getRoute()->getObject();

    if(true)
    {
      return $object;
    }
    else
    {
      $this->forward404(); 
    }
  }
}
