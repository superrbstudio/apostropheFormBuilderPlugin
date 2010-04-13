<?php
/**
 */
class PluginaFormFieldsetTable extends Doctrine_Table
{  
  public static function getTypes()
  {
    return sfConfig::get('app_aFormBuilder_fieldsets');
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