<h1>Mutualités (état actuel)</h1>

<?php if ($assurabilites['error']): ?>

	<p><?php echo $assurabilites['message']; ?></p>

<?php else: ?>
	<?php $assurabilite = $assurabilites['data']; ?>
	
	<?php if (isset($assurabilite->insuringOrganization)): ?>
	<div class="fieldset">
		<h1>Organisme assureur</h1>

		<table>
			<tbody>
				<tr>
					<th>Mutuelle :</th>
					<td><?php echo $mutuelleDb->getNomFromNumeroSection( $assurabilite->insuringOrganization->mutuality ); ?></td>
				</tr>

				<tr>
					<th>Organisme assureur :</th>
					<td><?php echo $mutuelleDb->getNomFromNumeroSection( $assurabilite->insuringOrganization->insuringOrganization ); ?></td>
				</tr>
			</tbody>
		</table>
	</div>
	<?php endif; ?>

	<?php if (isset($assurabilite->ct1ct2)): ?>
	<div class="fieldset">
		<h1>CT1/CT2</h1>

		<table>
			<tbody>
				<tr>
					<th>Mutuelle :</th>
					<td>
					<?php 
					
					   echo $mutuelleDb->getNomFromNumeroSection(       
					        (
					           isset( $assurabilite->ct1ct2->mutuality) ?
					           $assurabilite->ct1ct2->mutuality :
					           NULL
					        ) 
					   ); 
					   
					?>   
					</td>
				</tr>

				<tr>
					<th>Organisme assureur :</th>
					<td>
					<?php 
					
					   echo $mutuelleDb->getNomFromNumeroSection( 
                            (
                                isset( $assurabilite->ct1ct2->insuringOrganization) ?
                                $assurabilite->ct1ct2->insuringOrganization :
                                NULL 
                            ) 
					  ); 
					
					?>
					</td>
				</tr>

				<tr>
					<th>Période:</th>
					<td><?php echo PeriodeHealthcareInsurance::format( $assurabilite->ct1ct2->period ); ?></td>
				</tr>

				<tr>
					<th>CT1/CT2:</th>
					<td><?php echo $assurabilite->ct1ct2->ct1 . "/" . $assurabilite->ct1ct2->ct2; ?></td>
				</tr>
			</tbody>
		</table>
	</div>
	<?php endif; ?>

	<div class="fieldset">
		<h1>Droits</h1>

		<table>
			<tbody>
				<?php if (isset($assurabilite->reimbursementRight)): ?>
					<?php 
						$infoSupplementaire = "";
						if ($assurabilite->reimbursementRight->value == 1) {
							$infoSupplementaire .= "<p>Organisme assureur: " . $mutuelleDb->getNomFromNumeroSection( $assurabilite->reimbursementRight->insuringOrganization ) . "</p>";
						}
					?>
				<tr>
					<th>Droit au remboursement :</th>
					<td class="yes_no"><?php echo (empty($assurabilite->reimbursementRight->value))?'<img src="'. $baseFolder . 'includes/images/no.png" alt="NON" title="NON">':'<img src="'. $baseFolder . 'includes/images/yes.png" alt="OUI" title="OUI">'; ?></td>
					<td><?php echo (empty($infoSupplementaire))?'':$infoSupplementaire; ?></td>
				</tr> 
				<?php endif; ?>

				<?php if (isset($assurabilite->payingThirdParty)): ?>
					<?php 
						$infoSupplementaire = "";
						if ($assurabilite->payingThirdParty->value == 1) {
							$infoSupplementaire .= "<p>Organisme assureur: " . $mutuelleDb->getNomFromNumeroSection( $assurabilite->payingThirdParty->insuringOrganization ) . "</p>";
						}
					?>
				<tr>
					<th>Droit au tiers payant :</th>
					<td class="yes_no"><?php echo (empty($assurabilite->payingThirdParty->value))?'<img src="'. $baseFolder . 'includes/images/no.png" alt="NON" title="NON">':'<img src="'. $baseFolder . 'includes/images/yes.png" alt="OUI" title="OUI">'; ?></td>
					<td><?php echo (empty($infoSupplementaire))?'':$infoSupplementaire; ?></td>
				</tr> 
				<?php endif; ?>

				<?php if (isset($assurabilite->maximumCharge)): ?>
					<?php 
						$infoSupplementaire = "";
						if (isset($assurabilite->maximumCharge->year)) {
							if (is_array($assurabilite->maximumCharge->year)) {
								foreach ($assurabilite->maximumCharge->year as $data) {
									$infoSupplementaire .= '<p>- En ' . $data->_ . " (" . $mutuelleDb->getNomFromNumeroSection( $data->insuringOrganization ) . ")</p>";
								}

							} else {
								$infoSupplementaire .= '<p>- En ' . $assurabilite->maximumCharge->year->_ . " (" . $mutuelleDb->getNomFromNumeroSection( $assurabilite->maximumCharge->year->insuringOrganization ) . ")</p>";
							}
							
						}
					?>
				<tr>
					<th>Maximum à facturer atteint :</th>
					<td class="yes_no"><?php echo ($assurabilite->maximumCharge->noRight)?'<img src="'. $baseFolder . 'includes/images/no.png" alt="NON" title="NON">':'<img src="'. $baseFolder . 'includes/images/yes.png" alt="OUI" title="OUI">'; ?></td>
					<td><?php echo (empty($infoSupplementaire))?'':$infoSupplementaire; ?></td>
				</tr>
				<?php endif; ?>

				<?php if (isset($assurabilite->medicalHouse)): ?>
					<?php 
						$infoSupplementaire = "";
						if (isset($assurabilite->medicalHouse->period)) {
							$infoSupplementaire .= "<p>Période: " . PeriodeHealthcareInsurance::format( $assurabilite->medicalHouse->period ) . "</p>";
							if (isset($assurabilite->medicalHouse->period->insuringOrganization)) {
								$infoSupplementaire .= "<p>Organisme assureur: " . $mutuelleDb->getNomFromNumeroSection( $assurabilite->medicalHouse->period->insuringOrganization ) . "</p>";
							}
						}
						if (isset($assurabilite->medicalHouse->doctor) || isset($assurabilite->medicalHouse->kine) || isset($assurabilite->medicalHouse->nurse)) {
							$professionnels = array();
							if ($assurabilite->medicalHouse->doctor == '1')
								$professionnels[] = "une doctoresse/un docteur";
							if ($assurabilite->medicalHouse->kine == '1')
								$professionnels[] = "un(e) kiné";
							if ($assurabilite->medicalHouse->nurse == '1')
								$professionnels[] = "une infirmière/un infirmier";

							$infoSupplementaire .= "<p>Contrat avec: " . implode(", ", $professionnels) . "</p>";
						}
					?>
				<tr>
					<th>En contrat avec une maison médicale :</th>
					<td class="yes_no"><?php echo ($assurabilite->medicalHouse->noRight)?'<img src="'. $baseFolder . 'includes/images/no.png" alt="NON" title="NON">':'<img src="'. $baseFolder . 'includes/images/yes.png" alt="OUI" title="OUI">'; ?></td>
					<td><?php echo (empty($infoSupplementaire))?'':$infoSupplementaire; ?></td>
				</tr>
				<?php endif; ?>

				<?php if (isset($assurabilite->increasedIntervention)): ?>
					<?php 
						$infoSupplementaire = "";
						if (isset($assurabilite->increasedIntervention->period)) {
							$infoSupplementaire .= "<p>Période: " . PeriodeHealthcareInsurance::format( $assurabilite->increasedIntervention->period ) . "</p>";
						}
					?>
				<tr>
					<th>Droit à l'intervention majorée :</th>
					<td class="yes_no">
					
					<?php 
					
					echo ( isset( $assurabilite->increasedIntervention->noRight) ) ? 
					   '<img src="'. $baseFolder . 'includes/images/no.png" alt="NON" title="NON">' : 
					   '<img src="'. $baseFolder . 'includes/images/yes.png" alt="OUI" title="OUI">'; 
					
					?>
					
					</td>
					<td><?php echo (empty($infoSupplementaire))?'':$infoSupplementaire; ?></td>
				</tr>
				<?php endif; ?>

				<?php if (isset($assurabilite->statusComplementaryInsurance)): ?>
					<?php 
						$infoSupplementaire = "";
						if ($assurabilite->statusComplementaryInsurance->value == 1) {
							$infoSupplementaire .= "<p>Organisme assureur: " . $mutuelleDb->getNomFromNumeroSection( $assurabilite->statusComplementaryInsurance->insuringOrganization ) . "</p>";
						}
					?>
				<tr>
					<th>Assurance complémentaire :</th>
					<td class="yes_no"><?php echo ($assurabilite->statusComplementaryInsurance->noRight)?'<img src="'. $baseFolder . 'includes/images/no.png" alt="NON" title="NON">':'<img src="'. $baseFolder . 'includes/images/yes.png" alt="OUI" title="OUI">'; ?></td>
					<td><?php echo (empty($infoSupplementaire))?'':$infoSupplementaire; ?></td>
				</tr>
				<?php endif; ?>

				<?php if (isset($assurabilite->globalMedicalFile)): ?>
					<?php 
						$infoSupplementaire = "";
						if (isset($assurabilite->globalMedicalFile->healthCareProvider)) {
							$infoSupplementaire .= "<p>Numéro INAMI: " . substr($assurabilite->globalMedicalFile->healthCareProvider, 0, 8) . " (qualification " . substr($assurabilite->globalMedicalFile->healthCareProvider, -3) . ")</p>";
						}
					?>
				<tr>
					<th>Dossier géré par un médecin :</th>
					<td>
					<?php 
					   echo ( isset( $assurabilite->globalMedicalFile->noRight) ) ? 
					       '<img src="'. $baseFolder . 'includes/images/no.png" alt="NON" title="NON">' : 
					       '<img src="'. $baseFolder . 'includes/images/yes.png" alt="OUI" title="OUI">'; 
					   ?>
					  </td>
					<td><?php echo (empty($infoSupplementaire))?'':$infoSupplementaire; ?></td>
				</tr>
				<?php endif; ?>
			</tbody>
		</table>
	</div>

<?php endif; ?>

<h1>Mutualités (état passé) </h1>
<?php if (count($assurabilitessPasse) > 0): ?>
	<?php foreach ($assurabilitessPasse as $i => $assurabilitesPasse): ?>

		<?php if ($assurabilitesPasse['error']): ?>

			<p><?php echo $assurabilitesPasse['message']; ?></p>

		<?php else: ?>
			<?php $assurabilite = $assurabilitesPasse['data']; ?>
			<?php echo ($i>0)?"<hr style='margin-top: 30px;'>":""; ?>
			
			<?php if (isset($assurabilite->insuringOrganization)): ?>
			<div class="fieldset">
				<h1>Organisme assureur</h1>

				<table>
					<tbody>
						<tr>
							<th>Mutuelle :</th>
							<td><?php echo $mutuelleDb->getNomFromNumeroSection( $assurabilite->insuringOrganization->mutuality ); ?></td>
						</tr>

						<tr>
							<th>Organisme assureur :</th>
							<td><?php echo $mutuelleDb->getNomFromNumeroSection( $assurabilite->insuringOrganization->insuringOrganization ); ?></td>
						</tr>
					</tbody>
				</table>
			</div>
			<?php endif; ?>

			<?php if (isset($assurabilite->ct1ct2)): ?>
			<div class="fieldset">
				<h1>CT1/CT2</h1>

				<table>
					<tbody>
						<tr>
							<th>Mutuelle :</th>
							<td>
							<?php 
							
							echo $mutuelleDb->getNomFromNumeroSection( 
							         (
							             isset($assurabilite->ct1ct2->mutuality) ?
							             $assurabilite->ct1ct2->mutuality :
							             NULL
							         )
							    
							    ); 
							
							?>
							
							</td>
						</tr>

						<tr>
							<th>Organisme assureur :</th>
							<td>
							<?php 
							
							 echo $mutuelleDb->getNomFromNumeroSection( 
							         (
							             isset($assurabilite->ct1ct2->insuringOrganization) ?
							             $assurabilite->ct1ct2->insuringOrganization :
							             NULL
							         )
							     ); 
							 
							 ?>
							 </td>
						</tr>

						<tr>
							<th>Période:</th>
							<td><?php echo PeriodeHealthcareInsurance::format( $assurabilite->ct1ct2->period ); ?></td>
						</tr>

						<tr>
							<th>CT1/CT2:</th>
							<td><?php echo $assurabilite->ct1ct2->ct1 . "/" . $assurabilite->ct1ct2->ct2; ?></td>
						</tr>
					</tbody>
				</table>
			</div>
			<?php endif; ?>

			<div class="fieldset">
				<h1>Droits</h1>

				<table>
					<tbody>
						<?php if (isset($assurabilite->reimbursementRight)): ?>
							<?php 
								$infoSupplementaire = "";
								if ($assurabilite->reimbursementRight->value == 1) {
									$infoSupplementaire .= "<p>Organisme assureur: " . $mutuelleDb->getNomFromNumeroSection( $assurabilite->reimbursementRight->insuringOrganization ) . "</p>";
								}
							?>
						<tr>
							<th>Droit au remboursement :</th>
							<td class="yes_no"><?php echo (empty($assurabilite->reimbursementRight->value))?'<img src="'. $baseFolder . 'includes/images/no.png" alt="NON" title="NON">':'<img src="'. $baseFolder . 'includes/images/yes.png" alt="OUI" title="OUI">'; ?></td>
							<td><?php echo (empty($infoSupplementaire))?'':$infoSupplementaire; ?></td>
						</tr> 
						<?php endif; ?>

						<?php if (isset($assurabilite->payingThirdParty)): ?>
							<?php 
								$infoSupplementaire = "";
								if ($assurabilite->payingThirdParty->value == 1) {
									$infoSupplementaire .= "<p>Organisme assureur: " . $mutuelleDb->getNomFromNumeroSection( $assurabilite->payingThirdParty->insuringOrganization ) . "</p>";
								}
							?>
						<tr>
							<th>Droit au tiers payant :</th>
							<td class="yes_no"><?php echo (empty($assurabilite->payingThirdParty->value))?'<img src="'. $baseFolder . 'includes/images/no.png" alt="NON" title="NON">':'<img src="'. $baseFolder . 'includes/images/yes.png" alt="OUI" title="OUI">'; ?></td>
							<td><?php echo (empty($infoSupplementaire))?'':$infoSupplementaire; ?></td>
						</tr> 
						<?php endif; ?>

						<?php if (isset($assurabilite->maximumCharge)): ?>
							<?php 
								$infoSupplementaire = "";
								if (isset($assurabilite->maximumCharge->year)) {
									if (is_array($assurabilite->maximumCharge->year)) {
										foreach ($assurabilite->maximumCharge->year as $data) {
											$infoSupplementaire .= '<p>- En ' . $data->_ . " (" . $mutuelleDb->getNomFromNumeroSection( $data->insuringOrganization ) . ")</p>";
										}

									} else {
										$infoSupplementaire .= '<p>- En ' . $assurabilite->maximumCharge->year->_ . " (" . $mutuelleDb->getNomFromNumeroSection( $assurabilite->maximumCharge->year->insuringOrganization ) . ")</p>";
									}
									
								}
							?>
						<tr>
							<th>Maximum à facturer atteint :</th>
							<td class="yes_no"><?php echo ($assurabilite->maximumCharge->noRight)?'<img src="'. $baseFolder . 'includes/images/no.png" alt="NON" title="NON">':'<img src="'. $baseFolder . 'includes/images/yes.png" alt="OUI" title="OUI">'; ?></td>
							<td><?php echo (empty($infoSupplementaire))?'':$infoSupplementaire; ?></td>
						</tr>
						<?php endif; ?>

						<?php if (isset($assurabilite->medicalHouse)): ?>
							<?php 
								$infoSupplementaire = "";
								if (isset($assurabilite->medicalHouse->period)) {
									$infoSupplementaire .= "<p>Période: " . PeriodeHealthcareInsurance::format( $assurabilite->medicalHouse->period ) . "</p>";
									if (isset($assurabilite->medicalHouse->period->insuringOrganization)) {
										$infoSupplementaire .= "<p>Organisme assureur: " . $mutuelleDb->getNomFromNumeroSection( $assurabilite->medicalHouse->period->insuringOrganization ) . "</p>";
									}
								}
								if (isset($assurabilite->medicalHouse->doctor) || isset($assurabilite->medicalHouse->kine) || isset($assurabilite->medicalHouse->nurse)) {
									$professionnels = array();
									if ($assurabilite->medicalHouse->doctor == '1')
										$professionnels[] = "une doctoresse/un docteur";
									if ($assurabilite->medicalHouse->kine == '1')
										$professionnels[] = "un(e) kiné";
									if ($assurabilite->medicalHouse->nurse == '1')
										$professionnels[] = "une infirmière/un infirmier";

									$infoSupplementaire .= "<p>Contrat avec: " . implode(", ", $professionnels) . "</p>";
								}
							?>
						<tr>
							<th>En contrat avec une maison médicale :</th>
							<td class="yes_no"><?php echo ($assurabilite->medicalHouse->noRight)?'<img src="'. $baseFolder . 'includes/images/no.png" alt="NON" title="NON">':'<img src="'. $baseFolder . 'includes/images/yes.png" alt="OUI" title="OUI">'; ?></td>
							<td><?php echo (empty($infoSupplementaire))?'':$infoSupplementaire; ?></td>
						</tr>
						<?php endif; ?>

						<?php if (isset($assurabilite->increasedIntervention)): ?>
							<?php 
								$infoSupplementaire = "";
								if (isset($assurabilite->increasedIntervention->period)) {
									$infoSupplementaire .= "<p>Période: " . PeriodeHealthcareInsurance::format( $assurabilite->increasedIntervention->period ) . "</p>";
								}
							?>
						<tr>
							<th>Droit à l'intervention majorée :</th>
							<td class="yes_no">
							<?php 
							     echo (isset( $assurabilite->increasedIntervention->noRight) ) ? 
							     '<img src="'. $baseFolder . 'includes/images/no.png" alt="NON" title="NON">' : 
							     '<img src="'. $baseFolder . 'includes/images/yes.png" alt="OUI" title="OUI">'; 
							 ?>
							 </td>
							<td><?php echo (empty($infoSupplementaire))?'':$infoSupplementaire; ?></td>
						</tr>
						<?php endif; ?>

						<?php if (isset($assurabilite->statusComplementaryInsurance)): ?>
							<?php 
								$infoSupplementaire = "";
								if ($assurabilite->statusComplementaryInsurance->value == 1) {
									$infoSupplementaire .= "<p>Organisme assureur: " . $mutuelleDb->getNomFromNumeroSection( $assurabilite->statusComplementaryInsurance->insuringOrganization ) . "</p>";
								}
							?>
						<tr>
							<th>Assurance complémentaire :</th>
							<td class="yes_no"><?php echo ($assurabilite->statusComplementaryInsurance->noRight)?'<img src="'. $baseFolder . 'includes/images/no.png" alt="NON" title="NON">':'<img src="'. $baseFolder . 'includes/images/yes.png" alt="OUI" title="OUI">'; ?></td>
							<td><?php echo (empty($infoSupplementaire))?'':$infoSupplementaire; ?></td>
						</tr>
						<?php endif; ?>

						<?php if (isset($assurabilite->globalMedicalFile)): ?>
							<?php 
								$infoSupplementaire = "";
								if (isset($assurabilite->globalMedicalFile->healthCareProvider)) {
									$infoSupplementaire .= "<p>Numéro INAMI: " . substr($assurabilite->globalMedicalFile->healthCareProvider, 0, 8) . " (qualification " . substr($assurabilite->globalMedicalFile->healthCareProvider, -3) . ")</p>";
								}
							?>
						<tr>
							<th>Dossier géré par un médecin :</th>
							<td>
							<?php 
							     echo (isset( $assurabilite->globalMedicalFile->noRight)) ? 
							         '<img src="'. $baseFolder . 'includes/images/no.png" alt="NON" title="NON">' :
							         '<img src="'. $baseFolder . 'includes/images/yes.png" alt="OUI" title="OUI">'; 
							 ?>
							 </td>
							<td><?php echo (empty($infoSupplementaire))?'':$infoSupplementaire; ?></td>
						</tr>
						<?php endif; ?>
					</tbody>
				</table>
			</div>

		<?php endif; ?>

	<?php endforeach; ?>

<?php else: ?>

	<p>Pas de données disponible</p>

<?php endif; ?>
