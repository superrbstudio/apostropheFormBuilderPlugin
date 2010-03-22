<?php
/**
 */
class PluginaFormFieldsetTable extends Doctrine_Table
{
  protected static $types = array(
    'input' => 'Text Field',
    'textarea' => 'Text Area', 
    'select' => 'Select Menu', 
    'select_radio' => 'Radio Select', 
    'select_checkbox' => 'Check Box', 
    'address' => 'Address Fields',
  );
  
  public static function getTypes()
  {
    return array_merge(sfConfig::get('app_aFormBuilder_fieldsets'), self::$types);
  }

  public function doSort($order = array())
  {    
    $fields = array();
    $aFormFieldsets = $this->createQuery('fl INDEXBY fl.id')->whereIn('id', $order)->execute();
    foreach ($order as $rank => $id) 
    {
      $field = $aFormFieldsets[$id];
      
      if ($field->getRank() != $rank)
      {
        $field->setRank($rank);
        $field->save();
      }
      
      $fields[] = $field;
    }
    
    return $fields;
  }
}