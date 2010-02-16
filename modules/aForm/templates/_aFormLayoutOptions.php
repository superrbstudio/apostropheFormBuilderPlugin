<?php use_helper('jQuery') ?>

<?php echo jq_form_remote_tag(array(
  'url' => 'aForm/editFieldOptions', 
  'update' => 'a-form-field-'.$a_form_layout->getId(),
  'script' => 'true', 
  'complete' => '$("#a-form-field-options-'.$a_form_layout->getId().' .a-form-field-options input:last").focus()', 
  ), array('id' => 'a-form-field-options-'.$a_form_layout->getId())) ?>
  <?php echo $a_form_layout_options_form->renderGlobalErrors(); ?>
	
	<ul class="a-form-field-options <?php echo $a_form_layout->getType() ?>">
  <?php $n=1; foreach($a_form_layout_options_form['options'] as $field): ?>
   	<li>
   	  <?php echo $field['id'] ?>
	    <?php echo $field['name']->renderError(); ?>
			<?php echo $field['name']->render(); ?>
		</li>
  <?php $n++; endforeach; ?>
  </ul>

  <?php echo input_hidden_tag('field_id', $a_form_layout->getId(), array()) ?>
  
  <input type="submit" value="save" class="a-submit" />

<?php if ($a_form_layout->getType() == 'select'): ?>
	<script type="text/javascript">
			$('.a-form-field-options.select input').focus(function(){
					$(this).parent().siblings().css('background','none');
					$(this).parent().css('background-color','#eee');
			});
	</script>
<?php endif ?>

<?php if ($a_form_layout->getType() == 'select_radio'): ?>	
	<script type="text/javascript">
		var radios = $('.a-form-field-options.select_radio input[type="text"]');
		radios.parent().find('input[type="radio"]').remove();
		radios.before('<input type="radio" class="radio" disabled="disabled" />');
	</script>
<?php endif ?>

<?php if ($a_form_layout->getType() == 'select_checkbox'): ?>	
	<script type="text/javascript">
		var checkboxes = $('.a-form-field-options.select_checkbox input[type="text"]');
		checkboxes.parent().find('input[type="checkbox"]').remove();
		checkboxes.before('<input type="checkbox" class="checkbox" disabled="disabled" />');
	</script>
<?php endif ?>

</form>