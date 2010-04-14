<?php

/**
 * Base components for the apostropheFormBuilderPlugin aFormSubmission module.
 * 
 * @package     apostropheFormBuilderPlugin
 * @subpackage  aFormSubmission
 * @author      Dan Ordille
 * @author      Alex Gilbert
 * @version     SVN: $Id: BaseComponents.class.php 12534 2008-11-01 13:38:27Z Kris.Wallsmith $
 */
abstract class BaseaFormSubmissionComponents extends sfComponents
{
  public function executeNew()
  {
    $this->form = new aFormBuilder(array(), array('a_form' => $this->aForm));
  }

  /**
   * executeSubForm renders html for a sub form.  An apostrophe form is broken
   * up into many sub forms by the page break fieldset.
   *
   * @param $aForm The apostrophe form to use for rendering
   * @param $aFormSubmission The apostrophe form submission
   * @param $rank The index of the subform that should be rendered.
   */
  public function executeSubform()
  {
    $this->form = $this->aForm->getSubform($this->rank, $this->aFormSubmission);
  }
	
}