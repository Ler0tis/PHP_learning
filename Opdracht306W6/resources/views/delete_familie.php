<?php
// IS DIT NOG WEL ECHT NODIG? 

require_once 'database.php';

function deleteEntity($conn, $table, $idColumn, $id) {
    $sql = "DELETE FROM $table WHERE $idColumn = ?";
    $result = executePreparedStatement($conn, $sql, 'i', $id);

    if ($result) {
        echo "De $table is succesvol verwijderd.";
    } else {
        echo "Er is een fout opgetreden bij het verwijderen van de $table.";
    }
}

// Voorbeeld van het verwijderen van een familie
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['familie_id'])) {
    $familieId = $_POST['familie_id'];
    deleteEntity($conn, 'familie', 'id', $familieId);
}

// Voorbeeld van het verwijderen van een familielid
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['familielid_id'])) {
    $familielidId = $_POST['familielid_id'];
    deleteEntity($conn, 'familielid', 'id', $familielidId);
}

// Voorbeeld van het verwijderen van een ander object
//if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['object_id'])) {
//    $objectId = $_POST['object_id'];
//    deleteEntity('andere_tabel', 'id', $objectId);
//}

?>
