<?php

/**
 * PluginaForm form.
 *
 * @package    form
 * @subpackage aForm
 * @version    SVN: $Id: sfDoctrineFormTemplate.php 6174 2007-11-27 06:22:40Z fabien $
 */
abstract class PluginaFormForm extends BaseaFormForm
{
  public function setup()
  {
    parent::setup();
    
    unset(
      $this['created_at'], $this['updated_at'], $this['description']
    );

		$this->widgetSchema->setLabels(array(
		  'name'    => 'Form Name',
		  'email_to'   => 'Email To',
		  'thank_you' => 'Thank You',
		));
  }
}