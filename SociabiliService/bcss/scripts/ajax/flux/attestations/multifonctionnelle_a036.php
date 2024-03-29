<h2 id="a036">Multifonctionnelles A036</h2>
<?php if ($attestations_a036['error']): ?>

<p class="error"><?php echo $attestations_a036['message']; ?></p>

<?php else: ?>

<div class="fieldset">
    <?php foreach($attestations_a036['data']['attestations'] as $attestation): ?>
        <?php
        $attestation_class = array();

        // Classe de typage d'attestation
        switch($attestation['AttestationStatus']) {
            case 0: $attestation_class[] = 'a036-original'; break;
            case 1: $attestation_class[] = 'a036-correction'; break;
            case 3: $attestation_class[] = 'a036-annulation'; break;
        }

        // Classe pour les anciennes réponses
        if ($attestation['RecentAnswer'] == 'X' ) {
            $attestation_class[] = 'a036-ancienne';
        }

        // Doit-on masquer les anciennes réponses et les annulations ?
        if ( in_array('a036-ancienne', $attestation_class) || in_array('a036-annulation', $attestation_class) ) {
            $attestation_class[] = 'hide';
        }

        // Création d'une chaine avec les classes
        $attestation_class = implode(' ', $attestation_class);
        ?>
        <h1 class="<?php echo $attestation_class; ?>">Période du <?php echo $attestation['ValidityPeriod']['BeginDate']->format('j/m/Y'); ?>
        au <?php echo $attestation['ValidityPeriod']['EndDate']->format('j/m/Y'); ?>
        <span class="titre-infos">Créée le <?php echo $attestation['CreationDate']->format('j/m/Y'); ?></span></h1>
        <table class="<?php echo $attestation_class; ?>" width="100%">
            <tbody>
                <tr>
                    <th>CPAS :</th>
                    <td><?php echo $cpInsDb->getNomFromIns($attestation['OcmwCpas']); ?></td>
                </tr>
                <tr>
                    <th>Numéro d'attestation</th>
                    <td><?php echo $attestation['AttestationID']; ?></td>
                </tr>
                <?php if(!empty($attestation['UpdateAttestationID'])){ ?>
                <tr class="a036-ancienne hide">
                    <th>Mise à jour de l'attestation N°: </th>
                    <td><?php echo $attestation['UpdateAttestationID']; ?></td>
                </tr>
                <?php } ?>
                 <tr>
                    <th>Statut :</th>
                    <td><?php 
                        switch( $attestation['AttestationStatus'] ) {
                            case 0: echo 'Original'; break;
                            case 1: echo 'Correction'; break;
                            case 3: echo 'Annulation'; break;
                            default: echo 'Inconnu (' . $attestation['AttestationStatus'] . ')'; break;
                        }
                    ?></td>
                </tr>
                <tr>
                    <th>Catégorie :</th>
                    <td><?php 
                        switch( $attestation['CategoryCode'] ) {
                            case 7: echo 'RI'; break;
                            case 8: echo 'Équivalent RI'; break;
                            default: echo 'Inconnu (' . $attestation['CategoryCode'] . ')'; break;
                        }
                    ?></td>
                </tr>
            </tbody>
        </table>
    <?php endforeach; ?>
    <p style="text-align: center;">
        <br>
        <a href="#" id="a06-viewAll" data-alt="Masquer les anciennes multifonctionnelles A036 ainsi que les annulations">
            Afficher les anciennes multifonctionnelles A036 ainsi que les annulations
        </a>
    </p>
</div>

<?php endif; ?>

<script>
    // Affichage/masquage des attestations (anciennes et annulations)
    $(document).ready(function() {
        $a036_viewAll = $('#a06-viewAll');

        $a036_viewAll.click(function(){
            $('.a036-ancienne').toggleClass('hide');
            $('.a036-annulation').toggleClass('hide');

            var oldText = $a036_viewAll.text().trim();
            $a036_viewAll.text($a036_viewAll.data('alt')).data('alt', oldText);

            window.setTimeout(function(){
                $(window).scrollTop($('#a036').offset().top);
            }, 200);
        });
    });
</script>