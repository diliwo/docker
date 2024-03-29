<h1>ONEM</h1>

<h2> Dernière situation connue </h2>
<?php print_r ( $flux->getResult('consultSituation') ); ?>

<h2> Sommes payées </h2>
<?php print_r ( $flux->getResult('consultPaidSums') ); ?>

<?php /*

<h2> <?php print( $flux->translate('consultScheduledPayment') ); ?> </h2>
<?php print_r ( $flux->getResult('consultScheduledPayment') ); ?>  

<h2><?php print( $flux->translate('consultActivationPaidSums') ); ?> </h2>
<fieldset> 
	<legend> <?php print( $flux->translate('consultActivationPaidSums') ); ?> </legend>
	<?php print_r ( $flux->getResult('consultActivationPaidSums') ); ?> 
</fieldset>

<h2> <?php print( $flux->translate('consultCareerBreak') ); ?> </h2>
<fieldset> 
	<legend> <?php print( $flux->translate('consultCareerBreak') ); ?> </legend>
	  <?php print_r ( $flux->getResult('consultCareerBreak') ); ?>        
</fieldset>
*/

?>