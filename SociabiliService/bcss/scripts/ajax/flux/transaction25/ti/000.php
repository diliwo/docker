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
        		<td><?php echo DateTransaction25::format($ti->NationalNumber->Date); ?></td>
        	</tr>

	        <tr>
	            <th>Numéro national : </th>
	            <td><a href="index.php?env=member&page=person&action=display&rn=<?php echo $ti->NationalNumber->NationalNumber; ?>" class="rn"><?php echo $ti->NationalNumber->NationalNumber; ?></a></td>
	        </tr>

	        <tr>
	            <th>Sexe : </th>
	            <td><?php echo ($ti->NationalNumber->Sex == 1)?"Homme":"Femme"; ?></td>
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
