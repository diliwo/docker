<ul class="nav nav-tabs">
	<li class="active"><a href="#getLivingWagePeriods" data-toggle="tab">  Uniquement périodes d'intégration sociale </a></li>
	<li><a href="#getLivingWagePeriodsFlanders" data-toggle="tab">         Intégration sociale en Flandre </a></li>
	<li><a href="#getLivingWagePeriodsPerPCSA" data-toggle="tab">          Périodes d'intégration regroupées par CPAS  </a></li>
	<li><a href="#getLivingWagePeriodsPerPCSAFlanders" data-toggle="tab">  Intégration sociale en Flandre (par les CPAS flamands) </a></li>
	<li><a href="#getLivingWages" data-toggle="tab">                       Périodes regroupées par CPAS et la catégorie d'intégration sociale </a></li>
</ul>

<br />

<div class="tab-content well">

	<div class="tab-pane fade active in" id="getLivingWagePeriods">
		<form id="form-getLivingWagePeriods" class="form-horizontal" role="form">
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
	
	<div class="tab-pane fade in" id="getLivingWagePeriodsFlanders">
		<form id="form-getLivingWagePeriodsFlanders" class="form-horizontal" role="form">
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
	
	<div class="tab-pane fade in" id="getLivingWagePeriodsPerPCSA">
		<form id="form-getLivingWagePeriodsPerPCSA" class="form-horizontal" role="form">
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
	
	<div class="tab-pane fade in" id="getLivingWagePeriodsPerPCSAFlanders">
		<form id="form-getLivingWagePeriodsPerPCSAFlanders" class="form-horizontal" role="form">
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
	
		<div class="tab-pane fade in" id="getLivingWages">
		<form id="form-getLivingWages" class="form-horizontal" role="form">
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




<script>

// ***getLivingWagePeriods*** //

//******************** //
// Living Wage Periods //
//******************** //

$("#getLivingWagePeriods form input[name=date_debut], #getLivingWagePeriods form input[name=date_fin]").datepicker({
	format: "yyyy-mm-dd",
	language: "fr",
	orientation: "top left",
	autoclose: true,
	todayHighlight: true
	
}).on("change", function() {
	var date_debut = $("#getLivingWagePeriods form input[name=date_debut]");
	var date_fin = $("#getLivingWagePeriods form input[name=date_fin]");

	date_debut.datepicker('setStartDate', date_debut.val());
	date_fin.datepicker('setEndDate', date_fin.val());
});

$("#getLivingWagePeriods form button[type=reset]").on( "click", function() {
	$("#getLivingWagePeriods form input[name=registre_national]").closest(".has-feedback").find(".glyphicon").removeClass("glyphicon-ok glyphicon-remove").addClass("glyphicon-pencil");
	$("#getLivingWagePeriods form input[name=registre_national]").closest(".has-feedback").removeClass("has-success has-error");
	$(".help-block").remove();
	$("#getLivingWagePeriods .reponse").remove();
});

$("#getLivingWagePeriods form").validate({
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
		$("#getLivingWagePeriods .reponse").remove();

		var rn = $("#getLivingWagePeriods form input[name=registre_national]").val();
		var date_debut = $("#getLivingWagePeriods form input[name=date_debut]").val();
		var date_fin = $("#getLivingWagePeriods form input[name=date_fin]").val();
		
		if (RegistreNational.valider( rn )) {
			
			var params = "&date_debut="+ date_debut + "&date_fin="+ date_fin;
			
			var url = "<?php echo $_CONFIG['url']; ?>api/living_wages/consulter/getLivingWagePeriods?env=<?php echo $_SESSION['test_flux_bcss']['env']; ?>&registre_national=" + rn + params;
			
			var jqxhr = $.getJSON( url , function(json) {

				$("#responsejson").getResponsejson(json, 'getLivingWagePeriods');	 
				
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
				}).insertAfter( $("#getLivingWagePeriods form") );
				$("#getLivingWagePeriods .reponse").append( statut );
				$("#getLivingWagePeriods .reponse").append( "<br />" );
				$("#getLivingWagePeriods .reponse").append( reponse );
			})
			.fail(function() {
			})
			.always(function(){
				$("#wait").hide();
			})
		}
	}
});


//***getLivingWagePeriodsFlanders*** //

//*********************************** //
// //
//*********************************** //

$("#getLivingWagePeriodsFlanders form input[name=date_debut], #getLivingWagePeriodsFlanders form input[name=date_fin]").datepicker({
	format: "yyyy-mm-dd",
	language: "fr",
	orientation: "top left",
	autoclose: true,
	todayHighlight: true
	
}).on("change", function() {
	var date_debut = $("#getLivingWagePeriodsFlanders form input[name=date_debut]");
	var date_fin = $("#getLivingWagePeriodsFlanders form input[name=date_fin]");

	date_debut.datepicker('setStartDate', date_debut.val());
	date_fin.datepicker('setEndDate', date_fin.val());
});

$("#getLivingWagePeriodsFlanders form button[type=reset]").on( "click", function() {
	$("#getLivingWagePeriodsFlanders form input[name=registre_national]").closest(".has-feedback").find(".glyphicon").removeClass("glyphicon-ok glyphicon-remove").addClass("glyphicon-pencil");
	$("#getLivingWagePeriodsFlanders form input[name=registre_national]").closest(".has-feedback").removeClass("has-success has-error");
	$(".help-block").remove();
	$("#getLivingWagePeriodsFlanders .reponse").remove();
});

$("#getLivingWagePeriodsFlanders form").validate({
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
		$("#getLivingWagePeriodsFlanders .reponse").remove();

		var rn = $("#getLivingWagePeriodsFlanders form input[name=registre_national]").val();
		var date_debut = $("#getLivingWagePeriodsFlanders form input[name=date_debut]").val();
		var date_fin = $("#getLivingWagePeriodsFlanders form input[name=date_fin]").val();
		
		if (RegistreNational.valider( rn )) {
			
			var params = "&date_debut="+ date_debut + "&date_fin="+ date_fin;
			
			var url = "<?php echo $_CONFIG['url']; ?>api/living_wages/consulter/getLivingWagePeriodsFlanders?env=<?php echo $_SESSION['test_flux_bcss']['env']; ?>&registre_national=" + rn + params;
			
			var jqxhr = $.getJSON( url , function(json) {

				$("#responsejson").getResponsejson(json, 'getLivingWagePeriodsFlanders');	 
				
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
				}).insertAfter( $("#getLivingWagePeriodsFlanders form") );
				$("#getLivingWagePeriodsFlanders .reponse").append( statut );
				$("#getLivingWagePeriodsFlanders .reponse").append( "<br />" );
				$("#getLivingWagePeriodsFlanders .reponse").append( reponse );
			})
			.fail(function() {
			})
			.always(function(){
				$("#wait").hide();
			})
		}
	}
});



//***getLivingWagePeriodsPerPCSA*** //

//*********************************** //
////
//*********************************** //

$("#getLivingWagePeriodsPerPCSA form input[name=date_debut], #getLivingWagePeriodsPerPCSA form input[name=date_fin]").datepicker({
	format: "yyyy-mm-dd",
	language: "fr",
	orientation: "top left",
	autoclose: true,
	todayHighlight: true
	
}).on("change", function() {
	var date_debut = $("#getLivingWagePeriodsPerPCSA form input[name=date_debut]");
	var date_fin = $("#getLivingWagePeriodsPerPCSA form input[name=date_fin]");

	date_debut.datepicker('setStartDate', date_debut.val());
	date_fin.datepicker('setEndDate', date_fin.val());
});

$("#getLivingWagePeriodsPerPCSA form button[type=reset]").on( "click", function() {
	$("#getLivingWagePeriodsPerPCSA form input[name=registre_national]").closest(".has-feedback").find(".glyphicon").removeClass("glyphicon-ok glyphicon-remove").addClass("glyphicon-pencil");
	$("#getLivingWagePeriodsPerPCSA form input[name=registre_national]").closest(".has-feedback").removeClass("has-success has-error");
	$(".help-block").remove();
	$("#getLivingWagePeriodsPerPCSA .reponse").remove();
});

$("#getLivingWagePeriodsPerPCSA form").validate({
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
		$("#getLivingWagePeriodsPerPCSA .reponse").remove();

		var rn = $("#getLivingWagePeriodsPerPCSA form input[name=registre_national]").val();
		var date_debut = $("#getLivingWagePeriodsPerPCSA form input[name=date_debut]").val();
		var date_fin = $("#getLivingWagePeriodsPerPCSA form input[name=date_fin]").val();
		
		if (RegistreNational.valider( rn )) {
			
			var params = "&date_debut="+ date_debut + "&date_fin="+ date_fin;
			
			var url = "<?php echo $_CONFIG['url']; ?>api/living_wages/consulter/getLivingWagePeriodsPerPCSA?env=<?php echo $_SESSION['test_flux_bcss']['env']; ?>&registre_national=" + rn + params;
			
			var jqxhr = $.getJSON( url , function(json) {

				$("#responsejson").getResponsejson(json, 'getLivingWagePeriodsPerPCSA');	 
				
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
				}).insertAfter( $("#getLivingWagePeriodsPerPCSA form") );
				$("#getLivingWagePeriodsPerPCSA .reponse").append( statut );
				$("#getLivingWagePeriodsPerPCSA .reponse").append( "<br />" );
				$("#getLivingWagePeriodsPerPCSA .reponse").append( reponse );
			})
			.fail(function() {
			})
			.always(function(){
				$("#wait").hide();
			})
		}
	}
});



//***getLivingWagePeriodsPerPCSAFlanders*** //

//*********************************** //
////
//*********************************** //

$("#getLivingWagePeriodsPerPCSAFlanders form input[name=date_debut], #getLivingWagePeriodsPerPCSAFlanders form input[name=date_fin]").datepicker({
	format: "yyyy-mm-dd",
	language: "fr",
	orientation: "top left",
	autoclose: true,
	todayHighlight: true
	
}).on("change", function() {
	var date_debut = $("#getLivingWagePeriodsPerPCSAFlanders form input[name=date_debut]");
	var date_fin = $("#getLivingWagePeriodsPerPCSAFlanders form input[name=date_fin]");

	date_debut.datepicker('setStartDate', date_debut.val());
	date_fin.datepicker('setEndDate', date_fin.val());
});

$("#getLivingWagePeriodsPerPCSAFlanders form button[type=reset]").on( "click", function() {
	$("#getLivingWagePeriodsPerPCSAFlanders form input[name=registre_national]").closest(".has-feedback").find(".glyphicon").removeClass("glyphicon-ok glyphicon-remove").addClass("glyphicon-pencil");
	$("#getLivingWagePeriodsPerPCSAFlanders form input[name=registre_national]").closest(".has-feedback").removeClass("has-success has-error");
	$(".help-block").remove();
	$("#getLivingWagePeriodsPerPCSAFlanders .reponse").remove();
});

$("#getLivingWagePeriodsPerPCSAFlanders form").validate({
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
		$("#getLivingWagePeriodsPerPCSAFlanders .reponse").remove();

		var rn = $("#getLivingWagePeriodsPerPCSAFlanders form input[name=registre_national]").val();
		var date_debut = $("#getLivingWagePeriodsPerPCSAFlanders form input[name=date_debut]").val();
		var date_fin = $("#getLivingWagePeriodsPerPCSAFlanders form input[name=date_fin]").val();
		
		if (RegistreNational.valider( rn )) {
			
			var params = "&date_debut="+ date_debut + "&date_fin="+ date_fin;
			
			var url = "<?php echo $_CONFIG['url']; ?>api/living_wages/consulter/getLivingWagePeriodsPerPCSAFlanders?env=<?php echo $_SESSION['test_flux_bcss']['env']; ?>&registre_national=" + rn + params;
			
			var jqxhr = $.getJSON( url , function(json) {

				$("#responsejson").getResponsejson(json, 'getLivingWagePeriodsPerPCSAFlanders');	 
				
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
				}).insertAfter( $("#getLivingWagePeriodsPerPCSAFlanders form") );
				$("#getLivingWagePeriodsPerPCSAFlanders .reponse").append( statut );
				$("#getLivingWagePeriodsPerPCSAFlanders .reponse").append( "<br />" );
				$("#getLivingWagePeriodsPerPCSAFlanders .reponse").append( reponse );
			})
			.fail(function() {
			})
			.always(function(){
				$("#wait").hide();
			})
		}
	}
});



//***getLivingWages*** //

//*********************************** //
////
//*********************************** //

$("#getLivingWages form input[name=date_debut], #getLivingWages form input[name=date_fin]").datepicker({
	format: "yyyy-mm-dd",
	language: "fr",
	orientation: "top left",
	autoclose: true,
	todayHighlight: true
	
}).on("change", function() {
	var date_debut = $("#getLivingWages form input[name=date_debut]");
	var date_fin = $("#getLivingWages form input[name=date_fin]");

	date_debut.datepicker('setStartDate', date_debut.val());
	date_fin.datepicker('setEndDate', date_fin.val());
});

$("#getLivingWages form button[type=reset]").on( "click", function() {
	$("#getLivingWages form input[name=registre_national]").closest(".has-feedback").find(".glyphicon").removeClass("glyphicon-ok glyphicon-remove").addClass("glyphicon-pencil");
	$("#getLivingWages form input[name=registre_national]").closest(".has-feedback").removeClass("has-success has-error");
	$(".help-block").remove();
	$("#getLivingWages .reponse").remove();
});

$("#getLivingWages form").validate({
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
		$("#getLivingWages .reponse").remove();

		var rn = $("#getLivingWages form input[name=registre_national]").val();
		var date_debut = $("#getLivingWages form input[name=date_debut]").val();
		var date_fin = $("#getLivingWages form input[name=date_fin]").val();
		
		if (RegistreNational.valider( rn )) {
			
			var params = "&date_debut="+ date_debut + "&date_fin="+ date_fin;
			
			var url = "<?php echo $_CONFIG['url']; ?>api/living_wages/consulter/getLivingWages?env=<?php echo $_SESSION['test_flux_bcss']['env']; ?>&registre_national=" + rn + params;
			
			var jqxhr = $.getJSON( url , function(json) {

				$("#responsejson").getResponsejson(json, 'getLivingWages');	 
				
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
				}).insertAfter( $("#getLivingWages form") );
				$("#getLivingWages .reponse").append( statut );
				$("#getLivingWages .reponse").append( "<br />" );
				$("#getLivingWages .reponse").append( reponse );
			})
			.fail(function() {
			})
			.always(function(){
				$("#wait").hide();
			})
		}
	}
});


</script>
















