<?php

require_once 'functions.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Verkrijg de formuliergegevens
    $naam = $_POST['naam'];
    $adres = $_POST['adres'];
    // Voeg de familie toe aan de database
    $sql = "INSERT INTO familie (naam, adres) VALUES (?, ?)";
    $result = executePreparedStatement($conn, $sql, $naam, $adres);

    if ($result) {
        header("Location: welcome.blade.php");
        exit;
    } else {
        $errorMessage = 'Er is een fout opgetreden bij het toevoegen van de familie.';
        header("Location: welcome.blade.php");
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Nieuwe Familie Toevoegen</title>
</head>
<body>
    <h1>Nieuwe Familie Toevoegen</h1>
    <a href="welcome.blade.php">Terug naar Overzicht</a><br><br>
    <form method="post">
        <label for="naam">Naam:</label>
        <input type="text" name="familieNaam" id="naam" required><br>
        <label for="adres">Adres:</label>
        <input type="text" name="familieAdres" id="adres" required><br>
        <input type="submit" value="Toevoegen">
    </form>
</body>
</html>
