<?php

require_once 'database.php';

if (isset($_GET['id'])) {
    $familieId = $_GET['id'];
    
    // Haal de familie op
    $status = 'verwijderd';
    $sql = "SELECT * FROM familie WHERE id = ? AND status <> ?";
    $familieResultaat = executePreparedStatement($conn, $sql, $familieId, $status);
    $familie = $familieResultaat->fetch_assoc();

    // Haal de familieleden op
    $sql = "SELECT familie_id, id, naam, soort_lid, date_format(geboortedatum, '%d-%m-%Y') AS geboortedatum 
    FROM familielid WHERE familie_id = ? AND status <> ?";
    $membersResult = executePreparedStatement($conn, $sql, $familieId, $status);
    $members = array();
    while ($row = $membersResult->fetch_assoc()) {
        $members[] = $row;
    }
} else {
    die('Familie ID is niet opgegeven.');
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Verkrijg de formuliergegevens
    $naam = $_POST['naam'];
    $geboortedatum = $_POST['geboortedatum'];
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
    }
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
    <a href="welcome.blade.php">Terug naar Overzicht</a>
    <?php if ($familie): ?>
        <h2>Naam: <?php echo $familie['naam']; ?></h2>

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
            <label for="geboortedatum">Geboortedatum:</label>
            <input type="text" name="geboortedatum" id="geboortedatum" placeholder="DD-MM-YYYY" required><br>
            <input type="submit" value="Toevoegen">
        </form>
    <?php else: ?>
        <p>Familie niet gevonden.</p>
    <?php endif; ?>
</body>
</html>
