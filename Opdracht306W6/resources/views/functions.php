<?php

// Database configuratie
$host = 'localhost';
$dbname = 'ledenadministratie';
$user = 'root';
$pass = 'mysql';
$chars = 'utf8mb4';
$attr = "mysql:host=$host;dbname=$dbname;charset=$chars";

$opts = [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES => false,
];

$opts = [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES => false,
];

try {
    $pdo = new PDO($attr, $user, $pass, $opts);
} catch (\PDOException $e) {
    throw new \PDOException($e->getMessage(), (int)$e->getCode());
}

// Functie om veilig een query uit te voeren
function executePreparedStatement($pdo, $sql, ...$params) {
    try {
        $stmt = $pdo->prepare($sql);
        
        if (!empty($params)) {
            $stmt->execute($params);
        } else {
            $stmt->execute();
        }
        
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (\PDOException $e) {
        echo 'Er is een fout opgetreden bij het uitvoeren van de query: ' . $e->getMessage();
        exit();
    }
}


function destroySession() {
    $_SESSION=array();

    if (session_id() != "" || isset($_COOKIE[session_name()]))
    setcookie(session_name(), '', time()-259200, '/');

    session_destroy();
}

function sanitizeString($var) {
    // Verwijder eventuele HTML-tags
    $var = strip_tags($var);
    // Verwijder ongewenste tekens met behulp van reguliere expressies
    $var = preg_replace('/[^a-zA-Z0-9\s]/', '', $var);
    // Verwijder extra spaties aan het begin en einde van de string
    $var = trim($var);
    // Verwijder meerdere opeenvolgende spaties in de string
    $var = preg_replace('/\s+/', ' ', $var);
    // Retourneer de schoongemaakte string
    return $var;
}

// Voorbeeldgebruik
//$dirtyString = "<script>alert('Hoi!');</script>    Ongewenste tekens verwijderen!  ";
//$cleanString = sanitizeString($dirtyString);
//echo $cleanString;


function showProfile($user) {
    global $pdo;

    if (file_exists("$user.jpg"))
        echo "<img src='$user.jpg' style='float:left;'>";

    $result = $pdo->query("SELECT * FROM profiles WHERE user = '$user'");

    while ($row = $result->fetch()) {
        die(stripslashes($row['text']) . "<br style='clear:left;'></br>");
    }

    echo "<p> Nothing to see here, yet</p><br>";
}

/*
// Maak verbinding met de database
$conn = new mysqli($host, $user, $pass, $data);
// Controleer verbinding
if ($conn->connect_errno) {
    die('Database verbinding is niet gelukt: ' . $conn->connect_error);
}

require_once 'controller.php';

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


*/

// Verwijderen van de familie
function verwijderFamilie($pdo, $familieId) {
    $sql = "DELETE familie, familielid FROM familie
            JOIN familielid ON familie.id = familielid.familie_id
            WHERE familie.id = ?";
    return executePreparedStatement($pdo, $sql, $familieId);
}

function verwijderFamilielid($pdo, $familielidId) {
    $sql = "DELETE FROM familielid WHERE id = ?";
    return executePreparedStatement($pdo, $sql, $familielidId);
}

function verwijderLidmaatschap($pdo, $lidmaatschapId) {
    $sql = "DELETE FROM lidmaatschap WHERE id = ?";
    return executePreparedStatement($pdo, $sql, $lidmaatschapId);
}

// Validatie geboortedatum
function geboortedatumValidatie() {

}

?>