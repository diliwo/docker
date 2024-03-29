<ul class="nav nav-tabs">
	<li class="active"><a href="#carriere" data-toggle="tab">Carrière</a></li>
	<li><a href="#contributions" data-toggle="tab">Contributions</a></li>
</ul>
<br />
<div class="tab-content well">
	<div class="tab-pane fade active in" id="carriere">
		<form id="form-carriere" class="form-horizontal" role="form">
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
					<div class="input-group" id="periode-self_employed-carriere">
						<span class="input-group-addon">du</span>
						<input type="text" class="form-control datepicker" name="date_debut" placeholder="YYYY-MM-DD" value="1976-07-01">
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

	<div class="tab-pane fade in" id="contributions">
		<form id="form-contributions" class="form-horizontal" role="form">
			<div class="form-group has-feedback">
				<label for="registre_national" class="col-md-2 control-label">Registre national: </label>
				<div class="col-md-3">
					<input type="text" class="form-control" name="registre_national">
					<span class="glyphicon glyphicon-pencil form-control-feedback"></span>
				</div>
			</div>

			<div class="form-group">
				<label for="quadrimestre" class="col-md-2 control-label">Début: </label>
				<div class="col-md-2">
					<div class="input-group" id="periode-self_employed-carriere">
					<span class="input-group-addon">Trimestre </span>
					
					<select class="form-control" name="debut_quadr" style="width:120px;">
						<option value="1" <?php echo (preg_match("/[1-3]/",     date("m") ) ? 'selected="selected"' : '');?>>Premier</option>
						<option value="2" <?php echo (preg_match("/[4-6]/",     date("m") ) ? 'selected="selected"' : '');?>>Deuxième</option>
						<option value="3" <?php echo (preg_match("/[7-9]/",     date("m") ) ? 'selected="selected"' : '');?>>Troisième</option>
						<option value="4" <?php echo (preg_match("/(10|11|12)/",date("m") ) ? 'selected="selected"' : '');?>>Quatrième</option> 
					</select>
					
					<span class="input-group-addon">Annee</span>
					<input type="text" class="form-control datepicker" name="q_date_debut" placeholder="YYYY" style="width:70px;">
					</div>
				</div>
			</div>
			
			<div class="form-group">
				<label for="quadrimestre" class="col-md-2 control-label">Fin: </label>
				<div class="col-md-2">
					<div class="input-group" id="periode-self_employed-carriere">
					<span class="input-group-addon">Trimestre </span>
					
					<select class="form-control" name="fin_quadr" style="width:120px;">
						<option value="1" <?php echo (preg_match("/[1-3]/",     date("m") ) ? 'selected="selected"' : '');?>>Premier</option>
						<option value="2" <?php echo (preg_match("/[4-6]/",     date("m") ) ? 'selected="selected"' : '');?>>Deuxième</option>
						<option value="3" <?php echo (preg_match("/[7-9]/",     date("m") ) ? 'selected="selected"' : '');?>>Troisième</option>
						<option value="4" <?php echo (preg_match("/(10|11|12)/",date("m") ) ? 'selected="selected"' : '');?>>Quatrième</option> 
					</select>
					
					<span class="input-group-addon">Annee</span>
					<input type="text" class="form-control datepicker" name="q_date_fin" placeholder="YYYY" style="width:70px;">
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

// ******** //
// Carrière //
// ******** //
$("#carriere form input[name=date_debut],input[name=date_fin]").datepicker({
	format: "yyyy-mm-dd",
	language: "fr",
	orientation: "top left",
	autoclose: true,
	todayHighlight: true
}).on("change", function() {
	var date_debut = $("#carriere form input[name=date_debut]");
	var date_fin = $("#carriere form input[name=date_fin]");

	date_fin.datepicker('setStartDate', date_debut.val());
	date_debut.datepicker('setEndDate', date_fin.val());
});
$("#carriere form button[type=reset]").on( "click", function() {
	$("#carriere form input[name=registre_national]").closest(".has-feedback").find(".glyphicon").removeClass("glyphicon-ok glyphicon-remove").addClass("glyphicon-pencil");
	$("#carriere form input[name=registre_national]").closest(".has-feedback").removeClass("has-success has-error");
	$(".help-block").remove();
	$("#carriere .reponse").remove();
});

$("#carriere form").validate({
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
		$("#carriere .reponse").remove();

		var rn = $("#carriere form input[name=registre_national]").val();
		var dateDebut = $("#carriere form input[name=date_debut]").val();
		var dateFin = $("#carriere form input[name=date_fin]").val();
		if (RegistreNational.valider( rn )) {
			var url = "<?php echo $_CONFIG['url']; ?>api/self_employed/v2/consulter/carriere?env=<?php echo $_SESSION['test_flux_bcss']['env']; ?>&registre_national=" + rn;
			if ( dateDebut != "" ) {
				url += "&date_debut=" + dateDebut;

				if ( dateFin != "" ) {
					url += "&date_fin=" + dateFin;
				}
			}

			var jqxhr = $.getJSON( url , function(json) { 
				
				$("#responsejson").getResponsejson(json,'consultCareer');
			
				var reponse = $("<fieldset />", { "html": "<legend>Réponse</legend>PAS DE DONNEES" });

				if(json.succes != 0 )  {  

					var val =  (json.data.status.hasOwnProperty('value')       ? json.data.status.value : "" );
					var code = (json.data.status.hasOwnProperty('code')        ? json.data.status.code : "" );
					var desc = (json.data.status.hasOwnProperty('description') ? json.data.status.description : "" );

					var data = (json.data.hasOwnProperty('career') ? json.data.career : "" );

					var statut = $("<fieldset />", {  "html": "<legend>Statut</legend>" + val +" (" + code + "): " + desc });

					if ( data ) { 
						reponse = $("<fieldset />", {  "html": "<legend>Réponse</legend>" });
						reponse.append( JsonHuman.format( data ) );
					}	

				}

				$("<div />", {
					"class": "reponse"
				}).insertAfter( $("#carriere form") );
				$("#carriere .reponse").append( statut );
				$("#carriere .reponse").append( "<br />" );
				$("#carriere .reponse").append( reponse );
			})
			.fail(function() {
			})
			.always(function(){
				$("#wait").hide();
			})
		}
	}
});

// ************* //
// contributions //
// ************* //
$("#contributions input[name=q_date_debut], input[name=q_date_fin]").datepicker({
	format: "yyyy",
	language: "fr",
	orientation: "top left",
	minViewMode: 2,
	autoclose: true,
	todayHighlight: true
});
$("#contributions form button[type=reset]").on( "click", function() {
	$("#contributions form input[name=registre_national]").closest(".has-feedback").find(".glyphicon").removeClass("glyphicon-ok glyphicon-remove").addClass("glyphicon-pencil");
	$("#contributions form input[name=registre_national]").closest(".has-feedback").removeClass("has-success has-error");
	$(".help-block").remove();
	$("#contributions .reponse").remove();
})
$("#contributions form").validate({
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
		$("#contributions .reponse").remove();

		var rn = $("#contributions form input[name=registre_national]").val();

		var date_debut = $("#contributions form input[name=q_date_debut]").val();
		var debut_quadr = $("#contributions form select[name=debut_quadr]").val();

		var date_fin   = $("#contributions form input[name=q_date_fin]").val();  
		var fin_quadr = $("#contributions form select[name=fin_quadr]").val();

		if (RegistreNational.valider( rn )) {
			var url = "<?php echo $_CONFIG['url']; ?>api/self_employed/v2/consulter/contributions?env=<?php echo $_SESSION['test_flux_bcss']['env']; ?>&registre_national=" + rn;

			if(date_debut == '' ) {

				$("#contributions input[name=q_date_debut]").attr('style','width:75px; border-color: #a94442; box-shadow: inset 0 3px 3px rgba(0,0,0,.075);');
				$("#wait").hide();
				$("#contributions .reponse").remove();	
				return;
				
			} 

			url += "&date_debut="+date_debut+debut_quadr;

			url += (date_fin == "" ? "" : "&date_fin="+date_fin+fin_quadr);
	
			$("#contributions input[name=q_date_debut]").attr('style','width:75px;');

			var jqxhr = $.getJSON( url , function(json) { 

				$("#responsejson").getResponsejson(json,'consultContributions');
			
				var reponse = $("<fieldset />", { "html": "<legend>Réponse</legend>PAS DE DONNEES" });

				if(json.succes != 0 )  {  

					var val =  (json.data.status.hasOwnProperty('value')       ? json.data.status.value : "" );
					var code = (json.data.status.hasOwnProperty('code')        ? json.data.status.code : "" );
					var desc = (json.data.status.hasOwnProperty('description') ? json.data.status.description : "" );

					var data = (json.data.hasOwnProperty('contributions') ? json.data.contributions : "" );

					var statut = $("<fieldset />", {  "html": "<legend>Statut</legend>" + val +" (" + code + "): " + desc });

					if ( data ) { 
						reponse = $("<fieldset />", {  "html": "<legend>Réponse</legend>" });
						reponse.append( JsonHuman.format( data ) );
					}	

				}

				$("<div />", {
					"class": "reponse"
				}).insertAfter( $("#contributions form") );
				$("#contributions .reponse").append( statut );
				$("#contributions .reponse").append( "<br />" );
				$("#contributions .reponse").append( reponse );
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
