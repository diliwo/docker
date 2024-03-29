<?php
$num = basename(__FILE__, '.php');
?>

<?php if (isset($res['data'][$num]["data"])): ?>

<div class="fieldset">
	<h1><?php echo $res['data'][$num]["name"]; ?> (TI <?php echo $num; ?>)</h1>
	
	<?php foreach ($res['data'][$num]["data"] as $nb=>$ti): ?>
	<table>
		<tbody>
			<tr>
				<th>Date : </th>
				<td><?php echo DateTransaction25::format($ti->Date); ?></td>
			</tr>
        	
			<?php if (isset($ti->DelDate)): ?>
			<tr>
				<th>Date de suppression : </th>
				<td><?php echo DateTransaction25::format($ti->DelDate); ?></td>
			</tr>
			<?php endif; ?>
			
			<?php if (isset($ti->Status)): ?>
			<tr>
				<th>Statut : </th>
				<td><?php echo $ti->Status->Label; ?></td>
			</tr>
			<?php endif; ?>
			
			<?php if (isset($ti->PassportIdent)): ?>
			<tr>
				<th>Type et numéro : </th>
				<td><?php echo IdentificationPasseportTransaction25::format($ti->PassportIdent); ?></td>
			</tr>
			<?php endif; ?>
			
			<?php if (isset($ti->Issuer)): ?>
			<tr>
				<th>Emetteur : </th>
				<td><?php echo EmetteurTransaction25::format($ti->Issuer); ?></td>
			</tr>
			<?php endif; ?>
			
			<?php if (isset($ti->RenewalNumber)): ?>
			<tr>
				<th>Numéro de renouvellement : </th>
				<td><?php echo $ti->RenewalNumber; ?></td>
			</tr>
			<?php endif; ?>
			
			<?php if (isset($ti->SerialNumber)): ?>
			<tr>
				<th>Numéro de série : </th>
				<td><?php echo $ti->SerialNumber; ?></td>
			</tr>
			<?php endif; ?>
			
			<?php if (isset($ti->SecondNumber)): ?>
			<tr>
				<th>Second numéro : </th>
				<td><?php echo $ti->SecondNumber; ?></td>
			</tr>
			<?php endif; ?>
			
			<?php if (isset($ti->ReplacementOf)): ?>
			<tr>
				<th>Remplacement de : </th>
				<td><?php echo $ti->ReplacementOf; ?></td>
			</tr>
			<?php elseif (isset($ti->AdditionTo)): ?>
			<tr>
				<th>Outre : </th>
				<td><?php echo $ti->AdditionTo; ?></td>
			</tr>
			<?php endif; ?>
			
			<?php if (isset($ti->ProductionDate)): ?>
			<tr>
				<th>Date de production : </th>
				<td><?php echo DateTransaction25::format($ti->ProductionDate); ?></td>
			</tr>
			<?php endif; ?>
			
			<?php if (isset($ti->ExpiryDate)): ?>
			<tr>
				<th>Date d'expiration : </th>
				<td><?php echo DateTransaction25::format($ti->ExpiryDate); ?></td>
			</tr>
			<?php endif; ?>
			
		</tbody>
	</table>
	<?php 
    if ($nb < (count($res['data'][$num]["data"]) - 1))
    	echo "<hr>";
    ?>
    
	<?php endforeach; ?>
	
</div>

<?php else: ?>

<div class="fieldset empty">
	<h1><?php echo $res['data'][$num]["name"]; ?> (TI <?php echo $num; ?>)</h1>
	<p>Aucune donnée</p>    
</div>

<?php endif; ?>