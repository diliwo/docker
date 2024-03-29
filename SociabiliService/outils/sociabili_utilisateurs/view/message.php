<p class="erreur"><?php echo (isset($erreur))?$erreur:''; ?></p>
<p class="validation"><?php echo (isset($validation))?$validation:''; ?></p>

<?php if ((isset($debug)) && (!empty($debug))): ?>

<div class="debug">
	<fieldset>
		<legend>DEBUG</legend>
		<?php echo $debug; ?>
		
	</fieldset>
</div>

<?php endif; ?>
