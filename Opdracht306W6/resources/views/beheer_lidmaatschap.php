
<?php

require_once 'functions.php';
include 'layout.php';

if (isset($_GET['id'])) {
    $lidmaatschapId = $_GET['id'];

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // Verkrijg formuliergegevens lidmaatschap
        $lidmaatschapId = $_POST['id'];
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
        <th>Acties</th>
            <?php while ($lidmaatschap = $lidmaatschapResultaat->fetch_assoc()): ?>
                <tr>
                    <td><?php echo $lidmaatschap['id'] ?></td>
                    <td><?php echo $lidmaatschap['omschrijving']; ?></td>
                    <td>
                        <input type="hidden" name="lidmaatschap_id" value="<?php echo $lidmaatschapId['id'];?>">
                        <input type="submit" value="Bijwerken">
                        <input type="submit" name="verwijder_lidmaatschap" value="Verwijder">
                    </td>
                </tr>
            <?php endwhile; ?>
            <tr>
                <td>Geen lidmaatschappen gevonden.</td>
            </tr>
    </table>
</body>
</html>