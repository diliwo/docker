<h2>PIIS</h2>

<?php if ($piis['error']): ?>

<p class="error"><?php echo $piis['message']; ?></p>

<?php else: ?>

<div class="fieldset">

<?php $piis = $piis['data']; ?>
   
    <?php if ($piis->GpmiPiis->hasAttestation == 1):  ?>
        <h1>Subvention frais d’accompagnement et d’activation pour PIIS général</h1>
        <?php
        
            $datetime1 = strtotime($piis->GpmiPiis->period->StartDate);
            $datetime2 = strtotime($piis->GpmiPiis->period->EndDate);
            $secs = $datetime2 - $datetime1;
            $daysPeriod = $secs / 86400;
            $datetime1 = strtotime($piis->GpmiPiis->prolongationPeriod->StartDate);
            $datetime2 = strtotime($piis->GpmiPiis->prolongationPeriod->EndDate);
            $secs = $datetime2 - $datetime1;
            $daysProlongationPeriod = $secs / 86400;
        ?>
        <table>
            <tbody>
                <tr>
                    <th>Période activée :</th>
                    
                    <td><?php echo "du ". date('d/m/Y', strtotime($piis->GpmiPiis->period->StartDate)) ." au ". date('d/m/Y', strtotime($piis->GpmiPiis->period->EndDate)) ." (" . $daysPeriod . " jours)";  ?> </td>
                </tr>
                <tr>
                    <th>Prolongation potentiellement activable :</th>
                    
                    <td><?php echo "à partir du ". date('d/m/Y', strtotime($piis->GpmiPiis->prolongationPeriod->StartDate)) ." pendant une période de 1 an (au " . date('d/m/Y', strtotime($piis->GpmiPiis->prolongationPeriod->EndDate)) . ")"; ?></td>
                </tr>
            </tbody>
        </table>
       
    <?php else: ?>
        <p class="info">Aucune subvention frais d’accompagnement et d’activation pour PIIS général<p>
    <?php endif; ?>
    
    <?php if(!empty($piis->Attestations)): ?>
        <?php foreach($piis->Attestations as $i => $attestation): ?>
        <?php 
            $dateDecision = DateTime::createFromFormat("Y-m-dP", $attestation->DecisionDate);
            $dateDebut = DateTime::createFromFormat("Y-m-dP", $attestation->EntryDate);
            $dateFin = clone $dateDebut;
            $dateFin->modify("+" . $attestation->Duration->Days . " days");
            $dateFin->modify("+" . $attestation->Duration->Weeks . " weeks");
            $dateFin->modify("+" . $attestation->Duration->Months . " months");
            $dateFin->modify("-1 day");
        ?>
        <h1>Période du <?php echo $dateDebut->format("d/m/Y"); ?> au <?php echo $dateFin->format("d/m/Y"); ?><span class="titre-infos-bottom">Référence : <?php echo $attestation->Reference; ?></span></h1>

        <table>
            <tbody>
                <tr>
                    <th>Date de séance :</th>
                    <td><?php echo $dateDecision->format("d/m/Y"); ?></td>
                </tr>

                <tr>
                    <th>Formulaire :</th>
                    <td><?php echo $attestation->FormType->Description->fr; ?> (<?php echo $attestation->AttestType->Description->fr; ?>)</td>
                </tr>

                <tr>
                    <th>Type de relation :</th>
                    <td> <?php echo $attestation->RelationType->Description->fr; ?></td>
                </tr>

                <tr>
                    <th>N° d'entreprise BCE :</th>
                    <td><?php echo $attestation->CPAS_KBOBCE_code; ?> (<?php echo $entrepriseDb->getNomFromNumero($attestation->CPAS_KBOBCE_code); ?>)</td>
                </tr>
                <tr>
                    <th>Statut :</th>
                    <td><?php 
                        switch ($attestation->Status) {
                            case "0":
                                echo "ACCEPTED";
                                break;

                            case "1":
                                echo "REFUSED";
                                break;

                            case "2":
                                echo "PARTIALLY ACCEPTED";
                                break;
                            
                            default:
                                echo $attestation->Status;
                                break;
                        }
                    ?></td>
                </tr>
            </tbody>
        </table>

        <?php endforeach; ?>

    <?php endif; ?>

<?php endif; ?>

</div>
