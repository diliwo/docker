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
				<th>Numéro de l'acte : </th>
				<td><?php echo $ti->ActNumber; ?></td>
			</tr>
			
			<?php if (isset($ti->SuppletoryRegister)): ?>
			<tr>
				<th>Enregistrement supplémentaire : </th>
				<td><?php echo $ti->SuppletoryRegister ?></td>
			</tr>
			<?php endif; ?>
			
			<?php if (isset($ti->Place1)): ?>
			<tr>
				<th>Lieu : </th>
				<td><?php echo $ti->Place1->Label; ?></td>
			</tr>
			<?php else: ?>
			<tr>
				<th>Lieu : </th>
				<td><?php echo $ti->Place2->Country->Label; ?><?php echo (isset($ti->Place2->Graphic))?" (" . $ti->Place2->Graphic . ")":""; ?></td>
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