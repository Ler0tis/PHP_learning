
<?php

require_once 'functions.php';

// Basiscontributie per jaar
$basisContributie = 100;

// Haal de geboortedatum en soort lid op
$familielidId = 1; // Voorbeeld familielid ID
$soortLid = 'Jeugd'; // Voorbeeld soort lid

// Haal de geboortedatum op van het familielid uit de database
$familielidSql = "SELECT geboortedatum FROM familielid WHERE id = ?";
$familielidResultaat = executePreparedStatement($conn, $familielidSql, [$familielidId]);
$familielid = $familielidResultaat->fetch_assoc();

// Controleer of de geboortedatum is opgehaald
if ($familielid) {
    $geboortedatum = $familielid['geboortedatum'];

    // Bereken de leeftijd op basis van de geboortedatum
    $geboortejaar = date('Y', strtotime($geboortedatum));
    $huidigJaar = date('Y');
    $leeftijd = $huidigJaar - $geboortejaar;

    // Definieer de kortingspercentages per soort lid
    $kortingspercentages = array(
        'Jeugd' => 0.5, // 50% korting voor jeugdleden
        'Junior' => 0.75, // 25% korting voor juniorleden
        // Voeg eventueel andere kortingspercentages toe voor verschillende soorten lid
    );

    // Controleer of het soort lid voorkomt in de kortingspercentages
    if (array_key_exists($soortLid, $kortingspercentages)) {
        // Haal het kortingspercentage op
        $korting = $kortingspercentages[$soortLid];

        // Bereken het bedrag inclusief korting
        $bedrag = $basisContributie * (1 - $korting);
    } else {
        // Geen kortingspercentage gevonden, gebruik de basiscontributie
        $bedrag = $basisContributie;
    }

    // Voeg de contributie toe aan de database
    $sql = "INSERT INTO contributie (leeftijd, soort_lid, bedrag) VALUES (?, ?, ?)";
    $result = executePreparedStatement($conn, $sql, [$leeftijd, $soortLid, $bedrag]);

    if ($result) {
        echo 'Contributie is succesvol toegevoegd.';
    } else {
        echo 'Er is een fout opgetreden bij het toevoegen van de contributie.';
    }
} else {
    echo 'Familielid met het opgegeven ID is niet gevonden.';
}

?>

<!DOCTYPE html>
<html>
<head>
    <title>Contributie beheren</title>
</head>
<body>
    <h1>Contributie beheren</h1>
    
    <h2>Contributie instellen</h2>
    <form method="post" action="beheer_contributie.php">
        <label for="soortLid">Soort lid:</label>
        <select name="soortLid" id="soortLid">
            <?php
            // Haal lidmaatschap op uit DB
            $lidmaatschapID = $_POST['id'];
            $lidmaatschapSql = "SELECT * FROM lidmaatschap";
            $lidmaatschapResultaat = executePreparedStatement($conn, $lidmaatschapSql, [$lidmaatschapID]);

            // Loop door resultaten en genereer opties voor elk lidmaatschap onder een lid
            while ($lidmaatschap = $lidmaatschapResultaat->fetch_assoc()) {
                $omschrijving = $lidmaatschap['omschrijving'];
                echo "<option value=\"$omschrijving\">$omschrijving</option>";
            }
            ?>
        <button type="submit">Contributie instellen</button>
    </form>
</body>
</html>
