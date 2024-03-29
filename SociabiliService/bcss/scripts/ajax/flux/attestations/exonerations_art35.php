<h2>Exonerations ART35</h2>

<?php if ($exonerations_art35['error']): ?>

<p class="error"><?php echo $exonerations_art35['message']; ?></p>

<?php else: ?>

<?php if (isset($exonerations_art35['data']['ExonerationArt35'])): ?>

<?php

// Recherche de la date de fixation
$now = new DateTime();
$today = new DateTime();
$premierDimancheDuMois = new DateTime();
$premierDimancheDuMois->modify("first sunday of " . $today->format("F Y"));

if ($today <= $premierDimancheDuMois) {
	$today->modify("-1 month");

}
$dateFixation = new DateTime($today->format("Y-m-01"));
$dateFixation->modify("-1 day");

// Intervalle de dates
$datePremiereExoneration = new DateTime($exonerations_art35['data']['ExonerationArt35']['FirstExonerationDate']);
$dateFinExoneration = clone $datePremiereExoneration;
$dateLimite = new DateTime("2011-10-01");

if ($datePremiereExoneration < $dateLimite) {
	$dateFinExoneration->modify("+3 years");

} else {
	$dateFinExoneration->modify("+6 years");

}

// Recherche des jours restants
$joursRestants = 0;
if ($dateFinExoneration >= $now)
	$joursRestants = (1096 - $exonerations_art35['data']['ExonerationArt35']['PaymentExoneratedDays']);

?>

<div class="fieldset">
	<h1>Données récupérées au <?php echo $dateFixation->format("d/m/Y"); ?></h1>

	<table>
		<tbody>
			<tr>
				<th>Intervalle de validité :</th>
				<td>Du <?php echo $datePremiereExoneration->format("d/m/Y"); ?> au <?php echo $dateFinExoneration->format("d/m/Y"); ?></td>
			</tr>
			<tr>
				<th>Jours restants :</th>
				<td><?php echo $joursRestants; ?> jour(s)</td>
			</tr>
		</tbody>
	</table>
</div>

<?php else: ?>

<p class="info">La personne n'est pas exonérée en tant qu'article 35</p>

<?php endif; ?>

<?php if (isset($exonerations_art35['data']['Attestation'])): ?>
	<?php /*foreach ($exonerations_art35['data']['Attestation'] as $exoneration): ?>

	<div class="fieldset">
		<h1>Exonération (date de décision : <?php echo DatetimeAttestations::format($exoneration['DecisionDate']); ?>)</h1>

		<table>
			<tbody>
				<tr>
					<th>Date d'entrée en vigeur :</th>
					<td><?php echo DatetimeAttestations::format($exoneration['EntryDate']); ?></td>
				</tr>
				<tr>
					<th>Numéro BCE du CPAS :</th>
					<td><?php echo $exoneration['CPAS_KBOBCE_code']; ?> (<?php echo $entrepriseDb->getNomFromNumero($exoneration['CPAS_KBOBCE_code']); ?>)</td>
				</tr>
				<tr>
					<th>Type d'attestation :</th>
					<td><?php echo utf8_decode($exoneration['AttestType']['Description']); ?> (code <?php echo $exoneration['AttestType']['Code']; ?>)</td>
				</tr>
				<tr>
					<th>Type de formulaire :</th>
					<td><?php echo utf8_decode($exoneration['FormType']['Description']); ?> (code <?php echo $exoneration['FormType']['Code']; ?>)</td>
				</tr>
				<tr>
					<th>Type de relation :</th>
					<td><?php echo utf8_decode($exoneration['RelationType']['Description']); ?> (code <?php echo $exoneration['RelationType']['Code']; ?>)</td>
				</tr>
				<tr>
					<th>Durée de l'attestation :</th>
					<td><?php echo $exoneration['Duration']['Days']; ?> jour(s), <?php echo $exoneration['Duration']['Weeks']; ?> semaine(s), <?php echo $exoneration['Duration']['Months']; ?> mois</td>
				</tr>
				<tr>
					<th>Référence :</th>
					<td><?php echo $exoneration['Reference']; ?></td>
				</tr>
				<tr>
					<th>Statut :</th>
					<td><?php echo $exoneration['Status']; ?></td>
				</tr>
			</tbody>
		</table>
	</div>
		
	<?php endforeach; ?>
<?php else: ?>

<p class="error">Aucune donnée</p>

<?php*/ endif; ?>

<?php endif; ?>
