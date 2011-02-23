<?php

/**
 * Base actions for the apostropheFormBuilderPlugin aFormSlot module.
 * 
 * @package     apostropheFormBuilderPlugin
 * @subpackage  aFormSlot
 * @author      Alex Gilbert
 * @version     SVN: $Id: BaseActions.class.php 12534 2008-11-01 13:38:27Z Kris.Wallsmith $
 */
abstract class BaseaFormSlotComponents extends BaseaSlotComponents
{
  public function executeEditView()
  {
    $this->setup();
    
    if (!isset($this->form))
    {
      $this->form = new aFormForm($this->id, $this->slot->getAForm());
    }
  }

	public function executeNormalView()
	{	  
    $this->setup();
		$this->a_form = $this->slot->getAForm();
    $this->form = new aFormBuilder(array(), array('a_form' => $this->a_form));
		
		// This should be refactored into the slot object or the base actions or
		// something like that.
		$this->slotParams = array(
      'slug' => $this->slug,
      'slot' => $this->name,
      'permid' => $this->permid, 
    );
	}
	
	public function executeAFormView()
	{
    if (!isset($this->form) || !$this->form->hasErrors())
    {
  		$this->form = $this->a_form->buildForm();
    }
	}

	public function executeAFormEdit()
	{
		$this->form = $this->a_form->buildForm();

    if (!isset($this->a_form_form) || !$this->a_form_form->hasErrors())
    {
      $this->a_form_form = new aFormForm($this->a_form);
    }
    
    if (!isset($this->a_form_fieldset_form) || !$this->a_form_fieldset_form->hasErrors())
    {
      $this->a_form_fieldset = new aFormField();
      $this->a_form_fieldset_form = new aFormFieldForm($this->a_form_fieldset, array('a_form' => $this->a_form));
    }
	}
	
	public function executeAFormFieldOptions()
	{
    $this->a_form_fieldset_options_form = $this->a_form_fieldset->getOptionsForm();
	}
	
	public function executeSubmitEmail()
	{
	  $values = $this->form->getValues();
    $this->values = array();
	  foreach ($values['fields'] as $field_id => $field_values)
	  {
	    $this->values[Doctrine::getTable('aFormField')->find($field_id)->getLabel()] = $field_values;
	  }
	}
}
