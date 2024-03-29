<h1>ONEM</h1>
<h2 class="header_center"> <?php print( $flux->translate('consultSituation') ); ?>  </h2> 
<?php print( $flux->getResult('consultSituation') ); ?>

<h2 class="header_center"> <?php print( $flux->translate('consultPaidSums') ); ?>  </h2>
<?php print( $flux->getResult('consultPaidSums') ); ?>

<?php 
/*
<h2> <?php print( $flux->translate('consultScheduledPayment') ); ?> </h2>
<?php print( $flux->getResult('consultScheduledPayment') ); ?>  

<h2><?php print( $flux->translate('consultActivationPaidSums') ); ?> </h2>
<?php print( $flux->getResult('consultActivationPaidSums') ); ?> 

<h2> <?php print( $flux->translate('consultCareerBreak') ); ?> </h2>
<?php print( $flux->translate('consultCareerBreak') ); ?>      
*/
?>