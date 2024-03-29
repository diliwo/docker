<h1>Intégrations</h1>

<?php if (count($integrations) > 0): ?>

<?php foreach ($integrations as $i=>$integration): ?>

<div class="fieldset" name="integration" id="integration-<?php echo $i; ?>">
	<h1>Période du <?php echo $integration->get('date_debut'); ?> au <?php echo $integration->get('date_fin'); ?></h1>
	<table width="100%">
		<tbody>
			<tr>
				<th>Organisme :</th>
				<td><?php echo $cpInsDb->getNomFromIns($integration->get('numero_organisation')) ." (" . $integration->get('numero_organisation') . ")"; ?></td>
			</tr>
			
			<tr>
				<th>Code qualité :</th>
				<td><?php echo $libelleCodes[$integration->get('code_qualite')]; ?> (code <?php echo $integration->get('code_qualite'); ?>)</td>
			</tr>
			
			<tr>
				<th>Type :</th>
				<td><?php echo $integration->get('type'); ?></td>
			</tr>
		</tbody>
	</table>
</div>

<?php endforeach; ?>

<?php else: ?>

<p class="error">Aucune donnée</p>

<?php endif; ?>
