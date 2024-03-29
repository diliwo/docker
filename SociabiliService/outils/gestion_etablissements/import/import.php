<?php
header('Content-Type: text/html; charset=UTF-8');

require '../config.php';
$conn = oci_connect(ORACLE_USERNAME, ORACLE_PASSWORD, ORACLE_CONNECTION_STRING, ORACLE_CHARSET);

$handle = fopen('etab2.csv', 'r');

while (($data = fgetcsv($handle, 0)) !== FALSE) {
    $libelle = $data[0];
    $type = $data[1];
    $voirie = $data[2];
    $numero = $data[3];
    $id_code_postal = $data[4];

    $id_adresse = 0;

    $stid1 = oci_parse($conn, "INSERT INTO SSC_ADRESSE (RUE, NUMERO, ID_CODE_POSTAUX) VALUES (:rue, :numero, :id_code_postaux) RETURNING ID_ADRESSE INTO :id_adresse");
    oci_bind_by_name($stid1, ':rue', $voirie);
    oci_bind_by_name($stid1, ':numero', $numero);
    oci_bind_by_name($stid1, ':id_code_postaux', $id_code_postal);
    oci_bind_by_name($stid1, ':id_adresse', $id_adresse, -1, OCI_B_INT);
    oci_execute($stid1);

    $stid2 = oci_parse($conn, "INSERT INTO SSC_ETABLISSEMENT (ETABLISSEMENT, ID_ADRESSE, ID_ETABLISSEMENT_TYPE, ACTIVE) VALUES (:etablissement, :id_adresse, :id_etablissement_type, 0)");
    oci_bind_by_name($stid2, ':etablissement', $libelle);
    oci_bind_by_name($stid2, ':id_adresse', $id_adresse);
    oci_bind_by_name($stid2, ':id_etablissement_type', $type);
    oci_execute($stid2);
}

oci_free_statement($stid1);
oci_free_statement($stid2);
oci_close($conn);