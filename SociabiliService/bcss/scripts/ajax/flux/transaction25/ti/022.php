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

			<?php if (isset($ti->Address->PosteDiplomatique)): ?>
			<tr>
        		<th>Poste diplomatique : </th>
        		<td><?php echo $ti->Address->PosteDiplomatique->Label; ?></td>
        	</tr>
			<?php endif; ?>

			<?php if (isset($ti->Address->Territory)): ?>
			<tr>
        		<th>Lieu : </th>
        		<td><?php echo $ti->Address->Territory->Label; ?></td>
        	</tr>
			<?php endif; ?>

			<?php if (isset($ti->Address->Address)): ?>
			<tr>
        		<th>Adresse : </th>
        		<td>
					<?php echo (isset($ti->Address->Address->Graphic1)) ? $ti->Address->Address->Graphic1 . "<br />" : ""; ?>
					<?php echo (isset($ti->Address->Address->Graphic2)) ? $ti->Address->Address->Graphic2 . "<br />" : ""; ?>
					<?php echo (isset($ti->Address->Address->Graphic3)) ? $ti->Address->Address->Graphic3 . "<br />" : ""; ?>
					<?php echo (isset($ti->Address->Address->Country->Label)) ? "- PAYS: " . $ti->Address->Address->Country->Label ." -" : ""; ?>
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