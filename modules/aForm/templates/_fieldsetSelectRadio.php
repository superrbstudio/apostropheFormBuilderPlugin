<li class="options-label"><label><?php echo $aFormFieldset['label'] ?></label></li>
<li class="options">
	<div class="options-container">
		<ul>
			<li class="option"><input type="radio" disabled="disabled" /> <label>Option 1</label> <span>Some Value</span> <a href="#" class="a-btn icon no-label a-delete" Title="Delete">Delete</a></li>
			<li class="option"><input type="radio" disabled="disabled" /> <label>Option 2</label> <span>Some Value</span> <a href="#" class="a-btn icon no-label a-delete" Title="Delete">Delete</a></li>
			<li class="option"><input type="radio" disabled="disabled" /> <label>Option 3</label> <span>Some Value</span> <a href="#" class="a-btn icon no-label a-delete" Title="Delete">Delete</a></li>
			<li class="option"><input type="radio" disabled="disabled" /> <label>Option 4</label> <span>Some Value</span> <a href="#" class="a-btn icon no-label a-delete" Title="Delete">Delete</a></li>
			<li class="option new"><input type="radio" disabled="disabled" /><label><input type="text" value="Label" class="a-default-value" /></label><input type="text" value="Value" class="a-default-value" /><a href="#" class="a-btn icon no-label a-add" title="Add Option">Add</a></li>
		</ul>
	</div>
	<input type="submit" value="Save" class="a-btn a-submit" />
</li>

<?php if ($aFormFieldset->getRequired()): ?>
<div class="a-form-field-required">Required</div>
<?php endif ?>
