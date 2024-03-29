<div class="well" id="handiflux">
	<form method="POST" id="form-handiflux" class="form-horizontal" role="form">
		<fieldset>
			<legend>Individu</legend>
			<div class="form-group has-feedback">
				<label for="registre_national" class="col-md-2 control-label">Registre national</label>
				<div class="col-md-3">
					<input type="text" class="form-control" name="registre_national">
					<span class="glyphicon glyphicon-pencil form-control-feedback"></span>
				</div>
			</div>
		</fieldset>

		<fieldset>
			<legend>Informations à une date de référence</legend>
			<div class="form-group">
				<label for="referenceDate" class="col-md-2 control-label">Date</label>
				<div class="col-md-2">
					<label class="sr-only" for="date">YYYY-MM-DD</label>
					<input type="text" class="form-control" name="referenceDate" placeholder="YYYY-MM-DD">
				</div>
			</div>
			<div class="form-group">
				<label for="" class="col-md-2 control-label">Informations</label>
				<div class="col-md-10">
					<label class="checkbox-inline">
						<input type="checkbox" name="evolutionOfRequest" value="1" checked="checked"> Demande
					</label>
					<label class="checkbox-inline">
						<input type="checkbox" name="handicapRecognition" value="1" checked="checked"> Reconnaissance
					</label>
					<label class="checkbox-inline">
						<input type="checkbox" name="rights" value="1" checked="checked"> Droits
					</label>
					<label class="checkbox-inline">
						<input type="checkbox" name="socialCards" value="1" checked="checked"> Cartes sociales
					</label>
				</div>
			</div>
		</fieldset>

		<fieldset>
			<legend>Paiements pour une période</legend>
			<div class="form-group">
				<label for="paiements_periode" class="col-md-2 control-label">Période</label>
				<div class="col-md-4">
					<div class="input-group" id="paiements_periode">
						<span class="input-group-addon">du</span>
						<input type="text" class="form-control" name="paymentsAtPeriodStartDate" placeholder="YYYY-MM-DD">
						<span class="input-group-addon">au</span>
						<input type="text" class="form-control" name="paymentsAtPeriodEndDate" placeholder="YYYY-MM-DD">
					</div>
				</div>
			</div>
		</fieldset>

		<div class="form-group">
			<div class="col-md-offset-2 col-md-3">
				<button type="submit" class="btn btn-primary" data-loading-text="Chargement...">Tester</button>
				<button type="reset" class="btn btn-default">Annuler</button>
			</div>
		</div>
	</form>
</div>

<script type="text/javascript">
<!--

$('input[name="referenceDate"], input[name="paymentsAtPeriodStartDate"], input[name="paymentsAtPeriodEndDate"]').datepicker({
	format: "yyyy-mm-dd",
	language: "fr",
	orientation: "top left",
	autoclose: true,
	todayHighlight: true
});

$("#handiflux form button[type=reset]").on( "click", function() {
	$("#handiflux form input[name=registre_national]").closest(".has-feedback").find(".glyphicon").removeClass("glyphicon-ok glyphicon-remove").addClass("glyphicon-pencil");
	$("#handiflux form input[name=registre_national]").closest(".has-feedback").removeClass("has-success has-error");
	$(".help-block").remove();
	$("#handiflux .reponse").remove();
});

$("#handiflux form").validate({
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
		$("#handiflux .reponse").remove();

		var rn = $("#handiflux form input[name=registre_national]").val();
		if (RegistreNational.valider( rn )) {
			var url = "<?php echo $_CONFIG['url']; ?>api/handiflux/consulter?env=<?php echo $_SESSION['test_flux_bcss']['env']; ?>&" + $('#form-handiflux').serialize();
			console.log(url);
			var jqxhr = $.getJSON( url , function(json) {
				
				$("#responsejson").getResponsejson(json,'handiflux');
			
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
				}).insertAfter( $("#handiflux form") );
				$("#handiflux .reponse").append( statut );
				$("#handiflux .reponse").append( "<br />" );
				$("#handiflux .reponse").append( reponse );

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