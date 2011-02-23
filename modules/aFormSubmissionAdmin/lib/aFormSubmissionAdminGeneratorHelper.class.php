<?php

/**
 * aFormSubmissionAdmin module helper.
 *
 * @package    apostropheFormBuilderPlugin
 * @subpackage aFormSubmissionAdmin
 * @author     Your name here
 * @version    SVN: $Id: helper.php 12474 2008-10-31 10:41:27Z fabien $
 */
class aFormSubmissionAdminGeneratorHelper extends BaseAFormSubmissionAdminGeneratorHelper
{
	public function linkToExport($params)
  {
    return '<li class="a-admin-action-edit">'.link_to(__($params['label'], array(), 'a_admin') . '<span class="icon"></span>', $this->getUrlForAction('export'), array() ,array("class"=>"a-btn big")).'</li>';
  }
}