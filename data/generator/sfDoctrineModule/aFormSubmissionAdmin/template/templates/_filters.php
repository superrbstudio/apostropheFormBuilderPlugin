[?php include_stylesheets_for_form($form) ?]
[?php include_javascripts_for_form($form) ?]

<div id="a-admin-filters-container">

	  <form action="[?php echo url_for('<?php echo $this->getUrlForAction('collection') ?>', array('action' => 'filter')) ?]" method="post" id="a-admin-filters-form">
		
			<h3>Filters</h3>

		  [?php if ($form->hasGlobalErrors()): ?]
		    [?php echo $form->renderGlobalErrors() ?]
		  [?php endif; ?]
		
	    <div class="a-admin-filters-fields">

	        [?php foreach ($configuration->getFormFilterFields($form) as $name => $field): ?]
	        [?php if ((isset($form[$name]) && $form[$name]->isHidden()) || (!isset($form[$name]) && $field->isReal())) continue ?]
					<div class="a-form-row" id="a-admin-filters-[?php echo str_replace("_","-",$name) ?]">
	          [?php include_partial('<?php echo $this->getModuleName() ?>/filters_field', array(
	            'name'       => $name,
	            'attributes' => $field->getConfig('attributes', array()),
	            'label'      => $field->getConfig('label'),
	            'help'       => $field->getConfig('help'),
	            'form'       => $form,
	            'field'      => $field,
	            'class'      => 'a-form-row a-admin-'.strtolower($field->getType()).' a-admin-filter-field-'.$name,
	          )) ?]
					</div>
	        [?php endforeach; ?]
          [?php foreach($a_form->aFormFieldsets as $aFormFieldset): ?]
          [?php if(count($aFormFieldset->aFormFields) > 1): ?]          
          <div class="a-form-row">[?php echo $aFormFieldset->getLabel() ?]</div>
          [?php endif ?]
          [?php foreach($aFormFieldset->aFormFields as $aFormField): ?]
          [?php $name = $aFormField->getId(); $field = $form[$name]; ?]
          <div class="a-form-row" id="a-admin-filters-[?php echo str_replace("_","-",$name) ?]">
          [?php echo $form[$name]->renderLabel() ?]
            <div class="a-admin-filter-field">
              [?php echo $form[$name]->renderError() ?]
              [?php echo $form[$name]->render() ?]
            </div>
          </div>
          [?php endforeach ?]
          [?php endforeach ?]
        [?php echo $form->renderHiddenFields() ?]
				<div class="a-form-row submit">
					<ul class="a-controls a-admin-filter-controls">
						<li>[?php echo jq_link_to_function(__('Filter', array(), 'apostrophe') . '<span class="icon"></span>', '$("#a-admin-filters-form").submit();', array('class' => 'a-btn', )) ?]</li>
						<li>[?php echo link_to(__('reset', array(), 'apostrophe') . '<span class="icon"></span>', '<?php echo $this->getUrlForAction('collection') ?>', array('action' => 'filter'), array('query_string' => '_reset', 'method' => 'post', 'class' => 'a-btn icon a-cancel event-default')) ?]</li>
					</ul>
				</div>
				
	    </div>
	  </form>

</div>
