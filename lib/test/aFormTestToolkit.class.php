<?php

/**
 * A collection of static methods useful for helping get things tested easily.
 * Mostly arrays of test data, both valid and invalid, for use with the individual
 * aFormLayout classes.
 */
class aFormTestTools extends aTestTools
{
  static public function getValidData($field = null)
  {
    $data = sfYaml::load(sfConfig::get('sf_plugins_dir').'/apostropheFormBuilderPlugin/test/data/values.yml');
    
    if ($field)
    {
      return $data['valid'][$field];
    }

    return $data['valid'];
  }
  
  static public function getInvalidData($field = null)
  {
    $data = sfYaml::load(sfConfig::get('sf_plugins_dir').'/apostropheFormBuilderPlugin/test/data/values.yml');
    
    if ($field)
    {
      return $data['invalid'][$field];
    }

    return $data['invalid'];    
  }
}