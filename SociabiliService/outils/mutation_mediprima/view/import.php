<h1>Liste des fichiers à importer</h1>

<?php 
    if(isset($erreur))
    {
        if($erreur != "")
        {
            ?>
                <div class="alert alert-danger alert-dismissible" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <strong>Erreur!</strong> <?php echo $erreur; ?>
                </div>
            <?php 
        }
    }
?>

<form action='index.php?ctrl=action_import' method='post'>
    <table class="table table-striped">
        <?php 
            if(count($files) > 0)
            {
                ?>
                    <tr><th style='text-align:center;'><input id='selecteur' type='button' value='Tout' onclick='selectionneTout();'/></th><th>Date mutation</th><th>Nom du fichier</th><th>Individu</th><th>Raison</th></tr>
                    <?php 
                        foreach($files as $file)
                        {
                            ?>
                                <tr>                        
                                    <td style='text-align:center;'><input class='checkbox1' type='checkbox' name="<?php echo ($file->donnees["NOM_FICHIER"]); ?>" /></td>
                                    <td><?php echo ($file->donnees["date_mutation"]); ?></td>
                                    <td><?php echo ($file->donnees["NOM_FICHIER"]); ?></td>
                                    <td><?php echo $file->donnees["firstName"]." ".strtoupper($file->donnees["lastName"])." [".$file->donnees["ssin"]."]"; ?></td>
                                    <td><?php echo ($file->donnees["reason"]); ?></td>
                                </tr>
                            <?php 
                        }
                    ?>
                    <tr><th colspan='5' style='text-align:center;'><input type='submit' value='Importer la sélection'/></th></tr>
                <?php                 
            }
            else
            {
                echo "<tr><th colspan='5' style='text-align:center;'>Aucun fichier de mutation à importer.</th></tr>";
            }
            ?>            
    </table>
</form>
<script>
    function selectionneTout()
    {
        $(".checkbox1").prop('checked', "checked");
        $("#selecteur").attr('onclick', "selectionneRien()");
        $("#selecteur").attr('value', "Rien");
    }
    
    function selectionneRien()
    {
        $(".checkbox1").prop('checked', false);
        $("#selecteur").attr('onclick', "selectionneTout()");
        $("#selecteur").attr('value', "Tout");
    }
</script>