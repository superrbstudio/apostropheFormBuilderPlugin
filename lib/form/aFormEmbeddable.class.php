<?php

abstract class aFormEmbeddable extends sfForm
{
  protected $objects = array();
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
    foreach ($this->objects as $name => &$object)
    {
      if(is_null($object))
      {
        $object = new aFormFieldSubmission();
        $object->setSubmissionId($this->getOption('a_form_submission'))->getId();
        $object->setFieldId($this->getOption('a_form_field')->getId());
        $object->setSubField($name);
      }
      $object->setValue($values[$name]);
    }
  }
    
  public function save($con = null)
  { 
    if (!$this->getOption('a_form_submission') instanceof aFormSubmission)
    {
      throw new Exception("Saving a aFormEmbeddable object requires an instance of aFormSubmission in the 'a_form_submission' option.");
    }

    if (!$this->getOption('a_form_field') instanceof aFormField)
    {
      throw new Exception("Saving a aFormEmbeddable object requires an instance of aFormField in the 'a_form_field' option.");
    }
    
    foreach ($this->objects as $name => &$object)
    {
      $object->save();
    }
  }
}