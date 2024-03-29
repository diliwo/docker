 <div class="well" id="cadnet">
	<form method="POST" id="form-cadnet" class="form-horizontal" role="form">
		<div class="form-group has-feedback">
			<label for="registre_national" class="col-md-2 control-label">Registre national: </label>
			<div class="col-md-3">
				<input type="text" class="form-control" name="registre_national">
				<span class="glyphicon glyphicon-pencil form-control-feedback"></span>
			</div>
		</div>

		<div class="form-group">
				<label for="nature_personne" class="col-md-2 control-label">Nature personne: </label>
				<div class="col-md-3">
					<select class="form-control" name="nature_personne">
						<option value="1">Demandeur</option>
						<option value="2">Cohabitant</option>
						<option value="3">Débiteur alimentaire</option>
					</select>
				</div>
		</div>

		<div class="form-group">
				<label for="langue" class="col-md-2 control-label">Langue: </label>
				<div class="col-md-2">
					<select class="form-control" name="langue">
						<option value="fr">Français</option>
						<option value="nl">Néerlandais</option>
					</select>
				</div>
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
<!--
// ***findProperties*** //

//******//
//cadnet//
//******//
$("#cadnet form button[type=reset]").on( "click", function() {
	$("#cadnet form input[name=registre_national]").closest(".has-feedback").find(".glyphicon").removeClass("glyphicon-ok glyphicon-remove").addClass("glyphicon-pencil");
	$("#cadnet form input[name=registre_national]").closest(".has-feedback").removeClass("has-success has-error");
	$(".help-block").remove();
	$("#cadnet .reponse").remove();
});

$("#cadnet form").validate({
	rules: {
		registre_national: {
			minlength: 11,
			maxlength: 11,
			required: true
		}
	},
	highlight: function(element) {
		if (RegistreNational.valider( $(element).val())) {
			$(element).closest(".has-feedback").find(".glyphicon").removeClass("glyphicon-pencil glyphicon-remove").addClass("glyphicon-ok");
			$(element).closest(".has-feedback").removeClass("has-error").addClass("has-success");
		} else {

			$(element).closest(".has-feedback").find(".glyphicon").removeClass("glyphicon-pencil glyphicon-ok").addClass("glyphicon-remove");
			$(element).closest(".has-feedback").removeClass("has-success").addClass("has-error");
		}
	},
	unhighlight: function(element) {
		if (RegistreNational.valider( $(element).val())) {
		$(element).closest(".has-feedback").find(".glyphicon").removeClass("glyphicon-pencil glyphicon-remove").addClass("glyphicon-ok");
		$(element).closest(".has-feedback").removeClass("has-error").addClass("has-success");
	} else {

		$(element).closest(".has-feedback").find(".glyphicon").removeClass("glyphicon-pencil glyphicon-ok").addClass("glyphicon-remove");
		$(element).closest(".has-feedback").removeClass("has-success").addClass("has-error");
	}
	},
	errorElement: "span",
	errorClass: "help-block",
	errorPlacement: function(error, element) {
		if(element.parent(".input-group").length) {
			error.insertAfter(element.parent());
		} else {
			error.insertAfter(element);
		}
	},
	submitHandler: function(form) {
		$("#wait").show();
		$("#cadnet .reponse").remove();

		var rn = $("#cadnet form input[name=registre_national]").val();
		var nature_personne = $("#cadnet form select[name=nature_personne]").val();
		var langue = $("#cadnet form select[name=langue]").val();
		
		if (RegistreNational.valider( rn )) {
			var url = "<?php echo $_CONFIG['url']; ?>api/cadnet/consulter?env=<?php echo $_SESSION['test_flux_bcss']['env']; ?>&registre_national=" + rn + "&langue=" + langue + "&nature_personne=" + nature_personne;
			var jqxhr = $.getJSON( url , function(json) {

				$("#responsejson").getResponsejson(json,'findProperties');
				
				var reponse = $("<fieldset />", { "html": "<legend>Réponse</legend>PAS DE DONNEES" });

				if(json.succes != 0 )  {
					
					var val =  (json.data.status.hasOwnProperty('value')       ? json.data.status.value : "" );
					var code = (json.data.status.hasOwnProperty('code')        ? json.data.status.code : "" );
					var desc = (json.data.status.hasOwnProperty('description') ? json.data.status.description : "" );
					
					var data = (json.data.hasOwnProperty('businessData') ? json.data.businessData : "" );
					
					var statut = $("<fieldset />", {  "html": "<legend>Statut</legend>" + val +" (" + code + "): " + desc });
	 
					if ( data ) { 
						reponse = $("<fieldset />", {  "html": "<legend>Réponse</legend>" });
						reponse.append( JsonHuman.format( data ) );
					}
					  
				}
				
				$("<div />", { 
					"class": "reponse"
				}).insertAfter( $("#cadnet form") );
				$("#cadnet .reponse").append( statut );
				$("#cadnet .reponse").append( "<br />" );
				$("#cadnet .reponse").append( reponse );

			})
			.fail(function() {
			})
			.always(function(){
				$("#wait").hide();
			})
		}
	}
});

// -->
</script>