<?php

// Database configuratie
define('DB_HOST', 'localhost');
define('DB_USERNAME', 'root');
define('DB_PASSWORD', 'mysql');
define('DB_NAME', 'ledenadministratie');

// Maak verbinding met de database
$conn = new mysqli(DB_HOST, DB_USERNAME, DB_PASSWORD, DB_NAME);


// Controleer verbinding
if ($conn->connect_errno) {
    die('Database connection failed: ' . $conn->connect_error);
}

// Functie om  veilig een query uit te voeren
function executePreparedStatement($conn, $sql, ...$params) {
    $stmt = $conn->prepare($sql);

    if ($stmt === false) {
        echo 'Er is een fout opgetreden bij het voorbereiden van de statement.';
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

        // Foutopsporingsinformatie
        echo 'Query: ' . $sql . '<br>';
        echo 'Parameters: ';
        var_dump($paramValues);

        $stmt->bind_param($types, ...$params);
        echo 'Statement parameters: ';
        var_dump($stmt->param_count);
    }

    if (!$stmt->execute()) {
        echo 'Er is een fout opgetreden bij het uitvoeren van de query: ' . $stmt->error;
        exit();
    }

    return $stmt->get_result();
}








?>