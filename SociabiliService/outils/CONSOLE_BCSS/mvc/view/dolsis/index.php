<ul class="nav nav-tabs">
	<li class="active"><a href="#employeurs" data-toggle="tab">Employeurs</a></li>
</ul>
<br />
<div class="tab-content well">
	<div class="tab-pane fade active in" id="employeurs">
		<form id="form-dolsis-employeurs" class="form-horizontal" role="form">
			<div class="form-group has-feedback">
				<label for="registre_national" class="col-md-2 control-label">Registre national: </label>
				<div class="col-md-3">
					<input type="text" class="form-control" name="registre_national">
					<span class="glyphicon glyphicon-pencil form-control-feedback"></span>
				</div>
			</div>

			<div class="form-group">
				<label for="scope" class="col-md-2 control-label">Scope: </label>
				<div class="col-md-2">
					<select class="form-control" name="scope">
						<option value="active" selected="selected">Active</option>
						<option value="activeInPeriod">ActiveInPeriod</option>
						<option value="mutations">Mutations</option>
					</select>
				</div>
			</div>

			<div class="form-group" id="form-group-periode" style="display: none;">
				<label for="periode" class="col-md-2 control-label">Période: </label>
				<div class="col-md-4">
					<div class="input-group" id="periode" disabled="disabled">
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

$("#employeurs form input[name=date_debut], #employeurs form input[name=date_fin]").datepicker({
	format: "yyyy-mm-dd",
	language: "fr",
	orientation: "top left",
	minViewMode: 0,
	autoclose: true,
	todayHighlight: true
}).on("change", function() {
	var date_debut = $("#employeurs form input[name=date_debut]");
	var date_fin = $("#employeurs form input[name=date_fin]");

	date_fin.datepicker('setStartDate', date_debut.val());
	date_debut.datepicker('setEndDate', date_fin.val());
});
$("#employeurs form select[name=scope]").on("change", function() {
	if ($(this).val() === "activeInPeriod" || $(this).val() === "mutations") {
		$("#form-group-periode").show();
	} else {
		$("#form-group-periode").hide();
	}

});

// ********* //
// Situation //
// ********* //
$("#employeurs form button[type=reset]").on( "click", function() {
	$("#employeurs form input[name=registre_national]").closest(".has-feedback").find(".glyphicon").removeClass("glyphicon-ok glyphicon-remove").addClass("glyphicon-pencil");
	$("#employeurs form input[name=registre_national]").closest(".has-feedback").removeClass("has-success has-error");
	$(".help-block").remove();
	$("#employeurs .reponse").remove();
});

$("#employeurs form").validate({
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
		$("#employeurs .reponse").remove();

		var rn = $("#employeurs form input[name=registre_national]").val();
		var scope = $("#employeurs form select[name=scope]").val();
		var date_debut = $("#employeurs form input[name=date_debut]").val();
		var date_fin = $("#employeurs form input[name=date_fin]").val();

		if (RegistreNational.valider( rn )) {
			var url = "<?php echo $_CONFIG['url']; ?>api/dolsis/employeurs/consulter?env=<?php echo $_SESSION['test_flux_bcss']['env']; ?>&registre_national=" + rn + "&scope=" + scope;

			if (scope === "activeInPeriod" || scope === "mutations") {
				if (date_debut || date_debut.length > 0) {
					var url = url + "&date_debut=" + date_debut
				}
				if (date_fin || date_fin.length > 0) {
					var url = url + "&date_fin=" + date_fin
				}
			}

			var jqxhr = $.getJSON( url , function(json) { 
				
				$("#responsejson").getResponsejson(json,'Dolsis');
			
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
				}).insertAfter( $("#employeurs form") );

				$("#employeurs .reponse").append( statut );
				$("#employeurs .reponse").append( "<br />" );
				$("#employeurs .reponse").append( reponse );

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
