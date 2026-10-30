<?php
$host = 'localhost';
$user = 's68160380';
$pass = 'rHX77ww1';
$dbname = 's68160380';

$conn = mysqli_connect($host, $user, $pass, $dbname);

if (!$conn) {
    exit('Database connection failed');
}

mysqli_set_charset($conn, 'utf8mb4');