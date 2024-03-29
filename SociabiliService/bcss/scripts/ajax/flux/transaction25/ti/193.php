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
			
			<?php if (isset($ti->Card)): ?>
			
				<?php if (isset($ti->Card->CardNumber)): ?>
				<tr>
					<th>Carte - numéro : </th>
					<td><?php echo $ti->Card->CardNumber; ?></td>
				</tr>
				<?php endif; ?>
				
				<?php if (isset($ti->Card->SerialNumber)): ?>
				<tr>
					<th>Carte - numéro de série : </th>
					<td><?php echo $ti->Card->SerialNumber; ?></td>
				</tr>
				<?php endif; ?>
				
			<?php endif; ?>
			
			<?php if (isset($ti->Categories)): ?>
			<tr>
				<th>Catégorie : </th>
				<td><?php echo $ti->Categories->Category; ?></td>
			</tr>
			<?php endif; ?>
			
			<?php if (isset($ti->Place)): ?>
			<tr>
				<th>Lieu : </th>
				<td><?php echo $ti->Place->Label; ?></td>
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