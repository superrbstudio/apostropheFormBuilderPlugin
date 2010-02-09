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
    
    foreach($this->getOption('a_form')->aFormLayouts as $aFormLayout)
    {
      $form = $aFormLayout->getForm();
      foreach($aFormLayout->getForm() as $subField => $field)
      {
        $this->setWidget($aFormLayout->getId().'_'.$subField, $field->getWidget());
        //$this->setValidator($aFormLayout->getId().'_'.$subField, $form->getValidator($subField));
        $this->getWidget($aFormLayout->getId().'_'.$subField)->setLabel($aFormLayout->getLabel());
        $this->setValidator($aFormLayout->getId().'_'.$subField, new sfValidatorString(array('required' => false)));
      }
      
      //$this->setWidget($aFormLayout->getId(), new sfWidgetFormInput());
      //
      
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
      foreach($aFormLayout->getForm()->getObjects() as $subField => $object)
      {
        $query->addSelect(sprintf("GROUP_CONCAT(IF(ffs.field_id = %s AND ffs.sub_field = '%s', ffs.value, null)) AS %s", $aFormLayout['id'], $subField, 'field_'.$aFormLayout['id']));
        if(isset($values[$aFormLayout['id']]))
          $this->addFieldColumnQuery($query, 'field_'.$aFormLayout['id'], $values[$aFormLayout['id']]);
      }
    }
    $query->addGroupBy('fs.id');
    return $query;
  }
}