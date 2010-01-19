<?php

class aFormEmbeddable extends sfForm
{
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
  
  public function save()
  {
    if (!$this->getOption('a_form_submission') instanceof aFormSubmission)
    {
      throw new Exception("Saving a aFormEmbeddable object requires an instance of aFormSubmission in the 'a_form_submission' option.");
    }

    if (!$this->getOption('a_form_field') instanceof aFormField)
    {
      throw new Exception("Saving a aFormEmbeddable object requires an instance of aFormField in the 'a_form_field' option.");
    }

    foreach ($this as $key => $field)
    {
      $a_form_field_submission = new aFormFieldSubmission();
      $a_form_field_submission->setSubmissionId($this->getOption('a_form_submission')->getId());
      $a_form_field_submission->setFieldId($this->getOption('a_form_field')->getId());
      $a_form_field_submission->setSubField((count($this) > 1) ? $key : null);
      $a_form_field_submission->setValue($field->getValue());
      $a_form_field_submission->save();
    }
  }
}