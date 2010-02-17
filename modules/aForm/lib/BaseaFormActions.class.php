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
    if($request->isXmlHttpRequest())
    {
      $this->setLayout(false);
    }
    $this->aForm = $this->getObject();
    $this->aFormForm = new aFormForm($this->aForm);
    
    $this->aFormLayout = new aFormLayout();
    $this->aFormLayoutForm = new aFormLayoutForm($this->aFormLayout, array('a_form' => $this->aForm));    
   
		$this->form = new aFormBuilder(array(), array('a_form' => $this->aForm));
  }
  
  public function executeEditLayout(sfRequest $request)
  {
    $this->a_form_layout = Doctrine::getTable('aFormLayout')->find($request->getParameter('layout_id'));
    
    $this->form = new aFormLayoutForm($this->a_form_layout);

    return $this->renderPartial('aForm/aFormLayoutForm', array('a_form_layout' => $this->a_form_layout, 'a_form_layout_form' => $this->form));
  }
  
  public function executeAddLayout(sfWebRequest $request)
  {
    if($request->isXmlHttpRequest())
    {
      $this->setLayout(false);
    }
    $this->aForm = $this->getObject();
    $this->aFormForm = new aFormForm($this->aForm);

    $this->aFormLayoutForm = new aFormLayoutForm();
    $this->aFormLayoutForm->bind($request->getParameter($this->aFormLayoutForm->getName()));
    if($this->aFormLayoutForm->isValid())
    {
      $this->aFormLayoutForm->save();
      $this->aFormLayout = $this->aFormLayoutForm->getObject();
    }
    $this->setTemplate('edit');
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
      return $object;
    else
      $this->forward404(); 
  }
  
  
  
}
