<ul class="nav nav-tabs">
	<li class="active"><a href="#carriere" data-toggle="tab">Carrière</a></li>
	<li><a href="#contributions" data-toggle="tab">Contributions</a></li>
	<li><a href="#carriere_contributions" data-toggle="tab">Carrière et contributions</a></li>
</ul>
<br />
<div class="tab-content well">
	<div class="tab-pane fade active in" id="carriere">
		<form id="form-self_employed-carriere" class="form-horizontal" role="form">
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
					<div class="input-group" id="periode-self_employed-carriere">
						<span class="input-group-addon">du</span>
						<input type="text" class="form-control datepicker" name="date_debut" placeholder="YYYY-MM-DD" value="1976-07-01">
						<span class="input-group-addon">au</span>
						<input type="text" class="form-control datepicker" name="date_fin" placeholder="YYYY-MM-DD">
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

	<div class="tab-pane fade in" id="contributions">
		<form id="form-self_employed-contributions" class="form-horizontal" role="form">
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

	<div class="tab-pane fade in" id="carriere_contributions">
		<form id="form-self_employed-carriere_contributions" class="form-horizontal" role="form">
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
					<div class="input-group" id="periode-self_employed-carriere_contributions">
						<span class="input-group-addon">du</span>
						<input type="text" class="form-control datepicker" name="date_debut" placeholder="YYYY-MM-DD" value="1976-07-01">
						<span class="input-group-addon">au</span>
						<input type="text" class="form-control datepicker" name="date_fin" placeholder="YYYY-MM-DD">
					</div>
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

// ******** //
// Carrière //
// ******** //
$("#carriere form input[name=date_debut],input[name=date_fin]").datepicker({
	format: "yyyy-mm-dd",
	language: "fr",
	orientation: "top left",
	autoclose: true,
	todayHighlight: true
}).on("change", function() {
	var date_debut = $("#carriere form input[name=date_debut]");
	var date_fin = $("#carriere form input[name=date_fin]");

	date_fin.datepicker('setStartDate', date_debut.val());
	date_debut.datepicker('setEndDate', date_fin.val());
});
$("#carriere form button[type=reset]").on( "click", function() {
	$("#carriere form input[name=registre_national]").closest(".has-feedback").find(".glyphicon").removeClass("glyphicon-ok glyphicon-remove").addClass("glyphicon-pencil");
	$("#carriere form input[name=registre_national]").closest(".has-feedback").removeClass("has-success has-error");
	$(".help-block").remove();
	$("#carriere .reponse").remove();
});

$("#carriere form").validate({
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
		$("#carriere .reponse").remove();

		var rn = $("#carriere form input[name=registre_national]").val();
		var dateDebut = $("#carriere form input[name=date_debut]").val();
		var dateFin = $("#carriere form input[name=date_fin]").val();
		if (RegistreNational.valider( rn )) {
			var url = "<?php echo $_CONFIG['url']; ?>api/self_employed/consulter/carriere?env=<?php echo $_SESSION['test_flux_bcss']['env']; ?>&registre_national=" + rn;
			if ( dateDebut != '' ) {
				url += "&date_debut=" + dateDebut;

				if ( dateFin != '' ) {
					url += "&date_fin=" + dateFin;
				}
			}

			var jqxhr = $.getJSON( url , function(json) {
				var statut =
				$("<fieldset />", {
					"html": "<legend>Statut</legend>" + json.data.status.value +" (" + json.data.status.code + "): " + json.data.status.description
				});

				if (typeof json.data.result == "undefined") {
					var reponse =
					$("<fieldset />", {
						"html": "<legend>Réponse</legend>PAS DE DONNEES"
					});
				} else {
					var reponse =
					$("<fieldset />", {
						"html": "<legend>Réponse</legend>"
					});
					reponse.append( JsonHuman.format( json.data.result ) );
				}

				$("<div />", {
					"class": "reponse"
				}).insertAfter( $("#carriere form") );
				$("#carriere .reponse").append( statut );
				$("#carriere .reponse").append( "<br />" );
				$("#carriere .reponse").append( reponse );
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
// contributions //
// ************* //
$("#contributions form input[name=annee]").datepicker({
	format: "yyyy",
	language: "fr",
	orientation: "top left",
	minViewMode: 2,
	autoclose: true,
	todayHighlight: true
});
$("#contributions form button[type=reset]").on( "click", function() {
	$("#contributions form input[name=registre_national]").closest(".has-feedback").find(".glyphicon").removeClass("glyphicon-ok glyphicon-remove").addClass("glyphicon-pencil");
	$("#contributions form input[name=registre_national]").closest(".has-feedback").removeClass("has-success has-error");
	$(".help-block").remove();
	$("#contributions .reponse").remove();
})
$("#contributions form").validate({
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
		$("#contributions .reponse").remove();

		var rn = $("#contributions form input[name=registre_national]").val();
		var date_debut = $("#contributions form input[name=date_debut]").val();
		var date_fin = $("#contributions form input[name=date_debut]").val();
		if (RegistreNational.valider( rn )) {
			var url = "<?php echo $_CONFIG['url']; ?>api/self_employed/consulter/contributions?env=<?php echo $_SESSION['test_flux_bcss']['env']; ?>&registre_national=" + rn;
			if (( date_debut != '' ) && ( date_fin != '' )) {
				url += "&date_debut=" + date_debut + "&date_fin=" + date_fin;
			}

			var jqxhr = $.getJSON( url , function(json) {
				var statut =
				$("<fieldset />", {
					"html": "<legend>Statut</legend>" + json.data.status.value +" (" + json.data.status.code + "): " + json.data.status.description
				});

				if (typeof json.data.result == "undefined") {
					var reponse =
					$("<fieldset />", {
						"html": "<legend>Réponse</legend>PAS DE DONNEES"
					});
				} else {
					var reponse =
					$("<fieldset />", {
						"html": "<legend>Réponse</legend>"
					});
					reponse.append( JsonHuman.format( json.data.result ) );
				}

				$("<div />", {
					"class": "reponse"
				}).insertAfter( $("#contributions form") );
				$("#contributions .reponse").append( statut );
				$("#contributions .reponse").append( "<br />" );
				$("#contributions .reponse").append( reponse );
			})
			.fail(function() {
			})
			.always(function(){
				$("#wait").hide();
			})

		}
	}
});

// ************************* //
// Carrière et contributions //
// ************************* //
$("#carriere_contributions form input[name=date_debut],input[name=date_fin]").datepicker({
	format: "yyyy-mm-dd",
	language: "fr",
	orientation: "top left",
	autoclose: true,
	todayHighlight: true
}).on("change", function() {
	var date_debut = $("#carriere_contributions form input[name=date_debut]");
	var date_fin = $("#carriere_contributions form input[name=date_fin]");

	date_fin.datepicker('setStartDate', date_debut.val());
	date_debut.datepicker('setEndDate', date_fin.val());
});
$("#carriere_contributions form input[name=annee]").datepicker({
	format: "yyyy",
	language: "fr",
	orientation: "top left",
	minViewMode: 2,
	autoclose: true,
	todayHighlight: true
});
$("#carriere_contributions form button[type=reset]").on( "click", function() {
	$("#carriere_contributions form input[name=registre_national]").closest(".has-feedback").find(".glyphicon").removeClass("glyphicon-ok glyphicon-remove").addClass("glyphicon-pencil");
	$("#carriere_contributions form input[name=registre_national]").closest(".has-feedback").removeClass("has-success has-error");
	$(".help-block").remove();
	$("#carriere_contributions .reponse").remove();
})
$("#carriere_contributions form").validate({
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
		$("#carriere_contributions .reponse").remove();

		var rn = $("#carriere_contributions form input[name=registre_national]").val();
		var dateDebut = $("#carriere_contributions form input[name=date_debut]").val();
		var dateFin = $("#carriere_contributions form input[name=date_fin]").val();
		var quadrimestre = $("#carriere_contributions form select[name=quadrimestre]").val();
		var annee = $("#carriere_contributions form input[name=annee]").val();
		if (RegistreNational.valider( rn )) {
			var url = "<?php echo $_CONFIG['url']; ?>api/self_employed/consulter/carriere_contributions?env=<?php echo $_SESSION['test_flux_bcss']['env']; ?>&registre_national=" + rn + "&quadrimestre=" + quadrimestre + "&annee=" + annee;
			if ( dateDebut != '' ) {
				url += "&date_debut=" + dateDebut;

				if ( dateFin != '' ) {
					url += "&date_fin=" + dateFin;
				}
			}

			var jqxhr = $.getJSON( url , function(json) {
				var statut =
				$("<fieldset />", {
					"html": "<legend>Statut</legend>" + json.data.status.value +" (" + json.data.status.code + "): " + json.data.status.description
				});

				if (typeof json.data.result == "undefined") {
					var reponse =
					$("<fieldset />", {
						"html": "<legend>Réponse</legend>PAS DE DONNEES"
					});
				} else {
					var reponse =
					$("<fieldset />", {
						"html": "<legend>Réponse</legend>"
					});
					reponse.append( JsonHuman.format( json.data.result ) );
				}

				$("<div />", {
					"class": "reponse"
				}).insertAfter( $("#carriere_contributions form") );
				$("#carriere_contributions .reponse").append( statut );
				$("#carriere_contributions .reponse").append( "<br />" );
				$("#carriere_contributions .reponse").append( reponse );
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
