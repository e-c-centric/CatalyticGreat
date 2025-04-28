<?php

$servername = "localhost";
$username = "root";
$password = "EATprof@2002Server";
$dbname = "catalyticgreat";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>