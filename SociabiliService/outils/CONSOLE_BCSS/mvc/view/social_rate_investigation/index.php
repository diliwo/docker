<div class="well" id="social_rate_investigation">
	<form method="POST" id="form-social_rate_investigation" class="form-horizontal" role="form">
		<div class="form-group has-feedback">
			<label for="registre_national" class="col-md-2 control-label">Registre national :</label>
			<div class="col-md-3">
				<input type="text" class="form-control" name="registre_national">
				<span class="glyphicon glyphicon-pencil form-control-feedback"></span>
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
$("#social_rate_investigation form").validate({
	rules: {
		registre_national: {
			minlength: 11,
			maxlength: 11,
			required: true
		}
	},
	highlight: function(element) {
		if ( $(element).attr("name") == "registre_national") {
			if (RegistreNational.valider( $(element).val())) {
				$(element).closest(".has-feedback").find(".glyphicon").removeClass("glyphicon-pencil glyphicon-remove").addClass("glyphicon-ok");
				$(element).closest(".has-feedback").removeClass("has-error").addClass("has-success");
			} else {

				$(element).closest(".has-feedback").find(".glyphicon").removeClass("glyphicon-pencil glyphicon-ok").addClass("glyphicon-remove");
				$(element).closest(".has-feedback").removeClass("has-success").addClass("has-error");
			}
		} else {
			$(element).closest('.form-group').addClass('has-error');
		}
	},
	unhighlight: function(element) {
		if ( $(element).attr("name") == "registre_national") {
			if (RegistreNational.valider( $(element).val())) {
				$(element).closest(".has-feedback").find(".glyphicon").removeClass("glyphicon-pencil glyphicon-remove").addClass("glyphicon-ok");
				$(element).closest(".has-feedback").removeClass("has-error").addClass("has-success");
			} else {

				$(element).closest(".has-feedback").find(".glyphicon").removeClass("glyphicon-pencil glyphicon-ok").addClass("glyphicon-remove");
				$(element).closest(".has-feedback").removeClass("has-success").addClass("has-error");
			}
		} else {
			$(element).closest('.form-group').removeClass('has-error');
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
		$("#social_rate_investigation .reponse").remove();

		var rn = $("#social_rate_investigation form input[name=registre_national]").val();

		if (RegistreNational.valider( rn )) {
			var url = "<?php echo $_CONFIG['url']; ?>api/social_rate_investigation/consulter?env=<?php echo $_SESSION['test_flux_bcss']['env']; ?>&registre_national=" + rn;

			var jqxhr = $.getJSON( url , function(json) { 
				
				$("#responsejson").getResponsejson(json,'socialRateInvestigation');
			
				var reponse = $("<fieldset />", { "html": "<legend>Réponse</legend>PAS DE DONNEES" });

				if(json.succes != 0 )  {  

					var val =  (json.data.status.hasOwnProperty('value')       ? json.data.status.value : "" );
					var code = (json.data.status.hasOwnProperty('code')        ? json.data.status.code : "" );
					var desc = (json.data.status.hasOwnProperty('description') ? json.data.status.description : "" );

					var data = (json.data.hasOwnProperty('result') ? json.data.result : "" );

					var statut = $("<fieldset />", {  "html": "<legend>Statut</legend>" + val +" (" + code + "): " + desc });

					if ( data ) { 
						reponse = $("<fieldset />", {  "html": "<legend>Réponse</legend>" });
						reponse.append( JsonHuman.format( data ) );
					}	

				}

				$("<div />", { 
					"class": "reponse"
				}).insertAfter( $("#social_rate_investigation form") );
				$("#social_rate_investigation .reponse").append( statut );
				$("#social_rate_investigation .reponse").append( "<br />" );
				$("#social_rate_investigation .reponse").append( reponse );

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