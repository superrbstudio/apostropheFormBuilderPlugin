<?php

class aFormSelectCheckbox extends aFormEmbeddable
{
  protected $objects = array();
  
  public function configure()
  {
    foreach ($this->getChoices() as $value => $choice)
    {
      $this->setWidget($value, new sfWidgetFormInputCheckbox(array('value_attribute_value' => $value)));
      $this->widgetSchema[$value]->setLabel($choice);
			$this->objects[$value] = null;
      $this->setValidator($value, new sfValidatorChoice(array(
        'choices' => array($value, ''),
        'multiple' => false,
        'required' => false
      )));
    }
  }
  
  public function getChoices()
  {  
    return $this->options['choices'];
  }
}