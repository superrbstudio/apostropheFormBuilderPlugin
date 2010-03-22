<?php

/**
 * PluginaFormFieldset form.
 *
 * @package    ##PROJECT_NAME##
 * @subpackage form
 * @author     ##AUTHOR_NAME##
 * @version    SVN: $Id: sfDoctrineFormPluginTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
abstract class PluginaFormFieldsetForm extends BaseaFormFieldsetForm
{
  public function setup()
  {
    parent::setup();
    
    unset(
      $this['rank'], $this['help'], $this['slug']
    );
    
    $this->setWidget('type', new sfWidgetFormChoice(array('choices' => aFormFieldset::getTypes())));
    $this->setWidget('form_id', new sfWidgetFormInputHidden());
    $this->setDefault('form_id', $this->getAForm()->getId());
  }
  
  public function getAForm()
  {
    return isset($this->options['a_form']) ? $this->options['a_form'] : $this->getObject()->getAForm();
  }
  
  public function doUpdateObject($values)
  {
    parent::doUpdateObject($values);
    if($this->getObject()->isNew())
    {
      foreach($this->getObject()->getForm()->getObjects() as $name => $object)
      {
        $field = new aFormField();
        $field->setName($name);
        $this->getObject()->aFormFields[] = $field;
      }
    }
  }
}
