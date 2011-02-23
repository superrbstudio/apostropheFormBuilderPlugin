<?php use_stylesheet('/apostropheFormBuilderPlugin/css/aFormBuilder.css', 'last') ?>

<h4>Please fill out the form name, the email address to receive the results, and a thank you message to be displayed after a user submits to your form. Then add fields to the form as needed.</h4>

<div class="a-form-builder" id="a-form-builder-<?php echo $id ?>">
  <?php echo $form ?>
</div>
<?php a_js_call('aFormEditorForFormSlot(?)', array('selector' => '#' . $form['form_editor']->renderId(), 'appendTo' => '#a-form-builder-' . $id, 'slotId' => $id, 'labels' => array(
  'chooseOne' => a_('Choose One'), 
  'add' => a_('Add'), 
  'value' => a_('Value'), 
  'label' => a_('Label'),
  'name' => a_('Name'), 
  'remove' => a_('Remove'),
  'input' => a_('Input'),
  'textarea' => a_('Text Area'),
  'address' => a_('Address'),
  'select' => a_('Select Menu'),
  'select_radio' => a_('Select Radio'),
  'select_checkbox' => a_('Select Multiple'),
  'street1' => a_('Street Line 1'),
  'street2' => a_('Street Line 2'),
  'city' => a_('City'),
  'state' => a_('State'),
  'postalCode' => a_('Postal Code'),
  'country' => a_('Country')
))) ?>
