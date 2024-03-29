<script type="text/javascript">
<!--
$(document).ready(function() {
	$("#ajouter-groupe").validate();
});
//-->
</script>

<style>
<!--
	#ajouter-groupe
	{
		width: 90%;
	}
	#ajouter-groupe p
	{
		margin: 10px 5px 0 0;
	}
	/* FIELDSET */
	#ajouter-groupe fieldset
	{
		width: 108%;
		padding: 10px 10px 5px 10px;
		border: #CCC 1px solid;
		margin: 20px 0 10px 0;
	}
	#ajouter-groupe fieldset legend
	{
		padding: 0 10px;
		font-size: 1.2em;
		color: green;
	}
	
	#ajouter-groupe input[type=checkbox]
	{
		padding: 5px 5px;
	}
	#ajouter-groupe input[type=text]
	{
		width: 250px;
	}
	#ajouter-groupe select
	{
		width: 250px;
	}
	/* LABEL */
	#ajouter-groupe label
	{
		display: block;
		width: 150px;
		float: left;
		line-height: 18px;
	}
	
	#ajouter-groupe label.error 
	{
		display: inline;
		float: none; 
		color: red; 
		padding-left: .5em; 
	}
-->
</style>

<h1 class="titre-gauche">Ajouter un groupe</h1>
<br style="clear:both;" />
<hr>

<form id="ajouter-groupe" method="post" action="<?php echo $baseUrl."groupes/ajouter"; ?>">
	<p>
		<label for="nom">Nom : </label>
		<input class="required" type="text" id="nom" name="nom" value="" />
	</p>
	<p>
		<label for="niveau">Niveau : </label>
		<input class="required" type="text" id="niveau" name="niveau" value="" />
	</p>
	<p>
		<label for="niveau">Système : </label>
		<input class="required" type="text" id="systeme" name="systeme" value="" />
	</p>
	<br style="clear:both;" />
	
	<div style="text-align: center;">
		<p>
			<input style="width: 120px;" class="ajouter" type="submit" name="ajouter-groupe" value="Ajouter">
		</p>
	</div>
	
</form>
