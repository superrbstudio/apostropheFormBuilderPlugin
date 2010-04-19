<li class="options-label"><label><?php echo $aFormFieldset['label'] ?></label></li>
<li class="options">
  <?php echo $form['select']->render(array('disabled' => $disabled)) ?>	
	<div class="options-container">
		<ul>
			<li class="option"><label><input type="text" value="Bicycles" /></label><input type="text" value="t1" /><a href="#" class="a-btn icon no-label a-delete" Title="Delete">Delete</a></li>
			<li class="option new"><label><input type="text" value="Label" class="a-default-value" /></label><input type="text" value="Value" class="a-default-value" /><a href="#" class="a-btn icon no-label a-add" title="Add Option">Add</a></li>
		</ul>
	</div>
	<button type="submit" class="a-btn a-submit">Save Options</button>
</li>

<?php if ($aFormFieldset->getRequired()): ?>
<div class="a-form-field-required">Required</div>
<?php endif ?>
