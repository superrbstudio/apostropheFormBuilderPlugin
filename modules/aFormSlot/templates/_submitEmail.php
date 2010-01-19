The following submission was received by the <?php echo $a_form->getName() ?> form at <?php echo $submission->getCreatedAt() ?>.

<?php foreach ($values as $label => $field): ?>

<?php echo $label ?> 
<?php for($i=0;$i<strlen($label);$i++): ?>--<?php endfor ?> 
<?php foreach ($field as $sub_field => $value): ?>
<?php echo (count($field) > 1) ? $sub_field.': ' : '' ?><?php echo $value ?> 
<?php endforeach ?>

<?php endforeach ?>