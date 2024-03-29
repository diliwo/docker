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
				<th>Etat civil : </th>
				<td><?php echo $ti->CivilState->Label; ?></td>
			</tr>
			
			<?php if (isset($ti->Spouse)): ?>
			<tr>
				<th>Epoux : </th>
				<td><?php echo NomCompletTransaction25::format($ti->Spouse->Name) . "<br />" . NumeroNationalTransaction25::format($ti->Spouse->NationalNumber); ?></td>
			</tr>
			<?php endif; ?>
			
			<?php if (isset($ti->Lieu)): ?>
			<tr>
				<th>Lieu : </th>
				<td><?php echo LieuTransaction25::formatEtatCivil($ti->Lieu); ?></td>
			</tr>
			<?php endif; ?>
			
			<?php if (isset($ti->ActNumber)): ?>
			<tr>
				<th>Numéro d'acte : </th>
				<td><?php echo $ti->ActNumber; ?></td>
			</tr>
			<?php endif; ?>
			
			<?php if (isset($ti->SuppletoryRegister)): ?>
			<tr>
				<th>Enregistrement supplémentaire : </th>
				<td><?php echo $ti->SuppletoryRegister ?></td>
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