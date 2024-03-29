<h1>Cadaf</h1>

<?php if($res['error']): ?>

<p class="error"><?php echo $res['message']; ?></p>

<?php else: ?>

	<h2>Dossiers du <?php echo $dateDebut->format('d/m/Y'); ?> au <?php echo $dateFin->format('d/m/Y'); ?></h2>

	<?php foreach (array_reverse($res['data']) as $nb=>$dossier): ?>

	<div class="fieldset">
		<h1>Dossiers numéro <?php echo $dossier->cadafID->dossierID; ?></h1>

		<table>
			<tbody>

				<tr>
					<th>Numéro du fonds CBF :</th>
					<td><?php echo $dossier->cadafID->cbfFundID; ?></td>
				</tr>

				<tr>
					<th>Institution :</th>
					<td><?php $nom = $institutionDb->getNomFromId($dossier->cadafID->officeNbr); echo (empty($nom))?"numéro " . $dossier->cadafID->officeNbr:$nom; ?></td>
				</tr>

			</tbody>
		</table>

		<h2>Acteurs</h2>
		<div class="fieldset">
			<h1>Personne ayant droit</h1>

			<table>
				<tbody>

					<tr>
						<th>Numéro de registre national : </th>
						<td><a href="index.php?env=member&page=person&action=display&rn=<?php echo $dossier->actorList->entitledPerson->ssin; ?>" class="rn"><?php echo $dossier->actorList->entitledPerson->ssin; ?></a></td>
					</tr>

				</tbody>
			</table>
		</div>

		<!-- DESTINATAIRES -->
		<?php if (isset($dossier->actorList->recipientList)): ?>

	<?php
	$destinataires = array();
	if (is_array($dossier->actorList->recipientList->recipient)) {
		$destinataires = $dossier->actorList->recipientList->recipient;

	} else {
		$destinataires[0] = $dossier->actorList->recipientList->recipient;
	}
	?>

		<div class="fieldset">
			<h1>Destinataires</h1>

			<?php foreach (array_reverse($destinataires) as $nb2=>$destinataire): ?>

			<table>
				<tbody>

					<tr>
						<th>Numéro de registre national : </th>
						<td><a href="index.php?env=member&page=person&action=display&rn=<?php echo $destinataire->ssin; ?>" class="rn"><?php echo $destinataire->ssin; ?></a></td>
					</tr>

					<tr>
						<th>Type : </th>
						<td><?php echo $destinataire->type; ?></td>
					</tr>

					<?php if (isset($destinataire->paymentPeriod)): ?>

	<?php
	$periodes = array();
	if (is_array($destinataire->paymentPeriod)) {
		$periodes = $destinataire->paymentPeriod;

	} else {
		$periodes[0] = $destinataire->paymentPeriod;
	}
	?>

					<tr>
						<th>Période de paiement : </th>
						<td>
							<ul>

							<?php foreach (array_reverse($periodes) as $periode): ?>

								<li><?php echo PeriodeCadaf::format($periode); ?></li>

							<?php endforeach; ?>

							</ul>
						</td>
					</tr>

					<?php endif; ?>

					<?php if (isset($destinataire->birthBonus)): ?>

	<?php
	$bonuss = array();
	if (is_array($destinataire->birthBonus)) {
		$bonuss = $destinataire->birthBonus;

	} else {
		$bonuss[0] = $destinataire->birthBonus;
	}
	?>
					<tr>
						<th>Bonus de naissance : </th>
						<td>
							<ul>

							<?php foreach (array_reverse($bonuss) as $bonus): ?>

								<li><?php echo DateCadaf::format($bonus->paymentDate); ?></li>

							<?php endforeach; ?>

							</ul>
						</td>
					</tr>

					<?php endif; ?>

				</tbody>
			</table>
			<?php
			if ($nb2 < (count($destinataires) - 1))
		    	echo "<hr>";
			?>

			<?php endforeach; ?>

		</div>

		<?php endif; ?>

		<!-- ENFANTS BENEFICIAIRES -->
		<?php if (isset($dossier->actorList->beneficiaryChildList)): ?>

	<?php
	$beneficiaires = array();
	if (is_array($dossier->actorList->beneficiaryChildList->beneficiaryChild)) {
		$beneficiaires = $dossier->actorList->beneficiaryChildList->beneficiaryChild;

	} else {
		$beneficiaires[0] = $dossier->actorList->beneficiaryChildList->beneficiaryChild;
	}
	?>

		<div class="fieldset">
			<h1>Enfants bénéficiaires</h1>

			<?php foreach (array_reverse($beneficiaires) as $nb2=>$beneficiaire): ?>

			<table>
				<tbody>

					<tr>
						<th>Numéro de registre national : </th>
						<td><a href="index.php?env=member&page=person&action=display&rn=<?php echo $beneficiaire->ssin; ?>" class="rn"><?php echo $beneficiaire->ssin; ?></a></td>
					</tr>

					<?php if (isset($beneficiaire->paymentPeriod)): ?>

	<?php
	$periodes = array();
	if (is_array($beneficiaire->paymentPeriod)) {
		$periodes = $beneficiaire->paymentPeriod;

	} else {
		$periodes[0] = $beneficiaire->paymentPeriod;
	}
	?>

					<tr>
						<th>Période de paiement : </th>
						<td>
							<ul>

							<?php foreach (array_reverse($periodes) as $periode): ?>

								<li><?php echo PeriodeCadaf::format($periode); ?></li>

							<?php endforeach; ?>

							</ul>
						</td>
					</tr>

					<?php endif; ?>

					<?php if (isset($beneficiaire->adoptionBonus)): ?>

	<?php
	$bonuss = array();
	if (is_array($beneficiaire->adoptionBonus)) {
		$bonuss = $beneficiaire->adoptionBonus;

	} else {
		$bonuss[0] = $beneficiaire->adoptionBonus;
	}
	?>
					<tr>
						<th>Bonus d'adoption : </th>
						<td>
							<ul>

							<?php foreach (array_reverse($bonuss) as $bonus): ?>

								<li><?php echo DateCadaf::format($bonus->paymentDate); ?></li>

							<?php endforeach; ?>

							</ul>
						</td>
					</tr>

					<?php endif; ?>

				</tbody>
			</table>
			<?php
			if ($nb2 < (count($beneficiaires) - 1))
		    	echo "<hr>";
			?>

			<?php endforeach; ?>

		</div>

		<?php endif; ?>

	</div>

	<?php endforeach; ?>

<?php endif; ?>
