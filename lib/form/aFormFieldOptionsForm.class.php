<?php

class aFormLayoutOptionsForm extends sfForm
{
  /**
   * http://www.thatsquality.com/articles/can-the-symfony-forms-framework-be-domesticated-a-simple-option-list
   */
  public function configure()
  {    
    if (!$this->getOption('a_form_layout') instanceof aFormLayout)
    {
      throw new Exception("aFormLayoutOptionForm requires an instance of aFormLayout in the 'a_form_layout' option.");
    }

    $optionWrapperForm = new sfForm();
    foreach($this->getOption('a_form_layout')->getpkFormFieldOptions() as $option)
    {
      $optionWrapperForm->embedForm($option->getId(), new aFormLayoutOptionForm($option));
    }

    $optionWrapperForm->embedForm('new_1', new aFormLayoutOptionForm());
    
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
        $optionForm->getObject()->setFieldId($this->getOption('a_form_layout')->getId());
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
