<?php 

foreach ($integrationsHorsCpas as $integration) {
	$numeroSecteur = $integration->get('numero_secteur');
	if ($numeroSecteur != 17) {
		$integrationsHorsCpasTemp[$numeroSecteur][] = clone $integration;
		
	}
}

// Si tableau est vide, on renvoi aucune un tablea vide
if (isset($integrationsHorsCpasTemp)) {
	ksort($integrationsHorsCpasTemp);

} else {
	$integrationsHorsCpasTemp = array();

}

?>

<h1>Intégrations hors CPAS<?php echo " (" . $dateDebut->format("d/m/Y") . " au " . $dateFin->format("d/m/Y") . ")"; ?></h1>

<?php if (count($integrationsHorsCpasTemp) > 0): ?>

<?php foreach ($integrationsHorsCpasTemp as $numeroSecteur => $integrations): ?>

	<div class="fieldset" name="integration-hors-cpas" id="integration-hors-cpas-<?php echo $i; ?>">
		<h1><?php echo $integrations[0]->get('description_secteur') . " (numéro " . $numeroSecteur . ")"; ?></h1>
		
		<?php foreach ($integrations as $nb=>$integration): ?>
		
		<table width="100%">
			<tbody>
				<tr>
					<th>Période :</th>
					<td><?php echo $integration->getPeriode(); ?></td>
				</tr>
				
				<tr>
					<th>Code qualité :</th>
					<td><?php echo $integration->get('description_code_qualite') . " (code " . $integration->get('code_qualite') . ")"; ?></td>
				</tr>
			</tbody>
		</table>
		<?php 
	    if ($nb < (count($integrations) - 1))
	    	echo "<hr>";
	    ?>
		
		<?php endforeach; ?>
		
	</div>
	
<?php endforeach; ?>

<?php else: ?>

<p class="error">Aucune donnée</p>

<?php endif; ?>