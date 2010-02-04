<table>
<?php $url = ($form->getObject()->isNew())? 'new' : "edit?id=".$form->getObject()->getId(); ?>
<?php echo form_tag("aForm/$url") ?>
<?php echo $form ?>
<tr><td><input type="submit" ></td></tr>
</form>
</table>