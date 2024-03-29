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
	})
	.multiselectfilter({
		label: 'Recherche:'
	});

	$("#ajouter-utilisateur").validate();
});
//-->
</script>

<style>
<!--
	#ajouter-utilisateur
	{
		width: 90%;
	}
	#ajouter-utilisateur p
	{
		margin: 10px 5px 0 0;
	}
	/* FIELDSET */
	#ajouter-utilisateur fieldset
	{
		width: 108%;
		padding: 10px 10px 5px 10px;
		border: #CCC 1px solid;
		margin: 20px 0 10px 0;
	}
	#ajouter-utilisateur fieldset legend
	{
		padding: 0 10px;
		font-size: 1.2em;
		color: green;
	}
	
	#ajouter-utilisateur input[type=checkbox]
	{
		padding: 5px 5px;
	}
	#ajouter-utilisateur input[type=text]
	{
		width: 250px;
	}
	#ajouter-utilisateur select
	{
		width: 500px;
	}
	/* LABEL */
	#ajouter-utilisateur label
	{
		display: block;
		width: 150px;
		float: left;
		line-height: 18px;
	}
	#ajouter-utilisateur label.ui-corner-all
	{
		width: 450px;
	}
	
	#ajouter-utilisateur label.error 
	{
		display: inline;
		float: none; 
		color: red; 
		padding-left: .5em; 
	}
-->
</style>

<h1 class="titre-gauche">Ajouter un utilisateur</h1>
<br style="clear:both;" />
<hr>

<form id="ajouter-utilisateur" method="post" action="<?php echo $baseUrl."utilisateurs/ajouter"; ?>">
	<p>
		<label for="prenom">Prénom: </label>
		<input class="required" type="text" id="prenom" name="prenom" value="" />
	</p>
	<p>
		<label for="nom">Nom: </label>
		<input class="required" type="text" id="nom" name="nom" value="" />
	</p>
	<p>
		<label for="code_as">Code AS: </label>
		<input type="text" id="code_as" name="code_as" value="" />
	</p>
	<p>
		<label for="samaccountname">Samaccountname: </label>
		<input class="required" type="text" id="samaccountname" name="samaccountname" value="" />
	</p>
	<p>
		<label for="slgs">SLGs: </label>
		<select id="slgs" name="id_slg[]" multiple="multiple">
			<?php foreach ($slgs as $slg): ?>
			<option value="<?php echo $slg->getId(); ?>"> <?php echo $slg->getService()->getNom(); ?> - <?php echo $slg->getLocalisation()->getNom(); ?> - <?php echo $slg->getGroupe()->getNom(); ?></option>
			<?php endforeach; ?>
		</select>
	</p>
	<br style="clear:both;" />
	
	<div style="text-align: center;">
		<p>
			<input style="width: 120px;" class="ajouter" type="submit" name="ajouter-utilisateur" value="Ajouter">
		</p>
	</div>
	
</form>
