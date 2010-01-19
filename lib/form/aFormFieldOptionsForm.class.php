<?php

class aFormFieldOptionsForm extends sfForm
{
  /**
   * http://www.thatsquality.com/articles/can-the-symfony-forms-framework-be-domesticated-a-simple-option-list
   */
  public function configure()
  {    
    if (!$this->getOption('a_form_field') instanceof aFormField)
    {
      throw new Exception("aFormFieldOptionForm requires an instance of aFormField in the 'a_form_field' option.");
    }

    $optionWrapperForm = new sfForm();
    foreach($this->getOption('a_form_field')->getpkFormFieldOptions() as $option)
    {
      $optionWrapperForm->embedForm($option->getId(), new aFormFieldOptionForm($option));
    }

    $optionWrapperForm->embedForm('new_1', new aFormFieldOptionForm());
    
    $this->embedForm('options', $optionWrapperForm);
    
    $this->widgetSchema->setNameFormat('option_list[%s]');
  }

  public function save()
  {
    $values = $this->getValues();

    foreach($this->embeddedForms['options']->getEmbeddedForms() as $key => $optionForm)
    {
      if ($values['options'][$key]['name'])
      {
        // only save options that aren't blank
        $optionForm->updateObject($values['options'][$key]);
        $optionForm->getObject()->setFieldId($this->getOption('a_form_field')->getId());
        $optionForm->getObject()->save();
      }
      else if (!$optionForm->getObject()->isNew())
      {
        // delete any existing options that are now blank
        $optionForm->getObject()->delete();
      }
    }
  }
}
