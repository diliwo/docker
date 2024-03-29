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
			
			<?php if (isset($ti->DateEntered)): ?>
			<tr>
				<th>Date d'entrée : </th>
				<td><?php echo DateTransaction25::format($ti->DateEntered); ?></td>
			</tr>
			<?php endif; ?>
			
			<?php if (isset($ti->DateValidated)): ?>
			<tr>
				<th>Date de validation : </th>
				<td><?php echo DateTransaction25::format($ti->DateValidated); ?></td>
			</tr>
			<?php endif; ?>
			
			<tr>
				<th>Validation : </th>
				<td><?php echo $ti->Validation->Label; ?></td>
			</tr>
			
			<tr>
				<th>Divers : </th>
				<td><?php echo $ti->Graphic; ?></td>
			</tr>
			
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