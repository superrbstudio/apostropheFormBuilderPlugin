<?php
require_once dirname(__FILE__).'/../lib/BaseaFormSlotComponents.class.php';
class aFormSlotComponents extends BaseaFormSlotComponents
{
  public function executeEditView()
  {
    $this->setup();
    
    $this->form = new aFormForm($this->slot->getAForm());
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
}
