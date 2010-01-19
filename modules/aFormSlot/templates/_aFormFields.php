<?php foreach ($a_form->getAllFieldsByRank() as $field): ?>
<ul id="a-form-field-<?php echo $field->getId() ?>" class="a-form-row">
<?php echo include_partial('aForm/aFormFieldEdit', array('a_form_field' => $field)); ?>
</ul>
<?php endforeach ?>
