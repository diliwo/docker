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
			
			<?php if (isset($ti->Decease)): ?>
			<tr>
				<th>Décès - numéro de l'acte : </th>
				<td><?php echo $ti->Decease->ActNumber; ?></td>
			</tr>
			
				<?php if (isset($ti->Decease->SuppletoryRegister)): ?>
				<tr>
					<th>Décès - enreg. supplémentaire : </th>
					<td><?php echo $ti->Decease->SuppletoryRegister; ?></td>
				</tr>
				<?php endif; ?>
				
				<?php if (isset($ti->Decease->Place1)): ?>
				<tr>
					<th>Décès - lieu : </th>
					<td><?php echo $ti->Decease->Place1->Label; ?></td>
				</tr>
				<?php elseif (isset($ti->Decease->Place2)): ?>
				<tr>
					<th>Décès - lieu : </th>
					<td><?php echo $ti->Decease->Place2->Country->Label; ?><?php echo (isset($ti->Decease->Place2->Graphic))?" (" . $ti->Decease->Place2->Graphic . ")":""; ?></td>
				</tr>
				<?php endif; ?>
			<?php elseif (isset($ti->Decision)): ?>
			<tr>
				<th>Décision - type : </th>
				<td><?php echo $ti->Decision->Type->Label; ?></td>
			</tr>
			
			<tr>
				<th>Décision - transcription : </th>
				<td><?php echo $ti->Decision->Transcription->Place->Label; ?><?php echo (isset($ti->Decision->Transcription->Date))?" (" . DateTransaction25::format($ti->Decision->Transcription->Date) . ")":""; ?></td>
			</tr>
			
				<?php if (isset($ti->Decision)): ?>
				<tr>
					<th>Décision - divers : </th>
					<td><?php echo $ti->Decision->Graphic; ?></td>
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