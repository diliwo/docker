<script type="text/javascript">
<!--
	$(document).ready(function() {
		$('#env').change(function() {
			$.ajax({
				url: "<?php echo $baseUrl; ?>environnement.php",
                cache: false,
                type: "POST",
                data: {
                    env: $("#env option:selected").val()
                },
                success: function () {
                	 location.reload();
                },
                error: function() {
                	alert("Impossible de modifier l'environnement");
                }
			});
		});
	} );
	
//-->
</script>

<div id="menu">
	<ul>
		<li>
			<a class="bouton-mauve" href="<?php echo $baseUrl."utilisateurs"; ?>">Utilisateur</a>
			
			<ul>
				<li><a class="bouton-mauve" href="<?php echo $baseUrl."utilisateurs/ajouter"; ?>">Ajouter</a></li>
				<li><a class="bouton-mauve" href="<?php echo $baseUrl."utilisateurs/importer"; ?>">Importer</a></li>
				<li><a class="bouton-mauve" href="<?php echo $baseUrl."utilisateurs/exporter"; ?>">Exporter</a></li>
			</ul>
		</li>
		<li>
			<a class="bouton-vert" href="<?php echo $baseUrl."localisations"; ?>">Localisations</a>
			
			<ul>
				<li><a class="bouton-vert" href="<?php echo $baseUrl."localisations/ajouter"; ?>">Ajouter</a></li>
			</ul>
		</li>
		<li>
			<a class="bouton-rouge" href="<?php echo $baseUrl."groupes"; ?>">Groupes</a>
			
			<ul>
				<li><a class="bouton-rouge" href="<?php echo $baseUrl."groupes/ajouter"; ?>">Ajouter</a></li>
			</ul>
		</li>
		<li>
			<a class="bouton-orange" href="<?php echo $baseUrl."services"; ?>">Services</a>
			
			<ul>
				<li><a class="bouton-orange" href="<?php echo $baseUrl."services/ajouter"; ?>">Ajouter</a></li>
			</ul>
		</li>
		<li>
			<a class="bouton-bleu" href="<?php echo $baseUrl."services_localisations_groupes"; ?>">SLGs</a>
			
			<ul>
				<li><a class="bouton-bleu" href="<?php echo $baseUrl."services_localisations_groupes/ajouter"; ?>">Ajouter</a></li>
			</ul>
		</li>
		
		<li class="deconnexion"><a class="bouton-jaune" href="<?php echo $baseUrl; ?>authentification/deconnexion">Déconnexion</a></li>
	</ul>
</div>
<p style="height: 40px;"></p>

<div id="contenu">
	<h2 class="titre-gauche">
		<label for="env">Environnement: </label>
		<select id="env" name="env" style="width: 200px;">
			<option<?php echo ($_SESSION['env']=='aux1030')?" selected='selected'":""; ?> value="aux1030">Applications Auxilliaires</option>
			<option<?php echo ($_SESSION['env']=='mig1030')?" selected='selected'":""; ?> value="mig1030">Migration 1030</option>
			<option<?php echo ($_SESSION['env']=='mig7000')?" selected='selected'":""; ?> value="mig7000">Migration 7000</option>
			<option<?php echo ($_SESSION['env']=='nef1030')?" selected='selected'":""; ?> value="nef1030">Notifications et formulaires</option>
			
		</select>
	</h2>	
	<h2 class="titre-droite" style="font-size: 20px;"> TNS : <?php echo $tn; ?> - TABLESPACE : <?php echo $login; ?></h2>
	<br style="clear: both;"  />
