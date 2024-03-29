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
				<th>Type de sépulture : </th>
				<td><?php echo $ti->TypeOfBurial->Label; ?></td>
			</tr>
			
			<?php if (isset($ti->LegalRepresentative)): ?>
				<?php if (isset($ti->LegalRepresentative->NationalNumber)): ?>
				<tr>
					<th>Représentant légal : </th>
					<td><?php echo NumeroNationalTransaction25::format($ti->LegalRepresentative->NationalNumber); ?></td>
				</tr>
				<?php endif; ?>
				
				<?php if (isset($ti->LegalRepresentative->Graphic)): ?>
				<tr>
					<th>Représentant légal - divers : </th>
					<td><?php echo $ti->LegalRepresentative->Graphic; ?></td>
				</tr>
				<?php endif; ?>
				
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