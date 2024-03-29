<h2>Sommes payées dans le cadre des allocations d'activation</h2>

<?php if (isset($sommesPayeesAllocationsActivation['data'])): ?>
	
	<?php foreach ($sommesPayeesAllocationsActivation['data']['payedActivationSum'] as $sommePayee): ?>

	<div class="fieldset">
		<h1><?php echo ucfirst(DateUnemploymentData::formatMonth($sommePayee->payedActivationSum->month)); ?></h1>

		<table>
			<tbody>

				<tr>
					<th>Montant :</th>
					<td><?php echo number_format((((float) $sommePayee->payedActivationSum->payedAmount) / 100), 2, ",", " ") . " €"; ?></td>
				</tr>

				<?php if (isset($sommePayee->employers)): ?>
				<tr>
					<th>Numéro BCE de l'entreprise :</th>
					<td><?php echo $sommePayee->employers->employerEnterpriseNumber; ?></td>
				</tr>
				<?php endif; ?>

			</tbody>
		</table>

	</div>

	<?php endforeach; ?>

<?php else: ?>
	<p class="error">Aucune donnée</p>

<?php endif; ?>