<?php

/**
 * PluginaFormField form.
 *
 * @package    form
 * @subpackage aFormField
 * @version    SVN: $Id: sfDoctrineFormTemplate.php 6174 2007-11-27 06:22:40Z fabien $
 */
abstract class PluginaFormFieldForm extends BaseaFormFieldForm
{
  public function setup()
  {
    parent::setup();
    
    unset(
      $this['rank'], $this['help'], $this['slug']
    );
    
    $this->setWidget('type', new sfWidgetFormChoice(array('choices' => aFormField::getTypes())));
    $this->setWidget('form_id', new sfWidgetFormInputHidden());
    
    $this->setDefault('form_id', $this->getpkForm()->getId());
  }
  
  public function getpkForm()
  {
    return isset($this->options['a_form']) ? $this->options['a_form'] : $this->getObject()->getpkForm();
  }
  
  // public function doSave($con = null)
  // {
  //   echo "<pre>";
  //   print_r($this->widgetSchema);
  //   echo "</pre>";
  //   exit();
  // }
}