<h1>Registre des pensions</h1>

<?php if ($data['error']): ?>
  <p class="error"><?php echo $data['message']; ?></p>
<?php else: ?>
  <?php if (count($data['items']) == 0): ?>
    <p class="error">Aucunes données disponibles.</p>
  <?php else: ?>
    <?php foreach ($data['items'] as $PensionItem): ?>
        <?php foreach ($PensionItem->PayingInstitutionItem as $PayingInstitutionItemData): ?>
          <div class="fieldset">
            <h1>
              <?php echo $PensionItem->PayingInstitution->InstitutionName; ?>
              <span class="titre-infos">N° entreprise : <?php echo $PensionItem->PayingInstitution->DebtorInstitutionCompanyId; ?> | N° immatriculation : <?php echo $PensionItem->PayingInstitution->DebtorInstitutionImmatriculation; ?></span>
            </h1>

            <?php
            // Simplification des objets retournés
            $PensionDemand = isset($PayingInstitutionItemData->PensionDemand) ? $PayingInstitutionItemData->PensionDemand : FALSE;
            $RightAndPayments = isset($PayingInstitutionItemData->RightWithoutPayments) ? $PayingInstitutionItemData->RightWithoutPayments : FALSE;
            $RightAndPayments = !$RightAndPayments && isset($PayingInstitutionItemData->RightWithPayments) ? $PayingInstitutionItemData->RightWithPayments : $RightAndPayments;
            $RightAndPayments = !$RightAndPayments && isset($PayingInstitutionItemData->RightOnly) ? $PayingInstitutionItemData->RightOnly : $RightAndPayments;
            ?>

            <!-- PensionDemand -->
            <table>
              <tr>
                <td>
                  <?php if (isset($PensionDemand->PensionDemand)): ?>
                    Date de la demande : <?php echo implode('/', array_reverse(explode('-', $PensionDemand->PensionDemand))); ?>
                  <?php else: ?>
                    Date de la demande : Inconnue
                  <?php endif; ?>
                </td>
                <?php if (isset($PensionDemand->PensionDemandRefusalDate)): ?>
                  <td>Date du refus : <?php echo implode('/', array_reverse(explode('-', $PensionDemand->PensionDemandRefusalDate))); ?></td>
                <?php endif; ?>
              </tr>
            </table>
            <!-- /PensionDemand -->

            <?php if ($RightAndPayments): ?>
              <!-- RightInformation -->
              <h2>Droit</h2>
              <table>
                <tbody>
                  <tr>
                    <th>Droit</th>
                    <td>
                      <?php
                      if (isset($RightAndPayments->RightInformation->PensionStartDate)) {
                        echo 'Depuis le ';
                        echo implode('/', array_reverse(explode('-', $RightAndPayments->RightInformation->PensionStartDate)));
                        echo ' - ';
                      }
                      switch ($RightAndPayments->RightInformation->attributes()->Pillar) {
                        case 'First': echo "Premier pilier"; break;
                        case 'Second': echo "Deuxième pilier"; break;
                      }
                      switch ($RightAndPayments->RightInformation->Periodicity) {
                        case '1': echo " - Mensuel"; break;
                        case '2': echo " - Bimestriel"; break;
                        case '3': echo " - Trimestriel"; break;
                        case '4': echo " - Quadrimestriel"; break;
                        case '6': echo " - Semestriel"; break;
                        case 'E': echo " - Paiement exceptionnel"; break;
                        case 'J': echo " - Annuel"; break;
                        case 'K': echo " - Capital"; break;
                        case 'M': echo " - Mensuel"; break;
                      }
                      echo ' - Dossier n°' . $RightAndPayments->RightInformation->PensionFileId;
                      ?>
                    </td>
                  </tr>
                  <?php if (isset($RightAndPayments->RightInformation->PensionType)): ?>
                    <tr>
                      <th>Type de pension</th>
                      <td>
                        <?php
                        switch ($RightAndPayments->RightInformation->PensionType) {
                          case '1':	echo "Retraite ou droit personnel, à utiliser également en cas de paiement de capitaux en cas de vie"; break;
                          case '2':	echo "Survie (droit dérivé), à utiliser également en cas de paiement de capitaux en cas de décès"; break;
                          case '3':	echo "Conjoint divorcé (droit dérivé)"; break;
                          case '4':	echo "Orphelin (droit dérivé) non soumis à la loi du 15/5/1984 (MB du 22/5/1984)"; break;
                          case '5':	echo "Orphelin (droit dérivé) soumis à la loi du 15/5/1984 (MB du 22/5/1984)"; break;
                        }
                        ?>
                      </td>
                    </tr>
                  <?php endif; ?>
                  <?php if (isset($RightAndPayments->RightInformation->RightStartDate)): ?>
                    <tr>
                      <th>Période et origine du droit</th>
                      <td>
                        Depuis le <?php echo implode('/', array_reverse(explode('-', $RightAndPayments->RightInformation->RightStartDate))); ?>
                        <?php if (isset($RightAndPayments->RightInformation->RightCloseDate)): ?>
                          jusqu'au <?php echo implode('/', array_reverse(explode('-', $RightAndPayments->RightInformation->RightCloseDate))); ?>
                        <?php endif; ?>
                        <?php if (isset($RightAndPayments->RightInformation->RightOrigin)): ?>
                          <?php
                          switch ($RightAndPayments->RightInformation->RightOrigin) {
                            case '1':	echo " - National (Belgique)"; break;
                            case '2':	echo " - Étranger"; break;
                            case '3':	echo " - Supranational (UE, ONU, etc.)"; break;
                          }
                          ?>
                        <?php endif; ?>
                      </td>
                    </tr>
                  <?php endif; ?>
                  <?php if (isset($RightAndPayments->RightInformation->AdministrativeSituation)): ?>
                    <tr>
                      <th>Situation administrative</th>
                      <td>
                        <?php
                        switch ($RightAndPayments->RightInformation->AdministrativeSituation) {
                          case '0': echo "Autres catégories"; break;
                          case '1': echo "Assuré social régime salarié ou assimilé"; break;
                          case '2': echo "Assuré social régime indépendant ou professions libérales ou assimilé"; break;
                          case '3': echo "Fonctionnaire (titulaire d’une nomination à titre définitif)"; break;
                          case '4': echo "Mandataire politique"; break;
                          case '5': echo "Membre du personnel d’une entreprise ou d’une institution qui a son propre fonds de pensions ou autres moyens de financement"; break;
                          case '6': echo "Membre du personnel d’une entreprise ou d’une institution qui a souscrit un contrat collectif auprès d’un fonds de pensions extérieur"; break;
                          case '7': echo "Indépendant qui perçoit un avantage en exécution d’un engagement de pension individuel"; break;
                          case '8': echo "Indépendant qui perçoit une pension complémentaire, visée à l’article 52bis de l’arrêté royal n°72 du 10 novembre 1967 sur la pension de retraite et de survie des travailleurs indépendants"; break;
                        }
                        ?>
                      </td>
                    </tr>
                  <?php endif; ?>
                  <tr>
                    <th >Code et type d'avantage</th>
                    <td class="bold" >
                      <?php
                      switch ($RightAndPayments->RightInformation->AdvantageCode) {
                        case '97': echo "Bonus de Pension"; break;
                        case '98': echo "Aide Socio-Culturelle"; break;
                        case '99': echo "Pensions mensuelles"; break;
                        case '00': echo "soumis à la retenue AMI et à la retenue de solidarité"; break;
                        case '01': echo "Pension de retraite salarié"; break;
                        case '02': echo "Pension de retraite indépendant"; break;
                        case '03': echo "Revenu garanti"; break;
                        case '04': echo "Séparé salarié"; break;
                        case '05': echo "Séparé indépendant"; break;
                        case '06': echo "Retraite mineur - donées fixes uniquement"; break;
                        case '07': echo "Rente de retraite C.G.E.R. indexée"; break;
                        case '08': echo "Pension inconditionnelle de retraite salarié"; break;
                        case '09': echo "Majoration de rente vieillesse"; break;
                        case '10': echo "Prime de revalorisation indépendant"; break;
                        case '11': echo "Pension de survie salarié"; break;
                        case '12': echo "Pension de survie indépendant"; break;
                        case '13': echo "Uniquement zone blanco (provisionnel)"; break;
                        case '14': echo "Pension européenne de retraite d'indépendant"; break;
                        case '15': echo "Pension européenne de survie d'indépendant"; break;
                        case '16': echo "Pension de survie mineur - donées fixes uniquement"; break;
                        case '17': echo "Rente de survie C.G.E.R. indexée"; break;
                        case '18': echo "Pension inconditionnelle de survie salarié"; break;
                        case '19': echo "Majoration rente de veuve"; break;
                        case '20': echo "Supplément Pension de survie salarié (+100.000)  libre"; break;
                        case '21': echo "Pécule de vacances"; break;
                        case '22': echo "Allocation spéciale"; break;
                        case '23': echo "Allocation spéciale indépendant"; break;
                        case '24': echo "Prime de rattrapage"; break;
                        case '25': echo "Allocation spéciale salarié"; break;
                        case '26': echo "Allocation spéciale de chauffage"; break;
                        case '27': echo "Pension inconditionnelle de retraite indépendant"; break;
                        case '28': echo "Pension inconditionnelle de survie indépendant"; break;
                        case '29': echo "Supplément de pension d'indépendant"; break;
                        case '30': echo "Garantie de Ressources aux Personnes Agées"; break;
                        case '31': echo "Allocation prépension spéciale salarié"; break;
                        case '32': echo "Allocation prépension spéciale indépendant"; break;
                        case '33': echo "Allocation complémentaire handicapé"; break;
                        case '34': echo "Allocation de complément du RG"; break;
                        case '35': echo "Pension européenne de retraite inconditionnelle d'indépendant"; break;
                        case '36': echo "Charbon"; break;
                        case '37': echo "Pension européenne de survie inconditionnelle d'indépendant"; break;
                        case '38': echo "Indemnité pour aide à tierce-personne"; break;
                        case '39': echo "Allocation de chauffage"; break;
                        case '40': echo "Groupe 40 (Trimestriel)"; break;
                        case '41': echo "Retraite Salarié - Subrogation U.E."; break;
                        case '42': echo "Survie Salarié - Subrogation U.E."; break;
                        case '43': echo "Rente de vieillesse - Subrogation U.E."; break;
                        case '44': echo "Rente de veuve - Subrogation U.E."; break;
                        case '45': echo "Overgangsuitkering werknemers"; break;
                        case '46': echo "Overgangsuitkering zelfstandigen"; break;
                        case '47': echo "Etat belge indépendant A.R. 65"; break;
                        case '48': echo "Etat belge indépendant A.R. 70"; break;
                        case '49': echo "Rente de retraite (indexée jusqu'en 10/85)"; break;
                        case '50': echo "Rente de survie  (indexée jusqu'en 10/85)"; break;
                        case '51': echo "Pension étrangère"; break;
                        case '52': echo "Rente"; break;
                        case '53': echo "Complément prépension spéciale INAMI"; break;
                        case '54': echo "Complément prépension spéciale FNROM"; break;
                        case '55': echo "Complément prépension spéciale MARIN"; break;
                        case '56': echo "Allocation prépension spéciale salarié (invalide)"; break;
                        case '57': echo "Invalide civil PRS"; break;
                        case '58': echo "Invalide civil PRI"; break;
                        case '59': echo "Allocation prépension spéciale indépendant (invalide)"; break;
                        case '60': echo "Libellé non transmis"; break;
                        case '61': echo "Complément PRS"; break;
                        case '62': echo "Complément indemnité prépension"; break;
                        case '63': echo "Complément statut de reconnaissance nationale"; break;
                        case '64': echo "Libellé non transmis"; break;
                        case '65': echo "Supplément préretraite agriculture - Retraite 60/65"; break;
                        case '66': echo "Supplément préretraite agriculture - Retraite 65/75 C.E."; break;
                        case '67': echo "Supplément préretraite agriculture - Retraite 65/75 Min.Agr."; break;
                        case '68': echo "Supplément préretraite agriculture - Retraite (payé)"; break;
                        case '69': echo "Complément prépension spéciale"; break;
                        case '70': echo "Rente de retraite C.G.E.R. non indexée"; break;
                        case '71': echo "Complément PSS"; break;
                        case '72': echo "Rente de survie C.G.E.R. non indexée"; break;
                        case '73': echo "Rente non indexée (retraite) U.E."; break;
                        case '74': echo "Rente non indexée (survie)  U.E."; break;
                        case '75': echo "Rente non indexée (retraite)"; break;
                        case '76': echo "Rente non indexée (survie)"; break;
                        case '77': echo "Capital rente vieillesse."; break;
                        case '78': echo "Capital rente de veuve."; break;
                        case '79': echo "Rente non indexée (capital) U.E."; break;
                        case '80': echo "Rente non indexée (rachat) U.E."; break;
                        case '81': echo "Etat belge salarié"; break;
                        case '82': echo "Etat belge indépendant"; break;
                        case '83': echo "Prépension de retaite salarié"; break;
                        case '84': echo "Prépension de retaite indépendant"; break;
                        case '85': echo "Supplément agriculture - Survie 60/65"; break;
                        case '86': echo "Supplément agriculture - Survie 65/75 C.E."; break;
                        case '87': echo "Supplément agriculture - Survie 65/75 Min.Agr."; break;
                        case '88': echo "Supplément agriculture - Survie (payé)"; break;
                        case '89': echo "Prime de revalorisation salarié"; break;
                        case '90': echo "Allocation 01/78"; break;
                        case '91': echo "1ère  pension étrangère Gr.92"; break;
                        case '92': echo "2ème pension étrangère Gr.92"; break;
                        case '93': echo "3ème pension étrangère Gr.92"; break;
                        case '94': echo "4ème pension étrangère Gr.92"; break;
                        case '95': echo "Arriérés étrangers "; break;
                        case '96': echo "Libellé non transmis"; break;
                        case '97': echo "Montant imposable + %"; break;
                        case '98': echo "Cotisation de solidarité ('Solidarité TOTALE')"; break;
                        case '99': echo "Pension Pouvoirs Publics"; break;
                        case 'A1': echo "Invalidité pour pension coloniale"; break;
                        case 'B1': echo "Bourgmestre"; break;
                        case 'B2': echo "Echevin"; break;
                        case 'B3': echo "Président de C.P.A.S."; break;
                        case 'B4': echo "Personnel administratif"; break;
                        case 'B5': echo "Gouverneur de province"; break;
                        case 'B6': echo "Conseiller provincial"; break;
                        case 'B7': echo "Député permanent"; break;
                        case 'F4': echo "Bonus de pension retraite salarié"; break;
                        case 'F5': echo "Bonus de pension survie salarié"; break;
                        case 'F6': echo "Bonus de pension retraite indépendant"; break;
                        case 'F7': echo "Bonus de pension survie indépendant"; break;
                        case 'F8': echo "Bonus de bien-être"; break;
                        case 'F9': echo "Bonus de bien-être mensuel"; break;
                        case 'G0': echo "Pension de retraite salarié séparé de fait"; break;
                        case 'G1': echo "Pension de retraite indépendant séparé de fait"; break;
                        case 'G2': echo "Revenu garanti séparé de fait"; break;
                        case 'G3': echo "Allocation de chauffage séparé de fait"; break;
                        case 'G4': echo "Bonus de bien-être mensuel séparé de fait"; break;
                        case 'G5': echo "Prime de revalorisation indépendant séparé de fait"; break;
                        case 'G6': echo "Prime de revalorisation salarié séparé de fait"; break;
                        case 'G7': echo "Bonus de bien-être séparé de fait"; break;
                        case 'G8': echo "Allocation spéciale de chauffage séparé de fait"; break;
                        case 'IT': echo "indemnité transitoire"; break;
                        case 'K1': echo "N° de suite - soumis à la retenue AMI et à la retenue de solidarité"; break;
                        case 'K1': echo "Autres avantages"; break;
                        case 'K2': echo "N° de suite - soumis à la retenue AMI et à la retenue de solidarité"; break;
                        case 'K3': echo "N° de suite - soumis à la retenue AMI et à la retenue de solidarité"; break;
                        case 'K4': echo "N° de suite - soumis à la retenue AMI et à la retenue de solidarité"; break;
                        case 'K5': echo "N° de suite - soumis à la retenue AMI et à la retenue de solidarité"; break;
                        case 'K6': echo "N° de suite - soumis à la retenue AMI et à la retenue de solidarité"; break;
                        case 'K7': echo "N° de suite - soumis à la retenue AMI et à la retenue de solidarité"; break;
                        case 'K8': echo "N° de suite - soumis à la retenue AMI et à la retenue de solidarité"; break;
                        case 'K9': echo "N° de suite - soumis à la retenue AMI et à la retenue de solidarité"; break;
                        case 'L1': echo "N° de suite - soumis à la retenue AMI et à la retenue de solidarité"; break;
                        case 'L2': echo "N° de suite - soumis à la retenue AMI et à la retenue de solidarité"; break;
                        case 'L3': echo "N° de suite - soumis à la retenue AMI et à la retenue de solidarité"; break;
                        case 'L4': echo "N° de suite - soumis à la retenue AMI et à la retenue de solidarité"; break;
                        case 'L5': echo "N° de suite - soumis à la retenue AMI et à la retenue de solidarité"; break;
                        case 'L6': echo "N° de suite - soumis à la retenue AMI et à la retenue de solidarité"; break;
                        case 'L7': echo "N° de suite - soumis à la retenue AMI et à la retenue de solidarité"; break;
                        case 'L8': echo "N° de suite - soumis à la retenue AMI et à la retenue de solidarité"; break;
                        case 'L9': echo "N° de suite - soumis à la retenue AMI et à la retenue de solidarité"; break;
                        case 'SB': echo "Seulement soumis à la retenue de solidarité"; break;
                        case 'ZV': echo "Seulement soumis à la retenue A.M.I."; break;
                      }
                      ?>
                      <?php if (isset($RightAndPayments->RightInformation->AdvantageType)): ?>
                        <?php
                        switch ($RightAndPayments->RightInformation->AdvantageType) {
                          case '11': echo "(Pension - Pension légale)"; break;
                          case '12': echo "(Pension - Pension extralégale)"; break;
                          case '21': echo "(Pension complémentaire - Pension légale)"; break;
                          case '22': echo "(Pension complémentaire - Pension extralégale)"; break;
                          case '31': echo "(Autre - Pension légale)"; break;
                          case '32': echo "(Autre - Pension extralégale)"; break;
                        }
                        ?>
                      <?php endif; ?>
                    </td>
                  </tr>
                  <?php if (isset($RightAndPayments->RightInformation->EmployerType)): ?>
                    <tr>
                      <th>Type d'employeur</th>
                      <td>
                        <?php
                        switch ($RightAndPayments->RightInformation->EmployerType) {
                          case '0': echo "Pas d’application"; break;
                          case '1': echo "Entreprise ou institution de droit privé"; break;
                          case '2': echo "Entreprise ou institution de droit public"; break;
                        }
                        ?>
                      </td>
                    </tr>
                  <?php endif; ?>
                  <?php if (isset($RightAndPayments->RightInformation->HouseholdCode)): ?>
                    <tr>
                      <th>Code ménage et charge de famille</th>
                      <td>
                        <?php
                        switch ($RightAndPayments->RightInformation->HouseholdCode) {
                          case '0': echo "Valeur non communiquée"; break;
                          case '1': echo "Taux ménage "; break;
                          case '2': echo "Taux isolé"; break;
                        }
                        ?>
                        <?php if (isset($RightAndPayments->RightInformation->FamilyChargeType)): ?>
                          <?php
                          switch ($RightAndPayments->RightInformation->FamilyChargeType) {
                            case '1': echo " - Avec charge de famille"; break;
                            case '2': echo " - Sans charge de famille"; break;
                          }
                          ?>
                        <?php endif; ?>
                      </td>
                    </tr>
                  <?php endif; ?>
                  <?php if (isset($RightAndPayments->RightInformation->Anomaly)): ?>
                    <tr>
                      <th>Anomalies</th>
                      <td>
                        <?php
                        $RightInformationAnomalySeparator = FALSE;
                        foreach ($RightAndPayments->RightInformation->Anomaly as $RightInformationAnomaly) {
                          if ($RightInformationAnomalySeparator) echo '<br>';
                          echo $RightInformationAnomaly->Description;
                          $RightInformationAnomalySeparator = $RightInformationAnomalySeparator ?: TRUE;
                        }
                        ?>
                      </td>
                    </tr>
                  <?php endif; ?>
                </tbody>
              </table>
              <!-- /RightInformation -->
              <!-- BLOCK PAIEMENT -->
              <h2>Paiement</h2>
               <table class="pension">
                 
                  <thead >
                        <th class="thead-pension">Date de référence</th>
                        <th class="thead-pension">Montants</th>
                        <th class="thead-pension cacher">Payement(s)</th>
                    <?php if (isset($RightAndPayments->PaymentsInformation->FiscalSituation)): ?>
                        <th class="thead-pension cacher">Code conjoint</th>
                        <th class="thead-pension cacher">Personne(s) à charge</th>
                    <?php endif; ?>
                        <th class="thead-pension cacher">INAMI</th>
                  </thead>
                 <tbody>
              <?php foreach ($RightAndPayments->PaymentsInformation as $PaymentsInformationItem): ?>
                  
                  <?php if ($PaymentsInformationItem->IsHolidayAmount == 'true'): /*echo('<tr><td colspan="2"  >***********************************************Ligne pécule de vacances*******************************************</td></tr>'); */?>
                  <?php endif; ?>

                    <tr>
                      <td><?php echo substr(implode('/', array_reverse(explode('-', $PaymentsInformationItem->ReferencePeriod->StartMonth))), 3); ?></td>
                      <td>
                        Brut : <?php echo number_format(floatval($PaymentsInformationItem->TotalAmounts->TotalGrossAmount), 2, ',', '.'); ?><br>
                        Précompte : <?php echo number_format(floatval($PaymentsInformationItem->TotalAmounts->TotalPrecomptableAmount), 2, ',', '.'); ?><br>
                       
                       <?php $montant_index = "index : ".number_format(floatval($PaymentsInformationItem->Index->Index), 2, ',', '.');
                             
                             switch ($PaymentsInformationItem->Index->IndexType) {

                                case '0': $montant_index .= "<img class=\"infobulle\" title=\"(Pas d'indexation)\" src=\"includes/images/info.png\">"; break;
                                case '1': $montant_index .= "<img class=\"infobulle\" title=\"(Régime secteur privé)\" src=\"includes/images/info.png\">"; break;
                                case '2': $montant_index .= "<img class=\"infobulle\" title=\"(Régime secteur public)\" src=\"includes/images/info.png\">"; break;
                                case '3': $montant_index .= "<img class=\"infobulle\" title=\"(Réservé à la B.N.B.)\" src=\"includes/images/info.png\">"; break;
                                case '4': $montant_index .= "<img class=\"infobulle\" title=\"(Réservé à ROSSEL et Cie. S.A.)\" src=\"includes/images/info.png\">"; break;
                                case '5': $montant_index .= "<img class=\"infobulle\" title=\"(Réservé à la S.T.I.B.)\" src=\"includes/images/info.png\">"; break;
                             }

                              //echo $montant_index;

                        ?>
                      
                    <?php if (isset($PaymentsInformationItem->Anomaly)): ?>
                        
                          <?php
                          $PaymentsInformationItemSeparator = FALSE;
                          foreach ($PaymentsInformationItem->Anomaly as $PaymentsInformationItemAnomaly) {
                            if ($PaymentsInformationItemSeparator) echo '<br>';
                            echo $PaymentsInformationItemAnomaly->Description;
                            $PaymentsInformationItemSeparator = $PaymentsInformationItemSeparator ?: TRUE;
                          }
                           echo '<br>';
                           
                          ?>
                          
                     <?php if (!$PaymentsInformationItem->PaymentHistory): ?>
                      </td>
                      <?php endif; ?>
                    <?php endif; ?>
                    <!-- PaymentsInformationItem->PaymentHistory -->
                    <?php if ($PaymentsInformationItem->PaymentHistory): ?>
                    <td class="cacher">
                      <?php foreach ($PaymentsInformationItem->PaymentHistory as $PaymentHistoryItem): ?>

                            <?php $string = "Montant brut : ";
                                  $string .= number_format(floatval($PaymentHistoryItem->GrossAmount), 2, ',', '.');
                                  $string .= "\nMontant du précompte : ";
                                  $string .= number_format(floatval($PaymentHistoryItem->PrecomptableAmount), 2, ',', '.');
                                  $string .= "(".$PaymentHistoryItem->PrecomptePercentage."%)";
                                  $string = "<img class=\"infobulle\" title=\"$string\" src=\"includes/images/info.png\">";
                            ?>

                            Payé le <?php echo implode('/', array_reverse(explode('-', $PaymentHistoryItem->CreationDate))); echo($string); ?><br>
                                                  
                      
                      <?php endforeach; ?> 
                      
                    </td>                
                    <?php endif; ?>
                    <!-- /PaymentsInformationItem->PaymentHistory -->

                    <!-- PaymentsInformation->FiscalSituation -->
                    <?php if (isset($RightAndPayments->PaymentsInformation->FiscalSituation)): ?>
                        <td class="cacher">
                         
                          <?php
                          switch ($RightAndPayments->PaymentsInformation->FiscalSituation->DependentSpouseCode) {
                            case '1': echo "Isolé <img class=\"infobulle\" title=\"[célibataire, veuf, veuve, divorcé(e), séparé(e) de fait ou séparé(e) de corps] ou marié dont le conjoint bénéficie de revenus professionnels en ce compris éventuellement des pensions, rentes ou revenus y assimilés dont le montant mensuel brut dépasse 172,00 EUR\" src=\"includes/images/info.png\">"; break;
                            case '2': echo "Marié <img class=\"infobulle\" title=\"dont le conjoint bénéficie de revenus professionnels exclusivement constitués de pensions, rentes ou revenus y assimilés dont le montant mensuel brut est compris entre 128,76 EUR et 428,75 EUR\" src=\"includes/images/info.png\">"; break;
                            case '3': echo "Marié <img class=\"infobulle\" title=\"dont le conjoint ne dispose pas de revenus professionnels, ou dont le conjoint bénéficie exclusivement de pensions, rentes ou revenus y assimilés dont le montant mensuel brut ne dépasse pas 128,75 EUR\" src=\"includes/images/info.png\">"; break;
                            case '4': echo "Marié <img class=\"infobulle\" title=\"dont le conjoint bénéficie de revenus professionnels, exclusivement constitués de pensions, rentes ou revenus y assimilés dont le montant mensuel brut dépasse 428,75 EUR\" src=\"includes/images/info.png\">"; break;
                            case '5': echo "Marié <img class=\"infobulle\" title=\"dont le conjoint bénéficie de revenus professionnels en ce compris éventuellement des pensions, rentes ou revenus y assimilés dont le montant mensuel brut ne dépasse pas 172,00 EUR\" src=\"includes/images/info.png\">"; break;
                            case '9': echo "Situation inconnue"; break;
                          }
                          ?>
                        </td>
                        <td class="cacher">
                          Enfant(s) : <?php echo $RightAndPayments->PaymentsInformation->FiscalSituation->TotalDependentChildren; ?><br>
                          Autre(s) : <?php echo $RightAndPayments->PaymentsInformation->FiscalSituation->TotalDependentOthers; ?>
                        </td>
                    <?php endif; ?>
                    <!-- /PaymentsInformation->FiscalSituation -->

                    <!-- RightAndPayments->PaymentsInformation->Contributions->ZIVAMI -->
                    <?php if (isset($RightAndPayments->PaymentsInformation->Contributions->ZIVAMI)): ?>
                        <td class="cacher">
                          <?php echo number_format(floatval($RightAndPayments->PaymentsInformation->Contributions->ZIVAMI->TotalAmiAmount), 2, ',', '.'); ?>
                          <?php
                          switch ($RightAndPayments->PaymentsInformation->Contributions->ZIVAMI->AmiTaxCode) {
                            case '0':	echo "(Pas de retenue A.M.I.)"; break;
                            case '1':	echo "(Avec charge de famille)"; break;
                            case '2':	echo "(Sans charge de famille)"; break;
                            case '3':	echo "(Retenue à calculer à la demande de l’I.N.A.M.I. sans tenir compte du plancher)"; break;
                            case '4':	echo "(Plus de retenue à calculer à la demande de l’I.N.A.M.I.)"; break;
                            case '5':	echo "(Pensions partagées avec charge de famille)"; break;
                            case '6':	echo "(Pensions partagées sans charge de famille)"; break;
                            case '7':	echo "(Retenue à calculer à la demande de l’I.N.A.M.I. sans tenir compte du plancher (pour pensions partagées))"; break;
                            case '8':	echo "(Plus de retenue à calculer à la demande de l’I.N.A.M.I. (pour pensions partagées))"; break;
                          }
                          ?>
                        </td>
                    <?php endif; ?>
                    <!-- /RightAndPayments->PaymentsInformation->Contributions->ZIVAMI -->

                    <!-- RightAndPayments->PaymentsInformation->Contributions->ContributionSolidarity -->
                    <?php if (isset($RightAndPayments->PaymentsInformation->Contributions->ContributionSolidarity)): ?>
                        <td class="cacher">
                          <?php echo number_format(floatval($RightAndPayments->PaymentsInformation->Contributions->ContributionSolidarity->TotalRsAmount), 2, ',', '.'); ?> 
                          (<?php echo $RightAndPayments->PaymentsInformation->Contributions->ContributionSolidarity->SolidarityPercentage; ?> %)
                        </td>
                    <?php endif; ?>
                    <!-- /RightAndPayments->PaymentsInformation->Contributions->ContributionSolidarity -->
                 
                <?php if ($PaymentsInformationItem->IsHolidayAmount == 'true'): /*echo('<tr><td colspan="2">**************************************************************************************************************</td></tr>');*/ ?>
                <?php endif; ?>
              <?php endforeach; ?>
               </tbody>
                </table>
            <?php endif; ?>
          </div>
        <?php endforeach; ?>
    <?php endforeach; ?>
  <?php endif; ?>
<?php endif; ?>
