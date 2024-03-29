
<script>

var win = null; 
$(".btnOpen").on("click", function() {	 
	if(win == null || win.closed) { 
		win = window.open(
			"https://kbopub.economie.fgov.be/kbopub/toonvestigingps.html?ondernemingsnummer="+ $(this).context.parentElement.children[0].title,
			null,
		    "width=1030, height=780, resizable, scrollbars=yes, status=1, copyhistory=no, menubar=no, directories=no, location=no, toolbar=no"
		);
	} else {
		win.focus();
	}		  
});

</script>

<h1>ONEM</h1>

<div class="title_flux"> <?php print( $flux->translate('consultPayments') ); ?> </div> 
<?php print( $flux->getResult('consultPayments') ); ?>

<div class="title_flux"> <?php print( $flux->translate('consultRights') ); ?> </div> 
<?php print( $flux->getResult('consultRights') ); ?> 

<h2 class="header_center"> <?php print( $flux->translate('consultPaidSums') ); ?> </h2> 
<?php print( $flux->getResult('consultPaidSums') ); ?> 

<h2 class="header_center"> <?php print( $flux->translate('consultActivationPaidSums') ); ?> </h2> 
<?php print( $flux->getResult('consultActivationPaidSums') ); ?> 