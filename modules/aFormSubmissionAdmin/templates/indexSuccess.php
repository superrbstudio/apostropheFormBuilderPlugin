<?php use_helper('I18N', 'Date', 'jQuery') ?>
<?php include_partial('aFormSubmissionAdmin/assets') ?>
<?php slot('body_class','a-form-admin a-admin index') ?>

<div id="a-admin-container" class="<?php echo $sf_params->get('module') ?>">

  <?php include_partial('aFormSubmissionAdmin/list_bar', array('a_form' => $a_form, 'filters' => $filters)) ?>

	<div id="a-admin-content" class="main">
		
		<ul id="a-admin-list-actions" class="a-controls a-admin-action-controls">
  		<li class="filters"><?php echo jq_link_to_function("Filters", "$('#a-admin-filters-container').slideToggle()" ,array('class' => 'a-btn icon a-settings', 'title'=>'Filter Data')) ?></li>
			<?php include_partial('aFormSubmissionAdmin/list_actions', array('helper' => $helper)) ?>		
		</ul>
				  <?php include_partial('aFormSubmissionAdmin/filters', array('form' => $filters, 'configuration' => $configuration)) ?>
		
		<?php include_partial('aFormSubmissionAdmin/flashes') ?>
					<form action="<?php echo url_for('a_form_submission_admin_collection', array('action' => 'batch')) ?>" method="post" id="a-admin-batch-form">
				<?php include_partial('aFormSubmissionAdmin/list', array('a_form' => $a_form, 'pager' => $pager, 'sort' => $sort, 'helper' => $helper)) ?>
				<ul class="a-admin-actions">
		      <?php include_partial('aFormSubmissionAdmin/list_batch_actions', array('helper' => $helper)) ?>
		    </ul>
				  </form>
			</div>

  <div id="a-admin-footer">
    <?php include_partial('aFormSubmissionAdmin/list_footer', array('pager' => $pager)) ?>
  </div>

</div>
