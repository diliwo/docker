<script type="text/javascript">
<!--
$(document).ready(function() {
	$("#ajouter-localisation").validate();
});
//-->
</script>

<style>
<!--
	#ajouter-localisation
	{
		width: 90%;
	}
	#ajouter-localisation p
	{
		margin: 10px 5px 0 0;
	}
	/* FIELDSET */
	#ajouter-localisation fieldset
	{
		width: 108%;
		padding: 10px 10px 5px 10px;
		border: #CCC 1px solid;
		margin: 20px 0 10px 0;
	}
	#ajouter-localisation fieldset legend
	{
		padding: 0 10px;
		font-size: 1.2em;
		color: green;
	}
	
	#ajouter-localisation input[type=checkbox]
	{
		padding: 5px 5px;
	}
	#ajouter-localisation input[type=text]
	{
		width: 250px;
	}
	#ajouter-localisation select
	{
		width: 250px;
	}
	/* LABEL */
	#ajouter-localisation label
	{
		display: block;
		width: 150px;
		float: left;
		line-height: 18px;
	}
	
	#ajouter-localisation label.error 
	{
		display: inline;
		float: none; 
		color: red; 
		padding-left: .5em; 
	}
-->
</style>

<h1 class="titre-gauche">Ajouter une localisation</h1>
<br style="clear:both;" />
<hr>

<form id="ajouter-localisation" method="post" action="<?php echo $baseUrl."localisations/ajouter"; ?>">
	<p>
		<label for="nom">Nom de la localisation : </label>
		<input class="required" type="text" id="nom" name="nom" value="" />
	</p>
	<br style="clear:both;" />
	
	<div style="text-align: center;">
		<p>
			<input style="width: 120px;" class="ajouter" type="submit" name="ajouter-localisation" value="Ajouter">
		</p>
	</div>
	
</form>
