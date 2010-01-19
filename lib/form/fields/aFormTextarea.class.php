<?php

class aFormTextarea extends aFormEmbeddable
{
  public function configure()
  {
    $this->setWidgets(array(
      'textarea' => new sfWidgetFormTextarea(),
    ));

    $this->setValidators(array(
      'textarea' => new sfValidatorString(array('required' => $this->getRequired()), array(
        'required' => 'This field is required.', 
      )),
    ));
    
    $this->widgetSchema['textarea']->setLabel($this->getLabel());
  }
}
