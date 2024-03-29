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
			
			<?php if (isset($ti->WarTitle)): ?>
			<tr>
				<th>Titre de guerre : </th>
				<td><?php echo $ti->WarTitle->Label; ?></td>
			</tr>
			<?php endif; ?>
			
			<?php if (isset($ti->Graphic1)): ?>
			<tr>
				<th>Divers 1 : </th>
				<td><?php echo $ti->Graphic1; ?></td>
			</tr>
			<?php endif; ?>
			
			<?php if (isset($ti->Graphic2)): ?>
			<tr>
				<th>Divers 2 : </th>
				<td><?php echo $ti->Graphic2; ?></td>
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