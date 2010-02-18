<?php

/**
 * Base actions for the apostropheFormBuilderPlugin aFormSubmission module.
 * 
 * @package     apostropheFormBuilderPlugin
 * @subpackage  aFormSubmission
 * @author      Dan Ordille
 * @author      Alex Gilbert
 * @version     SVN: $Id: BaseActions.class.php 12534 2008-11-01 13:38:27Z Kris.Wallsmith $
 */
abstract class BaseaFormSubmissionActions extends sfActions
{
  /**
   * Action that lists all for submissions
	 * @param sfWebRequest $request
	 * @return 
   */
  public function executeIndex(sfWebRequest $request)
  {
    $this->aFormSubmissions = Doctrine::getTable('aFormSubmission')
      ->createQuery('fs')
      ->execute();
  }
  
	/**
	 * Action that renders a new form submission
	 * @param sfWebRequest $request
	 * @return 
	 */
	public function executeNew(sfWebRequest $request)
	{
		$this->forward404Unless($this->aForm = $this->getRoute()->getObject());
		$this->form = new aFormBuilder(array(), array('a_form' => $this->aForm));
	}
	
	/**
	 * Action to edit an existing submission
	 * @param sfWebRequest $request
	 * @return 
	 */
	public function executeEdit(sfWebRequest $request)
	{
		$this->forward404Unless($this->aFormSubmission = $this->getRoute()->getObject());
		$this->form = new aFormBuilder($this->aFormSubmission);
	}
	
	/**
	 * Action that creates a new aFormSubmission
	 * @param sfWebRequest $request
	 * @return 
	 */
	public function executeCreate(sfWebRequest $request)
	{
		$this->forward404Unless($this->aForm = $this->getRoute()->getObject());
		$this->form = new aFormBuilder(array(), array('a_form' => $this->aForm));
		if($this->processForm($this->form, $request))
		{
			//TODO: Here is where any additional action parameter stuff will be handled
			$this->redirect('@a_form_submission_edit?id='.$this->form->getObject()->getId());
		}
		$this->setTemplate('new');
	}
	
	/**
	 * Action that updates an existing aFormSubmission
	 * @param sfWebRequest $request
	 * @return 
	 */
	public function executeUpdate(sfWebRequest $request)
	{
		$this->forward404Unless($this->aFormSubmission = $this->getRoute()->getObject());
		$this->form = new aFormBuilder($this->aFormSubmission);
		if($this->processForm($this->form, $request))
    {
      //TODO: Here is where any additional action parameter stuff will be handled
    }
		$this->setTemplate('edit');
	}
	
	/**
	 * Method to bind and save a form if it is valid.
	 * @param aFormBuilder $form
	 * @param sfWebRequest $request
	 * @return 
	 */
	public function processForm(aFormBuilder $form, sfWebRequest $request)
	{
		$form->bind($request->getParameter('form'));
		if($form->isValid())
		{
			return $form->save();
		}
		return false;
	}
  
  public function executeNewSequence(sfWebRequest $request)
  {
    //TODO: Refactor into model
    $aForm = Doctrine::getTable('aForm')->createQuery('f')
      ->leftJoin('f.aFormLayouts fl INDEXBY fl.rank')
      ->where('f.id = ?', $request->getParameter('form_id'))
      ->orderBy('fl.rank')
      ->fetchOne();
    $aFormSubmission = new aFormSubmission();
    $aFormSubmission->setFormId($aForm->getId());
    $aFormSubmission->save();
    //TODO: Make sure form has layouts
    $this->redirect('@a_form_submission_sequence?id='.$aFormSubmission->getId().'&form_id='.$aForm->getId().'&layout_rank=1');
  }
  
  public function executeSequence(sfWebRequest $request)
  {
    $this->aFormSubmission = $this->getRoute()->getObject();
    //TODO: Refactor into model
    $this->aForm = Doctrine::getTable('aForm')->createQuery('f')
      ->leftJoin('f.aFormLayouts fl INDEXBY fl.rank')
      ->where('f.id = ?', $request->getParameter('form_id'))
      ->orderBy('fl.rank')
      ->fetchOne();
    $this->aFormLayout = $this->aForm->aFormLayouts[$request->getParameter('layout_rank')];
    $this->forward404Unless($this->aForm);
    $this->forward404Unless($this->aFormLayout);
    
    $this->form = $this->aFormLayout->getForm(
      $this->aFormSubmission->getFieldSubmissionsForLayout($this->aFormLayout->getId()), 
      array('a_form_layout' => $this->aFormLayout, 'a_form_submission' => $this->aFormSubmission)
    );
    $this->pos = $request->getParameter('layout_rank');
    if($request->isMethod('POST'))
    {
      if(true)
      {
        $this->form->updateObjects($this->form->getValues());
        $this->form->save();
        /*$this->redirect('@a_form_submission_sequence'.
          '?id='.$this->aFormSubmission->getId().
          '&form_id='.$this->aForm->getId().
          '&layout_rank='.$this->pos+1
        );*/
      }
    }
  }	
}