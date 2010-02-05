<?php

/**
 * aFormSubmissionAdmin module configuration.
 *
 * @package    aBlog
 * @subpackage aFormSubmissionAdmin
 * @author     Your name here
 * @version    SVN: $Id: configuration.php 12474 2008-10-31 10:41:27Z fabien $
 */
class aFormSubmissionGeneratorConfiguration extends BaseAFormSubmissionGeneratorConfiguration
{
  public function getFilterForm($filters, $options = array())
  {
    $class = $this->getFilterFormClass();
  
    return new $class($filters, array_merge($this->getFilterFormOptions(), $options));
  }
}