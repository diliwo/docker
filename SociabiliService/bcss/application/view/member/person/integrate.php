<?php 

$dateDebut = new DateTime(); 
$dateFin = clone $dateDebut;
$dateFin->modify("+1 month"); 

/* Statut de l'integration:
 *  0 => Ne pas intégrer
 *  1 => A intégrer avec le RN encodé
 *  2 => A intégrer avec le nouvel RN (car changement de RN découvert)
 *  3 => Possibilité d'intéger mais RN BIS
 */
$statutIntegration = 1;
$rn = $ancienRn = $_GET['rn'];

if ($rn != $personne->get('rn')) {
	$ancienRn = $rn;
	$rn = $personne->get('rn');
	$statutIntegration = 2;
}
if ((int) (substr($rn, 2, 2)) > 12) {
	$statutIntegration = 3;
}

?>

<style type="text/css">
	<!--
	@IMPORT URL('includes/css/people.css');
	-->
</style>

<h1>La personne n'est pas encore intégrée à la B.C.S.S.</h1>
<fieldset>
	<table width="100%">
		<tbody>
			<tr>
				<th>Numéro NISS (RN) : </th>
				<td><?php echo $personne->get('rn'); ?></td>
			</tr>
			
			<tr>
				<th>Nom : </th>
				<td><?php echo $personne->get('nom'); ?></td>
			</tr>
			
			<tr>
				<th>Prénom : </th>
				<td><?php echo $personne->get('prenom'); ?></td>
			</tr>
			
			<tr>
				<th>Date de naissance : </th>
				<td><?php echo $personne->get('date_naissance'); ?></td>
			</tr>
			
			<tr>
				<th>Sexe : </th>
				<td><?php echo $personne->get('sexe'); ?></td>
			</tr>
			
			<tr>
				<th>Adresse : </th>
				<td><?php echo $personne->get('adresse'); ?></td>
			</tr>
		</tbody>
	</table>
</fieldset>

<?php if ($statutIntegration > 0): ?>

<div id="integrate_people">

	<?php if ($statutIntegration == 2): ?>
		<p class="info">ATTENTION, le numéro de registre national de la personne a changé.</p>
		<p class="info">(<?php echo $ancienRn; ?> --> <?php echo $rn; ?>)</p>
		<p class="info">Ce nouveau numéro sera donc utilisé pour intégrer la personne.</p>
	<?php elseif ($statutIntegration == 3): ?>
		<p class="info">ATTENTION, le numéro de registre national de la personne est un BIS.</p>
		<p class="info">Certaines données BCSS de la personne ne seront pas disponible.</p>
	<?php endif; ?>
	
	<form action="index.php?env=<?php echo $_GET['env']; ?>&page=<?php echo $_GET['page']; ?>&action=integrate&rn=<?php echo $rn; ?>" method="post">
		<input type="hidden" name="rn" value="<?php echo $rn; ?>">
		
		<p>Voulez-vous intégrer cette personne du <input readonly="readonly" class="datepicker" id="date_debut" name="date_debut" type="text" value="<?php echo $dateDebut->format("d/m/Y"); ?>"> au <input readonly="readonly" class="datepicker" id="date_fin" name="date_fin" type="text" value="<?php echo $dateFin->format("d/m/Y"); ?>"> ?</p>
		<p>
			<input style="width: 100px;" class="yes button" type="submit" name="integrate_person" Value="OUI">
			<input style="width: 100px;" class="no button" type="button" value="NON" onclick="javascript:document.location.href='index.php?env=<?php echo $_GET['env']; ?>&page=<?php echo $_GET['page']; ?>&action=search';">
		</p>
	</form>
	<br style="clear: both;" />
</div>

<script type="text/javascript">
<!--
	$(function(){
		$('#date_debut, #date_fin').datepicker();
		$('#date_fin').datepicker("option", "minDate", <?php echo $dateDebut->format("d/m/Y"); ?>);
		$('#date_debut').datepicker("option", "maxDate", <?php echo $dateDebut->format("d/m/Y"); ?>);
	});
//-->
</script>

<?php else: ?>

<p class="error">ATTENTION, il est impossible d'accéder aux données BCSS de la personne.</p>

<?php endif; ?>