<?php
session_start();

require 'config.php';
$conn = oci_connect(ORACLE_USERNAME, ORACLE_PASSWORD, ORACLE_CONNECTION_STRING, ORACLE_CHARSET);

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    $sqlt = "SELECT * FROM SSC_ETABLISSEMENT INNER JOIN SSC_ADRESSE USING (ID_ADRESSE) INNER JOIN SSC_CODES_POSTAUX USING (ID_CODE_POSTAUX) WHERE SSC_ETABLISSEMENT.ID_ETABLISSEMENT = :id_etablissement";
    $stid = oci_parse($conn, $sqlt);
    oci_bind_by_name($stid, ':id_etablissement', $_GET['id']);
    oci_execute($stid);
    $row = oci_fetch_array($stid);
    oci_free_statement($stid);
} else {
    $sqlt = "UPDATE SSC_ETABLISSEMENT SET SOFTDELETE = 1 WHERE ID_ETABLISSEMENT = :id_etablissement";
    $stid = oci_parse($conn, $sqlt);
    oci_bind_by_name($stid, ':id_etablissement',  $_GET['id']);
    oci_execute($stid);
    oci_free_statement($stid);

    header('Location: ./');
}
?><!doctype html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Supprimer un établissement | Gestion des établissements (Helpdesk Social)</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=Edge">
    <link rel="stylesheet" href="../libs/bootstrap/3.3.7/css/bootstrap.min.css">
    <!--[if lt IE 9]>
        <script src="../libs/legacy/html5shiv.js"></script>
        <script src="../libs/legacy/respond.min.js"></script>
    <![endif]-->
</head>
<body style="padding-top: 70px;">    
    <div class="container">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title">Supprimer un établissement</h3>
            </div>
            <div class="panel-body text-center">
                <form action="<?php echo $_SERVER['REQUEST_URI']; ?>" method="POST" class="form-horizontal">
                    <p><strong>Voulez-vous vraiment supprimer l'établissement suivant ?</strong></p>
                    <p>
                        <?php echo $row['ETABLISSEMENT']; ?><br>
                        <?php
                        if (!empty($row['RUE'])) {
                            echo $row['RUE'] . ' ' . $row['NUMERO'];
                            if (!empty($row['BOITE'])) {
                                echo '/' . $row['BOITE'];
                            }
                            echo ' – ';
                        }
                        if (!empty($row['ID_CODE_POSTAUX'])) {
                            echo $row['CODE_POSTAL'] . ' ' . $row['COMMUNE_ABSORBEE'];
                        }
                        ?>
                    </p>
                    <p>&nbsp;</p>
                    <p>
                        <button type="Submit" class="btn btn-danger"><span class="glyphicon glyphicon-trash"></span> Supprimer</button>
                        <a href="./" class="btn btn-default">Annuler</a>
                    </p>
                </form>
            </div>
        </div>
    </div>
    <script src="../libs/jquery/3.1.1/jquery.min.js"></script>
    <script src="../libs/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</body>
</html>