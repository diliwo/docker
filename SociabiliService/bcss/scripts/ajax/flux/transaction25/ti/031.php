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
        		<th>Nationalité : </th>
        		<td><?php echo $ti->Nationality->Label; ?></td>
        	</tr>
        	
        	<?php if (isset($ti->Reason)): ?>
        		<?php if (isset($ti->Reason->Graphic)): ?>
	        	<tr>
	        		<th>Raison : </th>
	        		<td><?php echo $ti->Reason->Graphic; ?></td>
	        	</tr>
	        	<?php elseif (isset($ti->Reason->Justification)): ?>
	        	
	        	<tr>
	        		<th>Raison - justification : </th>
	        		<td><?php echo $ti->Reason->Justification->Label; ?></td>
	        	</tr>
	        	
	        	<tr>
	        		<th>Raison - lieu : </th>
	        		<td><?php echo LieuTransaction25::format($ti->Reason->Place); ?></td>
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