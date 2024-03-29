<script type="text/javascript">
<!--
$(document).ready(function() {
	$('#prenom').change(function(){
		var samaccountname = $(this).val() + "." + $('#nom').val();
		$('#samaccountname').val(samaccountname.toLowerCase());
	});
	$('#nom').change(function(){
		var samaccountname = $('#prenom').val() + "." + $(this).val();
		$('#samaccountname').val(samaccountname.toLowerCase());
	});
	$("#slgs").multiselect({
		checkAllText: 'Tous',
		uncheckAllText: 'Aucun',
		noneSelectedText: 'Sélection des SLGs',
		selectedList: 2,
		selectedText: function(numChecked, numTotal, checkedItems){
			return numChecked + ' SLGs sélectionné(s)';
		}		
	});

	$("#modifier-utilisateur").validate();
});
//-->
</script>

<style>
<!--
	#modifier-utilisateur
	{
		width: 90%;
	}
	#modifier-utilisateur p
	{
		margin: 10px 5px 0 0;
	}
	/* FIELDSET */
	#modifier-utilisateur fieldset
	{
		width: 108%;
		padding: 10px 10px 5px 10px;
		border: #CCC 1px solid;
		margin: 20px 0 10px 0;
	}
	#modifier-utilisateur fieldset legend
	{
		padding: 0 10px;
		font-size: 1.2em;
		color: green;
	}
	
	#modifier-utilisateur input[type=checkbox]
	{
		padding: 5px 5px;
	}
	#modifier-utilisateur input[type=text]
	{
		width: 250px;
	}
	#modifier-utilisateur select
	{
		width: 500px;
	}
	/* LABEL */
	#modifier-utilisateur label
	{
		display: block;
		width: 150px;
		float: left;
		line-height: 18px;
	}
	#modifier-utilisateur label.ui-corner-all
	{
		width: 450px;
	}
	
	#modifier-utilisateur label.error 
	{
		display: inline;
		float: none; 
		color: red; 
		padding-left: .5em; 
	}
-->
</style>

<h1 class="titre-gauche">Modifier un utilisateur</h1>
<br style="clear:both;" />
<hr>

<form id="modifier-utilisateur" method="post" action="<?php echo $baseUrl."utilisateurs/modifier/".$utilisateur->getId(); ?>">
	<p>
		<label for="prenom">Prénom: </label>
		<input class="required" type="text" id="prenom" name="prenom" value="<?php echo $utilisateur->getPrenom(); ?>" />
	</p>
	<p>
		<label for="nom">Nom: </label>
		<input class="required" type="text" id="nom" name="nom" value="<?php echo $utilisateur->getNom(); ?>" />
	</p>
	<p>
		<label for="code_as">Code AS: </label>
		<input type="text" id="code_as" name="code_as" value="<?php echo $utilisateur->getCodeAs(); ?>" />
	</p>
	<p>
		<label for="samaccountname">Samaccountname: </label>
		<input class="required" type="text" id="samaccountname" name="samaccountname" value="<?php echo $utilisateur->getSamaccountname(); ?>" />
	</p>
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
			<input style="width: 120px;" class="modifier" type="submit" name="modifier-utilisateur" value="Modifier">
		</p>
	</div>
	
</form>
