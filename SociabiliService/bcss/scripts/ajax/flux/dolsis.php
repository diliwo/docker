<h1>Dimonas (dolsis)</h1>

<?php
/*
if( isset($activite) ) {
    
    $inServiceDates = array();
    foreach ($activites['data'] as $activite) {
        
	   $inServiceDates[] = $activite->inServiceDate;
    }
    
    array_multisort($inServiceDates, SORT_DESC, $activites['data']);
}
*/

if( isset($activites['data']) ) {
    usort($activites['data'], function($a, $b) {
        return strtotime($a->inServiceDate) - strtotime($b->inServiceDate);
    });
}

?>

<?php if ($activites['error']): ?>

<p class="error"><?php echo $activites['message']; ?></p>

<?php else: ?>
	<?php
		$data = array();
		if (is_array($activites["data"])) {
			$data = array_reverse($activites['data']);

		} else {
			if (!is_null($activites['data']))
				$data[] = $activites['data'];

		}
	?>

	<?php if (count($data) == 0): ?>

<p class="error">Aucune données disponible</p>

	<?php else: ?>

		<?php foreach ($data as $nb=>$activite): ?>

		<?php
			$dateCreation = $dateMisAJour = $dateDebut = $dateFin = null;
			if (isset($activite->creationDate))
				$dateCreation = new DateTime($activite->creationDate);
			if (isset($activite->lastUpdateDate)) {
				$dateMisAJour = new DateTime($activite->lastUpdateDate);
				if ($dateCreation == $dateMisAJour)
					$dateMisAJour = null;
			}
			if (isset($activite->inServiceDate))
				$dateDebut = new DateTime($activite->inServiceDate);
			if (isset($activite->outServiceDate))
				$dateFin = new DateTime($activite->outServiceDate);
		?>

<div class="fieldset">
	<h1>Période du <?php echo is_null($dateDebut)?"...":$dateDebut->format("d/m/Y"); ?> au <?php echo is_null($dateFin)?"...":$dateFin->format("d/m/Y"); ?>
		<span class="titre-infos">Créé le <?php echo is_null($dateCreation)?"...":$dateCreation->format("d/m/Y à H:i:s"); ?><?php echo is_null($dateMisAJour)?"":" | Mis à jour le " . $dateMisAJour->format("d/m/Y à H:i:s"); ?></span>
	</h1>

	<table>
		<tbody>

			<tr>
				<th>Entreprise - nom: </th>
				<td><?php echo $activite->employer->name; ?></td>
			</tr>

			<tr>
				<th>Entreprise - numéro BCE : </th>
				<td><?php echo $activite->employer->cbeNumber; ?></td>
			</tr>

			<?php if(isset($activite->employer->vatNumber)): ?>
			<tr>
				<th>Entreprise - numéro TVA : </th>
				<td><?php echo $activite->employer->vatNumber; ?></td>
			</tr>
			<?php endif; ?>

			<tr>
				<th>Entreprise - immatriculation : </th>
				<td><?php echo $activite->employer->nossRegistrationNumber->_; ?></td>
			</tr>

			<?php if(isset($activite->jointCommissionNbr)): ?>
			<tr>
				<th>Commision paritaire : </th>
				<td><?php echo $activite->jointCommissionNbr; ?></td>
			</tr>
			<?php endif; ?>

			<tr>
				<th>Nature du travailleur :</th>
				<td>
				<?php
					switch ($activite->workerType) {
						case 'stu':
							echo "Etudiant";
							break;

						case 'stx':
							echo "Travailleur occasionnel étudiant";
							break;

						case 'ext':
							echo "Travailleur occasionnel";
							break;

						case 'ivt':
							echo "Plan Formation-Insertion (PFI)";
							break;

						case 'rta':
							echo "Étudiant reconnu ou équivalent";
							break;

						case 'oth':
							echo "Autre";
							break;

						case 'bcw':
							echo "Travailleur dans le secteur de la construction (à l'exception des étudiants et PFI)";
							break;

						case 'dwd':
							echo "Travailleur non soumis aux cotisations de sécurité sociale";
							break;

						case 'tea':
							echo "Enseignants (code E dans DmfAPPL)";
							break;

						case 'tri':
						case 'stg':
							echo "Stagiaire";
							break;

						default:
							echo "Inconnu";
							break;
					}

				?>
				</td>
			</tr>

			<tr>
				<th>Numéro Dimona :</th>
				<td><?php echo $activite->dimonaPeriodId; ?></td>
			</tr>

			<tr>
				<th>Dernière action dans la Dimona :</th>
				<td>
				<?php
				if($activite->lastDimonaAction == DolsisFlux::CODE_ACTION_ENTREE) {
					echo "<span class='entree'> entrée service</span>";
				} elseif($activite->lastDimonaAction == DolsisFlux::CODE_ACTION_SORTIE) {
					echo "<span class='sortie'> sortie service</span>";
				} elseif($activite->lastDimonaAction == DolsisFlux::CODE_ACTION_MODIFICATION) {
					echo "<span class='modification'> modification</span>";
				}
				if($activite->cancelled == true) {
					echo "<span class='annulation'> annulation</span>";
				}
				?>
				</td>
			</tr>

			<?php if(isset($activite->usingEmployer)): ?>
			<?php
				$nomEntrepriseInterim = "";
				if (isset($activite->usingEmployer->cbeNumber)) {
					$entrepriseInterim = "N° entreprise BCE = " . $activite->usingEmployer->cbeNumber;

					$nomEntrepriseInterim = $entrepriseDb->getNomFromNumero($activite->usingEmployer->cbeNumber);

				} elseif (isset($activite->usingEmployer->nossRegistrationNbr)) {
					$entrepriseInterim = "N° matricule ONSS = " . $activite->usingEmployer->nossRegistrationNbr->{'_'};

					$nomEntrepriseInterim = $entrepriseDb->getNomFromImmatriculation($activite->usingEmployer->nossRegistrationNbr->{'_'});

				}
			?>
			<tr>
				<th>Intérimaire dans l'entreprise :</th>
				<td><?php echo $entrepriseInterim; ?><?php echo (!empty($nomEntrepriseInterim))?" (" . $nomEntrepriseInterim . ")":""; ?></td>
			</tr>
			<?php endif; ?>

		</tbody>
	</table>
</div>

		<?php endforeach; ?>

	<?php endif; ?>

<?php endif; ?>
