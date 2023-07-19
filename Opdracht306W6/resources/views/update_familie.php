<?php

require_once 'functions.php';

try {
    if (isset($_GET['id'])) {
        $familieId = $_GET['id'];

        // Haal familie op
        $familieSql = "SELECT * FROM familie WHERE id = ?";
        $familieResultaat = executePreparedStatement($conn, $familieSql, $familieId);

        // Haal familieleden op
        $status = 'verwijderd';
        $familielidSql = "SELECT familie_id, id, naam, date_format(geboortedatum, '%d-%m-%Y') AS geboortedatum 
        FROM familielid WHERE familie_id = ? AND (status IS NULL OR status <> ?)";
        $familielidResultaat = executePreparedStatement($conn, $familielidSql, $familieId, $status);

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Haal de formuliergegevens op voor familie en check of ze bestaan in  de $_POST-ARRAY. 
            // Als ze bestaan, worden ze toegevoegd aan de variabelen, anders wordt er een lege string toegewezen
            $familieNaam = isset($_POST['familieNaam']) ? $_POST['familieNaam'] : '';
            $familieAdres = isset($_POST['familieAdres']) ? $_POST['familieAdres'] : '';

            if (!empty($familieNaam) && !empty($familieAdres)) {
                // Werk de familie bij in de database
                $familieUpdateSql = "UPDATE familie SET naam = ?, adres = ? WHERE id = ?";
                $familieUpdateResultaat = executePreparedStatement($conn, $familieUpdateSql, $familieNaam, $familieAdres, $familieId);

                if (!$familieUpdateResultaat) {
                    echo 'Familie is bijgewerkt.';
                    exit;
                } else {
                    echo 'Er is een fout opgetreden bij het bijwerken van de familie.';
                    exit;
                }
            }

            // Haal de formuliergegevens op voor familielid
            $familielidId = $_POST['familielidId'];
            $naamFamilielid = $_POST['naamFamilielid'];
            $geboortedatum = $_POST['geboortedatum'];
            $lidmaatschap = $_POST['soort_lid'];

            // Zet de geboortedatum om naar het formaat "YYYY-MM-DD" voor databaseopslag
            $geboortedatum = date('Y-m-d', strtotime($geboortedatum));

            // Checkt of de NAAM is ingevuld. Zo ja, dan wordt de IF uitgevoerd
            if (!empty($naamFamilielid)) {
                if (!empty($geboortedatum) && strtotime($geboortedatum) === false) {
                    echo "Ongeldige geboortedatum. Voer de geboortedatum in het formaat 'DD-MM-YYYY' in.";
                    exit;

                    } elseif(!empty($geboortedatum)) {
                        // Update familielid inclusief geboortedatum
                        $familielidUpdateSql = "UPDATE familielid SET naam = ?, geboortedatum = ? WHERE id = ?";
                        $familielidUpdateResultaat = executePreparedStatement($conn, $familielidUpdateSql, $naamFamilielid, $geboortedatum, $familielidId);
                    
                    } else {
                        // Update familielid zonder geboortedatum
                        $familielidUpdateSql = "UPDATE familielid SET naam = ? WHERE id = ?";
                        $familielidUpdateResultaat = executePreparedStatement($conn, $familielidUpdateSql, $naamFamilielid, $familielidId);
                        
                    }

                }
            

            if (!empty($lidmaatschap)) {
                // Voer UPDATE uit om lidmaatschap toe te voegen aan een familielid
                $lidmaatschapUpdateSql = "UPDATE familielid SET soort_lid = ? WHERE id = ?";
                // Maak een tussenvariabele om de stringwaarde te bevatten
                $lidmaatschapValue = $lidmaatschap;
                $lidmaatschapUpdateResultaat = executePreparedStatement($conn, $lidmaatschapUpdateSql, $lidmaatschapValue, $familielidId);
    // Hier nog even naar KIJKEN, want lijkt nu dat als het FALSE is, de update wordt gedaan
                if (!$lidmaatschapUpdateResultaat) {
                    echo 'Lidmaatschap is toegevoegd.';
                } else {
                    echo "Er is een fout opgetreden bij het bijwerken van het lidmaatschap.";
                    exit();
                }
            }

        header("Location: view_familie.php?id=$familieId");
        }
    } else {
        throw new Exception('Familie ID is niet opgegeven.');
    }
} catch (DatabaseException $e) {
    echo "Er is een fout opgetreden in de database: " . $e->getMessage();
    // Andere foutafhandeling of logging
} catch (Exception $e) {
    echo "Er is een onverwachte fout opgetreden: " . $e->getMessage();
    // Andere foutafhandeling of logging
}

?>

<!DOCTYPE html>
<html>
<head>
    <title>Familie Bewerken</title>
    
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

                    <td>
                    <label for="geboortedatum">Geboortedatum:</label></td>
                    <td><input type="text" name="geboortedatum" id="geboortedatum" value="<?php echo $familielid['geboortedatum']; ?>"></td>

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
                        <input type="hidden" name="familielid_id" value="<?php echo $familielid['id'];?>">
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
