<div class="well" id="motivateDecision">
	<form method="POST" id="form-transaction25" class="form-horizontal" role="form">
		
		<div class="form-group">
			<label for="alertId" class="col-md-3">ID de l’alerte émise par le SPP-IS: </label>
			<div class="col-md-2">
				<input type="text" class="form-control" name="alertId" placeholder="LONG">
			</div>
			
			<span class="dhelp">?</span>
			<div class="doverlay">
				<h3 class="dheading">ID de l’alerte émise par le SPP-IS</h3>
				
				<ul>
					<li>1). 
						Suite à la réception d’une alerte, le CPAS communique sa 
						réponse au SPP-IS au travers d’un message XML au format SOAP.
						Ce message contiendra un numéro de dossier permettant au 
						SPP-IS de faire le lien entre la réponse du CPAS et l’alerte émise.
					</li>
					
					<li>2).  
						Aucun SSIN n’est transmis dans le message, le service de la BCSS 
						réalise donc seulement le transfert de la réponse au SPP-IS. 
					</li>
					
					<li>3).  
						Le SPP-IS communique son accord ou refus du motif soumis par le CPAS.
					</li>
					<li>4).  
						La BCSS transmet au CPAS la réponse du SPP-IS.
					</li>
				
				</ul>
    			Cet élément doit être unique sur l’ensemble des motivations. En cas de doublons, 
    			un message d’erreur (MSG00008) sera retourné au client.  
			</div> 
					
		</div>
		
		<div class="form-group">
			<label for="formNumber" class="col-md-3">Numéro du formulaire: </label>
			<div class="col-md-2">
				<input type="text" class="form-control" name="formNumber" placeholder="LONG">
			</div>
			
			<span class="dhelp">?</span>
			<div class="doverlay">
				<h3 class="dheading">Numéro du formulaire</h3>
    			The number  of the form concerned by the alert. This number is the SPP IS reference number (as given when the form was submitted)  
			</div> 
					
		</div>

		<div class="form-group">
			<label for="code" class="col-md-3">Codes de motivation: </label>
			<div class="col-md-2">
				<input type="text" class="form-control" name="code" placeholder="INTEGER">
			</div>	
				
			<span class="dhelp">?</span>
			<div class="doverlay">
				<h3 class="dheading">Codes de motivation</h3>
    			Code of the current motivation given by the PCSW/OCMW
			</div>
			
		</div>
	
		<div class="form-group">
			<label for="comment" class="col-md-3">Commentaire: </label>
			<div class="col-md-4">
				<textarea  class="form-control" name="comment" placeholder="COMMENT"> </textarea>
			</div>	
			
			<span class="dhelp">?</span>
			<div class="doverlay">
				<h3 class="dheading">Commentaire</h3>
    			Commentaire textuel pouvant être ajouté à la motivation 
			</div>
				
		</div>
				
		<div class="form-group">
			<div class="col-md-offset-2 col-md-3">
				<button type="submit" class="btn btn-primary">Tester</button>
				<button type="reset" class="btn btn-default">Annuler</button>
			</div>
		
		</div>
	</form>
</div>

<script type="text/javascript">

// ***motivateDecision*** //

// ************ //
//  Clignotants //
// ************ //

$("#motivateDecision form").validate({
	
	rules: { registre_national: {} },
	highlight: function(element) {},
	unhighlight: function(element) {}, 
	
	errorElement: "span",
	errorClass: "help-block",
	errorPlacement: function(error, element) {},
	
	submitHandler: function(form) {

		$("#wait").show();
		$("#motivateDecision .reponse").remove();

		var alertId = $("#motivateDecision form input[name=alertId]").val();
		var formNumber = $("#motivateDecision form input[name=formNumber]").val();
		var codeM =  $("#motivateDecision form input[name=code]").val();
		var comment =  $("#motivateDecision form textarea[name=comment]").val();
	
		var url = "<?php echo $_CONFIG['url']; ?>api/alert_reaction/consulter?env=<?php echo $_SESSION['test_flux_bcss']['env']; ?>";
			url += "&alertId=" + alertId + "&formNumber=" + formNumber + "&codeM=" + codeM+ "&comment=" + comment;
		
		var jqxhr = $.getJSON( url , function(json) {
 
			$("#responsejson").getResponsejson(json,'motivateDecision');
				
			var reponse = $("<fieldset />", { "html": "<legend>Réponse</legend>PAS DE DONNEES" });

			if(json.succes != 0 )  {  

				var val =  (json.data.status.hasOwnProperty('value')       ? json.data.status.value : "" );
				var code = (json.data.status.hasOwnProperty('code')        ? json.data.status.code : "" );
				var desc = (json.data.status.hasOwnProperty('description') ? json.data.status.description : "" );

				var data = (json.data.hasOwnProperty('motivationResponses') ? json.data.motivationResponses : "" );

				var statut = $("<fieldset />", {  "html": "<legend>Statut</legend>" + val +" (" + code + "): " + desc });

				if ( data ) { 
					reponse = $("<fieldset />", {  "html": "<legend>Réponse</legend>" });
					reponse.append( JsonHuman.format( data ) );
				}	

			}
				
			$("<div />", {
				"class": "reponse"
			}).insertAfter( $("#motivateDecision form") );
			$("#motivateDecision .reponse").append( statut );
			$("#motivateDecision .reponse").append( "<br />" );
			$("#motivateDecision .reponse").append( reponse );
		})
		.fail(function() {
		})
		.always(function(){
			$("#wait").hide();
		})
	}
});

</script>