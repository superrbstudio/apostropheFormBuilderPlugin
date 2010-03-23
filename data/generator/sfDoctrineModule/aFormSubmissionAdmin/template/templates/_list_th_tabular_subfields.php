<th class="a-admin-text a-admin-list-th-field" colspan="<?php echo count($this->configuration->getValue('list.display'))+1 ?>"></th>

[?php foreach($a_form->aFormFieldsets as $aFormFieldset): ?]
    [?php $form = $aFormFieldset->getForm() ?]
    [?php foreach($aFormFieldset->aFormFields as $aFormField): ?]
      [?php $label = $aFormFieldset->getLabel() ?]
      [?php if(count($aFormFieldset->aFormFields) > 1)
        $label = $form[$aFormField['name']]->renderLabelName(); ?]
      <th class="a-admin-text a-admin-list-th-field">
      [?php if ('field_'.$aFormField['id'] == $sort[0]): ?]
        [?php echo link_to(__($label, array(), 'messages'), 'aFormSubmissionAdmin/index?sort=field_'.$aFormField['id'].'&sort_type='.($sort[1] == 'asc' ? 'desc' : 'asc')) ?]
        [?php echo image_tag(sfConfig::get('app_aAdmin_web_dir').'/images/'.$sort[1].'.png', array('alt' => __($sort[1], array(), 'apostrophe'), 'title' => __($sort[1], array(), 'apostrophe'))) ?]
      [?php else: ?]
        [?php echo link_to(__($label, array(), 'messages'), 'aFormSubmissionAdmin/index?sort=field_'.$aFormField['id'].'&sort_type=asc') ?]
      [?php endif ?]
      </th>
    [?php endforeach; ?]
[?php endforeach ?]

<th class="a-admin-text a-admin-list-th-field" colspan="1"></th>
