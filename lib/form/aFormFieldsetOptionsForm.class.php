<?php

class aFormFieldsetOptionsForm extends aFormFieldsetForm
{
  public function setup()
  {
    parent::setup();
    unset($this['form_id'], $this['rank'], $this['type'], $this['label'], $this['help'], $this['required'], $this['slug']);

    $optionsForm = new sfForm();
    $newOptionsForm = new sfForm();
    
    foreach ($this->getObject()->aFormFieldsetOptions as $i => $aFormFieldsetOption)
    {
      $form = new aFormFieldsetOptionForm($aFormFieldsetOption);
      unset($form['fieldset_id'], $form['id'], $form['rank']);
      $optionsForm->embedForm($i, $form);
    }
    $this->embedForm('options', $optionsForm);
  }

}