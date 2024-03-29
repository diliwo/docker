<?php 
    include(__DIR__."/../config/config.php");
    include(__DIR__."/../model/autoloader.class.php");
    
    $mutations = Mutation::listerMutations($_POST["ORDRE"],$_POST["FILTRE"]);
    
    if($_POST["TYPE"] == "search")
    {
        $mutations = Mutation::listerMutations($_POST["ORDRE"],$_POST["FILTRE"]);
    }
    else
    {
        $mutations = Mutation::listerMutationsNonTraitees($_POST["ORDRE"],$_POST["FILTRE"]);
    }
    
    $mutations = Mutation::listerMutations($_POST["ORDRE"],$_POST["FILTRE"]);
    
    foreach($mutations as $mutation)
    {
        ?>
            <tr>
                <td style='vertical-align:middle;'><?php echo ($mutation->donnees["DATE_MUTATION"]); ?></td>
                <td style='vertical-align:middle;'><?php echo $mutation->donnees["PRENOM"]." ".strtoupper($mutation->donnees["NOM"])." [".$mutation->donnees["RN"]."]"; ?></td>
                <td style='vertical-align:middle;'><?php echo ($mutation->donnees["RAISON"]); ?></td>
                <td style='vertical-align:middle;'>
                    <textarea onclick='majCommentaire' id='commentaire_<?php echo $mutation->donnees["ID_MUTATION"]; ?>' style='width:100%;'><?php echo $mutation->donnees["COMMENTAIRE"]; ?></textarea>
                    <br>
                    <input style='width:100%;' type='button' value='enregistrer' onclick='enregistrer_commentaire("commentaire_<?php echo $mutation->donnees["ID_MUTATION"]; ?>")'/>
                </td>
                <td style='vertical-align:middle;' id="verifie_<?php echo $mutation->donnees["ID_MUTATION"] ?>"><?php echo ($mutation->donnees["VERIFIE"] ? "<span style='color:green'>Oui</span>" : "<span style='color:red'>Non</span><br><input type='button' value='vérifié' onclick='verifier(".$mutation->donnees["ID_MUTATION"].")'/> "); ?></td>
                <td style='vertical-align:middle;' id="traite_<?php echo $mutation->donnees["ID_MUTATION"] ?>"><?php echo ($mutation->donnees["TRAITE"] ? "<span style='color:green'>Oui</span>"   : "<span style='color:red'>Non</span><br><input type='button' value='traité'  onclick ='traiter(".$mutation->donnees["ID_MUTATION"].")'/> "); ?></td>
                <td style='vertical-align:middle;'><a href='index.php?ctrl=visualiser&id=<?php echo $mutation->donnees["ID_MUTATION"] ?>' ><span class="glyphicon glyphicon-search" aria-hidden="true" style='cursor:pointer;' ></span></a></td>
            </tr>
        <?php 
    }
?>