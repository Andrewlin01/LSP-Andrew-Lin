<?php
//session_start();

$host = "localhost";
$user = "root";
$pass = "";
$db = "mvc-library";

// Koneksi ke database menggunakan MySQLi
$koneksi = new mysqli($host, $user, $pass, $db);

// Cek koneksi
if ($koneksi->connect_error) {
    die("Koneksi gagal: " . $koneksi->connect_error);
}
?>
