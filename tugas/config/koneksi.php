<?php
session_start();

function getDbConnection() {
    $username = 'system';
    $password = '123';
    $host = 'AL-HAQQ_RIAU';
    $port = '1521';
    $service_name = 'FREE';

    $conn_str = "(DESCRIPTION=(ADDRESS_LIST=(ADDRESS=(PROTOCOL=TCP)(HOST=$host)(PORT=$port)))(CONNECT_DATA=(SERVICE_NAME=$service_name)))";
    
    $conn = oci_connect($username, $password, $conn_str);
    
    if (!$conn) {
        $err = oci_error();
        die("Koneksi gagal: " . $err['message']);
    }
    
    return $conn;
}

function cek_login() {
    $result = isset($_SESSION['login']) ? $_SESSION['login'] : false;
    if (!$result) {
        header("Location: login.php");
        exit;
    }
    return $result;
}

$conn = getDbConnection();
?>
