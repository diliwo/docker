<ul class="nav nav-tabs">
	<li class="active"><a href="#enterprise_immovable_properties" data-toggle="tab">Immeubles d'entreprise</a></li>
	<li><a href="#immovable_properties" data-toggle="tab">Bien Immobilier</a></li> 
	<li><a href="#find_division_by_enterprise_number" data-toggle="tab">Trouver la division par numéro d'entreprise</a></li>
</ul> 
<br />

<div class="tab-content well">

	<div class="tab-pane fade active in" id="enterprise_immovable_properties">
		<form id="form-data-enterprise_immovable_properties" class="form-horizontal" role="form">
			<div class="form-group">
				<label for="enterprise_Immovable_Properties" class="col-md-2 control-label">N. d'entreprise: </label>
				<div class="form-group">
					<div class="col-md-3">
						<input type="text" class="form-control" name="enterprise_number" id="input_enterprise_Immovable_Properties" placeholder="0000000000"> 
					</div>
				</div>
				
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
	
	<div class="tab-pane fade in" id="immovable_properties">
		<form id="form-data-immovable_properties" class="form-horizontal" role="form">
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
	
	<div class="tab-pane fade in" id="find_division_by_enterprise_number">
		<form id="form-data-find_division_by_enterprise_number" class="form-horizontal" role="form">
		
			<div class="form-group">
				<label for="enterprise_Immovable_Properties" class="col-md-2 control-label">N. d'entreprise: </label>
				<div class="form-group">
					<div class="col-md-3">
						<input type="text" class="form-control" name="enterprise_number" id="input_find_division_by_enterprise_number" placeholder="0000000000"> 
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

// ***EnterpriseImmovableProperties*** //

//**********************//
//Immeubles d'entreprise//
//**********************//
$("#enterprise_immovable_properties form input[name=date_debut], #enterprise_immovable_properties form input[name=date_fin]").datepicker({
	format: "yyyy-mm",
	language: "fr",
	orientation: "top left",
	minViewMode: 0,
	autoclose: true,
	todayHighlight: true
}).on("change", function() {
	var date_debut = $("#enterprise_immovable_properties form input[name=date_debut]");
	var date_fin = $("#enterprise_immovable_properties form input[name=date_fin]");

	date_fin.datepicker('setStartDate', date_debut.val());
	date_debut.datepicker('setEndDate', date_fin.val());
});

$("#enterprise_immovable_properties form button[type=reset]").on( "click", function() {
	$("#enterprise_immovable_properties form input[name=registre_national]").closest(".has-feedback").find(".glyphicon").removeClass("glyphicon-ok glyphicon-remove").addClass("glyphicon-pencil");
	$("#enterprise_immovable_properties form input[name=registre_national]").closest(".has-feedback").removeClass("has-success has-error");
	$(".help-block").remove();
	$("#enterprise_immovable_properties .reponse").remove();
});

$("#enterprise_immovable_properties form").validate({
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
		$("#enterprise_immovable_properties .reponse").remove();

		var enterprise_number = $("#enterprise_immovable_properties form input[name=enterprise_number]").val();
		var date_debut = $("#enterprise_immovable_properties form input[name=date_debut]").val();
		var date_fin = $("#enterprise_immovable_properties form input[name=date_fin]").val();
		
		var url = "<?php echo $_CONFIG['url']; ?>api/patrimony_service/consulter/enterprise_immovable_properties/?env=<?php echo $_SESSION['test_flux_bcss']['env']; ?>";
		if (( date_debut != '' ) && ( date_fin != '' )) {
			url += "&date_debut=" + date_debut + "&date_fin=" + date_fin;
				
		}
			
		var reg_en = new RegExp(/[0-1]\d{9}$/);
		var x = document.getElementById("input_enterprise_Immovable_Properties");
			
		if( !(reg_en.test(enterprise_number) && enterprise_number.length == 10) ) {
			x.setAttribute('style','border-color: #a94442; -webkit-box-shadow: inset 0 1px 1px rgba(0,0,0,.075); box-shadow: inset 0 1px 1px rgba(0,0,0,.075);');
			$("#wait").hide(); 	
			return;
				 
		}  else {
			x.setAttribute('style','');
				
		} 
			
		url += "&enterprise_number=" +enterprise_number;
		var jqxhr = $.getJSON( url , function(json) { 

			$("#responsejson").getResponsejson(json,'enterpriseImmovableProperties');
		
			var reponse = $("<fieldset />", { "html": "<legend>Réponse</legend>PAS DE DONNEES" });

			if(json.succes != 0 )  {

				var val =  (json.data.status.hasOwnProperty('value')       ? json.data.status.value : "" );
				var code = (json.data.status.hasOwnProperty('code')        ? json.data.status.code : "" );
				var desc = (json.data.status.hasOwnProperty('description') ? json.data.status.description : "" );

				var data = (json.data.hasOwnProperty('properties') ? json.data.properties : "" );

				var statut = $("<fieldset />", {  "html": "<legend>Statut</legend>" + val +" (" + code + "): " + desc });

				if ( data ) { 
					reponse = $("<fieldset />", {  "html": "<legend>Réponse</legend>" });
					reponse.append( JsonHuman.format( data ) );
				}
  
			}
 	 
			$("<div />", { 
				"class": "reponse"
			}).insertAfter( $("#enterprise_immovable_properties form") );
			$("#enterprise_immovable_properties .reponse").append( statut );
			$("#enterprise_immovable_properties .reponse").append( "<br />" );
			$("#enterprise_immovable_properties .reponse").append( reponse );

		})
		.fail(function() { })
		.always(function() {
			$("#wait").hide();
		})
	}
});

// ***immovableProperties*** //

//***************//
//Bien Immobilier//
//***************//
$("#immovable_properties form input[name=date_debut], #immovable_properties form input[name=date_fin]").datepicker({
	format: "yyyy-mm",
	language: "fr",
	orientation: "top left",
	minViewMode: 1,
	autoclose: true,
	todayHighlight: true
}).on("change", function() {
	var date_debut = $("#immovable_properties form input[name=date_debut]");
	var date_fin = $("#immovable_properties form input[name=date_fin]");

	date_debut.datepicker('setStartDate', date_debut.val());
	date_fin.datepicker('setEndDate', date_fin.val());
});
$("#immovable_properties form button[type=reset]").on( "click", function() {
	$("#immovable_properties form input[name=registre_national]").closest(".has-feedback").find(".glyphicon").removeClass("glyphicon-ok glyphicon-remove").addClass("glyphicon-pencil");
	$("#immovable_properties form input[name=registre_national]").closest(".has-feedback").removeClass("has-success has-error");
	$(".help-block").remove();
	$("#immovable_properties .reponse").remove();
})
$("#immovable_properties form").validate({
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
		$("#immovable_properties .reponse").remove();

		var rn = $("#immovable_properties form input[name=registre_national]").val();
		var date_debut = $("#immovable_properties form input[name=date_debut]").val();
		var date_fin = $("#immovable_properties form input[name=date_fin]").val();
		if (RegistreNational.valider( rn )) {
			var url = "<?php echo $_CONFIG['url']; ?>api/patrimony_service/consulter/immovable_properties?env=<?php echo $_SESSION['test_flux_bcss']['env']; ?>&registre_national=" + rn;
			if (( date_debut != '' ) && ( date_fin != '' )) {
				url += "&date_debut=" + date_debut + "&date_fin=" + date_fin;
			}

			var jqxhr = $.getJSON( url , function(json) { 

				$("#responsejson").getResponsejson(json,'immovableProperties');
			
				var reponse = $("<fieldset />", { "html": "<legend>Réponse</legend>PAS DE DONNEES" });

				if(json.succes != 0 )  {

					var val =  (json.data.status.hasOwnProperty('value')       ? json.data.status.value : "" );
					var code = (json.data.status.hasOwnProperty('code')        ? json.data.status.code : "" );
					var desc = (json.data.status.hasOwnProperty('description') ? json.data.status.description : "" );

					var data = (json.data.hasOwnProperty('properties') ? json.data.properties : "" );

					var statut = $("<fieldset />", {  "html": "<legend>Statut</legend>" + val +" (" + code + "): " + desc });

					if ( data ) { 
						reponse = $("<fieldset />", {  "html": "<legend>Réponse</legend>" });
						reponse.append( JsonHuman.format( data ) );
					}
  
				}
				 
				$("<div />", { 
					"class": "reponse"
				}).insertAfter( $("#immovable_properties form") );
				$("#immovable_properties .reponse").append( statut );
				$("#immovable_properties .reponse").append( "<br />" );
				$("#immovable_properties .reponse").append( reponse );
			})
			.fail(function() {})
			.always(function(){
				$("#wait").hide();
			})
		}
	}
});

//***findDivisionByEnterpriseNumber*** //

//*******************************************//
//Trouver la division par numéro d'entreprise//
//*******************************************//
$("#find_division_by_enterprise_number form button[type=reset]").on( "click", function() {
	$("#find_division_by_enterprise_number form input[name=registre_national]").closest(".has-feedback").find(".glyphicon").removeClass("glyphicon-ok glyphicon-remove").addClass("glyphicon-pencil");
	$("#find_division_by_enterprise_number form input[name=registre_national]").closest(".has-feedback").removeClass("has-success has-error");
	$(".help-block").remove();
	$("#find_division_by_enterprise_number .reponse").remove();
});

$("#find_division_by_enterprise_number form").validate({
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
		$("#find_division_by_enterprise_number .reponse").remove();

		var enterprise_number = $("#find_division_by_enterprise_number form input[name=enterprise_number]").val();
		
		var url = "<?php echo $_CONFIG['url']; ?>api/patrimony_service/consulter/find_division_by_enterprise_number/?env=<?php echo $_SESSION['test_flux_bcss']['env']; ?>";
		 	
		var reg_en = new RegExp(/[0-1]\d{9}$/);
		var x = document.getElementById("input_find_division_by_enterprise_number");
			
		if( !(reg_en.test(enterprise_number) && enterprise_number.length == 10) ) {
			x.setAttribute('style','border-color: #a94442; -webkit-box-shadow: inset 0 1px 1px rgba(0,0,0,.075); box-shadow: inset 0 1px 1px rgba(0,0,0,.075);');
			$("#wait").hide(); 	
			return;
				 
		}  else {
			x.setAttribute('style','');
				
		} 
			
		url += "&enterprise_number=" +enterprise_number;
		var jqxhr = $.getJSON( url , function(json) { 

			$("#responsejson").getResponsejson(json,'findDivisionByEnterpriseNumber');
		
			var reponse = $("<fieldset />", { "html": "<legend>Réponse</legend>PAS DE DONNEES" });

			if(json.succes != 0 )  {

				var val =  (json.data.status.hasOwnProperty('value')       ? json.data.status.value : "" );
				var code = (json.data.status.hasOwnProperty('code')        ? json.data.status.code : "" );
				var desc = (json.data.status.hasOwnProperty('description') ? json.data.status.description : "" );

				var data = (json.data.hasOwnProperty('divisions') ? json.data.divisions : "" );

				var statut = $("<fieldset />", {  "html": "<legend>Statut</legend>" + val +" (" + code + "): " + desc });

				if ( data ) { 
					reponse = $("<fieldset />", {  "html": "<legend>Réponse</legend>" });
					reponse.append( JsonHuman.format( data ) );
				}

			}
				 
			$("<div />", { 
				"class": "reponse"
			}).insertAfter( $("#find_division_by_enterprise_number form") );
			$("#find_division_by_enterprise_number .reponse").append( statut );
			$("#find_division_by_enterprise_number .reponse").append( "<br />" );
			$("#find_division_by_enterprise_number .reponse").append( reponse );

		})
		.fail(function() { })
		.always(function() {
			$("#wait").hide();
		})
	}
});

//-->
</script>