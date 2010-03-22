<?php foreach ($aForm->getAllFieldsByRank() as $aFormFieldset): ?>
<ul id="a-form-fieldset-<?php echo $aFormFieldset->getId() ?>" class="a-form-row">
<?php echo include_partial('aForm/aFormFieldsetEdit', array('aForm' => $aForm, 'aFormFieldset' => $aFormFieldset)); ?>
</ul>
<?php endforeach ?>
