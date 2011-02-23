<?php

/**
 * PluginaForm form.
 *
 * @package    form
 * @subpackage aForm
 * @version    SVN: $Id: sfDoctrineFormTemplate.php 6174 2007-11-27 06:22:40Z fabien $
 */
abstract class PluginaFormForm extends BaseaFormForm
{
  // Ensures unique IDs throughout the page
  protected $id;
  // PARAMETERS ARE REQUIRED, no-parameters version is strictly to satisfy i18n-update
  public function __construct($id = 1, $object = null)
  {
    $this->id = $id;
    parent::__construct($object);
  }
  
  public function configure()
  {
    unset(
      $this['created_at'],
      $this['updated_at'],
      $this['description'],
      $this['deleted_at'],
      $this['action']
    );

		$this->widgetSchema->setLabels(array(
		  'name' => 'Form Name',
		  'email_to'   => 'Email To',
		  'thank_you' => 'Thank You',
		));
		
		$this->setWidget('form_editor', new sfWidgetFormInputHidden(array('default' => $this->toJson($this->getObject()))));
		$this->setValidator('form_editor', new sfValidatorPass());
		
		// Ensures unique IDs throughout the page
    $this->widgetSchema->setNameFormat('slot-form-' . $this->id . '[%s]');
    $this->widgetSchema->setFormFormatterName('aAdmin');
    $this->widgetSchema->getFormFormatter()->setTranslationCatalogue('apostrophe');
  }
  
  public function toJson($aForm)
  {
    $fieldsetInfos = array();
    foreach ($aForm->aFormFieldsets as $aFormFieldset)
    {
      $info = array('type' => $aFormFieldset->type, 'label' => $aFormFieldset->label, 'id' => $aFormFieldset->id);
      foreach ($aFormFieldset->aFormFieldsetOptions as $option)
      {
        $info['options'][] = array('name' => $option->name, 'value' => $option->value);
      }
      $fieldsetInfos[] = $info;
    }
    return json_encode($fieldsetInfos);
  }
  
  public function updateObject($values = null)
  {
    if (is_null($values))
    {
      $values = $this->getValues();
    }
    $aForm = parent::updateObject($values);
    $form_editor = $values['form_editor'];
    try
    {
      $fieldsetInfos = json_decode($form_editor, true);
      $oldFieldsetsById = aArray::listToHashById($aForm->aFormFieldsets);
      
      $rank = 1;
      foreach ($fieldsetInfos as $fieldsetInfo)
      {
        if (!in_array($fieldsetInfo['type'], array('input', 'textarea', 'address', 'select', 'select_radio', 'select_checkbox')))
        {
          throw new sfException("Bad fieldset type: " . $fieldsetInfo['type']);
        }
        $id = (int) $fieldsetInfo['id'];
        if (isset($oldFieldsetsById[$id]))
        {
          $fieldset = $oldFieldsetsById[$id];
          // So we don't discard it
          unset($oldFieldsetsById[$id]);
        }
        else
        {
          $fieldset = new aFormFieldset();
          $fieldset->aForm = $aForm;
          $aForm->aFormFieldsets[] = $fieldset;
        }
        $fieldset->type = $fieldsetInfo['type'];
        $fieldset->label = $fieldsetInfo['label'];
        $fieldset->rank = $rank++;
        $options = $fieldsetInfo['options'];
        $fieldset->unlink('aFormFieldsetOptions');
        if (count($options) && is_array($options))
        {
          foreach ($options as $option)
          {
            $option = new aFormFieldsetOption();
            $option->name = $option['name'];
            $option->value = $option['value'];
            $fieldset->options->aFormFieldsetOptions[] = $option;
          }
        }
      }
    }
    catch (Exception $e)
    {
      // The js widget won't send a bad form unless someone is up to no good
      throw new sfException("Bad form submission, JavaScript error or forgery: " . $e->getMessage());
    }
    return $aForm;
  }
}