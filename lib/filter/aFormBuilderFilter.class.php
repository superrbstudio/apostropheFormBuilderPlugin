<?php

/**
 * aFormBuilderFilter form.
 *
 * @package    filters
 * @subpackage aFormBuilder *
 * @version    SVN: $Id: sfDoctrineFormTemplate.php 6174 2007-11-27 06:22:40Z fabien $
 */
class aFormBuilderFilter extends BaseaFormSubmissionFormFilter
{ 

  public function addFieldColumnQuery($query, $field, $value)
  {
    $fieldName = $field;
    if ('' != $value)
    {
      $query->addHaving(sprintf('%s LIKE ?', $fieldName), '%'.$value.'%');
    }
  }
 
  public function setup()
  {
    parent::setup();
		unset($this['form_id'], $this['ip_address'], $this['created_at'], $this['updated_at'], $this['deleted_at']);
    if (!$this->getOption('a_form') instanceof aForm)
    {
      throw new Exception("aFormBuilderFilter requires an instance of aForm in the 'a_form' option.");
    }
    
		/*TODO: This is a temporary fix, the ideal solution would be to handle the filter form in the same manner
		 * as the regular form, embedding subFilters into this form.  This will provide the functionality for now though
		 */
    foreach($this->getOption('a_form')->aFormLayouts as $aFormLayout)
    {
    	$form = $aFormLayout->getForm();
      foreach($aFormLayout->aFormFields as $aFormField)
      {
        $this->setWidget($aFormField['id'], $form[$aFormField['name']]->getWidget());
        $this->getWidget($aFormField['id'])->setLabel($aFormField['name']);
        $this->setValidator($aFormField['id'], new sfValidatorString(array('required' => false)));
      }      
    }
  }
  
  public function doBuildQuery(array $values)
  {
    $query = Doctrine_Query::create()
      ->from('aFormSubmission fs, aFormFieldSubmission ffs')
      ->addSelect('fs.id')
      ->where('fs.id = ffs.submission_id');
    foreach($this->getOption('a_form')->aFormLayouts as $aFormLayout)
    {
      foreach($aFormLayout->aFormFields as $aFormField)
      {
        $query->addSelect(sprintf("GROUP_CONCAT(IF(ffs.field_id = %s, ffs.value, null)) AS %s", $aFormField['id'], 'field_'.$aFormField['id']));
        if(isset($values[$aFormField['id']]))
          $this->addFieldColumnQuery($query, 'field_'.$aFormLayout['id'], $values[$aFormLayout['id']]);
      }
    }
    $query->addGroupBy('fs.id');
    return $query;
  }
}