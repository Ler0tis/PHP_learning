<?php

require_once 'functions.php';

if (isset($_GET['id'])) {
    $familieId = $_GET['id'];

    // Haal familie op
    $familieSql = "SELECT * FROM familie WHERE id = $familieId";
    $familieResultaat = executePreparedStatement($conn, $familieSql);

    // Haal familieleden op
    $status = 'verwijderd';
    $familielidSql = "SELECT familie_id, id, naam, date_format(geboortedatum, '%d-%m-%Y') AS geboortedatum 
    FROM familielid WHERE familie_id = ? AND (status IS NULL OR status <> ?)";
    $familielidResultaat = executePreparedStatement($conn, $familielidSql, $familieId, $status);

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // Haal de formuliergegevens op voor familie en check of ze bestaan in  de $_POST-ARRAY. 
        //Als ze bestaan worden ze toegevoegen aan de variabelen, anders wordt er een lege string toegewezen
        $familieNaam = isset($_POST['familieNaam']) ? $_POST['familieNaam'] : '';
        $familieAdres = isset($_POST['familieAdres']) ? $_POST['familieAdres'] : '';

        if (!empty($familieNaam) && !empty($familieAdres)) {
            // Werk de familie bij in de database
            $familieUpdateSql = "UPDATE familie SET naam = ?, adres = ? WHERE id = ?";
            $familieUpdateResultaat = executePreparedStatement($conn, $familieUpdateSql, $familieNaam, $familieAdres, $familieId);

            if (!$familieUpdateResultaat) {
                echo 'Er is een fout opgetreden bij het bijwerken van de familie.';
                exit;
            }
        }

        // Haal de formuliergegevens op voor familielid
        $familielidId = $_POST['familielidId'];
        $naamFamilielid = $_POST['naamFamilielid'];
        $geboortedatum = $_POST['geboortedatum'];
        $lidmaatschap = $_POST['soort_lid'];

        // Omzetten naar het formaat "YYYY-MM-DD" voor databaseopslag
        $geboortedatum = date('Y-m-d', strtotime($geboortedatum));

        // Checkt of de NAAM is ingevuld. Zo ja, dan wordt de IF uitgevoerd
        if (!empty($naamFamilielid)) {
            if (!empty($geboortedatum)) {
                // Update familielid inclusief geboortedatum
                $familielidUpdateSql = "UPDATE familielid SET naam = ?, geboortedatum = ? WHERE id = ?";
                $familielidUpdateResultaat = executePreparedStatement($conn, $familielidUpdateSql, $naamFamilielid, $geboortedatum, $familielidId);
            } else {
                // Update familielid zonder geboortedatum
                $familielidUpdateSql = "UPDATE familielid SET naam = ? WHERE id = ?";
                $familielidUpdateResultaat = executePreparedStatement($conn, $familielidUpdateSql, $naamFamilielid, $familielidId);
            }

            if (!$familielidUpdateResultaat) {
                echo "Er is een fout opgetreden bij het bijwerken van de geboortedatum.";
                exit();
            }
        }

        if (!empty($lidmaatschap)) {
            // Voer UPDATE uit om lidmaatschap toe te voegen aan een familielid
            $lidmaatschapUpdateSql = "UPDATE familielid SET soort_lid = ? WHERE id = ?";
            $lidmaatschapUpdateResultaat = executePreparedStatement($conn, $lidmaatschapUpdateSql, $lidmaatschap, $familielidId);

            if (!$lidmaatschapUpdateResultaat) {
                echo "Er is een fout opgetreden bij het bijwerken van het lidmaatschap.";
                exit();
            }
        }
        
        header("Location: view_familie.php?id=$familieId");
        exit();
    }
} else {
    die('Familie ID is niet opgegeven.');
}

?>

<!DOCTYPE html>
<html>
<head>
    <title>Familie Bewerken</title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
        }
        table, th, td {
            border: 1px solid black;
            padding: 5px;
        }
    </style>
</head>
<body>
    <h1>Familie Bewerken</h1>
    <a href="welcome.blade.php">Terug naar Familie Overzicht</a><br><br>

    <?php if ($familie = $familieResultaat->fetch_assoc()): ?>
        <table>
            <form method="post">
                <tr>
                    <td><label for="familieNaam">Naam:</label></td>
                    <td><input type="text" name="familieNaam" id="familieNaam" value="<?php echo $familie['naam']; ?>" required><br></td>
                </tr>
                <tr>
                    <td><label for="familieAdres">Adres:</label></td>
                    <td><input type="text" name="familieAdres" id="familieAdres" value="<?php echo $familie['adres']; ?>" required><br></td>
                </tr>
                <tr>
                    <td><input type="submit" value="Bijwerken"></td>
                </tr>
            </form>
        </table>
        <h2>Familielid bewerken</h2>
        <?php while ($familielid = $familielidResultaat->fetch_assoc()): ?>
        <table>
            <form method="post">
                <tr>
                    <td><input type="hidden" name="familielidId" value="<?php echo $familielid['id']; ?>"></td>
                    <td><label for="naamFamilielid">Naam: </label></td>
                    <td><input type="text" name="naamFamilielid" value="<?php echo $familielid['naam']; ?>"></td> 

                    <td><label for="geboortedatum">Geboortedatum:</label></td>
                    <td><input type="text" name="geboortedatum" id="geboortedatum" placeholder="DD-MM-YYYY"></td>

                    <td><label for="soort_lid">Lidmaatschap:</label></td>
                    <td>
                        <select name="soort_lid" id="soort_lid">
                            <option value="">Selecteer een lidmaatschap</option>
                            <?php
                            // Haal lidmaatschap op uit DB
                            $lidmaatschapSql = "SELECT * FROM lidmaatschap";
                            $lidmaatschapResultaat = executePreparedStatement($conn, $lidmaatschapSql);

                            // Loop door resultaten en genereer opties voor elk lidmaatschap bij een lid
                            while ($lidmaatschap = $lidmaatschapResultaat->fetch_assoc()) {
                                $omschrijving = $lidmaatschap['omschrijving'];
                                echo "<option value=\"$omschrijving\">$omschrijving</option>";
                            }
                            ?>
                        </select>
                    </td>

                    <td>
                        <input type="submit" value="Familielid bijwerken">
                        <input type="submit" name="verwijder_familielid" value="Verwijder">
                    </td>
                </tr>
            </form>
        </table>
        <?php endwhile; ?>
    <?php else: ?>
        <p>Familie niet gevonden.</p>
    <?php endif; ?>
</body>
</html>