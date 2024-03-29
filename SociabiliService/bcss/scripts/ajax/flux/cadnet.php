<h1>Cadnet</h1>

<?php if($res['error']): ?>

<p class="error"><?php echo $res['message']; ?></p>

<?php else: ?>

<p class="info"><?php echo $res['message']; ?></p>

<?php if (isset($res['data']->person->partnerIdentity)): ?>
<div class="fieldset">
	<h1>Partenaire</h1>

	<table>
		<tbody>
			
			<tr>
				<th>Nom : </th>
				<td><?php echo PersonneCadnet::formatNom($res['data']->person->partnerIdentity); ?></td>
			</tr>

			<tr>
				<th>Prénom : </th>
				<td><?php echo PersonneCadnet::formatPrenom($res['data']->person->partnerIdentity); ?></td>
			</tr>

			<tr>
				<th>Numéro national : </th>
				<td><?php echo PersonneCadnet::formatNumeroNational($res['data']->person->partnerIdentity); ?></td>
			</tr>

		</tbody>
	</table>

</div>
<?php endif; ?>

<div class="fieldset">
	<h1>Biens immobiliers</h1>
	
<?php 
$biensImmobiliers = array();
if (is_array($res['data']->property)) {
	$biensImmobiliers = $res['data']->property;

} else {
	$biensImmobiliers[0] = $res['data']->property;
	
}
?>
	<?php foreach ($biensImmobiliers as $nb=>$bienImmobilier): ?>
	
	<table>
		<tbody>
		
		<?php if (isset($bienImmobilier->duty)): ?>
			<tr>
				<th>Nature du droit réel : </th>
				<td><?php echo $bienImmobilier->duty; ?></td>
			</tr>
		<?php endif; ?>
		
		<?php if (isset($bienImmobilier->dutyTermination)): ?>
			<tr>
				<th>Droit et année d'extinction: </th>
				<td><?php echo $bienImmobilier->dutyTermination; ?></td>
			</tr>
		<?php endif; ?>
		
		<?php if (isset($bienImmobilier->landRegisterDivisionName)): ?>
			<tr>
				<th>Nom de la division cadastrale dans la commune : </th>
				<td><?php echo $bienImmobilier->landRegisterDivisionName; ?></td>
			</tr>
		<?php endif; ?>
		
		<?php if (isset($bienImmobilier->totalNumberOfOwners)): ?>
			<tr>
				<th>Nombre total de propriétaires : </th>
				<td><?php echo $bienImmobilier->totalNumberOfOwners; ?></td>
			</tr>
		<?php endif; ?>
			
		</tbody>
	</table><br />
	
		<?php if (isset($bienImmobilier->asset)): ?>
	
<?php 
$caracteristiques = array();
if (is_array($bienImmobilier->asset)) {
	$caracteristiques = $bienImmobilier->asset;

} else {
	$caracteristiques[0] = $bienImmobilier->asset;
	
}
?>
		<div class="fieldset">
			<h1>Caractéristiques</h1>
	
			<?php foreach ($caracteristiques as $nb2=>$caracteristique): ?>
			
			<table>
				<tbody>
				
				<?php if (isset($caracteristique->situation)): ?>
					<tr>
						<th>Situation du bien immobilier : </th>
						<td><?php echo $caracteristique->situation; ?></td>
					</tr>
				<?php endif; ?>
				
				<?php if (isset($caracteristique->dateModifSituationAdm)): ?>
					<tr>
						<th>Date de modification de la situation administrative : </th>
						<td><?php echo DatetimeCadnet::format($caracteristique->dateModifSituationAdm); ?></td>
					</tr>
				<?php endif; ?>
				
				<?php if (isset($caracteristique->codeModifSituationAdm)): ?>
					<tr>
						<th>Code « O » de modification de la situation administrative signale que le bien immobilier n'est plus en possession de la personne : </th>
						<td><?php echo $caracteristique->codeModifSituationAdm; ?></td>
					</tr>
				<?php endif; ?>
				
				<?php if (isset($caracteristique->assetDetail)): ?>

<?php 
$details = array();
if (is_array($actif->assetDetail)) {
	$details = $caracteristique->assetDetail;

} else {
	$details[0] = $caracteristique->assetDetail;
	
}
?>
					<tr>
						<th>Détail : </th>
						<td><?php 
						
						foreach ($details as $detail) {
							echo DetailRevenuCadastralCadnet::format($detail);
							echo "<br />";
							
						}
						
						?></td>
					</tr>
				<?php endif; ?>
					
				</tbody>
			</table>
			<?php 
			if ($nb2 < (count($caracteristiques) - 1))
		    	echo "<hr>";
			?>
				
			<?php endforeach; ?>
			
		</div>
	
		<?php endif; ?>
		<?php 
		if ($nb < (count($biensImmobiliers) - 1))
	    	echo "<hr>";
		?>
	
	<?php endforeach; ?>
	
</div>

<?php endif; ?>
