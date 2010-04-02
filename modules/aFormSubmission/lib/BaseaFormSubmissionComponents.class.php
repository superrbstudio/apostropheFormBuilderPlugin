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
	
}