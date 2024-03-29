<h1>Tarif social</h1>

<?php if($res['error']): ?>

<p class="error"><?php echo $res['message']; ?></p>

<?php else: ?>

<?php
    $dataCbss = $res['data'][0]->cbss;
    $dataSoctar = $res['data'][0]->soctar;
?>
<?php if (isset($dataCbss->identifier)): ?>


<div class="fieldset">
	<h1>Catégorie(s)</h1>

    <table>
        <tbody>
            <tr>
                <th>Client final <img class="infobulle" title="à un contrat à son nom chez un fournisseur d'énergie" src="includes/images/info.png"> :</th>
                <td class="yes_no">
                <?php
                    echo ($dataCbss->identifier->finalCustomer==true) ?
                        '<img src="'. $baseFolder . 'includes/images/yes.png" alt="OUI" title="OUI">':
                        '<img src="'. $baseFolder . 'includes/images/no.png" alt="NON" title="NON">';
                ?>
                </td>
                <td />
            </tr>
            <tr>
                <th>Chef de ménage <img class="infobulle" title="est le chef de ménage" src="includes/images/info.png"> :</th>
                <td class="yes_no"><?php
                    echo ($dataCbss->identifier->householdHead==true) ? 
                            '<img src="'. $baseFolder . 'includes/images/yes.png" alt="OUI" title="OUI">' : 
                            '<img src="'. $baseFolder . 'includes/images/no.png" alt="NON" title="NON">';
                ?></td>
                <td />
            </tr>
            <tr>
                <th>Personne protégée <img class="infobulle" title="le droit au tarif social lui a été accordé par des organisations CPAS, ONP ou DGPH" src="includes/images/info.png"> :</th>
                <td class="yes_no"><?php
                    echo ($dataCbss->identifier->protectedPerson==true) ? 
                        '<img src="'. $baseFolder . 'includes/images/yes.png" alt="OUI" title="OUI">' : 
                        '<img src="'. $baseFolder . 'includes/images/no.png" alt="NON" title="NON">';
                ?></td>
                <td />
            </tr>
        </tbody>
    </table>

</div>

<?php endif; ?>

<?php if (isset($dataSoctar->CitizenCompleteStatus)): ?>

<div class="fieldset">
	<h1>Dates</h1>

    <?php
        $dateBcss = new DateTime((string) $dataSoctar->CitizenCompleteStatus->bcssReferenceDate);
        $dateRn = new DateTime((string) $dataSoctar->CitizenCompleteStatus->rnReferenceDate);
        $dateFournisseur = new DateTime((string) $dataSoctar->CitizenCompleteStatus->supplierReferenceDate);
    ?>

    <p>Date de référence de la BCSS: <?php  echo $dateBcss->format("d/m/Y"); ?></p>
    <p>Date de référence du Registre National: <?php echo $dateRn->format("d/m/Y"); ?></p>
    <p>Date de référence du fournisseur: <?php echo $dateFournisseur->format("d/m/Y"); ?></p>

</div>

<?php if (isset($dataSoctar->CitizenCompleteStatus->HouseholdData)): ?>

<div class="fieldset">
	<h1>Ménage</h1>

    <table>
        <tbody>
            <tr>
                <th>Adresse :</th>
                <td><?php echo AdresseSocialRateInvestigation::format($dataSoctar->CitizenCompleteStatus->HouseholdData); ?></td>
            </tr>
            <tr>
                <th>Membre(s) :</th>
                <td>
                <?php
                    if (is_array($dataSoctar->CitizenCompleteStatus->HouseholdMembers->HouseHoldMember)) {
                        $membres = $dataSoctar->CitizenCompleteStatus->HouseholdMembers->HouseHoldMember;
                    } else {
                        $membres[] = $dataSoctar->CitizenCompleteStatus->HouseholdMembers->HouseHoldMember;
                    }
                ?>
                <?php foreach ($membres as $membre): ?>
                - <?php echo mb_strtoupper((string) $membre->name) . " " . (string) $membre->firstNames . " - <a href='index.php?env=member&page=person&action=display&rn=" . (string) $membre->ssin . "' class='rn'>" . (string) $membre->ssin . "</a>"; ?><br />
                <?php endforeach; ?>
                </td>
            </tr>
        </tbody>
    </table>

</div>

<?php endif; ?>

<?php if (isset($dataSoctar->CitizenCompleteStatus->MatchList)): ?>

<div class="fieldset">
    <h1>Fournisseur(s) d'énergie</h1>

<?php
    if (is_array($dataSoctar->CitizenCompleteStatus->MatchList->Match)) {
        $fournisseurs = $dataSoctar->CitizenCompleteStatus->MatchList->Match;
    } else {
        $fournisseurs[] = $dataSoctar->CitizenCompleteStatus->MatchList->Match;
    }
?>
<?php foreach ($fournisseurs as $fournisseur): ?>

    <?php
        // Date tarif social
        $dateDebutTarifSocial = null;
        if (isset($fournisseur->startDate))
            $dateDebutTarifSocial = new DateTime($fournisseur->startDate);
        $dateMajTarifSocial = null;
        if (isset($fournisseur->updateDate))
            $dateMajTarifSocial = new DateTime($fournisseur->updateDate);
        $dateFinTarifSocial = null;
        if (isset($fournisseur->endDate))
            $dateFinTarifSocial = new DateTime($fournisseur->endDate);

        // Date contrat
        $dateDebutContrat = null;
        if (isset($fournisseur->supplierStart))
            $dateDebutContrat = new DateTime($fournisseur->supplierStart);
        $dateFinContrat = null;
        if (isset($fournisseur->supplierEnd))
            $dateFinContrat = new DateTime($fournisseur->supplierEnd);
    ?>

    <table>
        <tbody>
            <tr>
                <th>Nom :</th>
                <td><?php echo $fournisseur->supplierName; ?> (n° EAN: <?php echo $fournisseur->eanId; ?>)</td>
            </tr>
            <tr>
                <th>Type :</th>
                <td><?php
                    switch ($fournisseur->product) {
                        case "E":
                            echo "Electricité";
                            break;

                        case "G":
                            echo "Gaz";
                            break;

                        default:
                            echo $fournisseur->product;
                            break;
                    }
                ?></td>
            </tr>
            <tr>
                <th>Client: </th>
                <td><?php echo mb_strtoupper((string) $fournisseur->name) . " " . (string) $fournisseur->firstNames; ?> (n° client: <?php echo $fournisseur->custId; ?>)<br />
                <?php echo AdresseSocialRateInvestigation::format($fournisseur); ?></td>
            </tr>

            <?php if (isset($fournisseur->eligibility)): ?>
            <tr>
                <th>Eligibilité :</th>
                <td><?php
                    echo ($fournisseur->eligibility=="1")?'<img src="'. $baseFolder . 'includes/images/yes.png" alt="OUI" title="OUI">':'<img src="'. $baseFolder . 'includes/images/no.png" alt="NON" title="NON">';
                ?></td>
            </tr>
            <?php else: ?>
            <tr>
                <th>Eligibilité :</th>
                <td>Indéterminé pour l'instant</td>
            </tr>
            <?php endif; ?>

            <?php if (!is_null($dateDebutTarifSocial)): ?>
            <tr>
                <th>Tarif social - date de début :</th>
                <td><?php echo $dateDebutTarifSocial->format("d/m/Y"); ?></td>
            </tr>
                <?php if (!is_null($dateFinTarifSocial)): ?>
                <tr>
                    <th>Tarif social - date de fin :</th>
                    <td><?php echo $dateFinTarifSocial->format("d/m/Y"); ?></td>
                </tr>
                <?php endif; ?>
                <?php if (!is_null($dateMajTarifSocial)): ?>
                <tr>
                    <th>Tarif social - date à laquelle le fournisseur a été prévenu de sa mise en place :</th>
                    <td><?php echo $dateMajTarifSocial->format("d/m/Y"); ?></td>
                </tr>
                <?php endif; ?>
            <?php endif; ?>

            <?php if (!is_null($dateDebutContrat)): ?>
            <tr>
                <th>Contrat - date de début :</th>
                <td><?php echo $dateDebutContrat->format("d/m/Y"); ?></td>
            </tr>
                <?php if (!is_null($dateFinContrat)): ?>
                <tr>
                    <th>Contrat - date de fin :</th>
                    <td><?php echo $dateFinContrat->format("d/m/Y"); ?></td>
                </tr>
                <?php endif; ?>
            <?php endif; ?>
        </tbody>
    </table>
    <hr />

<?php endforeach; ?>

</div>

<?php endif; ?>

    <?php if (isset($dataSoctar->CitizenCompleteStatus->Status)): ?>
        <br />
        <?php
            switch ($dataSoctar->CitizenCompleteStatus->Status->value) {
                case "SSIN_NOT_FOUND":
                    echo "<p class='error'>Le RN n'est pas connu au Registre National</p>";
                    break;

                default:
                    echo "<p class='error'>ERREUR inconnue</p>";
                    break;
            }
        ?>
    <?php endif; ?>

<?php endif; ?>

<?php endif; ?>
