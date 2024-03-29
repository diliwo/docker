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
        	
			<?php if (isset($ti->GeneralInfo)): ?>
			<tr>
				<th>Information générale : </th>
				<td><?php echo isset($ti->GeneralInfo->Label)?$ti->GeneralInfo->Label:"";  ?> <?php echo isset($ti->GeneralInfo->Organization)?$ti->GeneralInfo->Organization->Label:"";  ?></td>
			</tr>
			<?php endif; ?>
			
			<?php if (isset($ti->Procedure)): ?>
			
			<tr>
				<th>Procédure - origine : </th>
				<td><?php echo $ti->Procedure->Origine->Label; ?></td>
			</tr>
			
			<tr>
				<th>Procédure - référence : </th>
				<td><?php echo $ti->Procedure->Reference; ?></td>
			</tr>
			
			<tr>
				<th>Procédure - appel : </th>
				<td><?php echo $ti->Procedure->Appeal->Label; ?></td>
			</tr>
			
			<tr>
				<th>Procédure - ouveture/fermeture : </th>
				<td><?php echo $ti->Procedure->OpenClose->Label; ?></td>
			</tr>
			
			<?php elseif (isset($ti->StrikingOut)): ?>
			
			<tr>
				<th>Radiation - référence : </th>
				<td><?php echo $ti->StrikingOut->Reference; ?></td>
			</tr>
			
			<tr>
				<th>Radiation - statut : </th>
				<td><?php echo $ti->StrikingOut->Status->Label; ?></td>
			</tr>
			
			<tr>
				<th>Radiation - ouveture/fermeture : </th>
				<td><?php echo $ti->StrikingOut->OpenClose->Label; ?></td>
			</tr>
			
			<?php elseif (isset($ti->DecisionCancelled)): ?>
			
			<tr>
				<th>Décision annulée - date : </th>
				<td><?php echo DateTransaction25::format($ti->DecisionCancelled->Date); ?></td>
			</tr>
			
			<tr>
				<th>Décision annulée - référence : </th>
				<td><?php echo $ti->DecisionCancelled->Reference; ?></td>
			</tr>
			
			<?php elseif (isset($ti->Protection)): ?>
				
				<?php if (isset($ti->Protection->Label)): ?>
				<tr>
					<th>Protection : </th>
					<td><?php echo $ti->Protection->Label; ?></td>
				</tr>
				<?php endif; ?>
				
				<?php if (isset($ti->Protection->Reference)): ?>
				<tr>
					<th>Protection - référence : </th>
					<td><?php echo $ti->Protection->Reference; ?></td>
				</tr>
				<?php endif; ?>
				
				<?php if (isset($ti->Protection->Term)): ?>
				<tr>
					<th>Protection - délai : </th>
					<td><?php echo $ti->Protection->Term; ?></td>
				</tr>
				<?php endif; ?>
				
			<?php elseif (isset($ti->DelayLeaveGranted)): ?>
			
			<tr>
				<th>Délai de sortie accordé - date : </th>
				<td><?php echo DateTransaction25::format($ti->DelayLeaveGranted->Date); ?></td>
			</tr>
			
			<?php elseif (isset($ti->Escape)): ?>
			
			<tr>
				<th>Evasion - statut : </th>
				<td><?php echo $ti->Escape->Status; ?></td>
			</tr>
			
			<?php elseif (isset($ti->UnrestrictedStay)): ?>
			
			<tr>
				<th>Séjour illimité - statut : </th>
				<td><?php echo $ti->UnrestrictedStay->Status; ?></td>
			</tr>
			
			<?php elseif (isset($ti->ApplicationRenounced)): ?>
			
			<tr>
				<th>Demande renoncée - statut : </th>
				<td><?php echo $ti->ApplicationRenounced->Status; ?></td>
			</tr>
			
			<?php elseif (isset($ti->TerritoryLeft)): ?>
			
			<tr>
				<th>Sortie du territoire : </th>
				<td><?php echo $ti->TerritoryLeft->Label; ?></td>
			</tr>
			
			<?php elseif (isset($ti->AdviceFromCGVS)): ?>
				
				<?php if (isset($ti->AdviceFromCGVS->Label)): ?>
				<tr>
					<th>Avis provenant de la CGRA : </th>
					<td><?php echo $ti->TerritoryLeft->Label; ?></td>
				</tr>
				<?php endif; ?>
				
				<?php if (isset($ti->AdviceFromCGVS->Reference)): ?>
				<tr>
					<th>Avis provenant de la CGRA - référence : </th>
					<td><?php echo $ti->TerritoryLeft->Reference; ?></td>
				</tr>
				<?php endif; ?>
				
			<?php elseif (isset($ti->Decision)): ?>
			
				<?php if (isset($ti->Decision->Label)): ?>
				<tr>
					<th>Décision : </th>
					<td><?php echo $ti->Decision->Label; ?></td>
				</tr>
				<?php endif; ?>
				
				<?php if (isset($ti->Decision->Reference)): ?>
				<tr>
					<th>Décision - référence : </th>
					<td><?php echo $ti->Decision->Reference; ?></td>
				</tr>
				<?php endif; ?>
				
				<?php if (isset($ti->Decision->OpenClose)): ?>
				<tr>
					<th>Décision - ouverture/fermeture : </th>
					<td><?php echo $ti->Decision->OpenClose->Label; ?></td>
				</tr>
				<?php endif; ?>
				
				<?php if (isset($ti->Decision->Comments)): ?>
				<tr>
					<th>Décision - commentaires : </th>
					<td><?php echo $ti->Decision->Comments; ?></td>
				</tr>
				<?php endif; ?>
				
				<?php if (isset($ti->Decision->Term)): ?>
				<tr>
					<th>Décision - délai : </th>
					<td><?php echo $ti->Decision->Term; ?> jour(s)</td>
				</tr>
				<?php endif; ?>
				
			<?php elseif (isset($ti->ApplicationFiled)): ?>
			
			<tr>
				<th>Demande déposée : </th>
				<td><?php echo $ti->ApplicationFiled->Label; ?></td>
			</tr>
			
			<?php elseif (isset($ti->NotificationByDVZ)): ?>
			
			<tr>
				<th>Notification - émetteur : </th>
				<td>Office des étrangers</td>
			</tr>
			
			<tr>
				<th>Notification - référence : </th>
				<td><?php echo $ti->NotificationByDVZ->Reference; ?></td>
			</tr>
			
			<?php elseif (isset($ti->NotificationByOrg)): ?>
			
			<tr>
				<th>Notification - émetteur : </th>
				<td><?php echo $ti->NotificationByOrg->Place->Label; ?></td>
			</tr>
			
			<tr>
				<th>Notification - référence : </th>
				<td><?php echo $ti->NotificationByOrg->Reference; ?></td>
			</tr>
			
			<?php elseif (isset($ti->AppealLodged)): ?>
			
			<tr>
				<th>Recours formulé - référence : </th>
				<td><?php echo $ti->AppealLodged->Reference; ?></td>
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