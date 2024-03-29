<div class="well" id="taxi_as">
	<form method="POST" id="form-taxi_as" class="form-horizontal" role="form">
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
				<label class="sr-only" for="date">YYYY</label>
				<input type="text" class="form-control" name="date" placeholder="YYYY">
			</div>
			
			<span class="dhelp">?</span>
				<div class="doverlay">
					<h3 class="dheading">Date</h3>
    				L’année de revenu devant explicitement être consultée  
				</div> 
		</div>
		
		<div class="form-group">
			<label for="derivedYear" class="col-md-2 control-label">Extrait de rôle: </label>
			<div class="col-md-3"> 
				<select name="derivedYear" class="form-control">  
					<option value=""></option>
					<option value="MOST_RECENT">MOST_RECENT</option>
					<option value="MOST_RECENT_UNLIMITED">MOST_RECENT_UNLIMITED</option>
				</select>
			</div>
			
			<span class="dhelp">?</span>
				<div class="doverlay">
					<h3 class="dheading">Extrait de rôle</h3>
    				L’année de revenu pouvant être dérivée automatiquement. 
				</div> 
		</div>
		
		<div class="form-group">
			<label for="elements" class="col-md-2 control-label">Elements: </label>
			<div class="col-md-3"> 
				<select name="elements" class="form-control">  
					<option value=""></option>
					<option value="GLOBAL_TAXABLE_INCOME">GLOBAL_TAXABLE_INCOME</option>
 					<option value="GLOBAL_TAXABLE_INCOME">CHILDREN_DEPENDENT_HANDICAP</option>
				</select>
			</div>
			
			<span class="dhelp">?</span>
				<div class="doverlay">
					<h3 class="dheading">Elements</h3>
    				Chaque element correspond à un concept fiscal <br>
    				(exemple de valeur possible : GLOBAL_TAXABLE_INCOME) 
				</div> 
		</div>
		
		<div class="form-group">
			<label for="groups" class="col-md-2 control-label">Groups: </label>
			<div class="col-md-3"> 
				<select name="groups" class="form-control">  
					<option value=""></option>
					<option value="MOST_RECENT">TAXABLE_INCOME</option>
					<option value="MOST_RECENT">CHILDREN_DEPENDENT</option>
 					<option value="MOST_RECENT">SOME_OTHER_GROUP</option>
 					<option value="DISTINCTLY_TAXABLE_INCOME">DISTINCTLY_TAXABLE_INCOME</option>
 					<option value="DISTINCTLY_TAXABLE_INCOME">GLOBAL_TAXABLE_INCOME_FISCAL_FAMILY</option>
				</select>
				 
			</div>
			 
			<span class="dhelp">?</span>
				<div class="doverlay">
					<h3 class="dheading">Groups</h3>
    				Un group correspond à plusieurs element, permettant de les demander en une seule fois<br> 
    				(exemple de valeur possible : group TAXABLE_INCOME pour elements GLOBAL_TAXABLE_INCOME, ...). 
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

<script type="text/javascript">
<!-- 

//**************************//
// TaxAssessmentData V2 TSS //
//**************************//
$("#taxi_as form input[name=date]").datepicker({
	format: "yyyy",
	language: "fr",
	orientation: "top left",
	minViewMode: 2,
	autoclose: true,
	todayHighlight: true
});

$("#taxi_as form").validate({
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
		$("#taxi_as .reponse").remove();

		var rn          = $("#taxi_as form input[name=registre_national]").val();
		var date        = $("#taxi_as form input[name=date]").val();
		var derivedYear = $("#taxi_as form select[name=derivedYear]").val();
		var elements    = $("#taxi_as form select[name=elements]").val();
		var groups      = $("#taxi_as form select[name=groups]").val();
		
		if (RegistreNational.valider( rn )) {
			var url = "<?php echo $_CONFIG['url']; ?>api/taxi_as/v2/consulter?env=<?php echo $_SESSION['test_flux_bcss']['env']; ?>&registre_national=" + rn;

			url += "&date=" + date + "&derivedYear=" + derivedYear + "&elements=" + elements + "&groups=" + groups;
			var jqxhr = $.getJSON( url , function(json) { 
				
				$("#responsejson").getResponsejson(json,'consultTaxAssessmentData');
			
				var reponse = $("<fieldset />", { "html": "<legend>Réponse</legend>PAS DE DONNEES" });

				if(json.succes != 0 )  {  

					var val =  (json.data.status.hasOwnProperty('value')       ? json.data.status.value : "" );
					var code = (json.data.status.hasOwnProperty('code')        ? json.data.status.code : "" );
					var desc = (json.data.status.hasOwnProperty('description') ? json.data.status.description : "" );

					var data = (json.data.status.hasOwnProperty('information') ? json.data.status.information : "" );

					var statut = $("<fieldset />", {  "html": "<legend>Statut</legend>" + val +" (" + code + "): " + desc });

					if ( data ) { 
						reponse = $("<fieldset />", {  "html": "<legend>Réponse</legend>" });
						reponse.append( JsonHuman.format( data ) );
					}	

				}

				$("<div />", { 
					"class": "reponse"
				}).insertAfter( $("#taxi_as form") );
				$("#taxi_as .reponse").append( statut );
				$("#taxi_as .reponse").append( "<br />" );
				$("#taxi_as .reponse").append( reponse );

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

