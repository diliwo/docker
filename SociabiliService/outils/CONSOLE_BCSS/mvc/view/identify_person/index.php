<div class="well" id="identify_person">
	<form method="POST" id="form-identify_person" class="form-horizontal" role="form">
		<div class="form-group has-feedback">
			<label for="registre_national" class="col-md-2 control-label">Registre national: </label>
			<div class="col-md-3">
				<input type="text" class="form-control" name="registre_national">
				<span class="glyphicon glyphicon-pencil form-control-feedback"></span>
			</div>
		</div>

		<div class="form-group">
			<div class="col-md-offset-2 col-md-3">
				<button type="submit" class="btn btn-primary" data-loading-text="Chargement...">Tester</button>
				<button type="reset" class="btn btn-default">Annuler</button>
			</div>
		</div>
	</form>
</div>

<script type="text/javascript">
<!--

$("#identify_person form button[type=reset]").on( "click", function() {
	$("#identify_person form input[name=registre_national]").closest(".has-feedback").find(".glyphicon").removeClass("glyphicon-ok glyphicon-remove").addClass("glyphicon-pencil");
	$("#identify_person form input[name=registre_national]").closest(".has-feedback").removeClass("has-success has-error");
	$(".help-block").remove();
	$("#identify_person .reponse").remove();
});

$("#identify_person form").validate({
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
		$("#identify_person .reponse").remove();

		var rn = $("#identify_person form input[name=registre_national]").val();
		if (RegistreNational.valider( rn )) {
			var url = "<?php echo $_CONFIG['url']; ?>api/identify_person/consulter?env=<?php echo $_SESSION['test_flux_bcss']['env']; ?>&registre_national=" + rn;
			var jqxhr = $.getJSON( url , function(json) {

				$("#responsejson").getResponsejson(json,'identify_person');
			
				var reponse = $("<fieldset />", { "html": "<legend>Réponse</legend>PAS DE DONNEES" });

				if(json.succes != 0 )  {
				
					var val =  (json.data.status.hasOwnProperty('value')       ? json.data.status.value : "" );
					var code = (json.data.status.hasOwnProperty('code')        ? json.data.status.code : "" );
					var desc = (json.data.status.hasOwnProperty('description') ? json.data.status.description : "" );
				
					var data = (json.data.hasOwnProperty('person') ? json.data.person : "" );
				
					var statut = $("<fieldset />", {  "html": "<legend>Statut</legend>" + val +" (" + code + "): " + desc });
 
					if ( data ) { 
						reponse = $("<fieldset />", {  "html": "<legend>Réponse</legend>" });
						reponse.append( JsonHuman.format( data ) );
					}
					  
				}

				$("<div />", { 
					"class": "reponse"
				}).insertAfter( $("#identify_person form") );
				$("#identify_person .reponse").append( statut );
				$("#identify_person .reponse").append( "<br />" );
				$("#identify_person .reponse").append( reponse );

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