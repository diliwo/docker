<script type="text/javascript">
<!--
$(document).ready(function() {
	$("#membres")
	.multiselect({
		checkAllText: 'Tous',
		uncheckAllText: 'Aucun',
		noneSelectedText: 'Sélection des membres',
		selectedList: 2,
		selectedText: function(numChecked, numTotal, checkedItems){
			return numChecked + ' membre(s) sélectionné(s)';
		}
	})
	.multiselectfilter({
		label: 'Recherche:'
	});
	
	$("#ajouter-membre").validate();
});
//-->
</script>

<style>
<!--
	#ajouter-membre
	{
		width: 90%;
	}
	#ajouter-membre p
	{
		margin: 10px 5px 0 0;
	}
	/* FIELDSET */
	#ajouter-membre fieldset
	{
		width: 108%;
		padding: 10px 10px 5px 10px;
		border: #CCC 1px solid;
		margin: 20px 0 10px 0;
	}
	#ajouter-membre fieldset legend
	{
		padding: 0 10px;
		font-size: 1.2em;
		color: green;
	}
	
	#ajouter-membre input[type=checkbox]
	{
		padding: 5px 5px;
	}
	#ajouter-membre input[type=text]
	{
		width: 250px;
	}
	#ajouter-membre select
	{
		width: 500px;
	}
	/* LABEL */
	#ajouter-membre label
	{
		display: block;
		width: 150px;
		float: left;
		line-height: 18px;
	}
	#ajouter-membre label.ui-corner-all
	{
		width: 450px;
	}
	
	#ajouter-membre label.error 
	{
		display: inline;
		float: none; 
		color: red; 
		padding-left: .5em; 
	}
-->
</style>

<h1 class="titre-gauche">Ajouter membre au SLG <br /><?php echo $slg->getService()->getNom(); ?> - <?php echo $slg->getLocalisation()->getNom(); ?> - <?php echo $slg->getGroupe()->getNom(); ?></h1>
<br style="clear:both;" />
<hr>

<form id="ajouter-membre" method="post" action="<?php echo $baseUrl."services_localisations_groupes/ajouter_membre/".$slg->getId(); ?>">

	<p>
		<label for="membres">Membres: </label>
		<select id="membres" name="id_membre[]" multiple="multiple">
			<?php foreach ($membres as $membre): ?>
			<option value="<?php echo $membre->getId(); ?>"<?php echo (in_array($membre->getId(), $slg->getIdMembres()))?" selected='selected'":""; ?>> <?php echo $membre->getNom(); ?> <?php echo $membre->getPrenom(); ?></option>
			<?php endforeach; ?>
		</select>
	</p>
	<br style="clear:both;" />
	
	<div style="text-align: center;">
		<p>
			<input style="width: 120px;" class="ajouter" type="submit" name="ajouter_membre" value="Ajouter">
		</p>
	</div>
	
</form>
