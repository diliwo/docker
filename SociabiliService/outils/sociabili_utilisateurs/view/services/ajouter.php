<script type="text/javascript">
<!--
$(document).ready(function() {
	$("#ajouter-service").validate();
});
//-->
</script>

<style>
<!--
	#ajouter-service
	{
		width: 90%;
	}
	#ajouter-service p
	{
		margin: 10px 5px 0 0;
	}
	/* FIELDSET */
	#ajouter-service fieldset
	{
		width: 108%;
		padding: 10px 10px 5px 10px;
		border: #CCC 1px solid;
		margin: 20px 0 10px 0;
	}
	#ajouter-service fieldset legend
	{
		padding: 0 10px;
		font-size: 1.2em;
		color: green;
	}
	
	#ajouter-service input[type=checkbox]
	{
		padding: 5px 5px;
	}
	#ajouter-service input[type=text]
	{
		width: 250px;
	}
	#ajouter-service select
	{
		width: 250px;
	}
	/* LABEL */
	#ajouter-service label
	{
		display: block;
		width: 150px;
		float: left;
		line-height: 18px;
	}
	
	#ajouter-service label.error 
	{
		display: inline;
		float: none; 
		color: red; 
		padding-left: .5em; 
	}
-->
</style>

<h1 class="titre-gauche">Ajouter un service</h1>
<br style="clear:both;" />
<hr>

<form id="ajouter-service" method="post" action="<?php echo $baseUrl."services/ajouter"; ?>">
	<p>
		<label for="nom">Nom du service : </label>
		<input class="required" type="text" id="nom" name="nom" value="" />
	</p>
	<br style="clear:both;" />
	
	<div style="text-align: center;">
		<p>
			<input style="width: 120px;" class="ajouter" type="submit" name="ajouter-service" value="Ajouter">
		</p>
	</div>
	
</form>
