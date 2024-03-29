<h1>Avertissement(s) extrait de rôle</h1>
<?php 
if ($_SESSION[$_config['application_name']]['droits']['taxi_as'] != true) { 
	$res['error']=true;
	$res['message'] = "Vous n'avez pas les droits suffisants pour accéder à ces informations";
} 
?>

<?php if($res['error']): ?>

<p class="error"><?php echo $res['message']; ?></p>

<?php else: ?>

	<p class="info"><?php echo $res['message']; ?></p>

	<?php if($res['data']): ?>

	<div class="fieldset">
		<h1>Revenu(s) disponible</h1> 

		<table>
			<tbody>
				
				<tr>
					<th>Année de revenu : </th>
					<td><?php echo $res['data']->incomeYear; ?></td>
				</tr>

				<tr>
					<th>Numéro d'article : </th>
					<td><?php echo $res['data']->articleNumber; ?></td>
				</tr>

				<tr>
					<th>Données IPCAL : </th>
					<td>
					<?php if (count($res['data']->ipcalItems->ipcalItem) > 0): ?> 
					<?php
						if (count($res['data']->ipcalItems->ipcalItem) == 1) {
							$items[] = $res['data']->ipcalItems->ipcalItem;

						} else {
							$items = $res['data']->ipcalItems->ipcalItem;

						}
					?>
						<table style="width: 70%; text-align: right;">
							<tbody>
						<?php foreach ($items as $i => $ipcal): ?>

							<tr>
								<td><?php echo($i+1); ?></td> 
								<td style="width:150px;"><?php echo number_format(((float) $ipcal->value)/100, 2, ',', ' '); ?> €</td> 
								<td style="width:150px;">Code <?php echo $ipcal->code; ?> <img class="infobulle" title="<?php echo $descriptionCodeIpcal[$ipcal->code]; ?>" src="includes/images/info.png"></td>
							</tr>

						<?php endforeach; ?>
							</tbody>
						</table>

					<?php else: ?>
							<p>Aucun</p>
					<?php endif; ?>
					</td>
				</tr>

			</tbody>
		</table>

	</div>

	<?php endif; ?>

<?php endif; ?>
	