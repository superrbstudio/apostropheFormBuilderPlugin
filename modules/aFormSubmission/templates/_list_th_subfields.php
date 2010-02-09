<th class="a-admin-text a-admin-list-th-field" colspan="5"></th>
<?php foreach($a_form->aFormLayouts as $aField): ?>
  <?php foreach($aField->getForm()->getObjects() as $subField => $object): ?>
    <th class="a-admin-text a-admin-list-th-field"><?php echo $subField; ?></th>
  <?php endforeach; ?>
<?php endforeach ?>
