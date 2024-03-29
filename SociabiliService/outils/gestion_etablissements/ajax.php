<?php
session_start();

require 'config.php';
$conn = oci_connect(ORACLE_USERNAME, ORACLE_PASSWORD, ORACLE_CONNECTION_STRING, ORACLE_CHARSET);

oci_execute(oci_parse($conn, "ALTER SESSION SET NLS_COMP = LINGUISTIC"));
oci_execute(oci_parse($conn, "ALTER SESSION SET NLS_SORT = BINARY_AI"));

$sqlt_where_parts = array();

$sqlt_where_softdelete = 'SSC_ETABLISSEMENT.SOFTDELETE = 0';
array_push($sqlt_where_parts, $sqlt_where_softdelete);

if (isset($_GET['libelle']) && !empty($_GET['libelle'])) {
    $sqlt_where_libelle = "LOWER(ETABLISSEMENT) LIKE LOWER('%" . $_GET['libelle'] . "%')";
    array_push($sqlt_where_parts, $sqlt_where_libelle);
}

if (isset($_GET['type']) && !empty($_GET['type'])) {
    $sqlt_where_type = '';
    foreach ($_GET['type'] as $type) {
        if (strtolower($type) != 'all') {
            $sqlt_where_type .= $type . ',';
        }
    }

    $sqlt_where_type = 'ID_ETABLISSEMENT_TYPE IN (' . substr_replace($sqlt_where_type, '', -1) . ')';
    array_push($sqlt_where_parts, $sqlt_where_type);
} else {
    $sqlt_where_type = 'ID_ETABLISSEMENT_TYPE IS NULL';
    array_push($sqlt_where_parts, $sqlt_where_type);
}  

if (isset($_GET['codePostal']) && !empty($_GET['codePostal'])) {
    $sqlt_where_codePostal = '';
    foreach ($_GET['codePostal'] as $codePostal) {
        if (strtolower($codePostal) != 'all') {
            $codePostalParts = explode('-', $codePostal);
            $sqlt_where_codePostal .= '(SSC_CODES_POSTAUX.CODE_POSTAL BETWEEN ' . $codePostalParts[0] . ' AND ' . $codePostalParts[1] . ') OR ';
        }
    }

    $sqlt_where_codePostal = '(' . substr_replace($sqlt_where_codePostal, '', -4) . ')';
    array_push($sqlt_where_parts, $sqlt_where_codePostal);
} else {
    $sqlt_where_codePostal = 'ID_ADRESSE IS NULL';
    array_push($sqlt_where_parts, $sqlt_where_codePostal);
}

if (isset($_GET['active']) && !empty($_GET['active'])) {
    $sqlt_where_active = '';
    foreach ($_GET['active'] as $active) {
        if (strtolower($active) != 'all') {
            $sqlt_where_active .= $active . ',';
        }
    }

    $sqlt_where_active = 'SSC_ETABLISSEMENT.ACTIVE IN (' . substr_replace($sqlt_where_active, '', -1) . ')';
    array_push($sqlt_where_parts, $sqlt_where_active);
} else {
    $sqlt_where_active = 'SSC_ETABLISSEMENT.ACTIVE IS NULL';
    array_push($sqlt_where_parts, $sqlt_where_active);
}

$sqlt_where = implode(' AND ', $sqlt_where_parts);

$sql_orderBy = '';
if (isset($_GET['trier']) && !empty($_GET['trier'])) {
    switch($_GET['trier']) {
        case 'libelle': $sql_orderBy = 'SSC_ETABLISSEMENT.ETABLISSEMENT'; break;
        case 'type': $sql_orderBy = 'SSC_ETABLISSEMENT_TYPE.LIBELLE'; break;
        case 'codePostal': $sql_orderBy = 'SSC_CODES_POSTAUX.CODE_POSTAL'; break;
    }

    $sql_orderBy = 'ORDER BY ' . $sql_orderBy;
}

$sqlt = "
    SELECT *
    FROM SSC_ETABLISSEMENT
    INNER JOIN SSC_ETABLISSEMENT_TYPE USING (ID_ETABLISSEMENT_TYPE)
    INNER JOIN SSC_ADRESSE USING (ID_ADRESSE)
    INNER JOIN SSC_CODES_POSTAUX USING (ID_CODE_POSTAUX)
    WHERE $sqlt_where
    $sql_orderBy
";

$stid = oci_parse($conn, $sqlt);
oci_execute($stid);

$items = array();

while (($row = oci_fetch_assoc($stid))) {
    $item = array();

    $item['id'] = $row['ID_ETABLISSEMENT'];
    $item['libelle'] = mb_strtoupper($row['ETABLISSEMENT'], 'UTF-8');
    $item['type'] = $row['LIBELLE'];
    $item['codePostal'] = $row['CODE_POSTAL'];
    $item['commune'] = $row['COMMUNE_ABSORBEE'];
    $item['active'] = $row['ACTIVE'];

    array_push($items, $item);
}

echo json_encode($items);

oci_close($conn);