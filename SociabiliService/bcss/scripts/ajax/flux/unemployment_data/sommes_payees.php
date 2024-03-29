<h2>Sommes payées</h2>

<?php if (isset($sommesPayees['data'])): ?>

	<?php foreach ($sommesPayees['data']['payedSum'] as $sommePayee): ?>

	<div class="fieldset">
		<h1><?php echo ucfirst(DateUnemploymentData::formatMonth($sommePayee->month)); ?></h1>

		<table>
			<tbody>

				<tr>
					<th>Montant :</th>
					<td><?php echo number_format((((float) $sommePayee->payedAmount) / 100), 2, ",", " ") . " €"; ?></td>
				</tr>

				<tr>
					<th>Statut :</th>
					<td><?php echo DescriptionUnemploymentData::getDescriptionStatutApprobation($sommePayee->approvalStatus); ?></td>
				</tr>

				<?php if (isset($sommePayee->approvedAmount)): ?>
				<tr>
					<th>Montant approuvé :</th>
					<td><?php echo number_format((((float) $sommePayee->approvedAmount) / 100), 2, ",", " ") . " €"; ?></td>
				</tr>
				<?php endif; ?>

			</tbody>
		</table>

	</div>

	<?php endforeach; ?>

<?php else: ?>
	<p class="error">Aucune donnée</p>

<?php endif; ?>