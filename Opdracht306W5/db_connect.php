<?php
// Verbinding met database
$host = "localhost";
$user = "root";
$pass = "mysql";
$db = "articles";

$conn = mysqli_connect($host, $user, $pass, $db);

if (!$conn) {
  die("Connection failed: " . mysqli_connect_error());
}