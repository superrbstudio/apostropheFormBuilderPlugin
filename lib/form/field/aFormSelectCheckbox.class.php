<?php

class aFormSelectCheckbox extends aFormEmbeddable
{
  public function configure()
  {
    foreach ($this->getChoices() as $choice)
    {
      $this->setWidget($choice, new sfWidgetFormInputCheckbox());
      $this->widgetSchema[$choice]->setLabel($choice);
    }

    foreach ($this->getChoices() as $choice)
    {
      $this->setValidator($choice, new sfValidatorPass());
    }
  }
  
  public function getChoices()
  {  
    return $this->options['choices'];
  }
}