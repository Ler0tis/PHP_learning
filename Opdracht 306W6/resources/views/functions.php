


// Functies omzetten naar deze pagina. ( INCLUDE GEBRUIKEN WAAR NODIG) NET zoals DB

<?php
//function getFamilie($familieId) {
  //  $familieSql = "SELECT * FROM familie WHERE id = ? AND status <> 'verwijderd'";
//    return executePreparedStatement($familieSql, 'i', $familieId);
//}

//function getFamilielid($familieId) {
//    $familielidSql = "SELECT familie_id, id, naam, date_format(geboortedatum, '%d-%m-%Y') AS geboortedatum 
  //  FROM familielid WHERE familie_id = ? AND status <> 'verwijderd'";
    //return executePreparedStatement($familielidSql, 'i', $familieId);
//}

//function updateFamilie($familieId, $naam, $adres) {
  //  $familieUpdateSql = "UPDATE familie SET naam = ?, adres = ? WHERE id = ?";
    //return executePreparedStatement($familieUpdateSql, 'ssi', $naam, $adres, $familieId);
//}

// ...

//if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // ...

  //  if (!empty($familieNaam) && !empty($familieAdres)) {
        // Werk de familie bij in de database
    //    $familieUpdateResultaat = updateFamilie($familieId, $familieNaam, $familieAdres);

      //  if (!$familieUpdateResultaat) {
        //    echo 'Er is een fout opgetreden bij het bijwerken van de familie.';
          //  exit;
    //    }
    //}

//}

?>
// functions.php

function executePreparedStatement($sql, $types, ...$params) {
    // Implementatie van de functie
}

function getFamilie($familieId) {
    // Implementatie van de functie
}

function getFamilielid($familieId) {
    // Implementatie van de functie
}

function updateFamilie($familieId, $naam, $adres) {
    // Implementatie van de functie
}

// ... andere functies ...


