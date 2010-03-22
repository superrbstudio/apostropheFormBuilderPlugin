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
    if ($this->getRequest()->isXmlHttpRequest())
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

    if ($aFormForm->isValid())
    {
      $aFormForm->save();
      $this->redirect('@a_form_edit?id='.$aFormForm->getObject()->getId());
    }
  }
 
  public function executeEdit(sfWebRequest $request)
  {    
    $this->aForm = $this->getObject();
    $this->aFormForm = new aFormForm($this->aForm);
    
    $this->aFormFieldset = new aFormFieldset();
    $this->aFormFieldsetForm = new aFormFieldsetForm($this->aFormFieldset, array('a_form' => $this->aForm));    
   
		$this->form = new aFormBuilder(array(), array('a_form' => $this->aForm));
  }
  
  public function executeUpdate(sfWebRequest $request)
  {
    $aForm = $this->getRoute()->getObject();
    
    $aFormForm = new aFormForm($aForm);
    $aFormForm->bind($request->getParameter($aFormForm->getName()));

    if ($aFormForm->isValid())
    {
      $aFormForm->save();
      $this->redirect('@a_form_edit?id='.$aFormForm->getObject()->getId());
    }
  }
  
  /**
   * aFormFieldset actions.
   * These should be refactored into their own module ASAP.
   */
  public function executeShowFieldset(sfWebRequest $request)
  {
    $this->aForm = $this->getObject();
    $this->aFormForm = new aFormForm($this->aForm, array('a_form' => $this->aForm));

    $this->aFormFieldset = Doctrine::getTable('aFormFieldset')->find($request->getParameter('fieldset_id'));    
    $this->forward404Unless($this->aFormFieldset);

    return $this->renderPartial('aForm/aFormFieldsetEdit', array(
      'aForm'       => $this->aForm,
      'aFormFieldset' => $this->aFormFieldset,
    ));
  }
  
  public function executeAddFieldset(sfWebRequest $request)
  {
    $this->aForm = $this->getObject();
    $this->aFormForm = new aFormForm($this->aForm);

    $this->aFormFieldsetForm = new aFormFieldsetForm();
    $this->aFormFieldsetForm->bind($request->getParameter($this->aFormFieldsetForm->getName()));
    
    $this->aFormFieldset = $this->aFormFieldsetForm->getObject();

    if ($this->aFormFieldsetForm->isValid())
    {
      $this->aFormFieldsetForm->save();
      
      $this->aFormFieldset = new aFormFieldset();
      $this->aFormFieldsetForm = new aFormFieldsetForm($this->aFormFieldset, array('a_form' => $this->aForm));    
    }

    $this->setTemplate('edit');
  }
  
  public function executeUpdateFieldset(sfWebRequest $request)
  {
    $this->aForm = $this->getObject();

    $this->aFormFieldset = Doctrine::getTable('aFormFieldset')->find($request->getParameter('fieldset_id'));
    $this->forward404Unless($this->aFormFieldset);
    
    $this->aFormFieldsetForm = new aFormFieldsetForm($this->aFormFieldset);

    $this->aFormFieldsetForm->bind($request->getParameter($this->aFormFieldsetForm->getName()));

    if ($this->aFormFieldsetForm->isValid())
    {
      $this->aFormFieldset = $this->aFormFieldsetForm->save();
      
      return $this->renderPartial('aForm/aFormFieldsetEdit', array(
        'aForm'       => $this->aForm,
        'aFormFieldset' => $this->aFormFieldset,
      ));
    }
    else
    {
      return $this->renderPartial('aForm/aFormFieldsetForm', array(
        'aForm'           => $this->aForm,
        'aFormFieldset'     => $this->aFormFieldset,
        'aFormFieldsetForm' => $this->aFormFieldsetForm
      ));
    }
  }
  
  public function executeEditFieldset(sfWebRequest $request)
  {    
    $this->aForm = $this->getObject();

    $this->aFormFieldset = Doctrine::getTable('aFormFieldset')->find($request->getParameter('fieldset_id'));
    $this->forward404Unless($this->aFormFieldset);

    $this->aFormFieldsetForm = new aFormFieldsetForm($this->aFormFieldset);

    return $this->renderPartial('aForm/aFormFieldsetForm', array(
      'aForm'           => $this->aForm,
      'aFormFieldset'     => $this->aFormFieldset,
      'aFormFieldsetForm' => $this->aFormFieldsetForm
    ));
  }
  
  public function executeDeleteFieldset(sfWebRequest $request)
  {
    $this->aForm = $this->getObject();
    
    $this->aFormFieldset = Doctrine::getTable('aFormFieldset')->find($request->getParameter('fieldset_id'));
    $this->forward404Unless($this->aFormFieldset);
    
    $this->aFormFieldset->delete();

    return sfView::NONE;
  }
  
  public function executeSortFieldsets(sfWebRequest $request)
  {
    $aForm = $this->getObject();
    $order = $request->getParameter('a-form-fieldset');
    Doctrine::getTable('aFormFieldset')->doSort($order);
    
    return sfView::NONE;
  }

  /**
   * aFormFieldsetOption actions.
   * These should be refactored into their own module just like the aFormFieldset actions.
   */
  public function executeShowFieldsetOption(sfWebRequest $request)
  {
    $this->aForm = $this->getObject();
    $this->aFormForm = new aFormForm($this->aForm, array('a_form' => $this->aForm));

    $this->aFormFieldset = Doctrine::getTable('aFormFieldset')->find($request->getParameter('fieldset_id'));    
    $this->forward404Unless($this->aFormFieldset);

    $this->aFormFieldsetOption = Doctrine::getTable('aFormFieldset')->find($request->getParameter('fieldset_option_id'));    
    $this->forward404Unless($this->aFormFieldsetOption);

    $this->aFormFieldsetOptionForm = new aFormFieldsetOptionForm($this->aFormFieldsetOption);

    return $this->renderPartial('aForm/aFormFieldsetEdit', array(
      'aForm'             => $this->aForm,
      'aFormFieldset'       => $this->aFormFieldset,
      'aFormFieldsetOption' => $this->aFormFieldsetOption, 
    ));
  }
  
  public function executeAddFieldsetOption(sfWebRequest $request)
  {
    $this->aForm = $this->getObject();
    $this->aFormForm = new aFormForm($this->aForm);

    $this->aFormFieldset = Doctrine::getTable('aFormFieldset')->find($request->getParameter('fieldset_id'));    
    $this->forward404Unless($this->aFormFieldset);

    $this->aFormFieldsetOptionForm = new aFormFieldsetOptionForm();
    $this->aFormFieldsetOptionForm->bind($request->getParameter($this->aFormFieldsetOptionForm->getName()));
    
    $this->aFormFieldsetOption = $this->aFormFieldsetOptionForm->getObject();

    if ($this->aFormFieldsetOptionForm->isValid())
    {
      $this->aFormFieldsetOptionForm->save();
      
      $this->aFormFieldsetOption = new aFormFieldsetOption();
      $this->aFormFieldsetOptionForm = new aFormFieldsetForm($this->aFormFieldset, array('a_form' => $this->aForm));    
    }

    return $this->renderPartial('aForm/aFormFieldsetEdit', array(
      'aForm'       => $this->aForm,
      'aFormFieldset' => $this->aFormFieldset,
    ));
  }
  
  public function executeUpdateFieldsetOption(sfWebRequest $request)
  {
    $this->aForm = $this->getObject();

    $this->aFormFieldset = Doctrine::getTable('aFormFieldset')->find($request->getParameter('fieldset_id'));
    $this->forward404Unless($this->aFormFieldset);
    
    $this->aFormFieldsetOption = Doctrine::getTable('aFormFieldset')->find($request->getParameter('fieldset_option_id'));    
    $this->forward404Unless($this->aFormFieldsetOption);

    $this->aFormFieldsetOptionForm = new aFormFieldsetOptionForm($this->aFormFieldsetOption);

    $this->aFormFieldsetOptionForm->bind($request->getParameter($this->aFormFieldsetOptionForm->getName()));

    if ($this->aFormFieldsetForm->isValid())
    {
      $this->aFormFieldset = $this->aFormFieldsetForm->save();
      
      return $this->renderPartial('aForm/aFormFieldsetEdit', array(
        'aForm'             => $this->aForm,
        'aFormFieldset'       => $this->aFormFieldset,
        'aFormFieldsetOption' => $this->aFormFieldsetOption, 
      ));
    }
  }
  
  public function executeEditFieldsetOption(sfWebRequest $request)
  {    
    $this->aForm = $this->getObject();

    $this->aFormFieldset = Doctrine::getTable('aFormFieldset')->find($request->getParameter('fieldset_id'));
    $this->forward404Unless($this->aFormFieldset);
    
    $this->aFormFieldsetOption = Doctrine::getTable('aFormFieldset')->find($request->getParameter('fieldset_option_id'));    
    $this->forward404Unless($this->aFormFieldsetOption);

    $this->aFormFieldsetOptionForm = new aFormFieldsetOptionForm($this->aFormFieldsetOption);

    return $this->renderPartial('aForm/aFormFieldsetEdit', array(
      'aForm'                 => $this->aForm,
      'aFormFieldset'           => $this->aFormFieldset,
      'aFormFieldsetOption'     => $this->aFormFieldsetOption, 
      'aFormFieldsetOptionForm' => $this->aFormFieldsetOptionForm, 
    ));
  }
  
  public function executeDeleteFieldsetOption(sfWebRequest $request)
  {
    $this->aForm = $this->getObject();
    
    $this->aFormFieldsetOption = Doctrine::getTable('aFormFieldset')->find($request->getParameter('fieldset_option_id'));    
    $this->forward404Unless($this->aFormFieldsetOption);
    
    $this->aFormFieldsetOption->delete();

    return sfView::NONE;
  }
  
  public function executeSortFieldsetOptions(sfWebRequest $request)
  {
    $this->aForm = $this->getObject();
    
    $this->aFormFieldset = Doctrine::getTable('aFormFieldset')->find($request->getParameter('fieldset_id'));
    
    $order = $request->getParameter('a-form-fieldset-optiont');
    Doctrine::getTable('aFormFieldsetOption')->doSort($order);
    
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

    if (true)
    {
      return $object;
    }
    else
    {
      $this->forward404(); 
    }
  }
}
