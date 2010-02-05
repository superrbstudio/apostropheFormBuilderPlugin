<?php

class aFormInput extends aFormEmbeddable
{
  protected $objects = array('input' => null);
  
  public function configure()
  {
    $this->setWidgets(array(
      'input' => new sfWidgetFormInput(),
    ));

    $this->setValidators(array(
      'input' => new sfValidatorString(array('required' => $this->getRequired(), 'max_length' => 255), array(
        'required' => 'This field is required.', 
        'invalid' => 'Your text is too long. Please make sure it is less than 255 characters.', 
      )),
    ));
    
    $this->widgetSchema['input']->setLabel($this->getLabel());
  }
}
