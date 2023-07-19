
<?php
// Check voor het verwijderen van een familie + leden
if (isset($_POST['verwijder_familie'])) {
    $familieId = $_POST['familie_id'];
    verwijderFamilie($conn, $familieId);
    if ($conn->affected_rows > 0) {
        echo 'De familie is succesvol verwijderd.';
    } else {
        echo 'Er is een fout opgetreden bij het verwijderen van de familie: ' . mysqli_error($conn);
    }
}

// Verwijder familielid
if (isset($_POST['verwijder_familielid'])) {
    $familielidId = $_POST['familielid_id'];
    verwijderFamilielid($conn, $familielidId);
    if ($conn->affected_rows > 0) {
        echo 'Het familielid is succesvol verwijderd.';
    } else {
        echo 'Er is een fout opgetreden bij het verwijderen : ' . mysqli_error($conn);
    }
}

// Verwijder lidmaatschap
if (isset($_POST['verwijder_lidmaatschap'])) {
    $lidmaatschapId = $_POST['lidmaatschap_id'];
    verwijderLidmaatschap($conn, $lidmaatschapId);
    if ($conn->affected_rows > 0) {
        echo 'Lidmaatschap is succesvol verwijderd.';
    } else {
        echo 'Er is een fout opgetreden bij het verwijderen van het lidmaatschap';
    }
}



?>