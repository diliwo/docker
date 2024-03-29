<script type="text/javascript">
<!--
$(document).ready(function() {
	$("#modifier-service").validate();
});
//-->
</script>

<style>
<!--
	#modifier-service
	{
		width: 90%;
	}
	#modifier-service p
	{
		margin: 10px 5px 0 0;
	}
	/* FIELDSET */
	#modifier-service fieldset
	{
		width: 108%;
		padding: 10px 10px 5px 10px;
		border: #CCC 1px solid;
		margin: 20px 0 10px 0;
	}
	#modifier-service fieldset legend
	{
		padding: 0 10px;
		font-size: 1.2em;
		color: green;
	}
	
	#modifier-service input[type=checkbox]
	{
		padding: 5px 5px;
	}
	#modifier-service input[type=text]
	{
		width: 250px;
	}
	#modifier-service select
	{
		width: 250px;
	}
	/* LABEL */
	#modifier-service label
	{
		display: block;
		width: 150px;
		float: left;
		line-height: 18px;
	}
	
	#modifier-service label.error 
	{
		display: inline;
		float: none; 
		color: red; 
		padding-left: .5em; 
	}
-->
</style>

<h1 class="titre-gauche">Modifier un service</h1>
<br style="clear:both;" />
<hr>

<form id="modifier-service" method="post" action="<?php echo $baseUrl."services/modifier/".$service->getId(); ?>">
	<p>
		<label for="nom">Nom du service : </label>
		<input class="required" type="text" id="nom" name="nom" value="<?php echo $service->getNom();?>" />
	</p>
	<br style="clear:both;" />
	
	<div style="text-align: center;">
		<p>
			<input style="width: 120px;" class="modifier" type="submit" name="modifier-service" value="Modifier">
		</p>
	</div>
	
</form>
