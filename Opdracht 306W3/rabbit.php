<?php

// Emo-konijnen array
$emojis = array(
    array("  /\\",
          " (´・ω・`)",
          "(\")_(\")"),
    array("  /\\",
          " (｡･ω･｡)",
          "(\")_(\")"),
    array("  /\\",
          " (o･ω･o)",
          "(\")_(\")"),
    // Voeg hier meer emo-konijnen toe
);

// Functie voor het genereren van een regel met random emo-konijntjes
function generateEmoLine($emojis) {
    $emojis1 = array();
    for ($i = 0; $i < 15; $i++) {
        $randIndex = array_rand($emojis);
        array_push($emojis1, $emojis[$randIndex]);
    }
    return $emojis1;
}

// HTML-functie voor het weergeven van emo-konijnen
function displayEmojis($emojis) {
    $emojis1 = generateEmoLine($emojis);
    $emojis2 = generateEmoLine($emojis);
    
    $html = '<p style="font-family: monospace;">';
    foreach ($emojis1 as $emoji) {
        $html .= '<span>' . implode('<br>', $emoji) . '</span>';
    }
    $html .= '</p>';
    
    $html .= '<p style="font-family: monospace;">';
    foreach ($emojis2 as $key => $emoji) {
        if ($emoji === $emojis1[$key]) {
            $html .= '<span style="color: red;">' . implode('<br>', $emoji) . '</span>';
        } else {
            $html .= '<span>' . implode('<br>', $emoji) . '</span>';
        }
    }
    $html .= '</p>';
    
    echo $html;
}

// Roep de functie aan om de emo-konijnen weer te geven
displayEmojis($emojis);

?>
