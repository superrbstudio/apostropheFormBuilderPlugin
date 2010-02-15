<?php

class aFormSelectCheckbox extends aFormEmbeddable
{
  protected $objects = array();
  
  public function configure()
  {
    foreach ($this->getChoices() as $value => $choice)
    {
      $this->setWidget($value, new sfWidgetFormInputCheckbox());
      $this->widgetSchema[$value]->setLabel($choice);
			$this->objects[$value] = null;
    }

    foreach ($this->getChoices() as $value => $choice)
    {
      $this->setValidator($value, new sfValidatorBoolean(array(
        'true_values' =>  array('1'),
        'false_values' => array('0', ' ', '')
      )));
    }
  }
  
  public function getChoices()
  {  
    return $this->options['choices'];
  }
}