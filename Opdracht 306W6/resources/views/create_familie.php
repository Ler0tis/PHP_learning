<?php

require_once 'database.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Verkrijg de formuliergegevens
    $naam = $_POST['naam'];
    $adres = $_POST['adres'];
    // Voeg de familie toe aan de database
    $sql = "INSERT INTO familie (naam, adres) VALUES (?, ?)";
    $result = executePreparedStatement($conn, $sql, $naam, $adres);
    var_dump($result);

    if ($result) {
        header('Location: welcome.blade.php');
        exit;
    } else {
        echo 'Er is een fout opgetreden bij het toevoegen van de familie.';
        
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
        <input type="text" name="naam" id="naam" required><br>
        <label for="adres">Adres:</label>
        <input type="text" name="adres" id="adres" required><br>
        <input type="submit" value="Toevoegen">
    </form>
</body>
</html>
