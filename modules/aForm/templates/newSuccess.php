<?php use_helper('jQuery') ?>

<?php slot('a-page-title', '<span>Form Builder :</span> Create A New Form') ?>

<?php echo form_tag('@a_form_create') ?>
<?php include_partial('aForm/aFormForm', array('aFormForm' => $aFormForm))  ?>
</form>