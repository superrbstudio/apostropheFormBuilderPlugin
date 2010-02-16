<?php foreach ($this->configuration->getValue('list.display') as $name => $field): ?>
<?php echo $this->addCredentialCondition(sprintf(<<<EOF
<td class="a-admin-%s a-admin-list-td-%s">
  [?php echo %s ?]
</td>

EOF
, strtolower($field->getType()), $name, $this->renderField($field)), $field->getConfig()) ?>
<?php endforeach; ?>
[?php foreach($a_form->aFormLayouts as $aFormLayout): ?]
  [?php foreach($aFormLayout->aFormFields as $field): ?]
    <td class="a-admin-foreignkey a-admin-list-td-user_id">
      [?php $column = 'field_'.$field['id']; echo $a_form_submission->$column ?]
    </td>
  [?php endforeach ?]
[?php endforeach ?]
