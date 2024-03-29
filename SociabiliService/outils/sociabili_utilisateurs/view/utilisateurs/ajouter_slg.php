<script type="text/javascript">
<!--
$(document).ready(function() {
	$("#slgs").multiselect({
		checkAllText: 'Tous',
		uncheckAllText: 'Aucun',
		noneSelectedText: 'Sélection des SLGs',
		selectedList: 2,
		selectedText: function(numChecked, numTotal, checkedItems){
			return numChecked + ' SLGs sélectionné(s)';
		}		
	})
	.multiselectfilter({
		label: 'Recherche:'
	});
	
	$("#ajouter-utilisateur-slg").validate();
});
//-->
</script>

<style>
<!--
	#ajouter-utilisateur-slg
	{
		width: 90%;
	}
	#ajouter-utilisateur-slg p
	{
		margin: 10px 5px 0 0;
	}
	/* FIELDSET */
	#ajouter-utilisateur-slg fieldset
	{
		width: 108%;
		padding: 10px 10px 5px 10px;
		border: #CCC 1px solid;
		margin: 20px 0 10px 0;
	}
	#ajouter-utilisateur-slg fieldset legend
	{
		padding: 0 10px;
		font-size: 1.2em;
		color: green;
	}
	
	#ajouter-utilisateur-slg input[type=checkbox]
	{
		padding: 5px 5px;
	}
	#ajouter-utilisateur-slg input[type=text]
	{
		width: 250px;
	}
	#ajouter-utilisateur-slg select
	{
		width: 500px;
	}
	/* LABEL */
	#ajouter-utilisateur-slg label
	{
		display: block;
		width: 150px;
		float: left;
		line-height: 18px;
	}
	#ajouter-utilisateur-slg label.ui-corner-all
	{
		width: 450px;
	}
	
	#ajouter-utilisateur-slg label.error 
	{
		display: inline;
		float: none; 
		color: red; 
		padding-left: .5em; 
	}
-->
</style>

<h1 class="titre-gauche">Ajouter SLG à <?php echo $utilisateur->getNom(); ?> <?php echo $utilisateur->getPrenom(); ?></h1>
<br style="clear:both;" />
<hr>

<form id="ajouter-utilisateur-slg" method="post" action="<?php echo $baseUrl."utilisateurs/ajouter_slg/".$utilisateur->getId(); ?>">

	<p>
		<label for="slgs">SLGs: </label>
		<select id="slgs" name="id_slg[]" multiple="multiple">
			<?php foreach ($slgs as $slg): ?>
			<option value="<?php echo $slg->getId(); ?>"<?php echo (in_array($slg->getId(), $utilisateur->getIdSLGs()))?" selected='selected'":""; ?>> <?php echo $slg->getService()->getNom(); ?> - <?php echo $slg->getLocalisation()->getNom(); ?> - <?php echo $slg->getGroupe()->getNom(); ?></option>
			<?php endforeach; ?>
		</select>
	</p>
	<br style="clear:both;" />
	
	<div style="text-align: center;">
		<p>
			<input style="width: 120px;" class="ajouter" type="submit" name="ajouter_utilisateur_slg" value="Ajouter">
		</p>
	</div>
	
</form>

