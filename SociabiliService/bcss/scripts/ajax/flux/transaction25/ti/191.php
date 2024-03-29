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
			
			<tr>
				<th>Type : </th>
				<td><?php echo $ti->TypeOfLicense->Label; ?></td>
			</tr>
			
			<?php if (isset($ti->LicenseNumber)): ?>
			<tr>
				<th>Numéro : </th>
				<td><?php echo $ti->LicenseNumber; ?></td>
			</tr>
			<?php endif; ?>
			
			<?php if (isset($ti->Place)): ?>
			<tr>
				<th>Lieu : </th>
				<td><?php echo $ti->Place->Label; ?></td>
			</tr>
			<?php endif; ?>
			
			<?php if (isset($ti->DeliveryCountry)): ?>
			<tr>
				<th>Lieu : </th>
				<td><?php echo $ti->DeliveryCountry->Label; ?></td>
			</tr>
			<?php endif; ?>
			
			<?php if (isset($ti->ForfeitureReason)): ?>
			<tr>
				<th>Raison de la confiscation : </th>
				<td><?php echo $ti->ForfeitureReason->Label; ?></td>
			</tr>
			<?php endif; ?>
			
			<?php if (isset($ti->ForfeitureDate)): ?>
			<tr>
				<th>Date de la confiscation : </th>
				<td><?php echo DateTransaction25::format($ti->ForfeitureDate); ?></td>
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