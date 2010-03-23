<div class="a-admin-list">
  [?php if (!$pager->getNbResults()): ?]
    <p>[?php echo __('No result', array(), 'apostrophe') ?]</p>
  [?php else: ?]
    <table cellspacing="0" class="a-admin-list-table">
      <thead>
        <tr>
					<?php if ($this->configuration->getValue('list.batch_actions')): ?>
          	<th id="a-admin-list-batch-actions"><input id="a-admin-list-batch-checkbox-toggle" class="a-admin-list-batch-checkbox-toggle a-checkbox" type="checkbox"/></th>
					<?php endif; ?>
          	[?php include_partial('<?php echo $this->getModuleName() ?>/list_th_<?php echo $this->configuration->getValue('list.layout') ?>', array('sort' => $sort, 'a_form' => $a_form)) ?]
					<?php if ($this->configuration->getValue('list.object_actions')): ?>
          	<th id="a-admin-list-th-actions">[?php echo __('Actions', array(), 'apostrophe') ?]</th>
					<?php endif; ?>
					<th colspan="90"></th>
        </tr>
				<tr>
					[?php include_partial('<?php echo $this->getModuleName() ?>/list_th_<?php echo $this->configuration->getValue('list.layout') ?>_subfields', array('sort' => $sort, 'a_form' => $a_form)) ?]
				</tr>
      </thead>
      <tfoot>
        <tr>
          <th colspan="[?php echo <?php echo count($this->configuration->getValue('list.display')) + ($this->configuration->getValue('list.object_actions') ? 1 : 0) + ($this->configuration->getValue('list.batch_actions') ? 1 : 0)?> + $a_form->getFieldcount() ?]">
						<div class="a-admin-list-results">
	            [?php echo format_number_choice('[0] no result|[1] 1 result|(1,+Inf] %1% results', array('%1%' => $pager->getNbResults()), $pager->getNbResults(), 'apostrophe') ?]
	            [?php if ($pager->haveToPaginate()): ?]
	              [?php // echo __('(page %%page%%/%%nb_pages%%)', array('%%page%%' => $pager->getPage(), '%%nb_pages%%' => $pager->getLastPage()), 'apostrophe') ?]
	            [?php endif; ?]
						</div>
            [?php if ($pager->haveToPaginate()): ?]
              [?php include_partial('<?php echo $this->getModuleName() ?>/pagination', array('pager' => $pager)) ?]
            [?php endif; ?]	
          </th>
        </tr>
      </tfoot>
      <tbody>
        [?php $n=1; $total = count($pager); foreach ($pager as $i => $<?php echo $this->getSingularName() ?>): $odd = fmod(++$i, 2) ? 'odd' : 'even' ?]
          <tr class="a-admin-row [?php echo $odd ?] [?php echo ($n == $total)? 'last':'' ?]">
						<?php if ($this->configuration->getValue('list.batch_actions')): ?>
            	[?php include_partial('<?php echo $this->getModuleName() ?>/list_td_batch_actions', array('<?php echo $this->getSingularName() ?>' => $<?php echo $this->getSingularName() ?>, 'helper' => $helper)) ?]
						<?php endif; ?>
            	[?php include_partial('<?php echo $this->getModuleName() ?>/list_td_<?php echo $this->configuration->getValue('list.layout') ?>', array('<?php echo $this->getSingularName() ?>' => $<?php echo $this->getSingularName() ?>, 'a_form' => $a_form)) ?]
						<?php if ($this->configuration->getValue('list.object_actions')): ?>
            	[?php include_partial('<?php echo $this->getModuleName() ?>/list_td_actions', array('<?php echo $this->getSingularName() ?>' => $<?php echo $this->getSingularName() ?>, 'helper' => $helper)) ?]
						<?php endif; ?>
          </tr>
        [?php $n++; endforeach; ?]
      </tbody>
    </table>
  [?php endif; ?]
</div>

<script type="text/javascript">
	$(document).ready(function() {
		$('#a-admin-list-batch-checkbox-toggle').click(function(){
			$('.a-admin-batch-checkbox').each( function() {
				$(this)[0].checked = !$(this)[0].checked;
			});
		})
	});
</script>
