<div class="well" id="health_care_insurance">
	<form method="POST" id="form-health_care_insurance" class="form-horizontal" role="form">
		<div class="form-group has-feedback">
			<label for="registre_national" class="col-md-2 control-label">Registre national :</label>
			<div class="col-md-3">
				<input type="text" class="form-control" name="registre_national">
				<span class="glyphicon glyphicon-pencil form-control-feedback"></span>
			</div>
		</div>

		<fieldset>
			<legend>Critère de temps</legend>

			<div class="form-group has-feedback">
				<label for="date" class="col-md-2 control-label">Date :</label>
				<div class="col-md-2">
					<label class="sr-only" for="date">YYYY-MM-DD</label>
					<input type="text" class="form-control" name="date" placeholder="YYYY-MM-DD">
				</div>
			</div>

		</fieldset>

		<fieldset>
			<legend>Données désirées <input type="checkbox" id="tous" checked="checked"></legend>

			<div class="form-group">
				<div class="checkbox col-md-4">
					<label>
						<input type="checkbox" class="donnees_demandees" name="insuringOrganization" checked="checked"> OA et mutualité
					</label>
				</div>

				<div class="checkbox col-md-4">
					<label>
						<input type="checkbox" class="donnees_demandees" name="reimbursementRight" checked="checked"> Droit au remboursement
					</label>
				</div>

				<div class="checkbox col-md-4">
					<label>
						<input type="checkbox" class="donnees_demandees" name="ct1ct2" checked="checked"> Codes CT1/CT2
					</label>
				</div>

				<div class="checkbox col-md-4">
					<label>
						<input type="checkbox" class="donnees_demandees" name="payingThirdParty" checked="checked"> Droit au tiers payant
					</label>
				</div>

				<div class="checkbox col-md-4">
					<label>
						<input type="checkbox" class="donnees_demandees" name="maximumCharge" checked="checked"> Année où le plafond a été atteint
					</label>
				</div>

				<div class="checkbox col-md-4">
					<label>
						<input type="checkbox" class="donnees_demandees" name="medicalHouse" checked="checked"> Contrats avec maison médicale
					</label>
				</div>

				<div class="checkbox col-md-4">
					<label>
						<input type="checkbox" class="donnees_demandees" name="increasedIntervention" checked="checked"> Droit à l'intervention majorée
					</label>
				</div>

				<div class="checkbox col-md-4">
					<label>
						<input type="checkbox" class="donnees_demandees" name="statusComplementaryInsurance" checked="checked"> Assurance complémentaire
					</label>
				</div>

				<div class="checkbox col-md-4">
					<label>
						<input type="checkbox" class="donnees_demandees" name="globalMedicalFile" checked="checked"> Médecin gérant le dossier
					</label>
				</div>

				<div class="checkbox col-md-4">
					<label>
						<input type="checkbox" class="donnees_demandees" name="sfdfL891" checked="checked"> Données du formulaire L891
					</label>
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
$("#health_care_insurance form input[name=date]").datepicker({
	format: "yyyy-mm-dd",
	language: "fr",
	orientation: "top left",
	autoclose: true,
	todayHighlight: true,
	startDate: "<?php echo (date('Y')-1) . date('-m-d'); ?>",
	endDate: "today"
});

$("#tous").on('click', function () {
	var checked = $(this).prop("checked");
	$(".donnees_demandees").each(function() {
		$(this).prop("checked", checked)
	});
});

$("#health_care_insurance form").validate({
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
		$("#health_care_insurance .reponse").remove();

		var rn = $("#health_care_insurance form input[name=registre_national]").val();
		var date = $("#health_care_insurance form input[name=date]").val();
		var donnees_demandees = new Array();

		if (RegistreNational.valider( rn )) {
			var url = "<?php echo $_CONFIG['url']; ?>api/health_care_insurance/consulter?env=<?php echo $_SESSION['test_flux_bcss']['env']; ?>&registre_national=" + rn;
			if ( date != '' ) {
				url += "&date=" + date;
			}

			$("#health_care_insurance form input.donnees_demandees").each(function(){
				if ( $(this).is(':checked') ) {
					donnees_demandees.push($(this).attr('name'));
				}

			});
			if (donnees_demandees.length > 0) {
				url += "&donnees_demandees=" + donnees_demandees.join(',');
			}

			var jqxhr = $.getJSON( url , function(json) { 

				
				$("#responsejson").getResponsejson(json,'consultFilesBySsin');
			
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
				}).insertAfter( $("#health_care_insurance form") );
				$("#health_care_insurance .reponse").append( statut );
				$("#health_care_insurance .reponse").append( "<br />" );
				$("#health_care_insurance .reponse").append( reponse );

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