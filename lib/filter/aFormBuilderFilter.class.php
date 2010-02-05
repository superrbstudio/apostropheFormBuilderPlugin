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
    if (!$this->getOption('a_form') instanceof aForm)
    {
      throw new Exception("aFormBuilderFilter requires an instance of aForm in the 'a_form' option.");
    }
    
    foreach($this->getOption('a_form')->aFormFields as $aFormField)
    {
      $this->setWidget($aFormField->getId(), new sfWidgetFormInput());
      $this->setValidator($aFormField->getId(), new sfValidatorString(array('required' => false)));
      $this->getWidget($aFormField->getId())->setLabel($aFormField->getLabel());
    }
  }
  
  public function doBuildQuery(array $values)
  {
    $query = parent::doBuildQuery($values);
    
    $query = Doctrine_Query::create()
      ->from('aFormSubmission fs, aFormFieldSubmission ffs')
      ->addSelect('fs.*')
      ->where('fs.id = ffs.submission_id');
    foreach($this->getOption('a_form')->aFormFields as $aFormField)
    {
      $query->addSelect(sprintf("GROUP_CONCAT(IF(ffs.field_id = %s, ffs.value, null)) AS %s", $aFormField['id'], 'field_'.$aFormField['id']));
      if(isset($values[$aFormField['id']]))
        $this->addFieldColumnQuery($query, 'field_'.$aFormField['id'], $values[$aFormField['id']]);
    }
    $query->addGroupBy('fs.id');
    return $query;
  }
}