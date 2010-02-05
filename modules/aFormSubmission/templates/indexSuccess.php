<?php use_helper('I18N', 'Date', 'jQuery') ?>
<?php include_partial('aFormSubmission/assets') ?>

<div id="a-admin-container" class="<?php echo $sf_params->get('module') ?>">

  <?php include_partial('aFormSubmission/list_bar', array('filters' => $filters)) ?>
  	
	<div id="a-admin-subnav" class="subnav">
		
		<ul class="a-controls a-admin-action-controls">
			  			<li class="filters"><?php echo jq_link_to_function("Filters", "$('#a-admin-filters-container').slideToggle()" ,array('class' => 'a-btn icon a-settings', 'title'=>'Filter Data')) ?></li>
							<li><?php include_partial('aFormSubmission/list_header', array('pager' => $pager)) ?></li>
		</ul>
  </div>

	<div id="a-admin-content" class="main">
		<ul id="a-admin-list-actions" class="a-controls a-admin-action-controls">
  		<?php include_partial('aFormSubmission/list_actions', array('helper' => $helper)) ?>		
		</ul>
				  <?php include_partial('aFormSubmission/filters', array('form' => $filters, 'configuration' => $configuration)) ?>
		
		<?php include_partial('aFormSubmission/flashes') ?>
					<form action="<?php echo url_for('a_form_submission_admin_collection', array('action' => 'batch')) ?>" method="post" id="a-admin-batch-form">
				<?php include_partial('aFormSubmission/list', array('pager' => $pager, 'sort' => $sort, 'helper' => $helper, 'a_form' => $a_form)) ?>
				<ul class="a-admin-actions">
		      <?php include_partial('aFormSubmission/list_batch_actions', array('helper' => $helper)) ?>
		    </ul>
				  </form>
			</div>

  <div id="a-admin-footer">
    <?php include_partial('aFormSubmission/list_footer', array('pager' => $pager)) ?>
  </div>

</div>
