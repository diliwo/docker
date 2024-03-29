<h1>Mutualités</h1>

<h2>du <?php echo $dateDebut->format("d/m/Y")?> au <?php echo $dateFin->format("d/m/Y")?></h2>
<div class="fieldset">
	<h1>Assurabilités</h1>
	
	<?php if ($assurabilites['error']): ?>
	
	<p><?php echo $assurabilites['message']; ?></p>
	
	<?php else: ?>
	
		<?php foreach ($assurabilites['data'] as $nb=>$assurabilite): ?>
	
	<table>
		<tbody>
		
<?php 
$i = 0;
foreach ($assurabilite->HolderRights->YearApplicationMaximumToBeInvoiced as $annee) {
	if ($annee != '0000') {
		if ($i==0) {
			$annees = $annee;
		} else {
			$annnees .= " et " .$annee;
		}
		$i++;
	}
}
?>

			<tr>
				<th>Années d'applications du 'maximum à facturer' :</th>
				<td><?php echo $annees; ?></td>
			</tr>
			
			<tr>
				<th>Droit au régime du tiers payant :</th>
				<td><?php echo ($assurabilite->HolderRights->PayingThirdIndicator == 0)?"non":"oui"; ?></td>
			</tr>
			
			<?php if (isset($assurabilite->InsurancePart)): ?>
			
			<tr>
				<th>Nom mutuelle :</th>
				<td><?php echo $mutuelleDb->getNomFromNumeroSection( $assurabilite->InsurancePart->HealthServiceIdentification ); ?></td>
			</tr>
			
			<tr>
				<th>Numéro d'affiliation :</th>
				<td><?php echo $assurabilite->InsurancePart->HealthServiceRegistrationNumber; ?></td>
			</tr>
			
			<tr>
				<th>Période d'assurabilité :</th>
				<td><?php echo PeriodeHealthinsurance::format($assurabilite->InsurancePart->InsurancePeriod); ?></td>
			</tr>
		</tbody>
	</table><br />
	
	<?php for($i=1; $i<=2; $i++): ?>
	
	<div class="fieldset">
		<h1>Code titulaire 2 :</h1>
		
		<table>
			<tbody>
			
				<tr>
					<th>Régime : </th>
					<td><?php echo RegimeHealthinsurance::format($assurabilite->InsurancePart->HolderCode[$i]->Regime, $i, $assurabilite->InsurancePart->HolderCode[1]->Regime); ?></td>
				</tr>
				
				<tr>
					<th>Statut social :</th>
					<td><?php echo StatutSocialHealthinsurance::format($assurabilite->InsurancePart->HolderCode[$i]->Regime, $assurabilite->InsurancePart->HolderCode[$i]->SocialStatus, $i, $assurabilite->InsurancePart->HolderCode[1]->Regime); ?></td>
				</tr>
				
				<tr>
					<th>Droit à l'intervention majorée :</th>
					<td><?php echo InterventionMajoreeHealthinsurance::format($assurabilite->InsurancePart->HolderCode[$i]->IncreasedIntervention); ?></td>
				</tr>
				
			</tbody>
			
		</table>
		
	</div>
	
	<?php endfor; ?>
			
			<?php endif; ?>
		<?php 
		if ($nb < (count($assurabilites['data']) - 1))
	    	echo "<hr>";
		?>
	
		<?php endforeach; ?>
		
	<?php endif; ?>

</div>

<?php
