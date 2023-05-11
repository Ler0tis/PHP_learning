<?php error_reporting (E_ALL ^ E_NOTICE);


$user = $_POST["name"];
$email = $_POST["email"];
$message = $_POST["message"];

$host = "localhost";
$dbname = "loidata";
$username = "root";
$password = "mysql";

$conn = mysqli_connect($host, $username, $password, $dbname);

if (mysqli_connect_errno()) {
    die("Connection error: " . mysqli_connect_error());
}

// update statement for SQL- injection
$sql = "INSERT INTO `userdata`(`user`,`email`,`message`) VALUES ('$user','$email','$message') ";


$stmt = mysqli_stmt_init($conn);

// If there is an syntax error, this will be caught and printed by the above statement
if ( ! mysqli_stmt_prepare($stmt, $sql)){
    die(mysqli_error($conn));
}


mysqli_stmt_execute($stmt);

echo "Message is send.";

?>
