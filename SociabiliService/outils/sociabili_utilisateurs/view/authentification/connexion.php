
<div id="authentification">

	<h1>Connexion à l'application</h1>
	
	<form action="<?php echo $baseUrl.'authentification/connexion'; ?><?php echo (isset($_GET['id']))?'/'.$_GET['id']:''; ?>" method="post">
		<p>
			<label for="username">Nom d'utilisateur : </label>
			<input class="focus" type="text" id="username" name="username" value="" />
		</p>
		
		<p>
			<label for="password">Mot de passe : </label>
			<input type="password" id="password" name="password" value="" />
		</p>
		
		<p>
			<label for="env">Environnement : </label>
			<select id="env" name="env" style="width: 200px;">
				
	                        <option<?php echo ($_SESSION['env']=='aux1030')?" selected='selected'":""; ?> value="aux1030">Applications Auxilliaires</option>
	         	    	<option<?php echo ($_SESSION['env']=='mig1030')?" selected='selected'":""; ?> value="mig1030">Migration 1030</option>
			        <option<?php echo ($_SESSION['env']=='mig1080')?" selected='selected'":""; ?> value="mig1080">Migration 1080</option>
			        <option<?php echo ($_SESSION['env']=='nef1030')?" selected='selected'":""; ?> value="nef1030">Notifications et formulaires</option>						</select>
		</p>
		
		<div style="text-align: center;">
			<p>
				<input style="width: 120px;" class="connexion" type="submit" value="Connexion" />
			</p>
		</div>
	</form>
	<br style="clear: both;" />
</div>

<?php echo (!empty($erreur))?'<p class="erreur">'.$erreur.'</p>':''; ?>

<script type="text/javascript">
	document.getElementsByName("login")[0].focus();
</script>
