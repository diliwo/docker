<div class="well" id="dimona">
	<form method="POST" id="form-dimona" class="form-horizontal" role="form">
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
						<input type="text" class="form-control datepicker" name="date_debut" placeholder="YYYY-MM-DD">
						<span class="input-group-addon">au</span>
						<input type="text" class="form-control datepicker" name="date_fin" placeholder="YYYY-MM-DD">
					</div>
				</div>
			</div>

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

$("#dimona form input[name=date_debut], #dimona form input[name=date_fin]").datepicker({
	format: "yyyy-mm-dd",
	language: "fr",
	orientation: "top left",
	minViewMode: 0,
	autoclose: true,
	todayHighlight: true
}).on("change", function() {
	var date_debut = $("#dimona form input[name=date_debut]");
	var date_fin = $("#dimona form input[name=date_fin]");

	date_fin.datepicker('setStartDate', date_debut.val());
	date_debut.datepicker('setEndDate', date_fin.val());
});

$("#dimona form button[type=reset]").on( "click", function() {
	$("#dimona form input[name=registre_national]").closest(".has-feedback").find(".glyphicon").removeClass("glyphicon-ok glyphicon-remove").addClass("glyphicon-pencil");
	$("#dimona form input[name=registre_national]").closest(".has-feedback").removeClass("has-success has-error");
	$(".help-block").remove();
	$("#dimona .reponse").remove();
});

$("#dimona form").validate({
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
		$("#dimona .reponse").remove();

		var rn = $("#dimona form input[name=registre_national]").val();
		var date_debut = $("#dimona form input[name=date_debut]").val();
		var date_fin = $("#dimona form input[name=date_fin]").val();
		
		if (RegistreNational.valider( rn )) {
			var url = "<?php echo $_CONFIG['url']; ?>api/dimona/consulter?env=<?php echo $_SESSION['test_flux_bcss']['env']; ?>&registre_national=" + rn;
			if (( date_debut != '' ) && ( date_fin != '' )) {
				url += "&date_debut=" + date_debut + "&date_fin=" + date_fin;
			}

			var jqxhr = $.getJSON( url , function(json) { 
				
				$("#responsejson").getResponsejson(json,'dimona');
			
				var reponse = $("<fieldset />", { "html": "<legend>Réponse</legend>PAS DE DONNEES" });

				if(json.succes != 0 )  {
				
					var val =  (json.data.status.hasOwnProperty('value')       ? json.data.status.value : "" );
					var code = (json.data.status.hasOwnProperty('code')        ? json.data.status.code : "" );
					var desc = (json.data.status.hasOwnProperty('description') ? json.data.status.description : "" );
				
					var data = (json.data.hasOwnProperty('activities') ? json.data.activities : "" );
				
					var statut = $("<fieldset />", {  "html": "<legend>Statut</legend>" + val +" (" + code + "): " + desc });
 
					if ( data ) { 
						reponse = $("<fieldset />", {  "html": "<legend>Réponse</legend>" });
						reponse.append( JsonHuman.format( data ) );
					}
				  
				}

				$("<div />", { 
					"class": "reponse"
				}).insertAfter( $("#dimona form") );
				$("#dimona .reponse").append( statut );
				$("#dimona .reponse").append( "<br />" );
				$("#dimona .reponse").append( reponse );

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