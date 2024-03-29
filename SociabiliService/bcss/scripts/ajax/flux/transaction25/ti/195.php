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
			
			<?php if (isset($ti->TypeOfCard)): ?>
			<tr>
				<th>Type : </th>
				<td><?php echo $ti->TypeOfCard->Label; ?></td>
			</tr>
			<?php endif; ?>
			
			<?php if (isset($ti->Duplicate)): ?>
			<tr>
				<th>Duplicata : </th>
				<td><?php echo $ti->Duplicate; ?></td>
			</tr>
			<?php endif; ?>
			
			<?php if (isset($ti->CardNumber)): ?>
			<tr>
				<th>Numéro : </th>
				<td><?php echo $ti->CardNumber; ?></td>
			</tr>
			<?php endif; ?>
			
			<?php if (isset($ti->Delivery)): ?>
			<tr>
				<th>Lieu de livraison : </th>
				<td><?php echo LieuTransaction25::format($ti->Delivery); ?></td>
			</tr>
			<?php endif; ?>
			
			<?php if (isset($ti->Renewal)): ?>
			<tr>
				<th>Renouvelé : </th>
				<td><?php echo $ti->Renewal; ?></td>
			</tr>
			<?php endif; ?>
			
			<?php if (isset($ti->ExpiryDate)): ?>
			<tr>
				<th>Date d'expiration : </th>
				<td><?php echo DateTransaction25::format($ti->ExpiryDate); ?></td>
			</tr>
			<?php endif; ?>
			
			<?php if (isset($ti->Duration)): ?>
			<tr>
				<th>Durée : </th>
				<td><?php echo $ti->Duration->Label; ?></td>
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