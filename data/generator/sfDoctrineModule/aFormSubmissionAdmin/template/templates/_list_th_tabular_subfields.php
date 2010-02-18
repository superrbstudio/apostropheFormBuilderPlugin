<th class="a-admin-text a-admin-list-th-field" colspan="<?php echo count($this->configuration->getValue('list.display'))+1 ?>"></th>

[?php foreach($a_form->aFormLayouts as $aFormLayout): ?]
    [?php $form = $aFormLayout->getForm() ?]
    [?php foreach($aFormLayout->aFormFields as $aFormField): ?]
      [?php $label = $aFormLayout->getLabel() ?]
      [?php if(count($aFormLayout->aFormFields) > 1)
        $label = $form[$aFormField['name']]->renderLabelName(); ?]
      <th class="a-admin-text a-admin-list-th-field">
      [?php if ('field_'.$aFormField['id'] == $sort[0]): ?]
        [?php echo link_to(__($label, array(), 'messages'), 'aFormSubmissionAdmin/index?sort=field_'.$aFormField['id'].'&sort_type='.($sort[1] == 'asc' ? 'desc' : 'asc')) ?]
        [?php echo image_tag(sfConfig::get('app_aAdmin_web_dir').'/images/'.$sort[1].'.png', array('alt' => __($sort[1], array(), 'a-admin'), 'title' => __($sort[1], array(), 'a-admin'))) ?]
      [?php else: ?]
        [?php echo link_to(__($label, array(), 'messages'), 'aFormSubmissionAdmin/index?sort=field_'.$aFormField['id'].'&sort_type=asc') ?]
      [?php endif ?]
      </th>
    [?php endforeach; ?]
[?php endforeach ?]

<th class="a-admin-text a-admin-list-th-field" colspan="1"></th>
