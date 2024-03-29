<h1>Liste de toutes les mutations</h1>
<table class="table table-striped">
    <thead>
        <tr>
            <th onclick='change_date()' style='cursor:pointer;'>Date mutation <span id='icon_date' class="glyphicon glyphicon-arrow-down" area-hidden="true"></span></th>
            <th>Individu <input type='text' id='filtre' onKeyUp='majListe();'/></th>
            <th>Raison</th>
            <th>Commentaire</th>
            <th>Verifiée</th>
            <th>Traité</th>
            <th></th>
        </tr>
    </thead>
    <tbody id='tbody'>
    <?php 
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
    </tbody>
</table>
<script>

    ordre = "date_mutation desc"; 
    
    function change_date()
    {
        if(ordre ==  "date_mutation desc")
        {
            ordre =  "date_mutation asc";
            $("#icon_date").attr("class","glyphicon glyphicon-arrow-up");
        }
        else
        {
            ordre =  "date_mutation desc";
            $("#icon_date").attr("class","glyphicon glyphicon-arrow-down");
        }
        majListe();
    }

    function majListe()
    {
        filtre = $("#filtre").val();
        $.ajax(
            {
               type: "POST",
                url: "scriptAjax/filtre.php",
                data: { 
                    FILTRE: filtre, 
                    ORDRE: ordre, 
                    TYPE: "search"
                    },
                success:
                function(result)
                {   
                    $("#tbody").html(result);
                }
            }
        );
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