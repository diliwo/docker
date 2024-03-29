<h1>ONEM</h1>

<?php if($situation['error']): ?>

	<p class="error"><?php echo $situation['message']; ?></p>

<?php else: ?>

	<?php if($situationToday['error']): ?>
	<p class="error"><?php echo $situationToday['message']; ?></p>
	<?php endif; ?>

	<p class="info"><?php echo $situation['message']; ?></p>

	<?php 
		//include dirname(__FILE__) . '/unemployment_data/situation.php';
		//include dirname(__FILE__) . '/unemployment_data/sommes_payees.php';
		//include dirname(__FILE__) . '/unemployment_data/sommes_payees_allocations_activation.php';
	?>

<?php endif; ?>
