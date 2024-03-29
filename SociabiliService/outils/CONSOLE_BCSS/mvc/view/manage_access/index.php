<div class="well" id="integrations">
	<form id="form-integrer" class="form-horizontal" role="form">
		<fieldset>
			<legend>Individu</legend>

			<div class="form-group has-feedback">
				<label for="registre_national" class="col-md-2 control-label">Registre national: </label>
				<div class="col-md-3">
					<input type="text" class="form-control" name="registre_national">
					<span class="glyphicon glyphicon-pencil form-control-feedback"></span>
				</div>

				<button type="button" class="btn btn-danger" id="identify_person" disabled>
					<span class="glyphicon glyphicon-search"></span> Recherche
				</button>
			</div>

			<div class="form-group has-feedback">
				<label for="nom_famille" class="col-md-2 control-label">Nom de famille: </label>
				<div class="col-md-3">
					<input type="text" class="form-control" name="nom_famille" style="text-transform: uppercase;">
				</div>
			</div>

			<div class="form-group has-feedback">
				<label for="date_naissance" class="col-md-2 control-label">Date de naissance: </label>
				<div class="col-md-2">
					<label class="sr-only" for="date">YYYY-MM-DD</label>
					<input type="text" class="form-control" name="date_naissance" placeholder="YYYY-MM-DD">
				</div>
			</div>

			<div class="form-group has-feedback">
				<div class="btn-group col-md-offset-2" data-toggle="buttons">
					<label class="btn btn-primary active">
						<input type="radio" name="option_integration" value="0" checked> <span class="glyphicon glyphicon-th-list"></span> Lister
					</label>

					<label class="btn btn-primary">
						<input type="radio" name="option_integration" value="1"> <span class="glyphicon glyphicon-plus"></span> Ajouter
					</label>

					<label class="btn btn-primary">
						<input type="radio" name="option_integration" value="2"> <span class="glyphicon glyphicon-minus"></span> Supprimer
					</label>

				</div>

			</div>

		</fieldset>

		<fieldset>
			<legend>Code et période</legend>

			<div class="form-group">
				<label for="code_qualite" class="col-md-2 control-label">Code qualité: </label>
				<div class="col-md-3">
					<select class="form-control" name="code_qualite">
						<option value="1">Dossier en cours</option>
						<option value="2">Minimex ou RI</option>
						<option value="3">Equivalent Minimex ou RI</option>
						<option value="4">Autre aide</option>
						<option value="5">SDF ou sans aide</option>
						<option value="6">Article 60</option>
						<option value="40">Fond mazout</option>
					</select>
				</div>
			</div>

			<div class="form-group">
				<label for="periode" class="col-md-2 control-label">Période: </label>
				<div class="col-md-4">
					<div class="input-group" id="periode">
						<span class="input-group-addon">du</span>
						<input type="text" class="form-control" name="date_debut" placeholder="YYYY-MM-DD">
						<span class="input-group-addon">au</span>
						<input type="text" class="form-control" name="date_fin" placeholder="YYYY-MM-DD">
					</div>
				</div>
			</div>

		</fieldset>

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

// ************ //
// integrations //
// ************ //
$("#form-integrer input[name=date_naissance]").datepicker({
	format: "yyyy-mm-dd",
	language: "fr",
	orientation: "top left",
	autoclose: true,
	todayHighlight: true,
	endDate: "today"
});

$("#identify_person").on("click", function(){
	var registre_national = $("#form-integrer input[name=registre_national]").val();
	var url = "<?php echo $_CONFIG['url']; ?>api/identify_person/consulter?env=<?php echo $_SESSION['test_flux_bcss']['env']; ?>&registre_national=" + registre_national;
	var jqxhr = $.getJSON( url , function(json) {
		if (json.succes == 1) {
			$("#form-integrer input[name=nom_famille]").val( json.data.person.name );
			$("#form-integrer input[name=date_naissance]").val( json.data.person.birthdate );

		}
	});

});

$("#form-integrer input[name=date_debut], #form-integrer input[name=date_fin]").datepicker({
	format: "yyyy-mm-dd",
	language: "fr",
	orientation: "top left",
	autoclose: true,
	todayHighlight: true
}).on("change", function() {
	var date_debut = $("#form-integrer input[name=date_debut]");
	var date_fin = $("#form-integrer input[name=date_fin]");

	date_fin.datepicker("setStartDate", date_debut.val());
	date_debut.datepicker("setEndDate", date_fin.val());
});
$("#form-integrer button[type=reset]").on( "click", function() {
	$("#identify_person").prop('disabled', true);
	$("#form-integrer input").closest(".has-feedback").find(".form-control-feedback").removeClass("glyphicon-ok glyphicon-remove").addClass("glyphicon-pencil");
	$("#form-integrer input").closest(".has-feedback").removeClass("has-success has-error");
	$(".help-block").remove();
	$("#integrations .reponse").remove();
});
$("#form-integrer").validate({
	rules: {
		registre_national: {
			minlength: 11,
			maxlength: 11,
			required: true
		},
		nom_famille: {
			minlength: 1,
			required: true
		},
		date_naissance: {
			minlength: 1,
			required: true
		}
	},
	highlight: function(element) {
		if ( $(element).attr("name") == "registre_national") {
			if (RegistreNational.valider( $(element).val())) {
				$("#identify_person").prop('disabled', false);
				$(element).closest(".has-feedback").find(".form-control-feedback").removeClass("glyphicon-pencil glyphicon-remove").addClass("glyphicon-ok");
				$(element).closest(".has-feedback").removeClass("has-error").addClass("has-success");
			} else {
				$("#identify_person").prop('disabled', true);
				$(element).closest(".has-feedback").find(".form-control-feedback").removeClass("glyphicon-pencil glyphicon-ok").addClass("glyphicon-remove");
				$(element).closest(".has-feedback").removeClass("has-success").addClass("has-error");
			}
		} else {
			$(element).closest('.form-group').addClass('has-error');
		}
	},
	unhighlight: function(element) {
		if ( $(element).attr("name") == "registre_national") {
			if (RegistreNational.valider( $(element).val())) {
				$("#identify_person").prop('disabled', false);
				$(element).closest(".has-feedback").find(".form-control-feedback").removeClass("glyphicon-pencil glyphicon-remove").addClass("glyphicon-ok");
				$(element).closest(".has-feedback").removeClass("has-error").addClass("has-success");
			} else {
				$("#identify_person").prop('disabled', true);
				$(element).closest(".has-feedback").find(".form-control-feedback").removeClass("glyphicon-pencil glyphicon-ok").addClass("glyphicon-remove");
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
		$("#integrations .reponse").remove();
		
		var code_qualite = $("#form-integrer select[name=code_qualite]").val();
		var date_debut = $("#form-integrer input[name=date_debut]").val();
		var date_fin = $("#form-integrer input[name=date_fin]").val();
		var registre_national = $("#form-integrer input[name=registre_national]").val();
		var nom_famille = $("#form-integrer input[name=nom_famille]").val();
		var date_naissance = $("#form-integrer input[name=date_naissance]").val();
		var option_integration = $("#form-integrer input[name=option_integration]:checked").val();

		if (RegistreNational.valider( registre_national )) {
			var url = "";
			if (option_integration == 1) {
				url = "<?php echo $_CONFIG['url']; ?>api/manage_access/integrer?env=<?php echo $_SESSION['test_flux_bcss']['env']; ?>&registre_national=" + registre_national + "&nom_famille=" + nom_famille + "&date_naissance=" + date_naissance  + "&code_qualite=" + code_qualite;
				
			} else if (option_integration == 2) {
				url = "<?php echo $_CONFIG['url']; ?>api/manage_access/desintegrer?env=<?php echo $_SESSION['test_flux_bcss']['env']; ?>&registre_national=" + registre_national + "&nom_famille=" + nom_famille + "&date_naissance=" + date_naissance  + "&code_qualite=" + code_qualite;
				
			} else {
				url = "<?php echo $_CONFIG['url']; ?>api/manage_access/consulter?env=<?php echo $_SESSION['test_flux_bcss']['env']; ?>&registre_national=" + registre_national + "&nom_famille=" + nom_famille + "&date_naissance=" + date_naissance  + "&code_qualite=" + code_qualite;

			}

			if (date_debut != "") {
				url += "&date_debut=" + date_debut;
				if (date_fin != "") {
					url += "&date_fin=" + date_fin;
				}
			}

			var jqxhr = $.getJSON( url , function(json) {
				
				$("#responsejson").getResponsejson(json,'manageAccess');
			
				var reponse = $("<fieldset />", { "html": "<legend>Réponse</legend>PAS DE DONNEES" });

				if(json.succes != 0 )  {
	
					var val =  (json.data.status.hasOwnProperty('value')       ? json.data.status.value : "" );
					var code = (json.data.status.hasOwnProperty('code')        ? json.data.status.code : "" );
					var desc = (json.data.status.hasOwnProperty('description') ? json.data.status.description : "" );
	
					var data = (json.data.hasOwnProperty('integrations') ? json.data.integrations : "" );
	
					var statut = $("<fieldset />", {  "html": "<legend>Statut</legend>" + val +" (" + code + "): " + desc });

					if ( data ) { 
						reponse = $("<fieldset />", {  "html": "<legend>Réponse</legend>" });
						reponse.append( JsonHuman.format( data ) );
					}
		  
				}

				$("<div />", { 
					"class": "reponse"
				}).insertAfter( $("#form-integrer") );
				$("#integrations .reponse").append( statut );
				$("#integrations .reponse").append( "<br />" );
				$("#integrations .reponse").append( reponse );
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