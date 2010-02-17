<?php foreach ($aForm->getAllFieldsByRank() as $aFormLayout): ?>
<ul id="a-form-layout-<?php echo $aFormLayout->getId() ?>" class="a-form-row">
<?php echo include_partial('aForm/aFormLayoutEdit', array('aForm' => $aForm, 'aFormLayout' => $aFormLayout)); ?>
</ul>
<?php endforeach ?>
