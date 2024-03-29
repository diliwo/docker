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
			
			<?php if (isset($ti->NationalNumber)): ?>
			<tr>
				<th>Numéro national : </th>
				<td><?php echo NumeroNationalTransaction25::format($ti->NationalNumber); ?></td>
			</tr>
			<?php endif; ?>
			
			<?php if (isset($ti->Housing)): ?>
			<tr>
				<th>Logement : </th>
				<td><?php echo ( isset( $ti->Housing->Label) ? $ti->Housing->Label : '' ) ; ?> </td>
			</tr>
			<?php endif; ?>
			
			<?php if (isset($ti->FamilyRole)): ?>
			<tr>
				<th>Role familial : </th>
				<td><?php echo $ti->FamilyRole->Label; ?></td>
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