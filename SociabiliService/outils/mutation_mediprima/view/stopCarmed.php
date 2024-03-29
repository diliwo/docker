<?php 
    if($resultat["resultat"] == 1)
    {
        ?>
            <h1>Carte stoppée !</h1>
            <input type='button' onclick='showXml()' value='voir les flux' />
            <div id='cadre_xml' style='display:none;'>
                Xml envoyé : 
                <div class="alert alert-danger" role="alert"><?php echo htmlentities($resultat["xmlEnvoye"]); ?></div>                
                XML reçu :
                <div class="alert alert-danger" role="alert"><?php echo htmlentities($resultat["xmlRecu"]); ?></div>     
            </div>      
        <?php
    }
    else
    {
        ?>
            <h1>Erreur, carte non stoppée !</h1>
            <div class="alert alert-danger" role="alert"><?php echo $resultat["message"]; ?></div>    
            <input type='button' onclick='showXml()' value='voir les flux' />
            <div id='cadre_xml' style='display:none;'>
                Xml envoyé : 
                <div class="alert alert-danger" role="alert"><?php echo htmlentities($resultat["xmlEnvoye"]); ?></div>                
                XML reçu :
                <div class="alert alert-danger" role="alert"><?php echo htmlentities($resultat["xmlRecu"]); ?></div>   
                Debug :
                <div class="alert alert-danger" role="alert"><?php echo htmlentities($resultat["debug"]); ?></div>    
            </div>            
        <?php
    }
?>
<a href='index.php?ctrl=visualiser&id=<?php echo $_GET["id"];?>'><input type='button' value='Retour à la visualisation' /></a>
<script>
    
    function showXml()
    {
        $("#cadre_xml").show();
    }
    
</script>