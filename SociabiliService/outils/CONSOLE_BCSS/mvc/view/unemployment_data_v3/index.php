<ul class="nav nav-tabs">
	<li class="active"><a href="#consultActivationPaidSums" data-toggle="tab">    Activation des sommes payées </a></li>
	<li><a href="#consultExemptionHistory" data-toggle="tab">                     Historique d'exemption  </a></li>
	<li><a href="#consultNoEarningCapacityAndLawsuitMutuality" data-toggle="tab"> Mutualité des procès </a></li>
	<li><a href="#consultPaidSums" data-toggle="tab">                             Sommes payées </a></li>
	<li><a href="#consultPayments" data-toggle="tab">                             Paiements </a></li>
	<li><a href="#consultRights" data-toggle="tab">                               Droits </a></li>
	<li><a href="#consultSanctionHistory" data-toggle="tab">                      Histoire de la sanction </a></li>
	<li><a href="#consultScaleCodeHistory" data-toggle="tab">                     Historique du code barémique  </a></li>
	<li><a href="#consultScheduledPayment" data-toggle="tab">                     Paiement prévu </a></li>
	<li><a href="#consultWorkDisabilityHistory" data-toggle="tab">                Reconnue comme ( Incapacité de travail ) </a></li>
	<li><a href="#consultYoungAvailabilityDecisionHistory" data-toggle="tab">     Contrôle de la disponibilité jeune </a></li>
</ul>

<br />
<div class="tab-content well">
	<div class="tab-pane fade active in" id="consultActivationPaidSums">
		<form id="form-data-consultActivationPaidSums" class="form-horizontal" role="form">
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
					<div class="input-group">
						<span class="input-group-addon">du</span>
						<input type="text" class="form-control datepicker" name="date_debut" placeholder="YYYY-MM">
						<span class="input-group-addon">au</span>
						<input type="text" class="form-control datepicker" name="date_fin" placeholder="YYYY-MM">
					</div>
				</div>
			</div>
			
			<fieldset>
			<legend>Permet de restreindre la recherche aux travailleurs de plus de 50 ans</legend>
			 
			<div class="form-group">
				<label for="" class="col-md-2 control-label">Toutes les indemnités: </label>
				<div class="col-md-10">
					
					<label class="checkbox-inline">
						<input type="checkbox" name="allAllowance" checked="checked">  
					</label>
					<div> 
						0 = Allocation d’activation, quel que soit l’âge </br>
						1 = Allocation d’activation travailleurs≥ 50 </br>
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

	<div class="tab-pane fade in" id="consultExemptionHistory">
		<form id="form-data-consultExemptionHistory" class="form-horizontal" role="form">
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
					<div class="input-group">
						<span class="input-group-addon">du</span>
						<input type="text" class="form-control datepicker" name="date_debut" placeholder="YYYY-MM-DD">
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
	
	<div class="tab-pane fade in" id="consultNoEarningCapacityAndLawsuitMutuality">
		<form id="form-data-consultNoEarningCapacityAndLawsuitMutuality" class="form-horizontal" role="form">
			<div class="form-group has-feedback">
				<label for="registre_national" class="col-md-2 control-label">Registre national: </label>
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

	<div class="tab-pane fade in" id="consultPaidSums">
		<form id="form-data-consultPaidSums" class="form-horizontal" role="form">
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
					<div class="input-group">
						<span class="input-group-addon">du</span>
						<input type="text" class="form-control datepicker" name="date_debut" placeholder="YYYY-MM">
						<span class="input-group-addon">au</span>
						<input type="text" class="form-control datepicker" name="date_fin" placeholder="YYYY-MM">
					</div>
				</div>
			</div>
			
			<fieldset>
			<legend>Recherche les allocations de chômage</legend>
			 
			<div class="form-group">
				<label for="" class="col-md-2 control-label">Allocations: </label>
				<div class="col-md-10">
					
					<label class="checkbox-inline">
						<input type="checkbox" name="allAllowance" checked="checked">  
					</label>
					<div>
						0 = Tous les types de chômage </br>
						1 = Chômage complet ainsi, que les allocations de garanties de revenu </br>
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
	
	<div class="tab-pane fade in" id="consultPayments">
		<form id="form-data-consultPayments" class="form-horizontal" role="form">
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
	
	<div class="tab-pane fade in" id="consultRights">
		<form id="form-data-consultRights" class="form-horizontal" role="form">
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
	
	<div class="tab-pane fade in" id="consultSanctionHistory">
		<form id="form-data-consultSanctionHistory" class="form-horizontal" role="form">
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
					<div class="input-group">
						<span class="input-group-addon">du</span>
						<input type="text" class="form-control datepicker" name="date_debut" placeholder="YYYY-MM-DD">
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
	
	<div class="tab-pane fade in" id="consultScaleCodeHistory">
		<form id="form-data-consultScaleCodeHistory" class="form-horizontal" role="form">
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
					<div class="input-group">
						<span class="input-group-addon">du</span>
						<input type="text" class="form-control datepicker" name="date_debut" placeholder="YYYY-MM-DD">
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
	
	<div class="tab-pane fade in" id="consultScheduledPayment">
		<form id="form-data-consultScheduledPayment" class="form-horizontal" role="form">
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
					<div class="input-group">
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
	
	<div class="tab-pane fade in" id="consultWorkDisabilityHistory">
		<form id="form-data-consultWorkDisabilityHistory" class="form-horizontal" role="form">
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
					<div class="input-group">
						<span class="input-group-addon">du</span>
						<input type="text" class="form-control datepicker" name="date_debut" placeholder="YYYY-MM-DD">
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
	
	<div class="tab-pane fade in" id="consultYoungAvailabilityDecisionHistory">
		<form id="form-data-consultYoungAvailabilityDecisionHistory" class="form-horizontal" role="form">
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
					<div class="input-group">
						<span class="input-group-addon">du</span>
						<input type="text" class="form-control datepicker" name="date_debut" placeholder="YYYY-MM-DD">
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
	
</div>

<script type="text/javascript">
<!--

// ***consultActivationPaidSums*** //

// **************************************** //
// Consulter l'activation des sommes payées //
// **************************************** //

$("#consultActivationPaidSums form input[name=date_debut], #consultActivationPaidSums form input[name=date_fin]").datepicker({
	format: "yyyy-mm",
	language: "fr",
	orientation: "top left",
	minViewMode: 1,
	autoclose: true,
	todayHighlight: true
}).on("change", function() {
	var date_debut = $("#consultActivationPaidSums form input[name=date_debut]");
	var date_fin = $("#consultActivationPaidSums form input[name=date_fin]");

	date_debut.datepicker('setStartDate', date_debut.val());
	date_fin.datepicker('setEndDate', date_fin.val());
});

$("#consultActivationPaidSums form button[type=reset]").on( "click", function() {
	$("#consultActivationPaidSums form input[name=registre_national]").closest(".has-feedback").find(".glyphicon").removeClass("glyphicon-ok glyphicon-remove").addClass("glyphicon-pencil");
	$("#consultActivationPaidSums form input[name=registre_national]").closest(".has-feedback").removeClass("has-success has-error");
	$(".help-block").remove();
	$("#consultActivationPaidSums .reponse").remove();
})
$("#consultActivationPaidSums form").validate({
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
		$("#consultActivationPaidSums .reponse").remove();

		var rn = $("#consultActivationPaidSums form input[name=registre_national]").val();

		var date_debut = $("#consultActivationPaidSums form input[name=date_debut]").val();
		var date_fin = $("#consultActivationPaidSums form input[name=date_fin]").val();

		var allAllowance = $("#consultActivationPaidSums form input[name=allAllowance]").prop( "checked" );
		var allowance = ( (allAllowance) ? 1 : 0 );
		
		if (RegistreNational.valider( rn )) {
	 
			var params = "&date_debut="+ date_debut + "&date_fin="+ date_fin+"&allAllowance="+allowance;
 
			var url = "<?php echo $_CONFIG['url']; ?>api/unemployment_data/v3/consulter/consultActivationPaidSums?env=<?php echo $_SESSION['test_flux_bcss']['env']; ?>&registre_national=" + rn + params;

			var jqxhr = $.getJSON( url , function(json) {
 
				$("#responsejson").getResponsejson(json,'consultActivationPaidSums');

				var reponse = $("<fieldset />", { "html": "<legend>Réponse</legend>PAS DE DONNEES" });

				if(json.succes != 0 )  {
					
					var val =  (json.data.status.hasOwnProperty('value')       ? json.data.status.value : "" );
					var code = (json.data.status.hasOwnProperty('code')        ? json.data.status.code : "" );
					var desc = (json.data.status.hasOwnProperty('description') ? json.data.status.description : "" );
					
					var data = (json.data.hasOwnProperty('activationAllowances') ? json.data.activationAllowances : "" );
					
					var statut = $("<fieldset />", {  "html": "<legend>Statut</legend>" + val +" (" + code + "): " + desc });
	 
					if ( data ) { 
						reponse = $("<fieldset />", {  "html": "<legend>Réponse</legend>" });
						reponse.append( JsonHuman.format( data ) );
					}
					  
				}

				$("<div />", { 
					"class": "reponse"
				}).insertAfter( $("#consultActivationPaidSums form") );
				$("#consultActivationPaidSums .reponse").append( statut );
				$("#consultActivationPaidSums .reponse").append( "<br />" );
				$("#consultActivationPaidSums .reponse").append( reponse );
			})
			.fail(function() {
			})
			.always(function(){
				$("#wait").hide();
			})
		}
	}
});

// ***consultExemptionHistory*** //

// *********************************** //
// Consulter l'historique d'exemption  //
// *********************************** //

$("#consultExemptionHistory form input[name=date_debut], #consultExemptionHistory form input[name=date_fin]").datepicker({
	format: "yyyy-mm-dd",
	language: "fr",
	orientation: "top left",
	autoclose: true,
	todayHighlight: true
	
}).on("change", function() {
	var date_debut = $("#consultExemptionHistory form input[name=date_debut]");
	var date_fin = $("#consultExemptionHistory form input[name=date_fin]");

	date_debut.datepicker('setStartDate', date_debut.val());
	date_fin.datepicker('setEndDate', date_fin.val());
});

$("#consultExemptionHistory form button[type=reset]").on( "click", function() {
	$("#consultExemptionHistory form input[name=registre_national]").closest(".has-feedback").find(".glyphicon").removeClass("glyphicon-ok glyphicon-remove").addClass("glyphicon-pencil");
	$("#consultExemptionHistory form input[name=registre_national]").closest(".has-feedback").removeClass("has-success has-error");
	$(".help-block").remove();
	$("#consultExemptionHistory .reponse").remove();
});

$("#consultExemptionHistory form").validate({
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
		$("#consultExemptionHistory .reponse").remove();

		var rn = $("#consultExemptionHistory form input[name=registre_national]").val();
		var date_debut = $("#consultExemptionHistory form input[name=date_debut]").val();
		var date_fin = $("#consultExemptionHistory form input[name=date_fin]").val();
		
		if (RegistreNational.valider( rn )) {
			
			var params = "&date_debut="+ date_debut + "&date_fin="+ date_fin;
			
			var url = "<?php echo $_CONFIG['url']; ?>api/unemployment_data/v3/consulter/consultExemptionHistory?env=<?php echo $_SESSION['test_flux_bcss']['env']; ?>&registre_national=" + rn + params;
			
			var jqxhr = $.getJSON( url , function(json) {

				$("#responsejson").getResponsejson(json, 'consultExemptionHistory');	 
				
				var reponse = $("<fieldset />", { "html": "<legend>Réponse</legend>PAS DE DONNEES" });

				if(json.succes != 0 )  {
					
					var val =  (json.data.status.hasOwnProperty('value')       ? json.data.status.value : "" );
					var code = (json.data.status.hasOwnProperty('code')        ? json.data.status.code : "" );
					var desc = (json.data.status.hasOwnProperty('description') ? json.data.status.description : "" );
					
					var data = (json.data.hasOwnProperty('exemptions') ? json.data.exemptions : "" );
					
					var statut = $("<fieldset />", {  "html": "<legend>Statut</legend>" + val +" (" + code + "): " + desc });
	 
					if ( data ) { 
						reponse = $("<fieldset />", {  "html": "<legend>Réponse</legend>" });
						reponse.append( JsonHuman.format( data ) );
					}
					  
				}

				$("<div />", { 
					"class": "reponse"
				}).insertAfter( $("#consultExemptionHistory form") );
				$("#consultExemptionHistory .reponse").append( statut );
				$("#consultExemptionHistory .reponse").append( "<br />" );
				$("#consultExemptionHistory .reponse").append( reponse );
			})
			.fail(function() {
			})
			.always(function(){
				$("#wait").hide();
			})
		}
	}
});

// ***consultNoEarningCapacityAndLawsuitMutuality*** //

// *********************************************************** //
// Consult aucune capacité de gain et mutualité des poursuites //
// *********************************************************** //

$("#consultNoEarningCapacityAndLawsuitMutuality form button[type=reset]").on( "click", function() {
	$("#consultNoEarningCapacityAndLawsuitMutuality form input[name=registre_national]").closest(".has-feedback").find(".glyphicon").removeClass("glyphicon-ok glyphicon-remove").addClass("glyphicon-pencil");
	$("#consultNoEarningCapacityAndLawsuitMutuality form input[name=registre_national]").closest(".has-feedback").removeClass("has-success has-error");
	$(".help-block").remove();
	$("#consultNoEarningCapacityAndLawsuitMutuality .reponse").remove();
});

$("#consultNoEarningCapacityAndLawsuitMutuality form").validate({
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
		$("#consultNoEarningCapacityAndLawsuitMutuality .reponse").remove();

		var rn = $("#consultNoEarningCapacityAndLawsuitMutuality form input[name=registre_national]").val();

		if (RegistreNational.valider( rn )) {
			var url = "<?php echo $_CONFIG['url']; ?>api/unemployment_data/v3/consulter/consultNoEarningCapacityAndLawsuitMutuality?env=<?php echo $_SESSION['test_flux_bcss']['env']; ?>&registre_national=" + rn;

			var jqxhr = $.getJSON( url , function(json) {

				$("#responsejson").getResponsejson(json, 'consultNoEarningCapacityAndLawsuitMutuality'); 
				
				var reponse = $("<fieldset />", { "html": "<legend>Réponse</legend>PAS DE DONNEES" });

				if(json.succes != 0 )  {
					
					var val =  (json.data.status.hasOwnProperty('value')       ? json.data.status.value : "" );
					var code = (json.data.status.hasOwnProperty('code')        ? json.data.status.code : "" );
					var desc = (json.data.status.hasOwnProperty('description') ? json.data.status.description : "" );
					
					var data = (json.data.hasOwnProperty('response') ? json.data.response : "" );
					
					var statut = $("<fieldset />", {  "html": "<legend>Statut</legend>" + val +" (" + code + "): " + desc });
	 
					if ( data ) { 
						reponse = $("<fieldset />", {  "html": "<legend>Réponse</legend>" });
						reponse.append( JsonHuman.format( data ) );
					}
					  
				}

				$("<div />", { 
					"class": "reponse"
				}).insertAfter( $("#consultNoEarningCapacityAndLawsuitMutuality form") );
				$("#consultNoEarningCapacityAndLawsuitMutuality .reponse").append( statut );
				$("#consultNoEarningCapacityAndLawsuitMutuality .reponse").append( "<br />" );
				$("#consultNoEarningCapacityAndLawsuitMutuality .reponse").append( reponse );
			})
			.fail(function() {
			})
			.always(function(){
				$("#wait").hide();
			})
		}
	}
});

// ***consultPaidSums*** //

// ************* //
// Sommes payées //
// ************* //

$("#consultPaidSums form input[name=date_debut], #consultPaidSums form input[name=date_fin]").datepicker({
	format: "yyyy-mm",
	language: "fr",
	orientation: "top left",
	minViewMode: 1,
	autoclose: true,
	todayHighlight: true
}).on("change", function() {
	var date_debut = $("#consultPaidSums form input[name=date_debut]");
	var date_fin = $("#consultPaidSums form input[name=date_fin]");

	date_debut.datepicker('setStartDate', date_debut.val());
	date_fin.datepicker('setEndDate', date_fin.val());
});
$("#consultPaidSums form button[type=reset]").on( "click", function() {
	$("#consultPaidSums form input[name=registre_national]").closest(".has-feedback").find(".glyphicon").removeClass("glyphicon-ok glyphicon-remove").addClass("glyphicon-pencil");
	$("#consultPaidSums form input[name=registre_national]").closest(".has-feedback").removeClass("has-success has-error");
	$(".help-block").remove();
	$("#consultPaidSums .reponse").remove();
})
$("#consultPaidSums form").validate({
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
		$("#consultPaidSums .reponse").remove();

		var rn = $("#consultPaidSums form input[name=registre_national]").val();
		var date_debut = $("#consultPaidSums form input[name=date_debut]").val();
		var date_fin = $("#consultPaidSums form input[name=date_fin]").val();

		var allAllowance = $("#consultPaidSums form input[name=allAllowance]").prop( "checked" );
		var allowance = ( (allAllowance) ? 1 : 0 );
		
		if (RegistreNational.valider( rn )) {
			
			var params = "&date_debut="+ date_debut + "&date_fin="+ date_fin+"&allAllowance="+allowance;
			 
			var url = "<?php echo $_CONFIG['url']; ?>api/unemployment_data/v3/consulter/consultPaidSums?env=<?php echo $_SESSION['test_flux_bcss']['env']; ?>&registre_national=" + rn + params;
			
			var jqxhr = $.getJSON( url , function(json) {
				
				$("#responsejson").getResponsejson(json,'consultPaidSums'); 

				var reponse = $("<fieldset />", { "html": "<legend>Réponse</legend>PAS DE DONNEES" });

				if(json.succes != 0 )  {
					
					var val =  (json.data.status.hasOwnProperty('value')       ? json.data.status.value : "" );
					var code = (json.data.status.hasOwnProperty('code')        ? json.data.status.code : "" );
					var desc = (json.data.status.hasOwnProperty('description') ? json.data.status.description : "" );
					
					var data = (json.data.hasOwnProperty('response') ? json.data.response : "" );
					
					var statut = $("<fieldset />", {  "html": "<legend>Statut</legend>" + val +" (" + code + "): " + desc });
	 
					if ( data ) { 
						reponse = $("<fieldset />", {  "html": "<legend>Réponse</legend>" });
						reponse.append( JsonHuman.format( data ) );
					}
					  
				}
 
				$("<div />", { 
					"class": "reponse"
				}).insertAfter( $("#consultPaidSums form") );
				$("#consultPaidSums .reponse").append( statut );
				$("#consultPaidSums .reponse").append( "<br />" );
				$("#consultPaidSums .reponse").append( reponse );
			})
			.fail(function() {
			})
			.always(function(){
				$("#wait").hide();
			})
		}
	}
});

// ***consultPayments*** //

// ********* //
// Paiements //
// ********* //

$("#consultPayments form input[name=date]").datepicker({
	format: "yyyy-mm-dd",
	language: "fr",
	orientation: "top left",
	autoclose: true,
	todayHighlight: true
});
$("#consultPayments form button[type=reset]").on( "click", function() {
	$("#consultPayments form input[name=registre_national]").closest(".has-feedback").find(".glyphicon").removeClass("glyphicon-ok glyphicon-remove").addClass("glyphicon-pencil");
	$("#consultPayments form input[name=registre_national]").closest(".has-feedback").removeClass("has-success has-error");
	$(".help-block").remove();
	$("#consultPayments .reponse").remove();
});

$("#consultPayments form").validate({
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
		$("#consultPayments .reponse").remove();

		var rn = $("#consultPayments form input[name=registre_national]").val();
		var date = $("#consultPayments form input[name=date]").val();

		if (RegistreNational.valider( rn )) { 
			var params = "&date=" + date;

			var url = "<?php echo $_CONFIG['url']; ?>api/unemployment_data/v3/consulter/consultPayments?env=<?php echo $_SESSION['test_flux_bcss']['env']; ?>&registre_national=" + rn + params;
			
			var jqxhr = $.getJSON( url , function(json) {
				
				$("#responsejson").getResponsejson(json,'consultPayments'); 

				var reponse = $("<fieldset />", { "html": "<legend>Réponse</legend>PAS DE DONNEES" });

				if(json.succes != 0 )  {
					
					var val =  (json.data.status.hasOwnProperty('value')       ? json.data.status.value : "" );
					var code = (json.data.status.hasOwnProperty('code')        ? json.data.status.code : "" );
					var desc = (json.data.status.hasOwnProperty('description') ? json.data.status.description : "" );
					
					var data = (json.data.hasOwnProperty('payment') ? json.data.payment : "" );
					
					var statut = $("<fieldset />", {  "html": "<legend>Statut</legend>" + val +" (" + code + "): " + desc });
	 
					if ( data ) { 
						reponse = $("<fieldset />", {  "html": "<legend>Réponse</legend>" });
						reponse.append( JsonHuman.format( data ) );
					}
					  
				}

				$("<div />", { 
					"class": "reponse"
				}).insertAfter( $("#consultPayments form") );
				$("#consultPayments .reponse").append( statut );
				$("#consultPayments .reponse").append( "<br />" );
				$("#consultPayments .reponse").append( reponse );
			})
			.fail(function() {
			})
			.always(function(){
				$("#wait").hide();
			})
		}
	}
});

// ***consultRights*** //

// ******************** //
// Consulter les droits //
// ******************** //

$("#consultRights form input[name=date]").datepicker({
	format: "yyyy-mm-dd",
	language: "fr",
	orientation: "top left",
	autoclose: true,
	todayHighlight: true
});
$("#consultRights form button[type=reset]").on( "click", function() {
	$("#consultRights form input[name=registre_national]").closest(".has-feedback").find(".glyphicon").removeClass("glyphicon-ok glyphicon-remove").addClass("glyphicon-pencil");
	$("#consultRights form input[name=registre_national]").closest(".has-feedback").removeClass("has-success has-error");
	$(".help-block").remove();
	$("#consultRights .reponse").remove();
});

$("#consultRights form").validate({
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
		$("#consultRights .reponse").remove();

		var rn = $("#consultRights form input[name=registre_national]").val();
		var date = $("#consultRights form input[name=date]").val();

		if (RegistreNational.valider( rn )) { 
			
			var params = "&date=" + date;

			var url = "<?php echo $_CONFIG['url']; ?>api/unemployment_data/v3/consulter/consultRights?env=<?php echo $_SESSION['test_flux_bcss']['env']; ?>&registre_national=" + rn + params;
			
			var jqxhr = $.getJSON( url , function(json) {
				
				$("#responsejson").getResponsejson(json,'consultRights'); 

				var reponse = $("<fieldset />", { "html": "<legend>Réponse</legend>PAS DE DONNEES" });

				if(json.succes != 0 )  {
					
					var val =  (json.data.status.hasOwnProperty('value')       ? json.data.status.value : "" );
					var code = (json.data.status.hasOwnProperty('code')        ? json.data.status.code : "" );
					var desc = (json.data.status.hasOwnProperty('description') ? json.data.status.description : "" );
					
					var data = (json.data.hasOwnProperty('rights') ? json.data.rights : "" );
					
					var statut = $("<fieldset />", {  "html": "<legend>Statut</legend>" + val +" (" + code + "): " + desc });
	 
					if ( data ) { 
						reponse = $("<fieldset />", {  "html": "<legend>Réponse</legend>" });
						reponse.append( JsonHuman.format( data ) );
					}
					  
				}

				$("<div />", { 
					"class": "reponse"
				}).insertAfter( $("#consultRights form") );
				$("#consultRights .reponse").append( statut );
				$("#consultRights .reponse").append( "<br />" );
				$("#consultRights .reponse").append( reponse );
			})
			.fail(function() {
			})
			.always(function(){
				$("#wait").hide();
			})
		}
	}
});

// ***consultSanctionHistory*** //

// ************************************ //
//  Consulter l'historique de Sanction  //
// ************************************ //

$("#consultSanctionHistory form input[name=date_debut], #consultSanctionHistory form input[name=date_fin]").datepicker({
	format: "yyyy-mm-dd",
	language: "fr",
	orientation: "top left",
	autoclose: true,
	todayHighlight: true
}).on("change", function() {
	var date_debut = $("#consultSanctionHistory form input[name=date_debut]");
	var date_fin = $("#consultSanctionHistory form input[name=date_fin]");

	date_debut.datepicker('setStartDate', date_debut.val());
	date_fin.datepicker('setEndDate', date_fin.val());
});

$("#consultSanctionHistory form button[type=reset]").on( "click", function() {
	$("#consultSanctionHistory form input[name=registre_national]").closest(".has-feedback").find(".glyphicon").removeClass("glyphicon-ok glyphicon-remove").addClass("glyphicon-pencil");
	$("#consultSanctionHistory form input[name=registre_national]").closest(".has-feedback").removeClass("has-success has-error");
	$(".help-block").remove();
	$("#consultSanctionHistory .reponse").remove();
});

$("#consultSanctionHistory form").validate({
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
		$("#consultSanctionHistory .reponse").remove();

		var rn = $("#consultSanctionHistory form input[name=registre_national]").val();
		var date_debut = $("#consultSanctionHistory form input[name=date_debut]").val();
		var date_fin = $("#consultSanctionHistory form input[name=date_fin]").val();
		
		if (RegistreNational.valider( rn )) {
			
			var params = "&date_debut="+ date_debut + "&date_fin="+ date_fin;
			
			var url = "<?php echo $_CONFIG['url']; ?>api/unemployment_data/v3/consulter/consultSanctionHistory?env=<?php echo $_SESSION['test_flux_bcss']['env']; ?>&registre_national=" + rn + params;
			
			var jqxhr = $.getJSON( url , function(json) {

				$("#responsejson").getResponsejson(json, 'consultSanctionHistory');	 
				
				var reponse = $("<fieldset />", { "html": "<legend>Réponse</legend>PAS DE DONNEES" });

				if(json.succes != 0 )  {
					
					var val =  (json.data.status.hasOwnProperty('value')       ? json.data.status.value : "" );
					var code = (json.data.status.hasOwnProperty('code')        ? json.data.status.code : "" );
					var desc = (json.data.status.hasOwnProperty('description') ? json.data.status.description : "" );
					
					var data = (json.data.hasOwnProperty('response') ? json.data.response : "" );
					
					var statut = $("<fieldset />", {  "html": "<legend>Statut</legend>" + val +" (" + code + "): " + desc });
	 
					if ( data ) { 
						reponse = $("<fieldset />", {  "html": "<legend>Réponse</legend>" });
						reponse.append( JsonHuman.format( data ) );
					}
					  
				}

				$("<div />", { 
					"class": "reponse"
				}).insertAfter( $("#consultSanctionHistory form") );
				$("#consultSanctionHistory .reponse").append( statut );
				$("#consultSanctionHistory .reponse").append( "<br />" );
				$("#consultSanctionHistory .reponse").append( reponse );
			})
			.fail(function() {
			})
			.always(function(){
				$("#wait").hide();
			})
		}
	}
});

// ***consultScaleCodeHistory*** //

// ****************************************** //
// Consulter l'historique des codes d'échelle //
// ****************************************** //

$("#consultScaleCodeHistory form input[name=date_debut], #consultScaleCodeHistory form input[name=date_fin]").datepicker({
	format: "yyyy-mm-dd",
	language: "fr",
	orientation: "top left",
	autoclose: true,
	todayHighlight: true
}).on("change", function() {
	var date_debut = $("#consultScaleCodeHistory form input[name=date_debut]");
	var date_fin = $("#consultScaleCodeHistory form input[name=date_fin]");

	date_debut.datepicker('setStartDate', date_debut.val());
	date_fin.datepicker('setEndDate', date_fin.val());
});

$("#consultScaleCodeHistory form button[type=reset]").on( "click", function() {
	$("#consultScaleCodeHistory form input[name=registre_national]").closest(".has-feedback").find(".glyphicon").removeClass("glyphicon-ok glyphicon-remove").addClass("glyphicon-pencil");
	$("#consultScaleCodeHistory form input[name=registre_national]").closest(".has-feedback").removeClass("has-success has-error");
	$(".help-block").remove();
	$("#consultScaleCodeHistory .reponse").remove();
});

$("#consultScaleCodeHistory form").validate({
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
		$("#consultScaleCodeHistory .reponse").remove();

		var rn = $("#consultScaleCodeHistory form input[name=registre_national]").val();
		var date_debut = $("#consultScaleCodeHistory form input[name=date_debut]").val();
		var date_fin = $("#consultScaleCodeHistory form input[name=date_fin]").val();
		
		if (RegistreNational.valider( rn )) {
			
			var params = "&date_debut="+ date_debut + "&date_fin="+ date_fin;
			
			var url = "<?php echo $_CONFIG['url']; ?>api/unemployment_data/v3/consulter/consultScaleCodeHistory?env=<?php echo $_SESSION['test_flux_bcss']['env']; ?>&registre_national=" + rn + params;
			
			var jqxhr = $.getJSON( url , function(json) {

				$("#responsejson").getResponsejson(json, 'consultScaleCodeHistory'); 	
				
				var reponse = $("<fieldset />", { "html": "<legend>Réponse</legend>PAS DE DONNEES" });

				if(json.succes != 0 )  {
					
					var val =  (json.data.status.hasOwnProperty('value')       ? json.data.status.value : "" );
					var code = (json.data.status.hasOwnProperty('code')        ? json.data.status.code : "" );
					var desc = (json.data.status.hasOwnProperty('description') ? json.data.status.description : "" );
					
					var data = (json.data.hasOwnProperty('response') ? json.data.response : "" );
					
					var statut = $("<fieldset />", {  "html": "<legend>Statut</legend>" + val +" (" + code + "): " + desc });
	 
					if ( data ) { 
						reponse = $("<fieldset />", {  "html": "<legend>Réponse</legend>" });
						reponse.append( JsonHuman.format( data ) );
					}
					  
				}

				$("<div />", { 
					"class": "reponse"
				}).insertAfter( $("#consultScaleCodeHistory form") );
				$("#consultScaleCodeHistory .reponse").append( statut );
				$("#consultScaleCodeHistory .reponse").append( "<br />" );
				$("#consultScaleCodeHistory .reponse").append( reponse );
			})
			.fail(function() {
			})
			.always(function(){
				$("#wait").hide();
			})
		}
	}
});

// ***consultScheduledPayment*** //

// *************************** //
// Consulter le paiement prévu //
// *************************** //

$("#consultScheduledPayment form input[name=date_debut], #consultScheduledPayment form input[name=date_fin]").datepicker({
	format: "yyyy-mm",
	language: "fr",
	orientation: "top left",
	minViewMode: 1,
	autoclose: true,
	todayHighlight: true
}).on("change", function() {
	var date_debut = $("#consultScheduledPayment form input[name=date_debut]");
	var date_fin = $("#consultScheduledPayment form input[name=date_fin]");

	date_debut.datepicker('setStartDate', date_debut.val());
	date_fin.datepicker('setEndDate', date_fin.val());
});

$("#consultScheduledPayment form button[type=reset]").on( "click", function() {
	$("#consultScheduledPayment form input[name=registre_national]").closest(".has-feedback").find(".glyphicon").removeClass("glyphicon-ok glyphicon-remove").addClass("glyphicon-pencil");
	$("#consultScheduledPayment form input[name=registre_national]").closest(".has-feedback").removeClass("has-success has-error");
	$(".help-block").remove();
	$("#consultScheduledPayment .reponse").remove();
})
$("#consultScheduledPayment form").validate({
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
		$("#consultScheduledPayment .reponse").remove();

		var rn = $("#consultScheduledPayment form input[name=registre_national]").val();

		var date_debut = $("#consultScheduledPayment form input[name=date_debut]").val();
		var date_fin = $("#consultScheduledPayment form input[name=date_fin]").val();
		
		if (RegistreNational.valider( rn )) {
	 
			var params = "&date_debut="+ date_debut + "&date_fin="+ date_fin;

			var url = "<?php echo $_CONFIG['url']; ?>api/unemployment_data/v3/consulter/consultScheduledPayment?env=<?php echo $_SESSION['test_flux_bcss']['env']; ?>&registre_national=" + rn + params;

			var jqxhr = $.getJSON( url , function(json) {

				$("#responsejson").getResponsejson(json,'consultScheduledPayment'); 

				var reponse = $("<fieldset />", { "html": "<legend>Réponse</legend>PAS DE DONNEES" });

				if(json.succes != 0 )  {
					
					var val =  (json.data.status.hasOwnProperty('value')       ? json.data.status.value : "" );
					var code = (json.data.status.hasOwnProperty('code')        ? json.data.status.code : "" );
					var desc = (json.data.status.hasOwnProperty('description') ? json.data.status.description : "" );
					
					var data = (json.data.hasOwnProperty('scheduledPayment') ? json.data.scheduledPayment : "" );
					
					var statut = $("<fieldset />", {  "html": "<legend>Statut</legend>" + val +" (" + code + "): " + desc });
	 
					if ( data ) { 
						reponse = $("<fieldset />", {  "html": "<legend>Réponse</legend>" });
						reponse.append( JsonHuman.format( data ) );
					}
					  
				}

				$("<div />", { 
					"class": "reponse"
				}).insertAfter( $("#consultScheduledPayment form") );
				$("#consultScheduledPayment .reponse").append( statut );
				$("#consultScheduledPayment .reponse").append( "<br />" );
				$("#consultScheduledPayment .reponse").append( reponse );
			})
			.fail(function() {
			})
			.always(function(){
				$("#wait").hide();
			})
		}
	}
});

// ***consultWorkDisabilityHistory*** //

// ****************************************************** //
// Consulter les antécédents d'invalidité professionnelle //
// ****************************************************** //

$("#consultWorkDisabilityHistory form input[name=date_debut], #consultWorkDisabilityHistory form input[name=date_fin]").datepicker({
	format: "yyyy-mm-dd",
	language: "fr",
	orientation: "top left",
	autoclose: true,
	todayHighlight: true
	
}).on("change", function() {
	var date_debut = $("#consultWorkDisabilityHistory form input[name=date_debut]");
	var date_fin = $("#consultWorkDisabilityHistory form input[name=date_fin]");

	date_debut.datepicker('setStartDate', date_debut.val());
	date_fin.datepicker('setEndDate', date_fin.val());
});

$("#consultWorkDisabilityHistory form button[type=reset]").on( "click", function() {
	$("#consultWorkDisabilityHistory form input[name=registre_national]").closest(".has-feedback").find(".glyphicon").removeClass("glyphicon-ok glyphicon-remove").addClass("glyphicon-pencil");
	$("#consultWorkDisabilityHistory form input[name=registre_national]").closest(".has-feedback").removeClass("has-success has-error");
	$(".help-block").remove();
	$("#consultWorkDisabilityHistory .reponse").remove();
});

$("#consultWorkDisabilityHistory form").validate({
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
		$("#consultWorkDisabilityHistory .reponse").remove();

		var rn = $("#consultWorkDisabilityHistory form input[name=registre_national]").val();
		var date_debut = $("#consultWorkDisabilityHistory form input[name=date_debut]").val();
		var date_fin = $("#consultWorkDisabilityHistory form input[name=date_fin]").val();
		
		if (RegistreNational.valider( rn )) {
			
			var params = "&date_debut="+ date_debut + "&date_fin="+ date_fin;
			
			var url = "<?php echo $_CONFIG['url']; ?>api/unemployment_data/v3/consulter/consultWorkDisabilityHistory?env=<?php echo $_SESSION['test_flux_bcss']['env']; ?>&registre_national=" + rn + params;
			
			var jqxhr = $.getJSON( url , function(json) {

				$("#responsejson").getResponsejson(json, 'consultWorkDisabilityHistory');	 
				
				var reponse = $("<fieldset />", { "html": "<legend>Réponse</legend>PAS DE DONNEES" });

				if(json.succes != 0 )  {
					
					var val =  (json.data.status.hasOwnProperty('value')       ? json.data.status.value : "" );
					var code = (json.data.status.hasOwnProperty('code')        ? json.data.status.code : "" );
					var desc = (json.data.status.hasOwnProperty('description') ? json.data.status.description : "" );
					
					var data = (json.data.hasOwnProperty('exemptions') ? json.data.exemptions : "" );
					
					var statut = $("<fieldset />", {  "html": "<legend>Statut</legend>" + val +" (" + code + "): " + desc });
	 
					if ( data ) { 
						reponse = $("<fieldset />", {  "html": "<legend>Réponse</legend>" });
						reponse.append( JsonHuman.format( data ) );
					}
					  
				}

				$("<div />", { 
					"class": "reponse"
				}).insertAfter( $("#consultWorkDisabilityHistory form") );
				$("#consultWorkDisabilityHistory .reponse").append( statut );
				$("#consultWorkDisabilityHistory .reponse").append( "<br />" );
				$("#consultWorkDisabilityHistory .reponse").append( reponse );
			})
			.fail(function() {
			})
			.always(function(){
				$("#wait").hide();
			})
		}
	}
});

// ***consultYoungAvailabilityDecisionHistory*** //

// **************************************************************** //
// Consulter l'historique des décisions de disponibilité des jeunes //
// **************************************************************** //

$("#consultYoungAvailabilityDecisionHistory form input[name=date_debut], #consultYoungAvailabilityDecisionHistory form input[name=date_fin]").datepicker({
	format: "yyyy-mm-dd",
	language: "fr",
	orientation: "top left",
	autoclose: true,
	todayHighlight: true
	
}).on("change", function() {
	var date_debut = $("#consultYoungAvailabilityDecisionHistory form input[name=date_debut]");
	var date_fin = $("#consultYoungAvailabilityDecisionHistory form input[name=date_fin]");

	date_debut.datepicker('setStartDate', date_debut.val());
	date_fin.datepicker('setEndDate', date_fin.val());
});

$("#consultYoungAvailabilityDecisionHistory form button[type=reset]").on( "click", function() {
	$("#consultYoungAvailabilityDecisionHistory form input[name=registre_national]").closest(".has-feedback").find(".glyphicon").removeClass("glyphicon-ok glyphicon-remove").addClass("glyphicon-pencil");
	$("#consultYoungAvailabilityDecisionHistory form input[name=registre_national]").closest(".has-feedback").removeClass("has-success has-error");
	$(".help-block").remove();
	$("#consultYoungAvailabilityDecisionHistory .reponse").remove();
});

$("#consultYoungAvailabilityDecisionHistory form").validate({
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
		$("#consultYoungAvailabilityDecisionHistory .reponse").remove();

		var rn = $("#consultYoungAvailabilityDecisionHistory form input[name=registre_national]").val();
		var date_debut = $("#consultYoungAvailabilityDecisionHistory form input[name=date_debut]").val();
		var date_fin = $("#consultYoungAvailabilityDecisionHistory form input[name=date_fin]").val();
		
		if (RegistreNational.valider( rn )) {
			
			var params = "&date_debut="+ date_debut + "&date_fin="+ date_fin;
			
			var url = "<?php echo $_CONFIG['url']; ?>api/unemployment_data/v3/consulter/consultYoungAvailabilityDecisionHistory?env=<?php echo $_SESSION['test_flux_bcss']['env']; ?>&registre_national=" + rn + params;
			
			var jqxhr = $.getJSON( url , function(json) {

				$("#responsejson").getResponsejson(json, 'consultYoungAvailabilityDecisionHistory');	 
				
				var reponse = $("<fieldset />", { "html": "<legend>Réponse</legend>PAS DE DONNEES" });

				if(json.succes != 0 )  {
					
					var val =  (json.data.status.hasOwnProperty('value')       ? json.data.status.value : "" );
					var code = (json.data.status.hasOwnProperty('code')        ? json.data.status.code : "" );
					var desc = (json.data.status.hasOwnProperty('description') ? json.data.status.description : "" );
					
					var data = (json.data.hasOwnProperty('exemptions') ? json.data.exemptions : "" );
					
					var statut = $("<fieldset />", {  "html": "<legend>Statut</legend>" + val +" (" + code + "): " + desc });
	 
					if ( data ) { 
						reponse = $("<fieldset />", {  "html": "<legend>Réponse</legend>" });
						reponse.append( JsonHuman.format( data ) );
					}
					  
				}

				$("<div />", { 
					"class": "reponse"
				}).insertAfter( $("#consultYoungAvailabilityDecisionHistory form") );
				$("#consultYoungAvailabilityDecisionHistory .reponse").append( statut );
				$("#consultYoungAvailabilityDecisionHistory .reponse").append( "<br />" );
				$("#consultYoungAvailabilityDecisionHistory .reponse").append( reponse );
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