<?php
session_start();

require 'config.php';
$conn = oci_connect(ORACLE_USERNAME, ORACLE_PASSWORD, ORACLE_CONNECTION_STRING, ORACLE_CHARSET);

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    $values['etablissement'] = '';
    $values['active'] = 1;
    $values['type'] = 1;
    $values['rue'] = '';
    $values['numero'] = '';
    $values['boite'] = '';
    $values['id_code_postaux'] = 1456;
} else {
    $values['etablissement'] = $_POST['etablissement'];
    $values['active'] = $_POST['active'];
    $values['type'] = $_POST['type'];
    $values['rue'] = $_POST['rue'];
    $values['numero'] = $_POST['numero'];
    $values['boite'] = $_POST['boite'];
    $values['id_code_postaux'] = $_POST['id_code_postaux'];

    if (empty($values['etablissement']) || empty($values['rue']) || empty($values['numero']) || empty($values['id_code_postaux']) || empty($values['type'])) {
        $error = true;
    } else {
        $sqlt = "INSERT INTO SSC_ADRESSE (RUE, NUMERO, BOITE, ID_CODE_POSTAUX) VALUES (:rue, :numero, :boite, :id_code_postaux) RETURNING ID_ADRESSE INTO :id_adresse";
        $stid = oci_parse($conn, $sqlt);
        oci_bind_by_name($stid, ':rue',  $values['rue']);
        oci_bind_by_name($stid, ':numero',  $values['numero']);
        oci_bind_by_name($stid, ':boite',  $values['boite']);
        oci_bind_by_name($stid, ':id_code_postaux',  $values['id_code_postaux']);
        oci_bind_by_name($stid, ':id_adresse',  $id_adresse, -1, OCI_B_INT);
        oci_execute($stid);
        oci_free_statement($stid);

        $sqlt = "INSERT INTO SSC_ETABLISSEMENT (ETABLISSEMENT, ID_ADRESSE, ID_ETABLISSEMENT_TYPE, ACTIVE) VALUES (:etablissement, :id_adresse, :id_etablissement_type, :active)";
        $stid = oci_parse($conn, $sqlt);
        oci_bind_by_name($stid, ':etablissement',  $values['etablissement']);
        oci_bind_by_name($stid, ':active',  $values['active']);
        oci_bind_by_name($stid, ':id_etablissement_type',  $values['type']);
        oci_bind_by_name($stid, ':id_adresse',  $id_adresse);
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

$sqlt = "SELECT * FROM SSC_ETABLISSEMENT_TYPE ORDER BY LIBELLE";
$stid = oci_parse($conn, $sqlt);
oci_execute($stid);
oci_fetch_all($stid, $types, 0, -1, OCI_FETCHSTATEMENT_BY_ROW + OCI_ASSOC);
oci_free_statement($stid);
?><!doctype html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Créer un établissement | Gestion des établissements (Helpdesk Social)</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=Edge">
    <link rel="stylesheet" href="../libs/bootstrap/3.3.7/css/bootstrap.min.css">
    <link rel="stylesheet" href="../libs/bootstrap-chosen/chosen.min.css">
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
                <h3 class="panel-title">Créer un établissement</h3>
            </div>
            <div class="panel-body">
                <form action="<?php echo $_SERVER['REQUEST_URI']; ?>" method="POST" class="form-horizontal">
                    <div class="form-group">
                        <label for="frmFieldIntitule" class="col-lg-1 control-label">Intitulé</label>
                        <div class="col-lg-9">
                            <input type="text" class="form-control" id="frmFieldIntitule" name="etablissement" value="<?php echo $values['etablissement']; ?>">
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
                                    <option value="<?php echo $type['ID_ETABLISSEMENT_TYPE']; ?>" <?php if ($values['type'] == $type['ID_ETABLISSEMENT_TYPE']) echo 'selected'; ?>><?php echo $type['LIBELLE']; ?></option>
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
                            <button type="Submit" class="btn btn-primary"><span class="glyphicon glyphicon-floppy-disk"></span> Créer</button>
                            <a href="./" class="btn btn-default">Annuler</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <script src="../libs/jquery/3.1.1/jquery.min.js"></script>
    <script src="../libs/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</body>
</html>