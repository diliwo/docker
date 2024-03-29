<?php
session_start();

if (!isset($_SESSION["helpdesksocial_autorise"]) || empty($_GET['id'])) {
    header('Location: ../');
}

$values = array();

require 'config.php';
$conn = oci_connect(ORACLE_USERNAME, ORACLE_PASSWORD, ORACLE_CONNECTION_STRING, ORACLE_CHARSET);

if ($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET['active'])) {
    $sqlt = "UPDATE SSC_ORGANISME SET ACTIVE = :active WHERE ID_ORGANISME = :id_organisme";
    $stid = oci_parse($conn, $sqlt);
    oci_bind_by_name($stid, ':id_organisme',  $_GET['id']);
    oci_bind_by_name($stid, ':active',  $_GET['active']);
    $success = oci_execute($stid);
    oci_free_statement($stid);

    header($success ? 'HTTP/1.0 204 No Content' : 'HTTP/1.1 500 Internal Server Error');
} elseif ($_SERVER['REQUEST_METHOD'] == 'GET') {
    $sqlt = "SELECT * FROM SSC_ORGANISME INNER JOIN SSC_ADRESSE USING (ID_ADRESSE) INNER JOIN SSC_CODES_POSTAUX USING (ID_CODE_POSTAUX) WHERE SSC_ORGANISME.ID_ORGANISME = :id_organisme";
    $stid = oci_parse($conn, $sqlt);

    oci_bind_by_name($stid, ':id_organisme', $_GET['id']);
    oci_execute($stid);
    $row = oci_fetch_array($stid);
    oci_free_statement($stid);

    $values['organisme'] = $row['ORGANISME'];
    $values['active'] = $row['ACTIVE'];
    $values['type'] = $row['ID_ORGANISME_TYPE'];
    $values['rue'] = $row['RUE'];
    $values['numero'] = $row['NUMERO'];
    $values['boite'] = $row['BOITE'];
    $values['id_code_postaux'] = $row['ID_CODE_POSTAUX'];
} else {
    $values['organisme'] = $_POST['organisme'];
    $values['active'] = $_POST['active'];
    $values['type'] = $_POST['type'];
    $values['rue'] = $_POST['rue'];
    $values['numero'] = $_POST['numero'];
    $values['boite'] = $_POST['boite'];
    $values['id_code_postaux'] = $_POST['id_code_postaux'];

    if (empty($values['organisme']) || empty($values['rue']) || empty($values['numero']) || empty($values['id_code_postaux']) || empty($values['type'])) {
        $error = true;
    } else {
        $sqlt = "UPDATE SSC_ORGANISME SET ORGANISME = :organisme, ID_ORGANISME_TYPE = :id_organisme_type, ACTIVE = :active WHERE ID_ORGANISME = :id_organisme";
        $stid = oci_parse($conn, $sqlt);
        oci_bind_by_name($stid, ':organisme',  $values['organisme']);
        oci_bind_by_name($stid, ':active',  $values['active']);
        oci_bind_by_name($stid, ':id_organisme_type',  $values['type']);
        oci_bind_by_name($stid, ':id_organisme',  $_GET['id']);
        oci_execute($stid);
        oci_free_statement($stid);

        $sqlt = "UPDATE SSC_ADRESSE SET RUE = :rue, NUMERO = :numero, BOITE = :boite, ID_CODE_POSTAUX = :id_code_postaux WHERE ID_ADRESSE = (SELECT ID_ADRESSE FROM SSC_ORGANISME WHERE ID_ORGANISME = :id_organisme)";
        $stid = oci_parse($conn, $sqlt);
        oci_bind_by_name($stid, ':rue',  $values['rue']);
        oci_bind_by_name($stid, ':numero',  $values['numero']);
        oci_bind_by_name($stid, ':boite',  $values['boite']);
        oci_bind_by_name($stid, ':id_code_postaux',  $values['id_code_postaux']);
        oci_bind_by_name($stid, ':id_organisme',  $_GET['id']);
        oci_execute($stid);
        oci_free_statement($stid);

        header('Location: ./');
    }
}

$sqlt = "SELECT * FROM SSC_CODES_POSTAUX ORDER BY CODE_POSTAL, COMMUNE_FUSIONNEE, COMMUNE_ABSORBEE";
$stid = oci_parse($conn, $sqlt);
oci_execute($stid);
oci_fetch_all($stid, $codes_postaux, 0, -1, OCI_FETCHSTATEMENT_BY_ROW + OCI_ASSOC);
oci_free_statement($stid);

$sqlt = "SELECT * FROM SSC_ORGANISME_TYPE ORDER BY LIBELLE";
$stid = oci_parse($conn, $sqlt);
oci_execute($stid);
oci_fetch_all($stid, $types, 0, -1, OCI_FETCHSTATEMENT_BY_ROW + OCI_ASSOC);
oci_free_statement($stid);
?><!doctype html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Modifier un organisme | Gestion des organismes (Helpdesk Social)</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=Edge">
    <link rel="stylesheet" href="../libs/bootstrap/3.3.7/css/bootstrap.min.css">
    <link rel="stylesheet" href="../libs/bootstrap/3.3.7/-chosen/chosen.min.css">
    <!--[if lt IE 9]>
        <script src="../libs/legacy/html5shiv.js"></script>
        <script src="../libs/legacy/respond.min.js"></script>
    <![endif]-->
</head>
<body style="padding-top: 70px;">    
    <div class="container">
        <?php if (isset($error)): ?>
            <div class="alert alert-danger">
                <strong>Erreur :</strong>
                Veuillez compléter tous les champs obligatoires (intitulé, rue, numéro et localité).
            </div>
        <?php endif; ?>
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title">Modifier un organisme</h3>
            </div>
            <div class="panel-body">
                <form action="<?php echo $_SERVER['REQUEST_URI']; ?>" method="POST" class="form-horizontal">
                    <div class="form-group">
                        <label for="frmFieldIntitule" class="col-lg-1 control-label">Intitulé</label>
                        <div class="col-lg-9">
                            <input type="text" class="form-control" id="frmFieldIntitule" name="organisme" value="<?php echo $values['organisme']; ?>">
                        </div>
                        <div class="col-lg-2">
                            <select name="active" id="frmFieldActive" class="form-control">
                                <option value="1" <?php if ($values['active'] == 1) echo 'selected'; ?>>Activé</option>
                                <option value="0" <?php if ($values['active'] == 0) echo 'selected'; ?>>Désactivé</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="frmFieldType" class="col-lg-1 control-label">Type</label>
                        <div class="col-lg-11">
                            <select name="type" id="frmFieldType" class="form-control">
                                <?php foreach ($types as $type): ?>
                                    <option value="<?php echo $type['ID_ORGANISME_TYPE']; ?>" <?php if ($values['type'] == $type['ID_ORGANISME_TYPE']) echo 'selected'; ?>><?php echo $type['LIBELLE']; ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                    <p>&nbsp;</p>
                    <div class="form-group">
                        <label for="frmFieldRue" class="col-lg-1 control-label">Rue</label>
                        <div class="col-lg-7">
                            <input type="text" class="form-control" id="frmFieldRue" name="rue" value="<?php echo $values['rue']; ?>">
                        </div>
                        <label for="frmFieldNumero" class="col-lg-1 control-label">Numéro</label>
                        <div class="col-lg-1">
                            <input type="text" class="form-control" id="frmFieldNumero" name="numero" value="<?php echo $values['numero']; ?>">
                        </div>
                        <label for="frmFieldBoite" class="col-lg-1 control-label">Boite</label>
                        <div class="col-lg-1">
                            <input type="text" class="form-control" id="frmFieldBoite" name="boite" value="<?php echo $values['boite']; ?>">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="frmFieldLocalite" class="col-lg-1 control-label">Localité</label>
                        <div class="col-lg-11">
                            <select name="id_code_postaux" id="frmFieldLocalite" class="form-control">
                                <?php foreach ($codes_postaux as $code_postal): ?>
                                    <option value="<?php echo $code_postal['ID_CODE_POSTAUX']; ?>" <?php echo ($code_postal['ID_CODE_POSTAUX'] == $values['id_code_postaux']) ? 'selected' : '' ?>>
                                        <?php echo $code_postal['CODE_POSTAL']; ?>
                                        <?php echo $code_postal['COMMUNE_FUSIONNEE']; ?>
                                        (<?php echo $code_postal['COMMUNE_ABSORBEE']; ?>)
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                    <p>&nbsp;</p>
                    <div class="form-group">
                        <div class="col-lg-10 col-lg-push-1">
                            <button type="Submit" class="btn btn-primary"><span class="glyphicon glyphicon-floppy-disk"></span> Enregistrer</button>
                            <a href="./supprimer.php?id=<?php echo $_GET['id']; ?>" class="btn btn-danger"><span class="glyphicon glyphicon-trash"></span> Supprimer</a>
                            <a href="./" class="btn btn-default">Annuler</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <script src="../libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="../libs/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</body>
</html><?php

oci_close($conn);