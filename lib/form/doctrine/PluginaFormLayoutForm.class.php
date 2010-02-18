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
    $this->setDefault('form_id', $this->getAForm()->getId());
  }
  
  public function getAForm()
  {
    return isset($this->options['a_form']) ? $this->options['a_form'] : $this->getObject()->getAForm();
  }
  
  public function save($con = null)
  {
    //TODO: Redo some of this to make cleaner
    parent::save();
    foreach($this->getObject()->getForm()->getObjects() as $name => $object)
    {
      $field = new aFormField();
      $field->setName($name);
      $this->getObject()->aFormFields[] = $field;
    }
    $this->getObject()->save();
    return $this->getObject();    
  }
}