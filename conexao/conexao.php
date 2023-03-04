<?php

$host = "localhost";
$user = "root";
$pass = "";
$dbname = "db_vinicios";
$port = 3306;

$mysqli = new mysqli($host, $user, $pass, $dbname);

// $conn = new PDO("mysql:host=$host;dbname=" . $dbname, $user, $pass);

if ($mysqli->connect_errno){
    echo "Connect failed: " . $mysqli->connect_error;
    
    exit();
}
