<?php




// KAN MEERDERE REQUIRE ONCE GEBRUIKEN


// Database configuratie
define('DB_HOST', 'localhost');
define('DB_USERNAME', 'root');
define('DB_PASSWORD', 'mysql');
define('DB_NAME', 'ledenadministratie');

// Maak verbinding met de database
$conn = new mysqli(DB_HOST, DB_USERNAME, DB_PASSWORD, DB_NAME);

// Controleer verbinding
if ($conn->connect_errno) {
    die('Database verbinding is niet gelukt: ' . $conn->connect_error);
}

// Functie om  veilig een query uit te voeren
function executePreparedStatement($conn, $sql, ...$params) {
    $stmt = $conn->prepare($sql);

    if ($stmt === false) {
        echo 'Er is een fout opgetreden bij het voorbereiden van de statement: ' . $conn->error;
        exit();
    }

    if (!empty($params)) {
        $types = '';
        $paramValues = []; // Aparte array voor parameterwaarden

        foreach ($params as $param) {
            if (is_int($param)) {
                $types .= 'i'; // Integer
            } elseif (is_float($param)) {
                $types .= 'd'; // DOUBLE
            } elseif (is_string($param)) {
                $types .= 's'; // String
            } else {
                $types .= 'b'; // Blob
            }

            $paramValues[] = $param; // Toevoegen aan parameterwaarden-array
        }

        $stmt->bind_param($types, ...$paramValues);
    }

    if (!$stmt->execute()) {
        echo 'Er is een fout opgetreden bij het uitvoeren van de query: ' . $stmt->error;
        return false;
    }
    

    return $stmt->get_result();
}

// Verwijderen van de familie
function verwijderFamilie($conn, $familieId) {
    $sql = "DELETE FROM familie WHERE id = ?";
    $Sql = "DELETE FROM familielid WHERE id = ?";
    return executePreparedStatement($conn, $sql, $familieId);
}

if (isset($_POST['verwijder_familie'])) {
    $familieId = $_POST['familie_id'];
    verwijderFamilie($conn, $familieId);
    if ($conn->affected_rows > 0) {
        echo 'De familie is succesvol verwijderd.';
    } else {
        echo 'Er is een fout opgetreden bij het verwijderen van de familie: ' . mysqli_error($conn);
    }

    header("Location: welcome.blade.php?id=$familieId");
    exit();
}

// Validatie geboortedatum
function geboortedatumValidatie() {

}

?>