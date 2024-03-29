<ul class="nav nav-tabs">
	<li class="active"><a href="#prime_installation" data-toggle="tab">Prime d'installation</a></li>
	<li><a href="#exonerations" data-toggle="tab">Exonerations</a></li>
	<li><a href="#formulaires" data-toggle="tab">Formulaires</a></li>
	<li><a href="#statut65" data-toggle="tab">Statut65</a></li>
	<li><a href="#exonerations_art35" data-toggle="tab">Exonerations Art35</a></li>
	<li><a href="#a036" data-toggle="tab">A036</a></li>
	<li><a href="#piis" data-toggle="tab">PIIS</a></li>
</ul>
<br />

<div class="tab-content well" id="list_of_attestation">
	<div class="tab-pane fade active in" id="prime_installation">
		<form method="POST" id="form-prime_installation" class="form-horizontal" role="form">
			<div class="form-group has-feedback">
				<label for="registre_national" class="col-md-2 control-label">Registre national :</label>
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
						<input type="text" class="form-control" name="date_debut" placeholder="YYYY-MM-DD">
						<span class="input-group-addon">au</span>
						<input type="text" class="form-control" name="date_fin" placeholder="YYYY-MM-DD">
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

	<div class="tab-pane fade in" id="exonerations">
		<form method="POST" id="form-exonerations" class="form-horizontal" role="form">
			<div class="form-group has-feedback">
				<label for="registre_national" class="col-md-2 control-label">Registre national :</label>
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
						<input type="text" class="form-control" name="date_debut" placeholder="YYYY-MM-DD">
						<span class="input-group-addon">au</span>
						<input type="text" class="form-control" name="date_fin" placeholder="YYYY-MM-DD">
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

	<div class="tab-pane fade in" id="formulaires">
		<form method="POST" id="form-formulaires" class="form-horizontal" role="form">
			<div class="form-group has-feedback">
				<label for="registre_national" class="col-md-2 control-label">Registre national :</label>
				<div class="col-md-3">
					<input type="text" class="form-control" name="registre_national">
					<span class="glyphicon glyphicon-pencil form-control-feedback"></span>
				</div>
			</div>

			<div class="form-group has-feedback">
				<label for="numero_bce" class="col-md-2 control-label">Numéro BCE :</label>
				<div class="col-md-3">
					<input type="text" class="form-control" name="numero_bce" value=$_config["flux"]["cbe_number"]>
					<span class="glyphicon glyphicon-pencil form-control-feedback"></span>
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
			
			<div class="form-group">
				<div class="col-md-offset-2 col-md-3">
					<button type="submit" class="btn btn-primary">Tester</button>
					<button type="reset" class="btn btn-default">Annuler</button>
				</div>
			</div>
		</form>
	</div>

	<div class="tab-pane fade in" id="statut65">
		<form method="POST" id="form-statut65" class="form-horizontal" role="form">
			<div class="form-group has-feedback">
				<label for="registre_national" class="col-md-2 control-label">Registre national :</label>
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
						<input type="text" class="form-control" name="date_debut" placeholder="YYYY-MM-DD">
						<span class="input-group-addon">au</span>
						<input type="text" class="form-control" name="date_fin" placeholder="YYYY-MM-DD">
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

	<div class="tab-pane fade in" id="exonerations_art35">
		<form method="POST" id="form-exonerations_art35" class="form-horizontal" role="form">
			<div class="form-group has-feedback">
				<label for="registre_national" class="col-md-2 control-label">Registre national :</label>
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
						<input type="text" class="form-control" name="date_debut" placeholder="YYYY-MM-DD">
						<span class="input-group-addon">au</span>
						<input type="text" class="form-control" name="date_fin" placeholder="YYYY-MM-DD">
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

	<div class="tab-pane fade in" id="a036">
		<form method="POST" id="form-a036" class="form-horizontal" role="form">
			<div class="form-group has-feedback">
				<label for="registre_national" class="col-md-2 control-label">Registre national :</label>
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
						<input type="text" class="form-control" name="date_debut" placeholder="YYYY-MM-DD">
						<span class="input-group-addon">au</span>
						<input type="text" class="form-control" name="date_fin" placeholder="YYYY-MM-DD">
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
	<div class="tab-pane fade in" id="piis">
		<form method="POST" id="form-piis" class="form-horizontal" role="form">
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
</div>

<script type="text/javascript">
<!--
$(".nav-tabs>li>a").on("click", function() {
	$("#list_of_attestation .reponse").remove();
});

// ******************** //
// Prime d'installation //
// ******************** //
$("#form-prime_installation input[name=date_debut], #form-prime_installation input[name=date_fin]").datepicker({
	format: "yyyy-mm-dd",
	language: "fr",
	orientation: "top left",
	autoclose: true,
	todayHighlight: true
}).on("change", function() {
	var date_debut = $("#form-prime_installation input[name=date_debut]");
	var date_fin = $("#form-prime_installation input[name=date_fin]");

	date_fin.datepicker("setStartDate", date_debut.val());
	date_debut.datepicker("setEndDate", date_fin.val());
});

$("#form-prime_installation").validate({
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
		$("#list_of_attestation .reponse").remove();

		var rn = $("#form-prime_installation input[name=registre_national]").val();
		var date_debut = $("#form-prime_installation input[name=date_debut]").val();
		var date_fin = $("#form-prime_installation input[name=date_fin]").val();

		if (RegistreNational.valider( rn )) {
			var url = "<?php echo $_CONFIG['url']; ?>api/list_of_attestation/prime_installation/consulter?env=<?php echo $_SESSION['test_flux_bcss']['env']; ?>&registre_national=" + rn;
			if (( date_debut != '' ) && ( date_fin != '' )) {
				url += "&date_debut=" + date_debut + "&date_fin=" + date_fin;
			}

			var jqxhr = $.getJSON( url , function(json) { 

				$("#responsejson").getResponsejson(json,'prime_installation');
			
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
				}).insertAfter( $("#list_of_attestation form") );
				$("#list_of_attestation .reponse").append( statut );
				$("#list_of_attestation .reponse").append( "<br />" );
				$("#list_of_attestation .reponse").append( reponse );

			})
			.fail(function() {
			})
			.always(function(){
				$("#wait").hide();
			})

		}

	}
});

// ************ //
// Exonerations //
// ************ //
$("#form-exonerations input[name=date_debut], #form-exonerations input[name=date_fin]").datepicker({
	format: "yyyy-mm-dd",
	language: "fr",
	orientation: "top left",
	autoclose: true,
	todayHighlight: true
}).on("change", function() {
	var date_debut = $("#form-exonerations input[name=date_debut]");
	var date_fin = $("#form-exonerations input[name=date_fin]");

	date_fin.datepicker("setStartDate", date_debut.val());
	date_debut.datepicker("setEndDate", date_fin.val());
});

$("#form-exonerations").validate({
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
		$("#list_of_attestation .reponse").remove();

		var rn = $("#form-exonerations input[name=registre_national]").val();
		var date_debut = $("#form-exonerations input[name=date_debut]").val();
		var date_fin = $("#form-exonerations input[name=date_fin]").val();

		if (RegistreNational.valider( rn )) {
			var url = "<?php echo $_CONFIG['url']; ?>api/list_of_attestation/exonerations/consulter?env=<?php echo $_SESSION['test_flux_bcss']['env']; ?>&registre_national=" + rn;
			if (( date_debut != '' ) && ( date_fin != '' )) {
				url += "&date_debut=" + date_debut + "&date_fin=" + date_fin;
			}

			var jqxhr = $.getJSON( url , function(json) { 

				$("#responsejson").getResponsejson(json,'exonerations');
			
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
				}).insertAfter( $("#list_of_attestation form") );
				$("#list_of_attestation .reponse").append( statut );
				$("#list_of_attestation .reponse").append( "<br />" );
				$("#list_of_attestation .reponse").append( reponse );

			})
			.fail(function() {
			})
			.always(function(){
				$("#wait").hide();
			})

		}

	}
});

// *********** //
// Formulaires //
// *********** //
$("#form-formulaires input[name=date_debut], #form-formulaires input[name=date_fin]").datepicker({
	format: "yyyy-mm-dd",
	language: "fr",
	orientation: "top left",
	autoclose: true,
	todayHighlight: true
}).on("change", function() {
	var date_debut = $("#form-formulaires input[name=date_debut]");
	var date_fin = $("#form-formulaires input[name=date_fin]");

	date_fin.datepicker("setStartDate", date_debut.val());
	date_debut.datepicker("setEndDate", date_fin.val());
});

$("#form-formulaires").validate({
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
		$("#list_of_attestation .reponse").remove();

		var rn = $("#form-formulaires input[name=registre_national]").val();
		var numero_bce = $("#form-formulaires input[name=numero_bce]").val();
		var date_debut = $("#form-formulaires input[name=date_debut]").val();
		var date_fin = $("#form-formulaires input[name=date_fin]").val();

		if (RegistreNational.valider( rn )) {
			var url = "<?php echo $_CONFIG['url']; ?>api/list_of_attestation/formulaires/consulter?env=<?php echo $_SESSION['test_flux_bcss']['env']; ?>&registre_national=" + rn + "&numero_bce=" + numero_bce;
			if (( date_debut != '' ) && ( date_fin != '' )) {
				url += "&date_debut=" + date_debut + "&date_fin=" + date_fin;
			}

			var jqxhr = $.getJSON( url , function(json) {

				$("#responsejson").getResponsejson(json,'formulaires');
				
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
				}).insertAfter( $("#list_of_attestation form") );
				$("#list_of_attestation .reponse").append( statut );
				$("#list_of_attestation .reponse").append( "<br />" );
				$("#list_of_attestation .reponse").append( reponse );

			})
			.fail(function() {
			})
			.always(function(){
				$("#wait").hide();
			})

		}

	}
});

// ******** //
// Statut65 //
// ******** //
$("#form-statut65 input[name=date_debut], #form-statut65 input[name=date_fin]").datepicker({
	format: "yyyy-mm-dd",
	language: "fr",
	orientation: "top left",
	autoclose: true,
	todayHighlight: true
}).on("change", function() {
	var date_debut = $("#form-statut65 input[name=date_debut]");
	var date_fin = $("#form-statut65 input[name=date_fin]");

	date_fin.datepicker("setStartDate", date_debut.val());
	date_debut.datepicker("setEndDate", date_fin.val());
});

$("#form-statut65").validate({
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
		$("#list_of_attestation .reponse").remove();

		var rn = $("#form-statut65 input[name=registre_national]").val();
		var date_debut = $("#form-statut65 input[name=date_debut]").val();
		var date_fin = $("#form-statut65 input[name=date_fin]").val();

		if (RegistreNational.valider( rn )) {
			var url = "<?php echo $_CONFIG['url']; ?>api/list_of_attestation/statut65/consulter?env=<?php echo $_SESSION['test_flux_bcss']['env']; ?>&registre_national=" + rn;
			if (( date_debut != '' ) && ( date_fin != '' )) {
				url += "&date_debut=" + date_debut + "&date_fin=" + date_fin;
			}

			var jqxhr = $.getJSON( url , function(json) {

				$("#responsejson").getResponsejson(json,'statut65');
				
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
				}).insertAfter( $("#list_of_attestation form") );
				$("#list_of_attestation .reponse").append( statut );
				$("#list_of_attestation .reponse").append( "<br />" );
				$("#list_of_attestation .reponse").append( reponse );

			})
			.fail(function() {
			})
			.always(function(){
				$("#wait").hide();
			})

		}

	}
});

// ****************** //
// Exonerations Art35 //
// ****************** //
$("#form-exonerations_art35 input[name=date_debut], #form-exonerations_art35 input[name=date_fin]").datepicker({
	format: "yyyy-mm-dd",
	language: "fr",
	orientation: "top left",
	autoclose: true,
	todayHighlight: true
}).on("change", function() {
	var date_debut = $("#form-exonerations_art35 input[name=date_debut]");
	var date_fin = $("#form-exonerations_art35 input[name=date_fin]");

	date_fin.datepicker("setStartDate", date_debut.val());
	date_debut.datepicker("setEndDate", date_fin.val());
});

$("#form-exonerations_art35").validate({
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
		$("#list_of_attestation .reponse").remove();

		var rn = $("#form-exonerations_art35 input[name=registre_national]").val();
		var date_debut = $("#form-exonerations_art35 input[name=date_debut]").val();
		var date_fin = $("#form-exonerations_art35 input[name=date_fin]").val();

		if (RegistreNational.valider( rn )) {
			var url = "<?php echo $_CONFIG['url']; ?>api/list_of_attestation/exonerations_art35/consulter?env=<?php echo $_SESSION['test_flux_bcss']['env']; ?>&registre_national=" + rn;
			if (( date_debut != '' ) && ( date_fin != '' )) {
				url += "&date_debut=" + date_debut + "&date_fin=" + date_fin;
			}

			var jqxhr = $.getJSON( url , function(json) {

				$("#responsejson").getResponsejson(json,'exonerations_art35');
				
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
				}).insertAfter( $("#list_of_attestation form") );
				$("#list_of_attestation .reponse").append( statut );
				$("#list_of_attestation .reponse").append( "<br />" );
				$("#list_of_attestation .reponse").append( reponse );

			})
			.fail(function() {
			})
			.always(function(){
				$("#wait").hide();
			})

		}

	}
});

// *****//
// A036 //
// **** //
$("#form-a036 input[name=date_debut], #form-a036 input[name=date_fin]").datepicker({
	format: "yyyy-mm-dd",
	language: "fr",
	orientation: "top left",
	autoclose: true,
	todayHighlight: true
}).on("change", function() {
	var date_debut = $("#form-a036 input[name=date_debut]");
	var date_fin = $("#form-a036 input[name=date_fin]");

	date_fin.datepicker("setStartDate", date_debut.val());
	date_debut.datepicker("setEndDate", date_fin.val());
});

$("#form-a036").validate({
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
		$("#list_of_attestation .reponse").remove();

		var rn = $("#form-a036 input[name=registre_national]").val();
		var date_debut = $("#form-a036 input[name=date_debut]").val();
		var date_fin = $("#form-a036 input[name=date_fin]").val();

		if (RegistreNational.valider( rn )) {
			var url = "<?php echo $_CONFIG['url']; ?>api/list_of_attestation/a036/consulter?env=<?php echo $_SESSION['test_flux_bcss']['env']; ?>&registre_national=" + rn;
			if (( date_debut != '' ) && ( date_fin != '' )) {
				url += "&date_debut=" + date_debut + "&date_fin=" + date_fin;
			}

			var jqxhr = $.getJSON( url , function(json) {

				$("#responsejson").getResponsejson(json,'a036');
				
				var reponse = $("<fieldset />", { "html": "<legend>Réponse</legend>PAS DE DONNEES" });

				if(json.succes != 0 )  {
		
					var val =  (json.data.status.hasOwnProperty('value')       ? json.data.status.value : "" );
					var code = (json.data.status.hasOwnProperty('code')        ? json.data.status.code : "" );
					var desc = (json.data.status.hasOwnProperty('description') ? json.data.status.description : "" );
		
					var data = (json.hasOwnProperty('data') ? json.data : "" );
		
					var statut = $("<fieldset />", {  "html": "<legend>Statut</legend>" + val +" (" + code + "): " + desc });

					if ( data ) { 
						reponse = $("<fieldset />", {  "html": "<legend>Réponse</legend>" });
						reponse.append( JsonHuman.format( data ) );
					}
			  
				}

				$("<div />", { 
					"class": "reponse"
				}).insertAfter( $("#list_of_attestation form") );
				$("#list_of_attestation .reponse").append( statut );
				$("#list_of_attestation .reponse").append( "<br />" );
				$("#list_of_attestation .reponse").append( reponse );

			})
			.fail(function() {
			})
			.always(function(){
				$("#wait").hide();
			})
		}
	}
});
$("#form-piis").validate({
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
		$("#list_of_attestation .reponse").remove();

		var rn = $("#form-piis input[name=registre_national]").val();

		if (RegistreNational.valider( rn )) {
			var url = "<?php echo $_CONFIG['url']; ?>api/list_of_attestation/piis/consulter?env=<?php echo $_SESSION['test_flux_bcss']['env']; ?>&registre_national=" + rn;

			var jqxhr = $.getJSON( url , function(json) {

				$("#responsejson").getResponsejson(json,'piis');
				
				var reponse = $("<fieldset />", { "html": "<legend>Réponse</legend>PAS DE DONNEES" });

				if(json.succes != 0 )  {
		
					var val =  (json.data.status.hasOwnProperty('value')       ? json.data.status.value : "" );
					var code = (json.data.status.hasOwnProperty('code')        ? json.data.status.code : "" );
					var desc = (json.data.status.hasOwnProperty('description') ? json.data.status.description : "" );
		
					var data = (json.hasOwnProperty('data') ? json.data : "" );
		
					var statut = $("<fieldset />", {  "html": "<legend>Statut</legend>" + val +" (" + code + "): " + desc });

					if ( data ) { 
						reponse = $("<fieldset />", {  "html": "<legend>Réponse</legend>" });
						reponse.append( JsonHuman.format( data ) );
					}
			  
				}

				$("<div />", { 
					"class": "reponse"
				}).insertAfter( $("#list_of_attestation form") );
				$("#list_of_attestation .reponse").append( statut );
				$("#list_of_attestation .reponse").append( "<br />" );
				$("#list_of_attestation .reponse").append( reponse );

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