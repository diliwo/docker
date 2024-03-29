<script type="text/javascript">
<!--
$(document).ready(function() {
	$("#modifier-slg").validate();
});
//-->
</script>

<style>
<!--
	#modifier-slg
	{
		width: 90%;
	}
	#modifier-slg p
	{
		margin: 10px 5px 0 0;
	}
	/* FIELDSET */
	#modifier-slg fieldset
	{
		width: 108%;
		padding: 10px 10px 5px 10px;
		border: #CCC 1px solid;
		margin: 20px 0 10px 0;
	}
	#modifier-slg fieldset legend
	{
		padding: 0 10px;
		font-size: 1.2em;
		color: green;
	}
	
	#modifier-slg input[type=checkbox]
	{
		padding: 5px 5px;
	}
	#modifier-slg input[type=text]
	{
		width: 250px;
	}
	#modifier-slg select
	{
		width: 250px;
	}
	/* LABEL */
	#modifier-slg label
	{
		display: block;
		width: 150px;
		float: left;
		line-height: 18px;
	}
	
	#modifier-slg label.error 
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

<form id="modifier-slg" method="post" action="<?php echo $baseUrl."services_localisations_groupes/modifier/".$slg->getId(); ?>">
	<p>
		<label for="service">Service : </label>
		<select id="service" name="id_service">
			<?php foreach ($services as $service): ?>
			<option value="<?php echo $service->getId(); ?>"<?php echo ($service->getId() == $slg->getService()->getId())?" selected='selected'":""; ?>><?php echo $service->getNom(); ?></option>
			<?php endforeach; ?>
		</select>
	</p>
	<p>
		<label for="localisation">Localisation : </label>
		<select id="localisation" name="id_localisation">
			<?php foreach ($localisations as $localisation): ?>
			<option value="<?php echo $localisation->getId(); ?>"<?php echo ($localisation->getId() == $slg->getLocalisation()->getId())?" selected='selected'":""; ?>><?php echo $localisation->getNom(); ?></option>
			<?php endforeach; ?>
		</select>
	</p>
	<p>
		<label for="groupe">Groupe : </label>
		<select id="groupe" name="id_groupe">
			<?php foreach ($groupes as $groupe): ?>
			<option value="<?php echo $groupe->getId(); ?>"<?php echo ($groupe->getId() == $slg->getGroupe()->getId())?" selected='selected'":""; ?>><?php echo $groupe->getNom(); ?></option>
			<?php endforeach; ?>
		</select>
	</p>
	<br style="clear:both;" />
	
	<div style="text-align: center;">
		<p>
			<input style="width: 120px;" class="modifier" type="submit" name="modifier-slg" value="Modifier">
		</p>
	</div>
	
</form>
