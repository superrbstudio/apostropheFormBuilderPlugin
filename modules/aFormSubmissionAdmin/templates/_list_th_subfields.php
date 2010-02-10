<th class="a-admin-text a-admin-list-th-field" colspan="5"></th>
<?php foreach($a_form->aFormLayouts as $aFormLayout): ?>
  <?php foreach($aFormLayout->aFormFields as $aFormField): ?>
    <th class="a-admin-text a-admin-list-th-field"><?php echo $aFormField['name']; ?></th>
  <?php endforeach; ?>
<?php endforeach ?>
<th class="a-admin-text a-admin-list-th-field" colspan="1"></th>
