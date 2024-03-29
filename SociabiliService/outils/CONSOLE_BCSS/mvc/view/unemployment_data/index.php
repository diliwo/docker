<ul class="nav nav-tabs">
	<li class="active"><a href="#situation" data-toggle="tab">Situation</a></li>
	<li><a href="#sommes_payees" data-toggle="tab">Sommes payées</a></li>
	<li><a href="#sommes_payees_activation" data-toggle="tab">Sommes payées d'activation</a></li>
</ul>
<br />
<div class="tab-content well">
	<div class="tab-pane fade active in" id="situation">
		<form id="form-unemployment_data-situation" class="form-horizontal" role="form">
			<div class="form-group has-feedback">
				<label for="registre_national" class="col-md-2 control-label">Registre national: </label>
				<div class="col-md-3">
					<input type="text" class="form-control" name="registre_national">
					<span class="glyphicon glyphicon-pencil form-control-feedback"></span>
				</div>
			</div>

			<div class="form-group">
				<label for="date" class="col-md-2 control-label">Date: </label>
				<div class="col-md-2">
					<label class="sr-only" for="date">YYYY-MM-DD</label>
					<input type="text" class="form-control" name="date" placeholder="YYYY-MM-DD">
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

	<div class="tab-pane fade in" id="sommes_payees">
		<form id="form-unemployment_data-sommes_payees" class="form-horizontal" role="form">
			<div class="form-group has-feedback">
				<label for="registre_national" class="col-md-2 control-label">Registre national: </label>
				<div class="col-md-3">
					<input type="text" class="form-control" name="registre_national">
					<span class="glyphicon glyphicon-pencil form-control-feedback"></span>
				</div>
			</div>

			<div class="form-group">
				<label for="periode" class="col-md-2 control-label">Période: </label>
				<div class="col-md-4">
					<div class="input-group" id="periode">
						<span class="input-group-addon">du</span>
						<input type="text" class="form-control datepicker" name="date_debut" placeholder="YYYY-MM">
						<span class="input-group-addon">au</span>
						<input type="text" class="form-control datepicker" name="date_fin" placeholder="YYYY-MM">
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

	<div class="tab-pane fade in" id="sommes_payees_activation">
		<form id="form-unemployment_data-sommes_payees_activation" class="form-horizontal" role="form">
			<div class="form-group has-feedback">
				<label for="registre_national" class="col-md-2 control-label">Registre national: </label>
				<div class="col-md-3">
					<input type="text" class="form-control" name="registre_national">
					<span class="glyphicon glyphicon-pencil form-control-feedback"></span>
				</div>
			</div>

			<div class="form-group">
				<label for="quadrimestre" class="col-md-2 control-label">Quadrimestre: </label>
				<div class="col-md-2">
					<select class="form-control" name="quadrimestre">
						<option value="1"<?php echo (ceil(date("m")/4)==1)?' selected="selected"':''; ?>>Premier</option>
						<option value="2"<?php echo (ceil(date("m")/4)==2)?' selected="selected"':''; ?>>Deuxième</option>
						<option value="3"<?php echo (ceil(date("m")/4)==3)?' selected="selected"':''; ?>>Troisième</option>
					</select>
				</div>
			</div>

			<div class="form-group">
				<label for="annee" class="col-md-2 control-label">Année: </label>
				<div class="col-md-1">
					<input type="text" class="form-control" name="annee" value="<?php echo date("Y"); ?>" placeholder="YYYY">
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
</div>

<script type="text/javascript">
<!--

// ********* //
// Situation //
// ********* //
$("#situation form input[name=date]").datepicker({
	format: "yyyy-mm-dd",
	language: "fr",
	orientation: "top left",
	autoclose: true,
	todayHighlight: true
});
$("#situation form button[type=reset]").on( "click", function() {
	$("#situation form input[name=registre_national]").closest(".has-feedback").find(".glyphicon").removeClass("glyphicon-ok glyphicon-remove").addClass("glyphicon-pencil");
	$("#situation form input[name=registre_national]").closest(".has-feedback").removeClass("has-success has-error");
	$(".help-block").remove();
	$("#situation .reponse").remove();
});

$("#situation form").validate({
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
		$("#situation .reponse").remove();

		var rn = $("#situation form input[name=registre_national]").val();
		var date = $("#situation form input[name=date]").val();
		if (RegistreNational.valider( rn )) {
			var url = "<?php echo $_CONFIG['url']; ?>api/unemployment_data/consulter/situation?env=<?php echo $_SESSION['test_flux_bcss']['env']; ?>&registre_national=" + rn;
			if ( date != '' ) {
				url += "&date=" + date;
			}

			var jqxhr = $.getJSON( url , function(json) {
				var statut = 
				$("<fieldset />", { 
					"html": "<legend>Statut</legend>" + json.data.status.value +" (" + json.data.status.code + "): " + json.data.status.description
				});

				if (typeof json.data.situation == "undefined") {
					var reponse =
					$("<fieldset />", { 
						"html": "<legend>Réponse</legend>PAS DE DONNEES"
					});
				} else {
					var reponse =
					$("<fieldset />", { 
						"html": "<legend>Réponse</legend>"
					});
					reponse.append( JsonHuman.format( json.data.situation ) );
				}

				$("<div />", { 
					"class": "reponse"
				}).insertAfter( $("#situation form") );
				$("#situation .reponse").append( statut );
				$("#situation .reponse").append( "<br />" );
				$("#situation .reponse").append( reponse );
			})
			.fail(function() {
			})
			.always(function(){
				$("#wait").hide();
			})

		}
	}
});

// ************* //
// Sommes payées //
// ************* //
$("#sommes_payees form input[name=date_debut], #sommes_payees form input[name=date_fin]").datepicker({
	format: "yyyy-mm",
	language: "fr",
	orientation: "top left",
	minViewMode: 1,
	autoclose: true,
	todayHighlight: true
}).on("change", function() {
	var date_debut = $("#sommes_payees form input[name=date_debut]");
	var date_fin = $("#sommes_payees form input[name=date_fin]");

	date_fin.datepicker('setStartDate', date_debut.val());
	date_debut.datepicker('setEndDate', date_fin.val());
});
$("#sommes_payees form button[type=reset]").on( "click", function() {
	$("#sommes_payees form input[name=registre_national]").closest(".has-feedback").find(".glyphicon").removeClass("glyphicon-ok glyphicon-remove").addClass("glyphicon-pencil");
	$("#sommes_payees form input[name=registre_national]").closest(".has-feedback").removeClass("has-success has-error");
	$(".help-block").remove();
	$("#sommes_payees .reponse").remove();
})
$("#sommes_payees form").validate({
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
		$("#sommes_payees .reponse").remove();

		var rn = $("#sommes_payees form input[name=registre_national]").val();
		var date_debut = $("#sommes_payees form input[name=date_debut]").val();
		var date_fin = $("#sommes_payees form input[name=date_debut]").val();
		if (RegistreNational.valider( rn )) {
			var url = "<?php echo $_CONFIG['url']; ?>api/unemployment_data/consulter/sommes_payees?env=<?php echo $_SESSION['test_flux_bcss']['env']; ?>&registre_national=" + rn;
			if (( date_debut != '' ) && ( date_fin != '' )) {
				url += "&date_debut=" + date_debut + "&date_fin=" + date_fin;
			}

			var jqxhr = $.getJSON( url , function(json) {
				var statut = 
				$("<fieldset />", { 
					"html": "<legend>Statut</legend>" + json.data.status.value +" (" + json.data.status.code + "): " + json.data.status.description
				});

				if (typeof json.data.payedSums == "undefined") {
					var reponse =
					$("<fieldset />", { 
						"html": "<legend>Réponse</legend>PAS DE DONNEES"
					});
				} else {
					var reponse =
					$("<fieldset />", { 
						"html": "<legend>Réponse</legend>"
					});
					reponse.append( JsonHuman.format( json.data.payedSums ) );
				}

				$("<div />", { 
					"class": "reponse"
				}).insertAfter( $("#sommes_payees form") );
				$("#sommes_payees .reponse").append( statut );
				$("#sommes_payees .reponse").append( "<br />" );
				$("#sommes_payees .reponse").append( reponse );
			})
			.fail(function() {
			})
			.always(function(){
				$("#wait").hide();
			})

		}
	}
});

// ************************** //
// Sommes payees d'activation //
// ************************** //
$("#sommes_payees_activation form input[name=annee]").datepicker({
	format: "yyyy",
	language: "fr",
	orientation: "top left",
	minViewMode: 2,
	autoclose: true,
	todayHighlight: true
});
$("#sommes_payees_activation form button[type=reset]").on( "click", function() {
	$("#sommes_payees_activation form input[name=registre_national]").closest(".has-feedback").find(".glyphicon").removeClass("glyphicon-ok glyphicon-remove").addClass("glyphicon-pencil");
	$("#sommes_payees_activation form input[name=registre_national]").closest(".has-feedback").removeClass("has-success has-error");
	$(".help-block").remove();
	$("#sommes_payees_activation .reponse").remove();
})
$("#sommes_payees_activation form").validate({
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
		$("#sommes_payees_activation .reponse").remove();

		var rn = $("#sommes_payees_activation form input[name=registre_national]").val();
		var quadrimestre = $("#sommes_payees_activation form select[name=quadrimestre]").val();
		var annee = $("#sommes_payees_activation form input[name=annee]").val();
		if (RegistreNational.valider( rn )) {
			var url = "<?php echo $_CONFIG['url']; ?>api/unemployment_data/consulter/sommes_payees_activation?env=<?php echo $_SESSION['test_flux_bcss']['env']; ?>&registre_national=" + rn + "&quadrimestre=" + quadrimestre + "&annee=" + annee;

			var jqxhr = $.getJSON( url , function(json) {
				var statut = 
				$("<fieldset />", { 
					"html": "<legend>Statut</legend>" + json.data.status.value +" (" + json.data.status.code + "): " + json.data.status.description
				});

				if (typeof json.data.payedActivationSums == "undefined") {
					var reponse =
					$("<fieldset />", { 
						"html": "<legend>Réponse</legend>PAS DE DONNEES"
					});
				} else {
					var reponse =
					$("<fieldset />", { 
						"html": "<legend>Réponse</legend>"
					});
					reponse.append( JsonHuman.format( json.data.payedActivationSums ) );
				}

				$("<div />", { 
					"class": "reponse"
				}).insertAfter( $("#sommes_payees_activation form") );
				$("#sommes_payees_activation .reponse").append( statut );
				$("#sommes_payees_activation .reponse").append( "<br />" );
				$("#sommes_payees_activation .reponse").append( reponse );
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