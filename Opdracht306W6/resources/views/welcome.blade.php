<?php
// index.php

require_once 'functions.php';

// Haal alle families op die actief zijn
$status = '';
$sql = "SELECT * FROM familie WHERE status IS NULL OR status = ?";
$familiesResultaat = executePreparedStatement($conn, $sql, $status);

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
        <?php while ($familie = $familiesResultaat->fetch_assoc()): ?>
            <tr>
                <td><?php echo $familie['id']; ?></td>
                <td><?php echo $familie['naam']; ?></td>
                <td><?php echo $familie['adres']; ?></td>
                <td>
                    <a href="view_familie.php?id=<?php echo $familie['id']; ?>">Bekijken |</a>
                    <a href="update_familie.php?id=<?php echo $familie['id']; ?>">Bewerken |</a>
                    
                    <form method="post" action="functions.php">
                        <input type="hidden" name="familie_id" value="<?php echo $familie['id'];?>"> 
                        <input type="submit" name="verwijder_familie" value="Verwijderen">
                    </form>
                </td>
            </tr>
        <?php endwhile; ?>
    </table>
    <a href="create_familie.php">Nieuwe Familie Toevoegen</a><br><br>
    <a href="beheer_lidmaatschap.php">Lidmaatschap Beheren</a><br><br>
    <a href="beheer_contributie.php">Contributie Beheren</a>
</body>
</html>