<?php
header('Content-Type: text/html; charset=UTF-8');

require '../config.php';
$conn = oci_connect(ORACLE_USERNAME, ORACLE_PASSWORD, ORACLE_CONNECTION_STRING, ORACLE_CHARSET);

oci_execute(oci_parse($conn, "ALTER SESSION SET NLS_COMP = LINGUISTIC"));
oci_execute(oci_parse($conn, "ALTER SESSION SET NLS_SORT = BINARY_AI"));

$handle = fopen('etab.csv', 'r');
$handle2 = fopen('etab2.csv', 'w');

while (($data = fgetcsv($handle, 0, ';')) !== FALSE) {
    $libelle = $data[0];
    $type = $data[1];
    $voirie = $data[2];
    $numero = $data[3];
    $codepostal = $data[4];

    if (is_numeric($codepostal)) {
        $sqlt = "SELECT * FROM SSC_CODES_POSTAUX WHERE CODE_POSTAL = :code_postal";
        $stid = oci_parse($conn, $sqlt);
        oci_bind_by_name($stid, ':code_postal', $codepostal);
        oci_execute($stid);
        $nrows = oci_fetch_all($stid, $rows, 0, -1, OCI_FETCHSTATEMENT_BY_ROW + OCI_ASSOC);

        if ($nrows == 0) {
            echo $codepostal . ' ==> NOT_FOUND<br>';
            fputcsv($handle2, array($libelle, $type, $voirie, $numero, 'NOT_FOUND/'.$codepostal));
        } elseif ($nrows == 1) {
            echo $codepostal . ' ==> ' . $rows[0]['ID_CODE_POSTAUX'] . ' (' . $rows[0]['COMMUNE_ABSORBEE'] . ')<br>';
            fputcsv($handle2, array($libelle, $type, $voirie, $numero, $rows[0]['ID_CODE_POSTAUX']));
        } else {
            $sqlt2 = "SELECT * FROM SSC_CODES_POSTAUX WHERE COMMUNE_FUSIONNEE = COMMUNE_ABSORBEE AND CODE_NISS = :code_niss";
            $stid2 = oci_parse($conn, $sqlt2);
            oci_bind_by_name($stid2, ':code_niss', $rows[0]['CODE_NISS']);
            oci_execute($stid2);
            $nrows2 = oci_fetch_all($stid2, $rows2, 0, -1, OCI_FETCHSTATEMENT_BY_ROW + OCI_ASSOC);
            if ($nrows2 == 0) {
                echo $codepostal . ' ==> NOT_FOUND<br>';
                fputcsv($handle2, array($libelle, $type, $voirie, $numero, 'NOT_FOUND/'.$codepostal));
            } else {
                echo $codepostal . ' ==> ' . $rows2[0]['ID_CODE_POSTAUX'] . ' (' . $rows2[0]['COMMUNE_ABSORBEE'] . ')<br>';
                fputcsv($handle2, array($libelle, $type, $voirie, $numero, $rows2[0]['ID_CODE_POSTAUX']));
            }
        }
    } else {
        echo $codepostal . ' ==> ERROR<br>';
        fputcsv($handle2, array($libelle, $type, $voirie, $numero, 'ERROR/'.$codepostal));
    }    
}

oci_free_statement($stid);
oci_free_statement($stid2);
oci_close($conn);