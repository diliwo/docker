<h1>Résultat de l'importation</h1>

<table class="table table-striped">
    <tr><th>Nom du fichier</th><th>Laison SSC</th><th>Insertion DB</th><th>Archivage de la mutation</th><th>Commentaire</th></tr>
    <?php 
        
        foreach($retours as $key=>$retour)
        {
            if(is_array($retour))
            {
                //valide
                
                $couleur = "green";
                
                if($retour["insert"] == 0)
                {
                    $couleur = "orange";
                }
                
                ?>
                    <tr style='color:<?php echo $couleur; ?>;' >                        
                        <td><?php echo $key; ?></td>
                        <td>
                            <?php 
                                if($retour["ssc"] == 1)
                                {
                                    echo "Ok";
                                }
                                else if($retour["ssc"] == 0)
                                {
                                    echo "RN inconnu dans sociabili";
                                }
                                else
                                {
                                    echo "RN en doublon dans sociabili";
                                }
                            ?>
                        </td>
                        <td>
                            <?php 
                                if($retour["insert"] == 1)
                                {
                                    echo "Ok";
                                }
                                else if($retour["insert"] == 0)
                                {
                                    echo "Déjà importé en DB";
                                }
                                else
                                {
                                    echo "Erreur à l'importation : ";
                                    echo "<pre>";
                                    print_r(htmlentities($retour["insert_error"]));
                                    echo "</pre>";
                                    echo("La requete : <b>".$retour["insert_requete"]."</b> a généré une erreur."); 
                                }
                            ?>
                        </td>
                        <td>
                            <?php 
                                if($retour["move"] == 1)
                                {
                                    echo "Ok";
                                }
                                else
                                {
                                    echo "Le fichier n'a pas pu être déplacé.";
                                }
                            ?>
                        </td>
                        <td>
                            Aucun problème
                        </td>
                    </tr>
                <?php 
            }
            else
            {
                
                //fichier introuvable
                ?>
                    <tr style='color:red;'>
                        <td><?php echo $key; ?> </td>
                        <td>Non</td>
                        <td>Non</td>
                        <td>Non</td>
                        <td>Fichier introuvable</td>
                    </tr>
                <?php
            }
        }
    ?>    
</table>