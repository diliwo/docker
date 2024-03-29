<script type="text/javascript">
<!--
$(document).ready(function() {
	$("#modifier-localisation").validate();
});
//-->
</script>

<style>
<!--
	#modifier-localisation
	{
		width: 90%;
	}
	#modifier-localisation p
	{
		margin: 10px 5px 0 0;
	}
	/* FIELDSET */
	#modifier-localisation fieldset
	{
		width: 108%;
		padding: 10px 10px 5px 10px;
		border: #CCC 1px solid;
		margin: 20px 0 10px 0;
	}
	#modifier-localisation fieldset legend
	{
		padding: 0 10px;
		font-size: 1.2em;
		color: green;
	}
	
	#modifier-localisation input[type=checkbox]
	{
		padding: 5px 5px;
	}
	#modifier-localisation input[type=text]
	{
		width: 250px;
	}
	#modifier-localisation select
	{
		width: 250px;
	}
	/* LABEL */
	#modifier-localisation label
	{
		display: block;
		width: 150px;
		float: left;
		line-height: 18px;
	}
	
	#modifier-localisation label.error 
	{
		display: inline;
		float: none; 
		color: red; 
		padding-left: .5em; 
	}
-->
</style>

<h1 class="titre-gauche">Modifier une localisation</h1>
<br style="clear:both;" />
<hr>

<form id="modifier-localisation" method="post" action="<?php echo $baseUrl."localisations/modifier/".$localisation->getId(); ?>">
	<p>
		<label for="nom">Nom de la localisation : </label>
		<input class="required" type="text" id="nom" name="nom" value="<?php echo $localisation->getNom(); ?>" />
	</p>
	<br style="clear:both;" />
	
	<div style="text-align: center;">
		<p>
			<input style="width: 120px;" class="modifier" type="submit" name="modifier-localisation" value="Modifier">
		</p>
	</div>
	
</form>
