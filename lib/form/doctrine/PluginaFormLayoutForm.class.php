<?php

/**
 * PluginaFormLayout form.
 *
 * @package    form
 * @subpackage aFormLayout
 * @version    SVN: $Id: sfDoctrineFormTemplate.php 6174 2007-11-27 06:22:40Z fabien $
 */
abstract class PluginaFormLayoutForm extends BaseaFormLayoutForm
{
  public function setup()
  {
    parent::setup();
    
    unset(
      $this['rank'], $this['help'], $this['slug']
    );
    
    $this->setWidget('type', new sfWidgetFormChoice(array('choices' => aFormLayout::getTypes())));
    $this->setWidget('form_id', new sfWidgetFormInputHidden());
  }
    
  // public function doSave($con = null)
  // {
  //   echo "<pre>";
  //   print_r($this->widgetSchema);
  //   echo "</pre>";
  //   exit();
  // }
}