<?php

class aFormSelectCheckbox extends aFormEmbeddable
{
  public function configure()
  {
    foreach ($this->getChoices() as $value => $choice)
    {
      $this->setWidget($value, new sfWidgetFormInputCheckbox());
      $this->widgetSchema[$value]->setLabel($choice);
    }

    foreach ($this->getChoices() as $value => $choice)
    {
      $this->setValidator($value, new sfValidatorPass());
    }
  }
  
  public function getChoices()
  {  
    return $this->options['choices'];
  }
}