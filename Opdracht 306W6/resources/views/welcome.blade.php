<?php
// index.php

require_once 'database.php';

// Haal alle families op die actief zijn
$status = '';
$sql = "SELECT * FROM familie WHERE status IS NULL OR status = ?";
$familiesResult = executePreparedStatement($conn, $sql, $status);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Overzicht Families</title>
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
    <h1>Families Overzicht</h1>
    <table>
        <tr>
            <th>Familie ID</th>
            <th>Naam</th>
            <th>Adres</th>
            <th>Acties</th>
        </tr>
        <?php while ($family = $familiesResult->fetch_assoc()): ?>
            <tr>
                <td><?php echo $family['id']; ?></td>
                <td><?php echo $family['naam']; ?></td>
                <td><?php echo $family['adres']; ?></td>
                
                <td>
                    <a href="view_familie.php?id=<?php echo $family['id']; ?>">Bekijken |</a>
                    <a href="update_familie.php?id=<?php echo $family['id']; ?>">Bewerken |</a>
                    <a href="delete_familie.php?id=<?php echo $family['id']; ?>">Verwijderen</a>
                </td>
            </tr>
        <?php endwhile; ?>
    </table>
    <a href="create_familie.php">Nieuwe Familie Toevoegen</a><br><br>
    <a href="beheer_lidmaatschap.php">Lidmaatschap Beheren</a><br><br>
    <a href="beheer_contributie.php">Contributie Beheren</a>
</body>
</html>
