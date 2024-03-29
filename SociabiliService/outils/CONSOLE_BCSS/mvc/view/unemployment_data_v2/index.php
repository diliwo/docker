<ul class="nav nav-tabs">

	<li class="active"><a href="#sommes_payees_activation" data-toggle="tab"> Activation des sommes payées</a></li>
	<li><a href="#droits" data-toggle="tab">                   Droits</a></li>
	<li><a href="#situation" data-toggle="tab">                Situation </a></li>
	<li><a href="#sommes_payees" data-toggle="tab">            Sommes payées</a></li>
	<li><a href="#paiements" data-toggle="tab">                Paiements</a></li>
	<li><a href="#sommes_paiement_prevu" data-toggle="tab">    Paiement prévu</a></li>
	<li><a href="#interruption_carriere" data-toggle="tab">    Interruption de carrière</a></li>

</ul>

<br />
<div class="tab-content well">
	<div class="tab-pane fade active in" id="sommes_payees_activation">
		<form id="form-data-sommes_payees_activation" class="form-horizontal" role="form">
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
						<option value="1" <?php echo (preg_match("/[1-3]/",     date("m") ) ? 'selected="selected"' : '');?>>Premier</option>
						<option value="2" <?php echo (preg_match("/[4-6]/",     date("m") ) ? 'selected="selected"' : '');?>>Deuxième</option>
						<option value="3" <?php echo (preg_match("/[7-9]/",     date("m") ) ? 'selected="selected"' : '');?>>Troisième</option>
						<option value="4" <?php echo (preg_match("/(10|11|12)/",date("m") ) ? 'selected="selected"' : '');?>>Quatrième</option> 
					</select>
				</div>
			</div>

			<div class="form-group">
				<label for="annee" class="col-md-2 control-label">Année: </label>
				<div class="col-md-2">
					<input type="text" class="form-control" name="annee" placeholder="YYYY">
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
	
	<div class="tab-pane fade in" id="droits">
		<form id="form-data-droits" class="form-horizontal" role="form">
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
	
	<div class="tab-pane fade in" id="situation">
		<form id="form-data-situation" class="form-horizontal" role="form">
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
		<form id="form-data-sommes_payees" class="form-horizontal" role="form">
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
	
	<div class="tab-pane fade in" id="paiements">
		<form id="form-data-paiements" class="form-horizontal" role="form">
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

	<div class="tab-pane fade in" id="sommes_paiement_prevu">
		<form id="form-data-sommes_paiement_prevu" class="form-horizontal" role="form">
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
						<option value="1" <?php echo (preg_match("/[1-3]/",     date("m") ) ? 'selected="selected"' : '');?>>Premier</option>
						<option value="2" <?php echo (preg_match("/[4-6]/",     date("m") ) ? 'selected="selected"' : '');?>>Deuxième</option>
						<option value="3" <?php echo (preg_match("/[7-9]/",     date("m") ) ? 'selected="selected"' : '');?>>Troisième</option>
						<option value="4" <?php echo (preg_match("/(10|11|12)/",date("m") ) ? 'selected="selected"' : '');?>>Quatrième</option> 
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
	
	<div class="tab-pane fade in" id="sommes_payees_activation">
		<form id="form-data-sommes_payees_activation" class="form-horizontal" role="form">
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

	<div class="tab-pane fade in" id="interruption_carriere">
		<form id="form-data-interruption_carriere" class="form-horizontal" role="form">
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
	
</div>

<script type="text/javascript">
<!--

// ***consultActivationPaidSums*** //

// ************************* //
// Activation sommes payées  //
// ************************* //
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
			var url = "<?php echo $_CONFIG['url']; ?>api/unemployment_data/v2/consulter/sommes_payees_activation?env=<?php echo $_SESSION['test_flux_bcss']['env']; ?>&registre_national=" + rn + "&quadrimestre=" + quadrimestre + "&annee=" + annee;

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

// ***consultRights*** //

// ****** //
// Droits //
// ****** //
$("#droits form input[name=date]").datepicker({
	format: "yyyy-mm-dd",
	language: "fr",
	orientation: "top left",
	autoclose: true,
	todayHighlight: true
});
$("#droits form button[type=reset]").on( "click", function() {
	$("#droits form input[name=registre_national]").closest(".has-feedback").find(".glyphicon").removeClass("glyphicon-ok glyphicon-remove").addClass("glyphicon-pencil");
	$("#droits form input[name=registre_national]").closest(".has-feedback").removeClass("has-success has-error");
	$(".help-block").remove();
	$("#droits .reponse").remove();
});

$("#droits form").validate({
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
		$("#droits .reponse").remove();

		var rn = $("#droits form input[name=registre_national]").val();
		var date = $("#droits form input[name=date]").val();
		if (RegistreNational.valider( rn )) {
			var url = "<?php echo $_CONFIG['url']; ?>api/unemployment_data/v2/consulter/droits?env=<?php echo $_SESSION['test_flux_bcss']['env']; ?>&registre_national=" + rn;
			if ( date != '' ) {
				url += "&date=" + date;
			}

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
				}).insertAfter( $("#droits form") );
				$("#droits .reponse").append( statut );
				$("#droits .reponse").append( "<br />" );
				$("#droits .reponse").append( reponse );
			})
			.fail(function() {
			})
			.always(function(){
				$("#wait").hide();
			})
		}
	}
});

// ***consultSituation*** //

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
			var url = "<?php echo $_CONFIG['url']; ?>api/unemployment_data/v2/consulter/situation?env=<?php echo $_SESSION['test_flux_bcss']['env']; ?>&registre_national=" + rn;
			if ( date != '' ) {
				url += "&date=" + date;
			}

			var jqxhr = $.getJSON( url , function(json) {

				$("#responsejson").getResponsejson(json,'consultSituation'); 
				
				var reponse = $("<fieldset />", { "html": "<legend>Réponse</legend>PAS DE DONNEES" });

				if(json.succes != 0 )  {
				
					var val =  (json.data.status.hasOwnProperty('value')       ? json.data.status.value : "" );
					var code = (json.data.status.hasOwnProperty('code')        ? json.data.status.code : "" );
					var desc = (json.data.status.hasOwnProperty('description') ? json.data.status.description : "" );
				
					var data = (json.data.hasOwnProperty('situation') ? json.data.situation : "" );
				
					var statut = $("<fieldset />", {  "html": "<legend>Statut</legend>" + val +" (" + code + "): " + desc });
 
					if ( data ) { 
						reponse = $("<fieldset />", {  "html": "<legend>Réponse</legend>" });
						reponse.append( JsonHuman.format( data ) );
					}
				  
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

// ***consultPaidSums*** //

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

	date_debut.datepicker('setStartDate', date_debut.val());
	date_fin.datepicker('setEndDate', date_fin.val());
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
		var date_fin = $("#sommes_payees form input[name=date_fin]").val();
		if (RegistreNational.valider( rn )) {
			var url = "<?php echo $_CONFIG['url']; ?>api/unemployment_data/v2/consulter/sommes_payees?env=<?php echo $_SESSION['test_flux_bcss']['env']; ?>&registre_national=" + rn;
			if (( date_debut != '' ) && ( date_fin != '' )) {
				url += "&date_debut=" + date_debut + "&date_fin=" + date_fin;
			}

			var jqxhr = $.getJSON( url , function(json) {

				$("#responsejson").getResponsejson(json,'consultPaidSums'); 
				
				var reponse = $("<fieldset />", { "html": "<legend>Réponse</legend>PAS DE DONNEES" });

				if(json.succes != 0 )  {
				
					var val =  (json.data.status.hasOwnProperty('value')       ? json.data.status.value : "" );
					var code = (json.data.status.hasOwnProperty('code')        ? json.data.status.code : "" );
					var desc = (json.data.status.hasOwnProperty('description') ? json.data.status.description : "" );
				
					var data = (json.data.hasOwnProperty('paidSums') ? json.data.paidSums : "" );
				
					var statut = $("<fieldset />", {  "html": "<legend>Statut</legend>" + val +" (" + code + "): " + desc });
 
					if ( data ) { 
						reponse = $("<fieldset />", {  "html": "<legend>Réponse</legend>" });
						reponse.append( JsonHuman.format( data ) );
					}
				  
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

// ***consultPayments*** //

// ********* //
// Paiements //
// ********* //
$("#paiements form input[name=date]").datepicker({
	format: "yyyy-mm-dd",
	language: "fr",
	orientation: "top left",
	autoclose: true,
	todayHighlight: true
});
$("#paiements form button[type=reset]").on( "click", function() {
	$("#paiements form input[name=registre_national]").closest(".has-feedback").find(".glyphicon").removeClass("glyphicon-ok glyphicon-remove").addClass("glyphicon-pencil");
	$("#paiements form input[name=registre_national]").closest(".has-feedback").removeClass("has-success has-error");
	$(".help-block").remove();
	$("#paiements .reponse").remove();
});

$("#paiements form").validate({
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
		$("#paiements .reponse").remove();

		var rn = $("#paiements form input[name=registre_national]").val();
		var date = $("#paiements form input[name=date]").val();
		if (RegistreNational.valider( rn )) {
			var url = "<?php echo $_CONFIG['url']; ?>api/unemployment_data/v2/consulter/paiements?env=<?php echo $_SESSION['test_flux_bcss']['env']; ?>&registre_national=" + rn;
			if ( date != '' ) {
				url += "&date=" + date;
			}

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
				}).insertAfter( $("#paiements form") );
				$("#paiements .reponse").append( statut );
				$("#paiements .reponse").append( "<br />" );
				$("#paiements .reponse").append( reponse );
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

// ******************* //
// Sommes paiement prevu //
// ******************* //
$("#sommes_paiement_prevu form input[name=annee]").datepicker({
	format: "yyyy",
	language: "fr",
	orientation: "top left",
	minViewMode: 2,
	autoclose: true,
	todayHighlight: true
});
$("#sommes_paiement_prevu form button[type=reset]").on( "click", function() {
	$("#sommes_paiement_prevu form input[name=registre_national]").closest(".has-feedback").find(".glyphicon").removeClass("glyphicon-ok glyphicon-remove").addClass("glyphicon-pencil");
	$("#sommes_paiement_prevu form input[name=registre_national]").closest(".has-feedback").removeClass("has-success has-error");
	$(".help-block").remove();
	$("#sommes_paiement_prevu .reponse").remove();
})
$("#sommes_paiement_prevu form").validate({
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
		$("#sommes_paiement_prevu .reponse").remove();

		var rn = $("#sommes_paiement_prevu form input[name=registre_national]").val();
		var quadrimestre = $("#sommes_paiement_prevu form select[name=quadrimestre]").val();
		var annee = $("#sommes_paiement_prevu form input[name=annee]").val();
		if (RegistreNational.valider( rn )) {
			var url = "<?php echo $_CONFIG['url']; ?>api/unemployment_data/v2/consulter/sommes_paiement_prevu?env=<?php echo $_SESSION['test_flux_bcss']['env']; ?>&registre_national=" + rn + "&quadrimestre=" + quadrimestre + "&annee=" + annee;

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
				}).insertAfter( $("#sommes_paiement_prevu form") );
				$("#sommes_paiement_prevu .reponse").append( statut );
				$("#sommes_paiement_prevu .reponse").append( "<br />" );
				$("#sommes_paiement_prevu .reponse").append( reponse );
			})
			.fail(function() {
			})
			.always(function(){
				$("#wait").hide();
			})
		}
	}
});

// ***careerBreaks*** //

// ********************* //
// Interruption carrière //
// ********************* //
$("#interruption_carriere form input[name=date_debut], #interruption_carriere form input[name=date_fin]").datepicker({
	format: "yyyy-mm",
	language: "fr",
	orientation: "top left",
	minViewMode: 1,
	autoclose: true,
	todayHighlight: true
}).on("change", function() {
	var date_debut = $("#interruption_carriere form input[name=date_debut]");
	var date_fin = $("#interruption_carriere form input[name=date_fin]");

	date_debut.datepicker('setStartDate', date_debut.val());
	date_fin.datepicker('setEndDate', date_fin.val());
});
$("#interruption_carriere form button[type=reset]").on( "click", function() {
	$("#interruption_carriere form input[name=registre_national]").closest(".has-feedback").find(".glyphicon").removeClass("glyphicon-ok glyphicon-remove").addClass("glyphicon-pencil");
	$("#interruption_carriere form input[name=registre_national]").closest(".has-feedback").removeClass("has-success has-error");
	$(".help-block").remove();
	$("#interruption_carriere .reponse").remove();
})
$("#interruption_carriere form").validate({
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
		$("#interruption_carriere .reponse").remove();

		var rn = $("#interruption_carriere form input[name=registre_national]").val();
		var date_debut = $("#interruption_carriere form input[name=date_debut]").val();
		var date_fin = $("#interruption_carriere form input[name=date_fin]").val();
		if (RegistreNational.valider( rn )) {
			var url = "<?php echo $_CONFIG['url']; ?>api/unemployment_data/v2/consulter/interruption_carriere?env=<?php echo $_SESSION['test_flux_bcss']['env']; ?>&registre_national=" + rn;
			if (( date_debut != '' ) && ( date_fin != '' )) {
				url += "&date_debut=" + date_debut + "&date_fin=" + date_fin;
			}

			var jqxhr = $.getJSON( url , function(json) { 

				$("#responsejson").getResponsejson(json,'careerBreaks');
				
				var reponse = $("<fieldset />", { "html": "<legend>Réponse</legend>PAS DE DONNEES" });

				if(json.succes != 0 )  {
			
					var val =  (json.data.status.hasOwnProperty('value')       ? json.data.status.value : "" );
					var code = (json.data.status.hasOwnProperty('code')        ? json.data.status.code : "" );
					var desc = (json.data.status.hasOwnProperty('description') ? json.data.status.description : "" );
			
					var data = (json.data.hasOwnProperty('careerBreaks') ? json.data.careerBreaks : "" );
			
					var statut = $("<fieldset />", {  "html": "<legend>Statut</legend>" + val +" (" + code + "): " + desc });

					if ( data ) { 
						reponse = $("<fieldset />", {  "html": "<legend>Réponse</legend>" });
						reponse.append( JsonHuman.format( data ) );
					}
			  
				}
				 
				$("<div />", { 
					"class": "reponse"
				}).insertAfter( $("#interruption_carriere form") );
				$("#interruption_carriere .reponse").append( statut );
				$("#interruption_carriere .reponse").append( "<br />" );
				$("#interruption_carriere .reponse").append( reponse );
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