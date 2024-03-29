<div class="well" id="transaction25">
	<form method="POST" id="form-transaction25" class="form-horizontal" role="form">
		<div class="form-group has-feedback">
			<label for="registre_national" class="col-md-2 control-label">Registre national: </label>
			<div class="col-md-3">
				<input type="text" class="form-control" name="registre_national">
				<span class="glyphicon glyphicon-pencil form-control-feedback"></span>
			</div>
		</div>

		<div class="form-group">
				<label for="langue" class="col-md-2 control-label">Langue: </label>
				<div class="col-md-2">
					<select class="form-control" name="langue">
						<option value="fr">Français</option>
						<option value="nl">Néerlandais</option>
					</select>
				</div>
			</div>

		<div class="form-group">
			<label for="historicite" class="col-md-2 control-label">Historicité: </label>
			<div class="col-md-1">
				<div class="checkbox">
					<label>
						<input type="checkbox" name="historicite" checked="checked">
					</label>
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

<script type="text/javascript">
<!--

$("#transaction25 form button[type=reset]").on( "click", function() {
	$("#transaction25 form input[name=registre_national]").closest(".has-feedback").find(".glyphicon").removeClass("glyphicon-ok glyphicon-remove").addClass("glyphicon-pencil");
	$("#transaction25 form input[name=registre_national]").closest(".has-feedback").removeClass("has-success has-error");
	$(".help-block").remove();
	$("#transaction25 .reponse").remove();
});

$("#transaction25 form").validate({
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
		$("#transaction25 .reponse").remove();

		var rn = $("#transaction25 form input[name=registre_national]").val();
		var langue = $("#transaction25 form select[name=langue]").val();
		if ($("#transaction25 form input[name=historicite]").prop("checked")) {
			var historicite = 1;
		} else {
			var historicite = 0;
		}
		if (RegistreNational.valider( rn )) {
			var url = "<?php echo $_CONFIG['url']; ?>api/transaction25/v2/consulter?env=<?php echo $_SESSION['test_flux_bcss']['env']; ?>&registre_national=" + rn + "&langue=" + langue + "&historicite=" + historicite;
			var jqxhr = $.getJSON( url , function(json) { 
				
				$("#responsejson").getResponsejson(json,'retrieveTiGroups');
			
				var reponse = $("<fieldset />", { "html": "<legend>Réponse</legend>PAS DE DONNEES" });

				if(json.succes != 0 )  {  

					var val =  (json.data.status.hasOwnProperty('value')       ? json.data.status.value : "" );
					var code = (json.data.status.hasOwnProperty('code')        ? json.data.status.code : "" );
					var desc = (json.data.status.hasOwnProperty('description') ? json.data.status.description : "" );

					var data = (json.data.hasOwnProperty('rrn_it_implicit') ? json.data.rrn_it_implicit : "" );

					var statut = $("<fieldset />", {  "html": "<legend>Statut</legend>" + val +" (" + code + "): " + desc });

					if ( data ) { 
						reponse = $("<fieldset />", {  "html": "<legend>Réponse</legend>" });
						reponse.append( JsonHuman.format( data ) );
					}
  
				}

				$("<div />", { 
					"class": "reponse"
				}).insertAfter( $("#transaction25 form") );
				$("#transaction25 .reponse").append( statut );
				$("#transaction25 .reponse").append( "<br />" );
				$("#transaction25 .reponse").append( reponse );

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
