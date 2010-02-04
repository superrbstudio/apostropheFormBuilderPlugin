<?php

class aFormSelect extends aFormEmbeddable
{
  protected $objects = array('select' => null);
  
  public function configure()
  {
    $this->setWidgets(array(
      'select' => new sfWidgetFormSelect(array('choices' => $this->getChoices())),
    ));

    $this->setValidators(array(
  		'select' => new sfValidatorChoice(array('choices' => array_keys($this->getChoices()), 'required' => $this->getRequired()), array(
  			'required' => 'Please select from one of the options.', 
  			'invalid'  => 'Please select from one of the options.'
  		)), 
    ));

    $this->widgetSchema['select']->setLabel($this->getLabel());
  }
  
  public function getChoices()
  {
    $choices = array('' => 'Please select an option');

    if (isset($this->options['choices']))
    {
      $choices = array_merge($choices, $this->options['choices']);
    }
    
    return $choices;
  }
}