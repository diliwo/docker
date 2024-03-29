<div class="well" id="pension_register">
  <form method="POST" id="form-pension_register" class="form-horizontal" role="form">

    <fieldset>
			<legend>Individu ciblé</legend>

      <div class="form-group has-feedback">
  			<label for="field_TargetSSIN" class="col-md-2 control-label">NISS</label>
  			<div class="col-md-3">
  				<input type="text" class="form-control" id="field_TargetSSIN" name="TargetSSIN">
  				<span class="glyphicon glyphicon-pencil form-control-feedback"></span>
  			</div>
  		</div>
    </fieldset>

    <fieldset>
			<legend>Période de consultation</legend>

      <div class="form-group has-feedback">
  			<label for="field_PeriodStartDate" class="col-md-2 control-label">Début</label>
  			<div class="col-md-3">
  				<input type="text" class="form-control" id="field_PeriodStartDate" name="PeriodStartDate" placeholder="YYYY-MM-DD">
  				<span class="glyphicon glyphicon-calendar form-control-feedback"></span>
  			</div>
  		</div>

      <div class="form-group has-feedback">
  			<label for="field_PeriodEndDate" class="col-md-2 control-label">Fin</label>
  			<div class="col-md-3">
  				<input type="text" class="form-control" id="field_PeriodEndDate" name="PeriodEndDate" placeholder="YYYY-MM-DD">
  				<span class="glyphicon glyphicon-calendar form-control-feedback"></span>
  			</div>
  		</div>
    </fieldset>

    <fieldset>
			<legend>Informations souhaitées</legend>

      <div class="form-group">
        <label for="field_RequestedDataPillar" class="col-md-2 control-label">Piliers</label>
        <div class="col-md-3">
          <select class="form-control" id="field_RequestedDataPillar" name="RequestedDataPillar">
            <option value="FirstOnly" selected="selected">1er pilier seulement</option>
            <option value="FirstSecond">1er et 2nd piliers</option>
          </select>
        </div>
      </div>

      <div class="form-group">
        <label for="field_RequestedDataRequestedInformation" class="col-md-2 control-label">Informations</label>
        <div class="col-md-3">
          <select class="form-control" id="field_RequestedDataRequestedInformation" name="RequestedDataRequestedInformation">
            <option value="RightsOnly" selected="selected">Droits seulement</option>
            <option value="RightsMinimumPayments">Droits et paiements (minimum)</option>
            <option value="RightsMaximumPayments">Droits et paiements (maximum)</option>
          </select>
        </div>
      </div>

      <div class="form-group">
        <label for="field_RequestedDataFocus" class="col-md-2 control-label">Type</label>
        <div class="col-md-3">
          <select class="form-control" id="field_RequestedDataFocus" name="RequestedDataFocus">
            <option value="ReferencePeriod" selected="selected">Période de référence</option>
            <option value="MonthOfPayment">Mois de paiement</option>
          </select>
        </div>
      </div>
    </fieldset>

    <p>&nbsp;</p>

		<div class="form-group">
			<div class="col-md-offset-2 col-md-3">
				<button type="submit" class="btn btn-primary">Tester</button>
				<button type="reset" class="btn btn-default">Réinitialiser</button>
			</div>
		</div>
	</form>
</div>

<script>
  $(function() {
    $('#field_PeriodStartDate, #field_PeriodEndDate').datepicker({
      format: 'yyyy-mm-dd',
      language: 'fr',
      orientation: 'top left',
      autoclose: true,
      todayHighlight: true
    });

    $('#pension_register form button[type=reset]').on( 'click', function() {
      $('#pension_register').validate().resetForm();
      $('#pension_register .has-error').removeClass('has-error');
      $('#pension_register .has-success').removeClass('has-success');
      $('#pension_register .help-block').remove();
	  $('#pension_register .reponse').remove();
    });

    $('#pension_register form').validate({
      rules: {
    		TargetSSIN: {
    			minlength: 11,
    			maxlength: 11,
    			required: true
    		},
        PeriodStartDate: 'required',
        PeriodEndDate: 'required'
    	},
    	highlight: function(element) {
    		$(element).closest('.form-group').removeClass('has-success').addClass('has-error');
    	},
    	unhighlight: function(element) {
    		$(element).closest('.form-group').removeClass('has-error').addClass('has-success');
    	},
    	errorPlacement: function(error, element) {
    	},
      submitHandler: function(form) {
        $("#wait").show();
        $("#pension_register .reponse").remove();

  			var url = '<?php echo $_CONFIG['url']; ?>api/pension_register/consulter';
        	url = url + '?' + 'env=<?php echo $_SESSION['test_flux_bcss']['env']; ?>';
			url = url + '&' + $('#form-pension_register').serialize();
			
			var jqxhr = $.getJSON( url , function(json) { 
				
        		$("#responsejson").getResponsejson(json,'pensionRegister');
		
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
				
          $reponse = $('<div class="reponse"/>')
          $reponse.append(statut);
          $reponse.append('<br>');
          $reponse.append(reponse);
          $reponse.appendTo('#pension_register form')
        });

		jqxhr.always(function() {
          $("#wait").hide();
        });
    	}
    });
  });
</script>
