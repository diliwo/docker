<style type="text/css">
	<!--
	@IMPORT URL('includes/css/person.css');
	-->
</style>

<div id="search_person">
	<h1>Rechercher une personne</h1>
	
	<form action="index.php" method="get">
		<input type="hidden" name="env" value="<?php echo $_GET['env']; ?>" />
		<input type="hidden" name="page" value="<?php echo $_GET['page']; ?>" />
		<input type="hidden" name="action" value="display" />
		<p>
			<label for="rn">Numéro de registre national :</label><input type="text" id="rn" name="rn">
		</p>
		
		<p>
			<input style="width: 140px;" type="submit" class="search button" id="submit_search_person" value="Rechercher">
									</p>
	</form>
	<br style="clear: both;" />
</div>

<script type="text/javascript">
<!--
	$(document).ready(function() {
		$("#submit_search_person").attr("disabled", "disabled").css("color", "grey");
		$("#rn").change( function() {
			if (validateRn( $( this ).val() )) {
				$( this ).css("color", "green");
				$("#submit_search_person").removeAttr("disabled").css("color", "black");
			} else {
				$( this ).css("color", "red");
				$("#submit_search_person").attr("disabled", "disabled").css("color", "grey");
			}
		});
		$("#rn").keyup( function() {
			if (validateRn( $( this ).val() )) {
				$( this ).css("color", "green");
				$("#submit_search_person").removeAttr("disabled").css("color", "black");
			} else {
				$( this ).css("color", "red");
				$("#submit_search_person").attr("disabled", "disabled").css("color", "grey");
			}
		});
		$("#rn").keydown( function() {
			if (validateRn( $( this ).val() )) {
				$( this ).css("color", "green");
				$("#submit_search_person").removeAttr("disabled").css("color", "black");
			} else {
				$( this ).css("color", "red");
				$("#submit_search_person").attr("disabled", "disabled").css("color", "grey");
			}
		});
	});
//-->
</script>