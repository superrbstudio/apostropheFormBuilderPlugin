<div id="a-admin-bar" <?php if (count($sf_user->getAttribute('aFormSubmissionAdmin.filters', null, 'admin_module'))): ?>class="has-filters"<?php endif ?>>
	<h2 class="a-admin-title you-are-here"><?php echo __('Viewing submissions for '.$a_form['name'], array(), 'messages') ?></h2>
</div>