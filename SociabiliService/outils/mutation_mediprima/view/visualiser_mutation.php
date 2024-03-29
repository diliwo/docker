<div class='cadre_global_mutation'>
    <table style='border-collapse:collapse;padding:20px;width:100%;font-size:20px;'>
        <tbody>
            <tr>
                <th style='border-bottom:1px #0269C2 solid;background-color:#DEEFFE;-moz-border-radius:10px 0 0 0;-webkit-border-radius:10px 0 0 0;border-radius:10px 0 0 0;'><?php echo $mutation->donnees["PRENOM"]; ?> <?php echo strtoupper($mutation->donnees["NOM"]); ?> (<?php echo $mutation->donnees["RN"]; ?>)</th>
                <th style='border-bottom:1px #0269C2 solid;background-color:#DEEFFE;'>Mutation n° <?php echo $mutation->donnees["MUTATION_NUMBER"]; ?></th>
                <th style='text-align:right;border-bottom:1px #0269C2 solid;background-color:#DEEFFE;-moz-border-radius:0 10px 0 0;-webkit-border-radius:0 10px 0 0;border-radius:0 10px 0 0;'>Date de la mutation : <?php echo $mutation->donnees["DATE_MUTATION"]; ?></th>
            </tr>
            <tr>
                <td colspan='3'>
                    <table style='width:800px;margin:auto;margin-top:10px;margin-bottom:10px;'>
                        <tr>
                            <td style='width:200px;'>Traité :</td>
                            <td style='vertical-align:middle;' id="traite_<?php echo $mutation->donnees["ID_MUTATION"] ?>"><?php echo ($mutation->donnees["TRAITE"] ? "Oui"   : "Non <input type='button' value='traité'  onclick ='traiter(".$mutation->donnees["ID_MUTATION"].")'/> "); ?></td>
                        </tr>
                        <tr>
                            <td>Vérifié :</td>
                            <td style='vertical-align:middle;' id="verifie_<?php echo $mutation->donnees["ID_MUTATION"] ?>"><?php echo ($mutation->donnees["VERIFIE"] ? "Oui" : "Non <input type='button' value='vérifié' onclick='verifier(".$mutation->donnees["ID_MUTATION"].")'/> "); ?></td>
                        </tr>
                        <tr>
                            <td>Commentaire :
                            <td>
                                <textarea onclick='majCommentaire' id='commentaire_<?php echo $mutation->donnees["ID_MUTATION"]; ?>' style='width:100%;'><?php echo $mutation->donnees["COMMENTAIRE"]; ?></textarea>
                                <br>
                                <input style='width:100%;' type='button' value='enregistrer' onclick='enregistrer_commentaire("commentaire_<?php echo $mutation->donnees["ID_MUTATION"]; ?>")'/>
                            </td>
                        </tr>
                        <tr>
                            <td>Numéro de carte :</td>
                            <td>
                                <?php 
                                    $nbr_lettre = strlen($mutation->donnees["NUM_CARTE"]);
                                    $a_ajouter = 12- $nbr_lettre;
                                    for($a_ajouter; $a_ajouter>0; $a_ajouter--)
                                    {
                                        echo "0";
                                    }
                                    echo $mutation->donnees["NUM_CARTE"];
                                    
                                ?>
                            </td>
                        </tr>
                        <tr>
                            <td>Numéro de version :</td>
                            <td><?php echo $mutation->donnees["NUM_VERSION"]; ?></td>
                        </tr>
                        <tr>
                            <td>Statut de la carte :</td>
                            <td><?php echo $mutation->donnees["STATUT_CARTE"]; ?></td>
                        </tr>
                        <tr>
                            <td>Raison de la mutation :</td>
                            <td><?php echo $mutation->donnees["RAISON"]; 
                                if(!empty($mutation->donnees["NEWSSIN"]))
                                {
                                    echo " (<b style='color:red;'>".$mutation->donnees["NEWSSIN"]."</b>)";
                                }
                            ?></td>            
                        </tr>
                        <tr>
                            <td>Actions possibles : </td>
                            <td><?php 
                                    echo $mutation->donnees["ACTION_POSSIBLE"]; 
                                    if(strpos($mutation->donnees["ACTION_POSSIBLE"],"stopCarmed") !== false)
                                    {
                                        echo " <form style='display:inline;' id='stopCarmed' method='post' action='index.php?ctrl=stop_carmed&id=".$mutation->donnees["ID_MUTATION"]."'><input style='color:red;' onclick='stopCarmed();' type='button' value='Stopper la carte'/> avec le rn : <input type='text' value='".$mutation->donnees["RN"]."' name='rn'/> </form>";
                                    }
                                ?></td>
                        </tr>
                        <tr>
                            <td>Changement urgence médicale : </td>
                            <td><?php echo $mutation->donnees["CHANGE_URG_MED"]; ?></td>
                        </tr>
                        <tr>
                            <td>Changement part SPP : </td>
                            <td><?php echo $mutation->donnees["CHANGE_PART_SPP"]; ?></td>
                        </tr>
                        <tr>
                            <td>Changement situation mutuelle : </td>
                            <td><?php echo $mutation->donnees["CHANGE_MUT"]; ?></td>
                        </tr>
                        <tr>
                            <td>Ancien refundcode : </td>
                            <td><?php echo $mutation->donnees["OLD_REFUNDCODE"]." : ".$refundCodes[$mutation->donnees["OLD_REFUNDCODE"]]; ?></td>
                        </tr>
                        <tr>
                            <td>Nouveau refundcode : </td>
                            <td><?php echo $mutation->donnees["NEW_REFUNDCODE"]." : ".$refundCodes[$mutation->donnees["NEW_REFUNDCODE"]]; ?></td>
                        </tr>
                    </table>
                </td>
            </tr>
        </tbody>
    </table>
</div>
<script>
    function stopCarmed()
    {
        if(confirm("Etes-vous certain de vouloir arrêter cette carte médicale ?"))
        {
            $("#stopCarmed").submit();
        }
    }

    function enregistrer_commentaire(id)
    {
        commentaire = $("#"+id).val();
        $.ajax(
            {
               type: "POST",
                url: "scriptAjax/commentaire.php",
                data: { 
                    ID_MUTATION: id, 
                    COMMENTAIRE: commentaire
                    },
                success:
                function(result)
                {   
                    if(result == "succes")
                    {
                        alert("Commentaire enregistré !");
                    }
                    else
                    {
                        alert(result);
                    }
                }
            }
        );
    }
    
    function traiter(id)
    {
        $.ajax(
            {
               type: "GET",
                url: "scriptAjax/traiter_mutation.php?id="+id,
                success:
                function(result)
                {   
                    if(result == "succes")
                    {
                        $("#traite_"+id).html("<span style='color:green;'>Oui</span>");
                    }
                    else
                    {
                        alert(result);
                    }
                }
            }
        );
    }
    
    function verifier(id)
    {
        $.ajax(
            {
               type: "GET",
                url: "scriptAjax/verifier_mutation.php?id="+id,
                success:
                function(result)
                {   
                    if(result == "succes")
                    {
                        $("#verifie_"+id).html("<span style='color:green;'>Oui</span>");
                        
                    }
                    else
                    {
                        alert(result);
                    }
                }
            }
        );
    }
</script>