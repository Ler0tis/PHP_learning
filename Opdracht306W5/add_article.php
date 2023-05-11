<!DOCTYPE html>
<html>
<head>
<title>Artikel toevoegen</title>
</head>
<body>
    <main>
        <div class="nav-list">
                <ul>
                    <li><a href="index.php">Terug naar menu</a></li>
                </ul>
            </div>
    <form action="add_article.php" method="POST">

        <label for="artikel_naam">Artikel naam:</label>
        <input type="text" id="artikel_naam" name="artikel_naam" required><br>

        <label for="prijs">Prijs:</label>
        <input type="number" id="prijs" name="prijs" required><br>

        <input type="submit" value="Artikel toevoegen">
    </form>
    
    </main>
</body>
</html>


<?php error_reporting (E_ALL ^ E_NOTICE);
include 'db_connect.php';

$artikel_naam = $_POST["artikel_naam"];
$prijs = $_POST["prijs"];

$sql = "INSERT INTO `articles` (`artikel_naam`, `prijs`) VALUES ('$artikel_naam', '$prijs')";

$stmt = mysqli_stmt_init($conn);

// Controleer of de query succesvol is uitgevoerd
if ( ! mysqli_stmt_prepare($stmt, $sql)){
    die(mysqli_error($conn));
}

mysqli_stmt_execute($stmt);


?>
