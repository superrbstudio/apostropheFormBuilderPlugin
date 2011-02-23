<?php

/**
 * PluginaFormFieldset
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @package    ##PACKAGE##
 * @subpackage ##SUBPACKAGE##
 * @author     ##NAME## <##EMAIL##>
 * @version    SVN: $Id: Builder.php 7021 2010-01-12 20:39:49Z lsmith $
 */
abstract class PluginaFormFieldset extends BaseaFormFieldset
{
  protected $form;
  protected $optionsForm;
  
  public static function getTypes()
  {
    return aFormFieldsetTable::getTypes();
  }
   
  public function getFormClass()
  {
    return 'aForm'.sfInflector::camelize($this->getType());
  }
    
  public function getFormOptions()
  {
    
    $options = array(
      'slug' => $this->getSlug(), 
      'label' => $this->getLabel(),
      'required' => $this->getRequired(),
    );
    
    if ($this->usesOptions())
    {
      $options['choices'] = array();
      foreach ($this->aFormFieldsetOptions as $choice)
      {
        $options['choices'][(string)$choice->getValue()] = $choice->getName();
      }
    }
    
    return $options;
  }
  
  public function usesOptions()
  {
    if (in_array($this->getType(), array('select', 'select_radio', 'select_checkbox')))
    {
      return true;
    }
    
    return false;
  }
  
  public function getForm($defaults = null, $options = array())
  {
    
    $class = $this->getFormClass();
    error_log("Class is $class");
    $this->form = new $class($defaults, array_merge($options, $this->getFormOptions()));
    
    error_log(get_class($this->form));
    return $this->form;
  }
  
  public function getOptionsForm()
  {
    if(!isset($this->optionsForm))
    {
      $this->optionsForm = new aFormFieldsetOptionsForm($this);
    }
    
    return $this->optionsForm;
  }

  public function setOptionsForm($form)
  {
    $this->optionsForm = $form;
  }
  
  public function preSave($event)
  {
    if($this->isNew() && (!isset($this->rank) || is_null($this->rank)))
    {
      $max = Doctrine::getTable('aForm')->getMaxRank($this->getFormId());
      if(is_null($max))
        $this->setRank(0);
      else
        $this->setRank($max + 1);
    }
  }
  
  public function setType($value)
  {
    if(!$this->isNew())
      return false;
    return $this->_set('type', $value);
  }
	
	public function postDelete($event)
	{
		Doctrine_Query::create()
		  ->update('aFormFieldset')
			->set('rank', 'rank - 1')
			->where('aFormFieldset.form_id = ? AND aFormFieldset.rank > ?', array($this->getFormId(), $this->getRank()))
			->execute();
	}
}