<?php
$server         = '127.0.0.1';
$username       = 'root';
$password       = '';
$nama_database  = 'kanvas';

$conn = mysqli_connect($server, $username, $password, $nama_database);
if (!$conn) {
    die("Connection error: " . mysqli_connect_error());
}
?>
