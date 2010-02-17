<ul>
<?php foreach ($aForms as $aForm): ?>
	<li><?php echo link_to($aForm->getName(), 'a_form_edit', $aForm) ?></li>
<?php endforeach ?>	
</ul>
