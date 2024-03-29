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
			
			<?php if (isset($ti->Name)): ?>
			<tr>
				<th>Nom : </th>
				<td><?php echo NomCompletTransaction25::format($ti->Name); ?></td>
			</tr>
			<?php endif; ?>
			
			<?php if (isset($ti->Nationality)): ?>
			<tr>
				<th>Nationalité : </th>
				<td><?php echo $ti->Nationality->Label; ?></td>
			</tr>
			<?php endif; ?>
			
			<?php if (isset($ti->BirthDate)): ?>
			<tr>
				<th>Date d'anniversaire : </th>
				<td><?php echo DateTransaction25::format($ti->BirthDate); ?></td>
			</tr>
			<?php endif; ?>
			
			<?php if (isset($ti->BirthPlace)): ?>
			<tr>
				<th>Lieu de naissance : </th>
				<td><?php echo $ti->BirthPlace; ?></td>
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