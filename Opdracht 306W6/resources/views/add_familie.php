
<?php
// Stap 1: Maak verbinding met de database (gebruik de juiste databasegegevens)
$servername = "localhost";
$username = "root";
$password = "mysql";
$dbname = "ledenadministratie";

try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Stap 2: Controleer of het formulier is ingediend
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Stap 3: Valideer en verwerk de ingediende gegevens
        $naam = $_POST["naam"];
        $adres = $_POST["adres"];

        // Voer eventuele validatie uit

        // Stap 4: Voeg de familie toe aan de database met behulp van een INSERT-query
        $query = "INSERT INTO familie (naam, adres) VALUES (:naam, :adres)";
        $stmt = $conn->prepare($query);
        $stmt->bindParam(':naam', $naam);
        $stmt->bindParam(':adres', $adres);
        $stmt->execute();

        // Haal de gegenereerde id op
        $familieId = $conn->lastInsertId();

        // Geef een succesbericht weer met de gegenereerde id
        echo "Familie succesvol toegevoegd. Familie ID: " . $familieId;

    } else {
        echo "Ongeldige aanvraag.";
    }

} catch(PDOException $e) {
    echo "Fout bij het verbinden met de database: " . $e->getMessage();
}

?>


<!DOCTYPE html>
<html>
<head>
    <title>Familie toevoegen</title>
</head>
<body>
    <h1>Familie toevoegen</h1>
    <a href="welcome.blade.php">Terug naar menu</a>
    <form method="POST" action="addFamily.php">
        Naam: <input type="text" name="naam"><br>
        Adres: <input type="text" name="adres"><br>
        <input type="submit" value="Opslaan">
    </form>
</body>
</html>
