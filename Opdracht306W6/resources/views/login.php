
<?php
session_start();

// Controleer of de gebruiker al is ingelogd
if (isset($_SESSION['gebruikersnaam'])) {
    header("Location: login.php");
    exit();
}

// Inloggegevens controleren bij het verzenden van het formulier
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Controleer de ingevoerde gebruikersnaam en wachtwoord
    $ingevoerdeGebruikersnaam = $_POST['gebruikersnaam'];
    $ingevoerdWachtwoord = $_POST['wachtwoord'];

    // Voer hier je eigen code uit om de ingevoerde gegevens te valideren en te controleren tegen de database

    // Voorbeeldcontrole: Als de gebruikersnaam en het wachtwoord overeenkomen, stel de sessievariabele in en stuur door naar het dashboard
    if ($ingevoerdeGebruikersnaam === "admin" && $ingevoerdWachtwoord === "admin123") {
        $_SESSION['gebruikersnaam'] = $ingevoerdeGebruikersnaam;
        header("Location: login.php");
        exit();
    } else {
        $foutmelding = "Ongeldige gebruikersnaam of wachtwoord.";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
</head>
<body>
    <h1>Login ledenadministratie</h1>

    <?php if (isset($foutmelding)) { ?>
        <p><?php echo $foutmelding; ?></p>
    <?php } ?>

    <form method="post" action="">
        <label for="gebruikersnaam">Gebruikersnaam:</label>
        <input type="text" name="gebruikersnaam" required><br>

        <label for="wachtwoord">Wachtwoord:</label>
        <input type="password" name="wachtwoord" required><br>

        <button type="submit">Inloggen</button>
    </form>

    <p><a href="wachtwoord_reset.php">Wachtwoord vergeten?</a></p>
</body>
</html>
