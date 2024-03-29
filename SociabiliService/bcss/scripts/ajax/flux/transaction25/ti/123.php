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
			
			<?php if (isset($ti->Declaration)): ?>
			
				<tr>
					<th>Type : </th>
					<td>DECLARATION</td>
				<tr>
				
				<tr>
					<th>Lieu : </th>
					<td><?php echo $ti->Declaration->Place->Label; ?></td>
				</tr>
				
				<tr>
					<th>Date d'enregistrement : </th>
					<td><?php echo DateTransaction25::format($ti->Declaration->RegistrationDate); ?></td>
				</tr>
				
				<?php if (isset($ti->Declaration->Partner)): ?>
				<tr>
					<th>Partenaire : </th>
					<td>
					<?php echo NomCompletTransaction25::format($ti->Declaration->Partner->Name) ?>
						<?php if (isset($ti->Declaration->Partner->NationalNumber)): ?>
							<br />
							<?php echo NumeroNationalTransaction25::format($ti->Declaration->Partner->NationalNumber); ?>
						<?php endif; ?>
					</td>
				</tr>
				<?php endif; ?>
				
				<?php if (isset($ti->Declaration->Notary)): ?>
				<tr>
					<th>Notaire : </th>
					<td><?php echo (isset($ti->Declaration->Notary->NameNotary))?$ti->Declaration->Notary->NameNotary:""; ?><?php echo (isset($ti->Declaration->Notary->Place))?" à " . $ti->Declaration->Notary->Place->Label:""; ?><?php echo (isset($ti->Declaration->Notary->Country))?" (" . $ti->Declaration->Notary->Country->Label . ")":""; ?></td>
				</tr>
				<?php endif; ?>
			
			<?php elseif (isset($ti->Cessation)): ?>
			
				<tr>
					<th>Type : </th>
					<td>CESSATION</td>
				</tr>
				
				<tr>
					<th>Lieu : </th>
					<td><?php echo $ti->Cessation->Place->Label; ?></td>
				</tr>
				
				<tr>
					<th>Raison : </th>
					<td><?php echo $ti->Cessation->Reason->Label; ?></td>
				</tr>
				
				<?php if (isset($ti->Cessation->Notification)): ?>
				<tr>
					<th>Notification : </th>
					<td><?php echo (isset($ti->Cessation->Notification->NotificationDate))?"le " . DateTransaction25::format($ti->Cessation->Notification->Place->NotificationDate):""; ?><?php echo (isset($ti->Cessation->Notification->Place))?" à " . $ti->Cessation->Notification->Place->Label:""; ?></td>
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