<style type="text/css">
	<!--
	@IMPORT URL('includes/css/authentication.css');
	-->
</style>

<div id="authentication">
	<h1>Connexion à l'application</h1>
	
	<form action="index.php?env=public&page=authentication&action=login" method="post">
		<p>
			<label style="text-align: left;" for="username">Nom d'utilisateur : </label>
			<input class="focus" type="text" id="username" name="username" value="" />
		</p>
		
		<p>
			<label style="text-align: left;" for="password">Mot de Passe : </label>
			<input type="password" id="password" name="password" value="" />
		</p>
		
		<p>
			<input style="width: 120px;" class="connection button" type="submit" value="Connexion" />
		</p>
	</form>
	<br style="clear: both;" />
</div>

<?php echo (!empty($error))?'<p class="error">'.$error.'</p>':''; ?>

<script type="text/javascript">
	document.getElementsByName("username")[0].focus();
</script>
