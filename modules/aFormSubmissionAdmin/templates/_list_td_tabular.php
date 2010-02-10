<td class="a-admin-text a-admin-list-td-id">
  <?php echo link_to($a_form_submission->getId(), 'a_form_submission_admin_edit', $a_form_submission) ?>
</td>
<td class="a-admin-foreignkey a-admin-list-td-form_id">
  <?php echo $a_form_submission->getFormId() ?>
</td>
<td class="a-admin-text a-admin-list-td-ip_address">
  <?php echo $a_form_submission->getIpAddress() ?>
</td>
<td class="a-admin-foreignkey a-admin-list-td-user_id">
  <?php echo $a_form_submission->getUserId() ?>
</td>
<?php foreach($a_form->aFormLayouts as $aFormLayout): ?>
  <?php foreach($aFormLayout->aFormFields as $field): ?>
    <td class="a-admin-foreignkey a-admin-list-td-user_id">
      <?php $column = 'field_'.$field['id']; echo $a_form_submission->$column ?>
    </td>
  <?php endforeach ?>
<?php endforeach ?>