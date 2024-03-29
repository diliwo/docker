<?php if (isset($situation['data'])): ?>
	<h2>Dernière situation connue</h2>
	<div class="fieldset">
		<h1>Paiements</h1>

		<table>
			<tbody>
				<tr>
					<th>Mois : </th>
					<td><?php echo DateUnemploymentData::formatMonth($situation['data']->payment->month); ?></td>
				</tr>

				<tr>
					<th>Nombre d'allocations payées : </th>
					<td><?php echo $situation['data']->payment->numberOfBenefits; ?></td>
				</tr>
			</tbody>
		</table>

	</div>

	<?php if (isset($situation['data']->right->activeRight)): ?>
		<div class="fieldset">
			<h1>Droit</h1>

			<table>
				<tbody>
					<tr>
						<th>Montant journalier théorique : </th>
						<td><?php echo number_format((((float) $situation['data']->right->activeRight->theoreticDailyAmount) / 100), 2, ",", " ") . " €"; ?></td>
					</tr>

					<tr>
						<th>Date de début du droit théorique : </th>
						<td><?php echo DateUnemploymentData::format($situation['data']->right->activeRight->startDate); ?></td>
					</tr>

					<tr>
						<th>Nature du chômage : </th>
						<td><?php echo DescriptionUnemploymentData::getDescriptionNatureChomage($situation['data']->right->activeRight->unemployementCategory); ?></td>
					</tr>

					<tr>
						<th>Situation familiale : </th>
						<td><?php echo DescriptionUnemploymentData::getDescriptionSituationFamiliale($situation['data']->right->activeRight->familySituation); ?></td>
					</tr>
				</tbody>
			</table>

		</div>
	<?php endif; ?>

	<?php if (isset($situation['data']->right->sanction)): ?>
		<div class="fieldset">
			<h1>Sanction</h1>

			<table>
				<tbody>

					<tr>
						<th>Date d'entrée en vigueur : </th>
						<td><?php echo DateUnemploymentData::format($situation['data']->right->sanction->startDate); ?></td>
					</tr>

					<?php if (isset($situation['data']->right->sanction->endDate)): ?>
					<tr>
						<th>Date de fin : </th>
						<td><?php echo DateUnemploymentData::format($situation['data']->right->sanction->endDate); ?></td>
					</tr>
					<?php endif; ?>

					<?php if (isset($situation['data']->right->sanction->nrWeeks)): ?>
					<tr>
						<th>Durée (en semaines) : </th>
						<td><?php echo $situation['data']->right->sanction->nrWeeks; ?></td>
					</tr>
					<?php endif; ?>

				</tbody>
			</table>

		</div>
	<?php endif; ?>

	<?php if (isset($situation['data']->right->exclusion)): ?>
		<div class="fieldset">
			<h1>Exclusion</h1>

			<table>
				<tbody>

					<tr>
						<th>Date d'entrée en vigueur : </th>
						<td><?php echo DateUnemploymentData::format($situation['data']->right->exclusion->startDate); ?></td>
					</tr>

				</tbody>
			</table>

		</div>
	<?php endif; ?>

<?php endif; ?>