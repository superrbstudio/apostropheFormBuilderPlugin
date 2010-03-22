<?php

abstract class aFormEmbeddable extends sfForm
{
  protected $objects = array();
  
  public function __construct($objects = null, $options = array(), $CSRFSecret = null)
  {
    parent::__construct(array(), $options, $CSRFSecret);
		if(is_array($objects))
		{
      foreach($objects as $object)
      {
        $this->objects[$object->getSubField()] = $object;
        $this->setDefault($object->getSubField(), $object->getValue());
      }
		}
  }
  
  public function setup()
  {
    parent::setup();
    $this->widgetSchema->setNameFormat('fieldset[%s]');
  }
      
  public function getObjects()
  {
    return $this->objects;
  }
  
  public function getRequired($default = false)
  {
    return isset($this->options['required']) ? $this->options['required'] : $default;
  }

  public function getLabel($default = false)
  {
    return isset($this->options['label']) ? $this->options['label'] : $default;
  }

  public function getSlug($default = false)
  {
    return isset($this->options['slug']) ? $this->options['slug'] : $default;
  }
  
  public function doUpdateObjects($values)
  {
    foreach ($this->getOption('a_form_fieldset')->aFormFields as $field)
    {
      if(is_null($this->objects[$field->name]))
      {
        $this->objects[$field->name] = new aFormFieldSubmission();
        $this->objects[$field->name]->setSubmissionId($this->getOption('a_form_submission'))->getId();
        $this->objects[$field->name]->setFieldsetId($this->getOption('a_form_fieldset')->getId());
        $this->objects[$field->name]->setFieldId($field->id);
        $this->objects[$field->name]->setSubField($field->name);
      }
      $this->objects[$field->name]->setValue($values[$field->name]);
    }
  }
    
  public function save($con = null)
  { 
    if (!$this->getOption('a_form_submission') instanceof aFormSubmission)
    {
      throw new Exception("Saving a aFormEmbeddable object requires an instance of aFormSubmission in the 'a_form_submission' option.");
    }

    if (!$this->getOption('a_form_fieldset') instanceof aFormFieldset)
    {
      throw new Exception("Saving a aFormEmbeddable object requires an instance of aFormFieldset in the 'a_form_fieldset' option.");
    }
    
    foreach ($this->getOption('a_form_fieldset')->aFormFields as $field)
    {
      $this->objects[$field->name]->save();
    }
  }
}