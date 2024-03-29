<h1>Dimonas</h1>

<?php if ($activites['error']): ?>
<div class="fieldset">
	<h1>Dimona</h1>
	<p><?php echo $activites['message']; ?></p>
</div>

<?php else: ?>

	<?php foreach ($activites['data'] as $nb=>$activite): ?>
	
<div class="fieldset">
	<h1>Période <?php echo PeriodeDimona::format($activite->Worker->OccupationPeriod); ?></h1>
	
<?php 
$nomEntreprise = $entrepriseDb->getNomFromImmatriculation($activite->Employer->FirmID->NLOSSRegistrationNbr);
if (empty($nomEntreprise)) {
	$entreprise = $flux->getEntreprise($activite->Employer->FirmID->NLOSSRegistrationNbr);
	$nomEntreprise = $entreprise['data']->Name;
	
	// Ajout dans la DB
	$entrepriseDb->ajouter($entreprise['data']->NLOSSRegistrationNbr, $entreprise['data']->CompanyID, $entreprise['data']->Name);
}
if (isset($activite->InterimUser))
	$nomEntrepriseInterim = $entrepriseDb->getNomFromNumero($activite->InterimUser->CompanyID);

?>
	<table>
		<tbody>
		
			<tr>
				<th>Entreprise - nom: </th>
				<td><?php echo $nomEntreprise; ?></td>
			</tr>
			
			<tr>
				<th>Entreprise - numéro BCE : </th>
				<td><?php echo $activite->Employer->FirmID->CompanyID; ?></td>
			</tr>
			
			<tr>
				<th>Entreprise - immatriculation : </th>
				<td><?php echo $activite->Employer->FirmID->NLOSSRegistrationNbr; ?></td>
			</tr>
			
			<tr>
				<th>Commision paritaire : </th>
				<td><?php echo $activite->Worker->JointCommissionNbr; ?></td>
			</tr>
			
			<tr>
				<th>Nature du travailleur :</th>
				<td>
				<?php 
				if ($activite->Worker->KindOfWorker == "STU") {
					echo "Etudiant";
				} else {
					echo "Travailleur hors secteur construction";
				}
				?>
				</td>
			</tr>
			
			<tr>
				<th>Numéro Dimona :</th>
				<td><?php echo $activite->Worker->DimonaNbr; ?></td>
			</tr>
			
			<tr>
				<th>Dernière action dimona :</th>
				<td>
				<?php 
				if($activite->Worker->LastDimonaAction == DimonaFlux::CODE_ACTION_ENTREE) {
					echo "<span class='entree'> entrée service</span>";
				} elseif($activite->Worker->LastDimonaAction == DimonaFlux::CODE_ACTION_SORTIE) {
					echo "<span class='sortie'> sortie service</span>";
				} elseif($activite->Worker->LastDimonaAction == DimonaFlux::CODE_ACTION_MODIFICATION) {
					echo "<span class='modification'> modification</span>";
				} elseif($activite->Worker->LastDimonaAction == DimonaFlux::CODE_ACTION_ANNULATION) {
					echo "<span class='annulation'> annulation</span>";
				}
				?>
				</td>
			</tr>

			<?php if(isset($activite->InterimUser)): ?>
			<tr>
				<th>Intérimaire dans l'entreprise :</th>
				<td>N° entreprise BCE = <?php echo $activite->InterimUser->CompanyID; ?><?php echo (!empty($nomEntrepriseInterim))?" (" . $nomEntrepriseInterim . ")":""; ?></td>
			</tr>
			<?php endif; ?>
			
		</tbody>
	</table>
</div>

	<?php endforeach; ?>
	
<?php endif; ?>
