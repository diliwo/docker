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
        		<th>Nom : </th>
        		<td>
        		<?php 
        		if (is_array($ti->Name->LastName)) {
	        		foreach ($ti->Name->LastName as $lastName) {
						echo $lastName->Label . " ";
					}
				} else {
					echo $ti->Name->LastName->Label;
				}
				?>
				</td>
			</tr>
        	<tr>
        		<th>Prénom : </th>
        		<td>
        		<?php 
        		if (is_array($ti->Name->FirstName)) {
	        		foreach ($ti->Name->FirstName as $firstName) {
						echo $firstName->Label . " ";
					}
				} else {
					echo $ti->Name->FirstName->Label;
				}
				?>
        		</td>
        	</tr>
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