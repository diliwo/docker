<script type="text/javascript">
<!--
$(document).ready(function() {
	$("#ajouter-slg").validate();
});
//-->
</script>

<style>
<!--
	#ajouter-slg
	{
		width: 90%;
	}
	#ajouter-slg p
	{
		margin: 10px 5px 0 0;
	}
	/* FIELDSET */
	#ajouter-slg fieldset
	{
		width: 108%;
		padding: 10px 10px 5px 10px;
		border: #CCC 1px solid;
		margin: 20px 0 10px 0;
	}
	#ajouter-slg fieldset legend
	{
		padding: 0 10px;
		font-size: 1.2em;
		color: green;
	}
	
	#ajouter-slg input[type=checkbox]
	{
		padding: 5px 5px;
	}
	#ajouter-slg input[type=text]
	{
		width: 250px;
	}
	#ajouter-slg select
	{
		width: 250px;
	}
	/* LABEL */
	#ajouter-slg label
	{
		display: block;
		width: 150px;
		float: left;
		line-height: 18px;
	}
	
	#ajouter-slg label.error 
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

<form id="ajouter-slg" method="post" action="<?php echo $baseUrl."services_localisations_groupes/ajouter"; ?>">
	<p>
		<label for="service">Service : </label>
		<select id="service" name="id_service">
			<?php foreach ($services as $service): ?>
			<option value="<?php echo $service->getId(); ?>"><?php echo $service->getNom(); ?></option>
			<?php endforeach; ?>
		</select>
	</p>
	<p>
		<label for="localisation">Localisation : </label>
		<select id="localisation" name="id_localisation">
			<?php foreach ($localisations as $localisation): ?>
			<option value="<?php echo $localisation->getId(); ?>"><?php echo $localisation->getNom(); ?></option>
			<?php endforeach; ?>
		</select>
	</p>
	<p>
		<label for="groupe">Groupe : </label>
		<select id="groupe" name="id_groupe">
			<?php foreach ($groupes as $groupe): ?>
			<option value="<?php echo $groupe->getId(); ?>"><?php echo $groupe->getNom(); ?></option>
			<?php endforeach; ?>
		</select>
	</p>
	<br style="clear:both;" />
	
	<div style="text-align: center;">
		<p>
			<input style="width: 120px;" class="ajouter" type="submit" name="ajouter-slg" value="Ajouter">
		</p>
	</div>
	
</form>
