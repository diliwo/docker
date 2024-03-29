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
			
			<?php if (isset($ti->ElectoralFunction)): ?>
			<tr>
				<th>Fonction électorale : </th>
				<td>
					<ul>
					<?php echo (isset($ti->ElectoralFunction->Situation))?"<li>" . $ti->ElectoralFunction->Situation->Label . "</li>":""; ?>
					<?php echo (isset($ti->ElectoralFunction->Category))?"<li>" . $ti->ElectoralFunction->Category->Label . "</li>":""; ?>
					<?php echo (isset($ti->ElectoralFunction->Modified))?"<li>" . $ti->ElectoralFunction->Modified . "</li>":""; ?>
					<?php echo (isset($ti->ElectoralFunction->Volunteer))?"<li>" . $ti->ElectoralFunction->Volunteer->Label . "</li>":""; ?>
					<?php echo (isset($ti->ElectoralFunction->CODNBSC))?"<li>" . $ti->ElectoralFunction->CODNBSC . "</li>":""; ?>
					<?php echo (isset($ti->ElectoralFunction->Place))?"<li>" . $ti->ElectoralFunction->Place . "</li>":""; ?>
					</ul>
				</td>
			</tr>
			<?php elseif (isset($ti->Voter)): ?>
			<tr>
				<th>Votant : </th>
				<td>
					<ul>
					<?php echo (isset($ti->ElectoralFunction->Situation))?"<li>" . $ti->ElectoralFunction->Situation->Label . "</li>":""; ?>
					<?php echo (isset($ti->ElectoralFunction->ExpiryDate))?"<li>" . DateTransaction25::format($ti->ElectoralFunction->ExpiryDate) . "</li>":""; ?>
					<?php echo (isset($ti->ElectoralFunction->Graphic))?"<li>" . $ti->ElectoralFunction->Graphic . "</li>":""; ?>
					</ul>
				</td>
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