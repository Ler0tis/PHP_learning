
<?php

require_once 'database.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Verkrijg formuliergegevens lidmaatschap
    $omschrijving = $_POST['omschrijving'];

    // Controle of lidmaatschap al bestaat
    $sql = "SELECT * FROM lidmaatschap WHERE omschrijving = ?";
    $controleerResultaat = executePreparedStatement($conn, $sql, $omschrijving);

    if ($controleerResultaat->num_rows > 0) {
        echo "Dit lidmaatschap bestaat al in de database.";
        exit();
    }

    $sql = "INSERT INTO lidmaatschap (omschrijving) 
    VALUES (?)";

    $resultaat = executePreparedStatement($conn, $sql, $omschrijving);

    if ($resultaat) {
        header("Location: beheer_lidmaatschap.php");
        exit();
    } else {
        echo "Er is een fout opgetreden bij het toevoegen van het lidmaatschap.";
    }
}

// Haal lidmaatschappen op
$sql = "SELECT * FROM lidmaatschap";
$lidmaatschapResultaat = executePreparedStatement($conn, $sql);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Lidmaatschap beheren</title>
</head>
<body>
    <h1>Lidmaatschap beheren</h1>
    <a href="welcome.blade.php">Terug naar Overzicht</a>

    <h2>Lidmaatschap instellen</h2>
    <form method="post" action="beheer_lidmaatschap.php">
        <label for="omschrijving">Omschrijving:</label>
        <input type="text" name="omschrijving" id="omschrijving" required><br>
        <button type="submit">Opslaan</button>
    </form>

    <h3>Huidige Lidmaatschappen</h3>
    <table>
        <th>ID</th>
        <th>Omschrijving</th>
        <?php if ($lidmaatschapResultaat && $lidmaatschapResultaat-> num_rows > 0): ?>
            <?php while ($member = $lidmaatschapResultaat->fetch_assoc()): ?>
                <tr>
                    <td><?php echo $member['id'] ?></td>
                    <td><?php echo $member['omschrijving']; ?></td>
                </tr>
            <?php endwhile; ?>
        <?php else: ?>
            <tr>
                <td>Geen lidmaatschappen geovnden.</td>
            </tr>
        <?php endif; ?>
    </table>
</body>
</html>