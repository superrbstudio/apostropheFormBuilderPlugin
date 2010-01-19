<?php

class aFormSelectRadio extends aFormEmbeddable
{
  public function configure()
  {
    $this->setWidgets(array(
      'radio' => new sfWidgetFormSelectRadio(array('choices' => $this->getChoices())),
    ));

    $this->setValidators(array(
  		'radio' => new sfValidatorChoice(array('choices' => array_keys($this->getChoices()), 'required' => $this->getRequired()), array(
  			'required' => 'Please select from one of the options.', 
  			'invalid'  => 'Please select from one of the options.'
  		)), 
    ));

    $this->widgetSchema['radio']->setLabel($this->getLabel());
  }
  
  public function getChoices()
  {  
    return $this->options['choices'];
  }
}