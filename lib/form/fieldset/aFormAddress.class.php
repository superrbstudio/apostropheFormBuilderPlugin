<?php

class aFormAddress extends aFormEmbeddable
{
  protected $objects = array(
    'street1' => null, 
    'street2' => null, 
    'city' => null, 
    'state' => null, 
    'postal_code' => null, 
    'country' => null);
  
  public function configure()
  {
    $this->setWidgets(array(
      'street1'     => new sfWidgetFormInput(),
      'street2'     => new sfWidgetFormInput(),
      'city'        => new sfWidgetFormInput(),
      'state'       => new sfWidgetFormInput(),
      'postal_code' => new sfWidgetFormInput(),
      'country' => new sfWidgetFormI18nChoiceCountry(),
    ));

    $this->setValidators(array(
      'street1' => new sfValidatorString(array('required' => $this->getRequired(), 'max_length' => 255), array(
        'required' => 'This field is required.', 
        'invalid' => 'Your text is too long. Please make sure it is less than 255 characters.', 
      )),
      'street2' => new sfValidatorString(array('required' => false, 'max_length' => 255), array(
        'required' => 'This field is required.', 
        'invalid' => 'Your text is too long. Please make sure it is less than 255 characters.', 
      )),
      'city' => new sfValidatorString(array('required' => $this->getRequired(), 'max_length' => 255), array(
        'required' => 'This field is required.', 
        'invalid' => 'Your text is too long. Please make sure it is less than 255 characters.', 
      )),
      'state' => new sfValidatorString(array('required' => false, 'max_length' => 255), array(
        'required' => 'This field is required.', 
        'invalid' => 'Your text is too long. Please make sure it is less than 255 characters.', 
      )),
      'postal_code' => new sfValidatorString(array('required' => $this->getRequired(), 'max_length' => 255), array(
        'required' => 'This field is required.', 
        'invalid' => 'Your text is too long. Please make sure it is less than 255 characters.', 
      )),
      'country' => new sfValidatorString(array('required' => $this->getRequired(), 'max_length' => 255), array(
        'required' => 'This field is required.', 
        'invalid' => 'Your text is too long. Please make sure it is less than 255 characters.', 
      )),
    ));
    
    $this->widgetSchema['street1']->setLabel('Street address');
    $this->widgetSchema['street2']->setLabel('&nbsp;');
    $this->widgetSchema['city']->setLabel('City');
    $this->widgetSchema['state']->setLabel('State');
    $this->widgetSchema['postal_code']->setLabel('Postal Code');
    $this->widgetSchema['country']->setLabel('Country');
  }
}
