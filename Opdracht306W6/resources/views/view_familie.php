<?php

require_once 'DatabaseException.php';

try {
    require_once 'functions.php';

    $familieId = isset($_GET['id']) ? $_GET['id'] : null;
    $familie = null;
    $familienaam = null;
    $members = array();

    if ($familieId) {
        // Haal de familie op
        $status = 'verwijderd';
        $sql = "SELECT * FROM familie WHERE id = ? AND (status IS NULL OR status <> ?)";
        $familieResultaat = executePreparedStatement($conn, $sql, $familieId, $status);

        if ($familieResultaat->num_rows > 0) {
            $familie = $familieResultaat->fetch_assoc();
            $familienaam = $familie['naam'];
        }
    }

    // Haal de familieleden op
    $sql = "SELECT familie_id, id, naam, soort_lid, 
    date_format(geboortedatum, '%d-%m-%Y') AS geboortedatum 
    FROM familielid WHERE familie_id = ? AND (status IS NULL OR status <> ?)";

    $membersResult = executePreparedStatement($conn, $sql, $familieId, $status);
    while ($row = $membersResult->fetch_assoc()) {
        $members[] = $row;
    }

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // Verkrijg de formuliergegevens
        $naam = isset($_POST['naam']) ? $_POST['naam'] : null;
        $geboortedatum = isset($_POST['geboortedatum']) ? $_POST['geboortedatum'] : null;

        if (!$naam OR !$geboortedatum) {
            echo 'Ontbrekende formuliergegevens.';
            exit;
        }

        // Validate geboortedatum
        $geboortedatumValide = false;
        $datumObj = DateTime::createFromFormat('d-m-Y', $geboortedatum);

        if ($datumObj && $datumObj->format('d-m-Y') === $geboortedatum) {
            $huidigeDatum = new DateTime();
            $maxLeeftijd = new DateInterval('P120Y'); // De max is nu 120 jaar oud.

            // Controleer of de leeftijd binnen het toegestane bereik valt
            $minGeboorteDatum = clone $huidigeDatum;
            $minGeboorteDatum->sub($maxLeeftijd);

            if ($datumObj < $minGeboorteDatum || $datumObj > $huidigeDatum) {
                echo 'Ongeldige leeftijd.';
                exit;
            }

            $geboortedatumValide = true;
        }

        if (!$geboortedatumValide) {
            echo 'Ongeldige geboortedatum.';
            exit;
        }

        // Omzetten naar het formaat "YYYY-MM-DD" voor databaseopslag
        $geboortedatum = date('Y-m-d', strtotime($geboortedatum));

        // Controleer of het familielid al bestaat
        $sql = "SELECT * FROM familielid WHERE naam = ? AND familie_id = ? ";
        $checkResult = executePreparedStatement($conn, $sql, $naam, $familieId);
        if ($checkResult->num_rows > 0) {
            echo 'Dit familielid bestaat al in deze familie.';
            exit;
        }

        // Voeg het familielid toe aan de database
        $sql = "INSERT INTO familielid (naam, geboortedatum, familie_id) 
        VALUES (?, ?, ?)";
        $result = executePreparedStatement($conn, $sql, $naam, $geboortedatum, $familieId);

        if ($result) {
            header("Location: view_familie.php?id=$familieId");
            exit;
        } else {
            echo 'Er is een fout opgetreden bij het toevoegen van het familielid.';
            exit;
        }
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
    <title>Familie Details</title>
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
    <h1>Familie Details</h1>
    <a href="welcome.blade.php">Naar Overzicht |</a>
    <a href="update_familie.php">Naar Familie bewerken</a>
    <?php if ($familie): ?>
        <h2>Naam: <?php echo $familienaam; ?></h2>

        <h3>Familieleden</h3>
        <table>
            <th>Familie ID</th>
            <th>Leden ID</th>
            <th>Naam</th>
            <th>Geboortedatum</th>
            <th>Soort lid</th>
            <th>Contributie</th>
            <?php foreach ($members as $member): ?>
                <tr>
                    <td><?php echo $member['familie_id'] ?></td>
                    <td><?php echo $member['id'] ?></td>
                    <td><?php echo $member['naam']; ?></td>
                    <td><?php echo $member['geboortedatum'] ?></td>
                    <td><?php echo $member['soort_lid'] ?></td>
                </tr>
            <?php endforeach; ?>
        </table>

        <h3>Familielid Toevoegen</h3>
        <form method="post">
            <label for="naam">Naam:</label>
            <input type="text" name="naam" id="naam" placeholder="Roepnaam" required><br>
            <label for="gebortedatum">Geboortedatum:</label>
            <input type="text" name="geboortedatum" id="geboortedatum" placeholder="DD-MM-YYYY" required><br>
            <input type="submit" value="Toevoegen">
        </form>
    <?php else: ?>
        <p>Familie niet gevonden.</p>
    <?php endif; ?>
</body>
</html>
