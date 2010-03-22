<li class="input">
    <?php echo $form['input']->renderLabel() ?>
    <?php echo $form['input']->render(array('disabled' => $disabled)) ?>
</li>

<?php if ($aFormFieldset->getRequired()): ?>
<div class="a-form-field-required">Required</div>
<?php endif ?>
