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
			
			<?php if (isset($ti->TypeOfVoting)): ?>
			<tr>
				<th>Type de vote : </th>
				<td><?php echo $ti->TypeOfVoting->Label; ?></td>
			</tr>
			<?php endif; ?>
			
			<?php if (isset($ti->Place)): ?>
			<tr>
				<th>Lieu : </th>
				<td><?php echo $ti->Place->Label; ?></td>
			</tr>
			<?php endif; ?>
			
			<?php if (isset($ti->Post)): ?>
			<tr>
				<th>Poste : </th>
				<td><?php echo $ti->Post->DiplomaticPost->Label; ?> (<?php echo $ti->Post->Territory->Label; ?>)</td>
			</tr>
			<?php endif; ?>
			
			<?php if (isset($ti->ChoiceOfAddress)): ?>
			<tr>
				<th>Choix de l'adresse : </th>
				<td><?php echo $ti->ChoiceOfAddress->Code; ?></td>
			</tr>
			<?php endif; ?>
			
			<?php if (isset($ti->Proxy)): ?>
			<tr>
				<th>Proxy : </th>
				<td><?php echo NumeroNationalTransaction25::format($ti->Proxy->NationalNumber); ?></td>
			</tr>
			<?php elseif (isset($ti->AbsenteeVoter)): ?>
			<tr>
				<th>Votant absent : </th>
				<td><?php echo NumeroNationalTransaction25::format($ti->Proxy->NationalNumber); ?></td>
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