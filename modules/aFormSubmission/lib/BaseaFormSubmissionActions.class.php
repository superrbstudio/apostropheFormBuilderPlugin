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
	
	
	
}