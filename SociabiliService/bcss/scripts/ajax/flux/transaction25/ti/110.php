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
				<th>Type de filiation : </th>
				<td><?php echo $ti->FiliationType->Label; ?></td>
			</tr>
			
			<?php if (isset($ti->Parent1)): ?>
			<tr>
				<th>1er parent : </th>
				<td><?php echo NomCompletTransaction25::format($ti->Parent1->Name); ?>
				<?php if (isset($ti->Parent1->NationalNumber)): ?>
					<br />
					<?php echo NumeroNationalTransaction25::format($ti->Parent1->NationalNumber); ?>
				<?php endif; ?>
				</td>
			</tr>
			<?php endif; ?>
			
			<?php if (isset($ti->Parent2)): ?>
			<tr>
				<th>2ème parent : </th>
				<td><?php echo NomCompletTransaction25::format($ti->Parent2->Name); ?>
				<?php if (isset($ti->Parent2->NationalNumber)): ?>
					<br />
					<?php echo NumeroNationalTransaction25::format($ti->Parent2->NationalNumber); ?>
				<?php endif; ?>
				</td>
			</tr>
			<?php endif; ?>
			
			<?php if (isset($ti->ActNumber)): ?>
			<tr>
				<th>Numéro de l'acte : </th>
				<td><?php echo $ti->ActNumber; ?></td>
			</tr>
			<?php endif; ?>
			
			<?php if (isset($ti->Place)): ?>
			<tr>
				<th>Lieu : </th>
				<td><?php echo $ti->Place->Label; ?></td>
			</tr>
			<?php endif; ?>
			
			<?php if (isset($ti->Graphic)): ?>
			<tr>
				<th>Divers : </th>
				<td><?php echo $ti->Graphic; ?></td>
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