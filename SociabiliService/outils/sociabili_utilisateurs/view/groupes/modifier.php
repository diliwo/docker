<script type="text/javascript">
<!--
$(document).ready(function() {
	$("#modifier-groupe").validate();
});
//-->
</script>

<style>
<!--
	#modifier-groupe
	{
		width: 90%;
	}
	#modifier-groupe p
	{
		margin: 10px 5px 0 0;
	}
	/* FIELDSET */
	#modifier-groupe fieldset
	{
		width: 108%;
		padding: 10px 10px 5px 10px;
		border: #CCC 1px solid;
		margin: 20px 0 10px 0;
	}
	#modifier-groupe fieldset legend
	{
		padding: 0 10px;
		font-size: 1.2em;
		color: green;
	}
	
	#modifier-groupe input[type=checkbox]
	{
		padding: 5px 5px;
	}
	#modifier-groupe input[type=text]
	{
		width: 250px;
	}
	#modifier-groupe select
	{
		width: 250px;
	}
	/* LABEL */
	#modifier-groupe label
	{
		display: block;
		width: 150px;
		float: left;
		line-height: 18px;
	}
	
	#modifier-groupe label.error 
	{
		display: inline;
		float: none; 
		color: red; 
		padding-left: .5em; 
	}
-->
</style>

<h1 class="titre-gauche">Modifier un groupe</h1>
<br style="clear:both;" />
<hr>

<form id="modifier-groupe" method="post" action="<?php echo $baseUrl."groupes/modifier/".$groupe->getId(); ?>">
	<p>
		<label for="nom">Nom : </label>
		<input class="required" type="text" id="nom" name="nom" value="<?php echo $groupe->getNom(); ?>" />
	</p>
	<p>
		<label for="niveau">Niveau : </label>
		<input class="required" type="text" id="niveau" name="niveau" value="<?php echo $groupe->getNiveau(); ?>" />
	</p>
	<p>
		<label for="niveau">Système : </label>
		<input class="required" type="text" id="systeme" name="systeme" value="<?php echo $groupe->getSysteme(); ?>" />
	</p>
	<br style="clear:both;" />
	
	<div style="text-align: center;">
		<p>
			<input style="width: 120px;" class="modifier" type="submit" name="modifier-groupe" value="Modifier">
		</p>
	</div>
	
</form>
