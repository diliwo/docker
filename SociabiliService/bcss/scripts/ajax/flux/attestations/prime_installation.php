<h2>Prime unique d'installation</h2>

<?php if ($primeInstallation['error']): ?>

<p class="error"><?php echo $primeInstallation['message']; ?></p>

<?php else: ?>

<div class="fieldset">

<?php $prime = $primeInstallation['data']; ?>
	<h1>Date d'entrée en vigueur : <?php echo DatetimeAttestations::format($prime->EntryDate); ?><span class="titre-infos-bottom">Référence : <?php echo $prime->Reference; ?></span></h1>

	<table>
		<tbody>
			<tr>
				<th>Registre national :</th>
				<td><a href="index.php?env=member&page=person&action=display&rn=<?php echo $prime->SocialSecurityUser; ?>" class="rn"><?php echo $prime->SocialSecurityUser; ?></a></td>
			</tr>

			<tr>
				<th>Formulaire :</th>
				<td><?php echo $prime->FormType->Description->fr; ?> (<?php echo $prime->AttestType->Description->fr; ?>)</td>
			</tr>

			<tr>
				<th>Type de relation :</th>
				<td> <?php echo $prime->RelationType->Description->fr; ?></td>
			</tr>

			<tr>
				<th>N° d'entreprise BCE :</th>
				<td><?php echo $prime->CPAS_KBOBCE_code; ?> (<?php echo $entrepriseDb->getNomFromNumero($prime->CPAS_KBOBCE_code); ?>)</td>
			</tr>
			<tr>
				<th>Statut :</th>
				<td><?php 
					switch ($prime->Status) {
						case "0":
							echo "ACCEPTED";
							break;

						case "1":
							echo "REFUSED";
							break;

						case "2":
							echo "PARTIALLY ACCEPTED";
							break;
						
						default:
							echo $prime->Status;
							break;
					}
				?></td>
			</tr>
		</tbody>
	</table>

</div>

<?php endif; ?>
