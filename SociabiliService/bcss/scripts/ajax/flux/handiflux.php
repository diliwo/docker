<h1>Direction Générale des Personnes Handicapées</h1>

<?php if($situation['error']): ?>

	<p class="error"><?php echo $situation['message']; ?></p>

<?php else: ?>

	<p class="info"><?php echo $situation['message']; ?></p>

	<?php if($situation['data']): ?>

		<div class="fieldset">
			<h1>Demande en cours</h1>
			<table width="100%">
				<tbody>
					<tr>
						<th>Législation</th>
						<td>
							<?php
							switch ($situation['data']->evolutionOfRequest->legislation) {
								case 0: echo "Aucune demande en cours"; break;
								case 1: echo "Allocations familiales supplémentaires, ancienne législation"; break;
								case 2: echo "Allocations familiales supplémentaires, nouvelle législation"; break;
								case 3: echo "Allocations de remplacement de revenu / Allocations d'intégration"; break;
								case 4: echo "Allocations pour l'aide aux personnes âgées"; break;
								case 5: echo "Ancienne législation"; break;
								default: echo "Inconnue"; break;
							}
							?>
						</td>
					</tr>
					<?php if (isset($situation['data']->evolutionOfRequest->requestDate)) : ?>
						<tr>
							<th>Date de demande</th>
							<td><?php implode('/', array_reverse(explode('-', $situation['data']->evolutionOfRequest->requestDate))); ?></td>
						</tr>
					<?php endif; ?>
					<tr>
						<th>Demande administrative</th>
						<td><?php echo $situation['data']->evolutionOfRequest->administrativePendingRequest ? 'Oui' : 'Non'; ?></td>
					</tr>
					<tr>
						<th>Examen de la reconnaissance du handicap</th>
						<td><?php echo $situation['data']->evolutionOfRequest->handicapRecognitionPending ? 'Oui' : 'Non'; ?></td>
					</tr>
					<?php if (isset($situation['data']->evolutionOfRequest->fileCompletionDate)) : ?>
						<tr>
							<th>Date du dossier complet</th>
							<td><?php echo implode('/', array_reverse(explode('-', $situation['data']->evolutionOfRequest->fileCompletionDate))); ?></td>
						</tr>
					<?php endif; ?>
					<tr>
						<th>En appel</th>
						<td><?php echo $situation['data']->evolutionOfRequest->appeal ? 'Oui' : 'Non'; ?></td>
					</tr>
				</tbody>
			</table>
		</div>

		<div class="fieldset">
			<h1>Reconnaissance du handicap</h1>
			<table width="100%">
				<tbody>
					<tr>
						<th>Date de décision</th>
						<td><?php echo $situation['data']->handicapRecognition->dateOfDecision ? implode('/', array_reverse(explode('-', $situation['data']->handicapRecognition->dateOfDecision))) : 'Aucune'; ?></td>
					</tr>
					<tr>
						<th>Date de début de la reconnaissance</th>
						<td><?php echo $situation['data']->handicapRecognition->dateOfDecision ? implode('/', array_reverse(explode('-', $situation['data']->handicapRecognition->startDateRecognition))) : 'Aucune'; ?></td>
					</tr>
					<?php if (isset($situation['data']->handicapRecognition->endDateRecognition)) : ?>
						<tr>
							<th>Date de fin de la reconnaissance</th>
							<td><?php echo implode('/', array_reverse(explode('-', $situation['data']->handicapRecognition->endDateRecognition))); ?></td>
						</tr>
					<?php endif; ?>
				</tbody>
			</table>
			<h2>Détail de la reconnaissance</h2>
			<table width="100%">
				<tbody>
					<tr>
						<th>50% des membres inférieurs</th>
						<td><?php echo $situation['data']->handicapRecognition->handicapRecognitionDetails->lowerLimbs50p ? 'Oui' : 'Non'; ?></td>
					</tr>
					<tr>
						<th>Cécité complète</th>
						<td><?php echo $situation['data']->handicapRecognition->handicapRecognitionDetails->fullBlindness ? 'Oui' : 'Non'; ?></td>
					</tr>
					<tr>
						<th>Amputation des membres supérieurs</th>
						<td><?php echo $situation['data']->handicapRecognition->handicapRecognitionDetails->upperLimbsAmputated ? 'Oui' : 'Non'; ?></td>
					</tr>
					<tr>
						<th>Paralysie des membres supérieurs</th>
						<td><?php echo $situation['data']->handicapRecognition->handicapRecognitionDetails->upperLimbsParalyzed ? 'Oui' : 'Non'; ?></td>
					</tr>
				</tbody>
			</table>
			<?php if (isset($situation['data']->handicapRecognition->resultRecognitionAdult)) : ?>
				<h2>Résultat de la reconnaissance (adulte)</h2>
				<table width="100%">
					<tbody>
						<tr>
							<th valign="top">Réduction de l'autonomie</th>
							<td>
								Score total : <?php echo $situation['data']->handicapRecognition->resultRecognitionAdult->diminuationIndependence->totalPoints; ?> / 18<br>
								<?php /*<ul>
									<li>Possibilité de se déplacer : <?php echo $situation['data']->handicapRecognition->resultRecognitionAdult->diminuationIndependence->mobility; ?> / 3</li>
									<li>Se préparer à manger et manger : <?php echo $situation['data']->handicapRecognition->resultRecognitionAdult->diminuationIndependence->nourishment; ?> / 3</li>
									<li>Assurer son hygiène personnelle et s'habiller : <?php echo $situation['data']->handicapRecognition->resultRecognitionAdult->diminuationIndependence->hygiene; ?> / 3</li>
									<li>Entretenir sa maison et accomplir des tâches ménagères : <?php echo $situation['data']->handicapRecognition->resultRecognitionAdult->diminuationIndependence->household; ?> / 3</li>
									<li>Vivre sans surveillance : <?php echo $situation['data']->handicapRecognition->resultRecognitionAdult->diminuationIndependence->supervision; ?> / 3</li>
									<li>Communication et contact social : <?php echo $situation['data']->handicapRecognition->resultRecognitionAdult->diminuationIndependence->socialSkills; ?> / 3</li>
								</ul>*/ ?>
							</td>
						</tr>
						<tr>
							<th>Diminution de l'audition</th>
							<td><?php echo $situation['data']->handicapRecognition->resultRecognitionAdult->diminuationEarnings ? 'Oui' : 'Non'; ?></td>
						</tr>
						<?php if ($situation['data']->handicapRecognition->resultRecognitionAdult->unsuitability->mentalUnsuitabilit): ?>
							<tr>
								<th>Incapacité mentale</th>
								<td><?php echo $situation['data']->handicapRecognition->resultRecognitionAdult->unsuitability->mentalUnsuitability; ?> %</td>
							</tr>
						<?php endif; ?>
						<?php if ($situation['data']->handicapRecognition->resultRecognitionAdult->unsuitability->physicalUnsuitability): ?>
							<tr>
								<th>Incapacité physique</th>
								<td><?php echo $situation['data']->handicapRecognition->resultRecognitionAdult->unsuitability->physicalUnsuitability; ?> %</td>
							</tr>
						<?php endif; ?>
					</tbody>
				</table>
			<?php endif; ?>
			<?php if (isset($situation['data']->handicapRecognition->resultRecognitionChild)) : ?>
				<h2>Résultat de la reconnaissance (enfant)</h2>
				<table width="100%">
					<tbody>
						<tr>
							<th>Incapacité de suivre des cours</th>
							<td><?php echo $situation['data']->handicapRecognition->resultRecognitionChild->inabilityFollowCourse ? 'Oui' : 'Non'; ?></td>
						</tr>
						<tr>
							<th>Incapacité d'exercer une profession</th>
							<td><?php echo $situation['data']->handicapRecognition->resultRecognitionChild->inabilityToWork ? 'Oui' : 'Non'; ?></td>
						</tr>
						<tr>
							<th>Incapacité</th>
							<td>
								<?php
								switch ($situation['data']->handicapRecognition->resultRecognitionChild->disabilityCode) {
									case 1: echo "De 0 % à 65 %"; break;
									case 2: echo "De 66 % à 79 %"; break;
									case 3: echo "De 80 % à 100 %"; break;
									default: echo "Non renseigné"; break;
								}
								?>
							</td>
						</tr>
						<tr>
							<th>Réduction de l'autonomie</th>
							<td>
								<?php
								switch ($situation['data']->handicapRecognition->resultRecognitionChild->independencyScore) {
									case 1: echo "De 0 à 3 points"; break;
									case 2: echo "De 4 à 6 points"; break;
									case 3: echo "De 7 à 9 points"; break;
									default: echo "Non renseigné"; break;
								}
								?>
							</td>
						</tr>
						<tr>
							<th valign="top">Piliers</th>
							<td>
								Score total : <?php echo $situation['data']->handicapRecognition->resultRecognitionChild->pillars->pillarsTotal; ?> / 36<br>
								<?php /*<ul>
									<li>
										<?php echo $situation['data']->handicapRecognition->resultRecognitionChild->pillars->pillar1; ?> / 6
										<?php
										switch ($situation['data']->handicapRecognition->resultRecognitionChild->pillars->pillar1) {
											case 0: echo "(de 0 % à 24 %)"; break;
											case 1: echo "(de 25 % à 49 %)"; break;
											case 2: echo "(de 50 % à 65 %)"; break;
											case 4: echo "(de 66 % à 79 %)"; break;
											case 6: echo "(de 80 % à 100 %)"; break;
										}
										?>
									</li>
									<li><?php echo $situation['data']->handicapRecognition->resultRecognitionChild->pillars->pillar2; ?> / 12</li>
									<li><?php echo $situation['data']->handicapRecognition->resultRecognitionChild->pillars->pillar3; ?> / 18</li>
								</ul>*/ ?>
							</td>
						</tr>
						<tr>
							<th>Pathologies infantiles spécifiques</th>
							<td><?php echo $situation['data']->handicapRecognition->resultRecognitionChild->childPathology ? 'Pas receonnu' : 'Reconnu'; ?></td>
						</tr>
					</tbody>
				</table>
			<?php endif; ?>
		</div>
		
		<?php if (!isset($situation['data']->rights->noDataReason)): ?>
			<div class="fieldset">
				<h1>Droits</h1>
				<table width="100%">
					<tbody>
						<tr>
							<th>Date de prise de cours</th>
							<td><?php echo implode('/', array_reverse(explode('-', $situation['data']->rights->period->beginDate))); ?></td>
						</tr>
						<?php if (isset($situation['data']->rights->endDate)) : ?>
							<tr>
								<th>Date de fin</th>
								<td><?php echo implode('/', array_reverse(explode('-', $situation['data']->rights->period->endDate))); ?></td>
							</tr>
						<?php endif; ?>
						<tr>
							<th>Législation</th>
							<td>
								<?php
								switch ($situation['data']->rights->legislation) {
									case 3: echo 'ARR/AI'; break;
									case 4: echo 'AAPA'; break;
									case 5: echo 'AO Allocation ordinaire (ancienne législation)'; break;
									case 6: echo 'AS Allocation spéciale (ancienne législation)'; break;
									case 7: echo 'ATP Allocation pour aide de tiers (ancienne législation)'; break;
									case 8: echo 'ACRG Allocation de complément du revenu garanti aux personnes âgées (ancienne législation)'; break;
									case 9: echo 'AC Allocation complémentaire (ancienne législation)'; break;
								}
								?>
							</td>
						</tr>
						<tr>
							<th>Total du montant mensuel</th>
							<td><?php echo number_format($situation['data']->rights->totalMonthAmount, 2, ',', '.'); ?> €</td>
						</tr>
						<tr>
							<th>Montant mensuel AI</th>
							<td><?php echo number_format($situation['data']->rights->monthAmount, 2, ',', '.'); ?> €</td>
						</tr>
						<tr>
							<th valign="top">Catégorie ARR</th>
							<td>
								<?php
								switch ($situation['data']->rights->categoryIVT) {
									case 'A': echo "Catégorie A<br><em>Personne handicapée qui n'appartient ni à la catégorie B, ni à la catégorie C.</em>"; break;
									case 'B': echo "Catégorie B<br><em>Personne handicapée qui soit habite seule, soit séjourne jour et nuit dans un établissement de soins depuis au moins trois mois et qui n'appartenait précédement pas à la catégorie C.</em>"; break;
									case 'C': echo "Catégorie C<br><em>Personne handicapée qui soit forme un ménage, soit a un ou plusieurs enfants à charge.</em>"; break;
									default: echo 'Aucune'; break;
								}
								?>
							</td>
						</tr>
						<tr>
							<th>Catégorie AI/AAPA</th>
							<td>
								<?php
								switch ($situation['data']->rights->categoryIT) {
									case 1: echo '7 ou 8 points'; break;
									case 2: echo '9 ou 11 points'; break;
									case 3: echo '12 ou 14 points'; break;
									case 4: echo '15 ou 16 points'; break;
									case 5: echo '17 points ou plus'; break;
									default: echo 'Aucune'; break;
								}
								?>
							</td>
						</tr>
							<th>Exonération des revenus du partenaire</th>
							<td><?php echo $situation['data']->rights->partnerIncome ? 'Exonération' : 'Pas d\'exonération'; ?></td>
						</tr>
					</tbody>
				</table>
			</div>
		<?php endif; ?>

		<?php /*if (is_array($situation['data']->socialCards)): ?>
			<div class="fieldset">
				<h1>Cartes sociales</h1>
				<?php foreach ($situation['data']->socialCards as $socialCard): ?>
					<h2><?php
						switch ($socialCard->cardType) {
							case 'PARKINGCARD': echo 'Carte de parking'; break;
							case 'REDUCTIONCARD': echo 'Carte de réduction'; break;
							default: echo 'Autre carte'; break;
						}
					?></h2>
					<table width="100%">
						<tbody>
							<tr>
								<th>Date de prise de cours</th>
								<td><?php echo implode('/', array_reverse(explode('-', $socialCard->deliveryDate))); ?></td>
							</tr>
							<?php if (isset($socialCard->endDate)): ?>
								<tr>
									<th>Date de fin</th>
									<td><?php echo implode('/', array_reverse(explode('-', $socialCard->endDate))); ?></td>
								</tr>
							<?php endif; ?>
							<tr>
								<th>Numéro de carte</th>
								<td><?php echo $socialCard->cardNumber; ?></td>
							</tr>
						</tbody>
					</table>
				<?php endforeach; ?>
			</div>
		<?php elseif (!isset($situation['data']->socialCards->noDataReason)): ?>
			<div class="fieldset">
				<h1>Cartes sociales</h1>
				<h2><?php
				switch ($situation['data']->socialCards->cardType) {
					case 'PARKINGCARD': echo 'Carte de parking'; break;
					case 'REDUCTIONCARD': echo 'Carte de réduction'; break;
					default: echo 'Autre carte'; break;
				}
				?></h2>
				<table width="100%">
					<tbody>
						<tr>
							<th>Date de prise de cours</th>
							<td><?php echo implode('/', array_reverse(explode('-', $situation['data']->socialCards->deliveryDate))); ?></td>
						</tr>
						<?php if (isset($situation['data']->socialCards->endDate)): ?>
							<tr>
								<th>Date de fin</th>
								<td><?php echo implode('/', array_reverse(explode('-', $situation['data']->socialCards->endDate))); ?></td>
							</tr>
						<?php endif; ?>
						<tr>
							<th>Numéro de carte</th>
							<td><?php echo $situation['data']->socialCards->cardNumber; ?></td>
						</tr>
					</tbody>
				</table>
			</div>
		<?php endif;*/ ?>

		<?php if (!isset($situation['data']->payments->noDataReason)): ?>
			<div class="fieldset">
				<h1>Paiements</h1>
				<table width="100%">
					<tbody>
						<?php $situation['data']->payments = array_reverse($situation['data']->payments);
						foreach ($situation['data']->payments as $payment):
							$paymentYearMonth = explode('-', $payment->yearMonth); ?>
							<tr>
								<th>Année <?php echo $paymentYearMonth[0]; ?>, mois <?php echo $paymentYearMonth[1]; ?></th>
								<td><?php echo number_format($payment->amount, 2, ',', '.'); ?> €</td>
							</tr>
						<?php endforeach; ?>
					</tbody>
				</table>
			</div>	
		<?php endif; ?>	

	<?php endif; ?>

<?php endif; ?>