<!DOCTYPE html>
<html>
<head>
<title>Artikel aanpassen</title>
</head>
<body>
    <main>
        <div class="nav-list">
                <ul>
                    <li><a href="index.php">Terug naar menu</a></li>
                </ul>
            </div>
    <form action="update_article.php" method="POST">
      <label for="artikel_naam">Artikel nummer:</label>
      <input type="text" id="artikel_nummer" name="artikel_nummer"><br>

      <label for="artikel_naam">Artikel naam:</label>
      <input type="text" id="artikel_naam" name="artikel_naam"><br>

      <label for="prijs">Prijs:</label>
      <input type="number" id="prijs" name="prijs"><br>

      <input type="submit" value="Submit">
    </form>
    
    </main>
</body>
</html>

<?php error_reporting (E_ALL ^ E_NOTICE);
include 'db_connect.php';

if (isset($_POST['submit'])){

  // Nieuwe waarden ophalen
  $artikel_naam = $_POST['artikel_naam'];
  $prijs = $_POST['prijs'];

  $sql = "UPDATE articles SET artikel_naam='$artikel_naam', prijs='$prijs' WHERE artikel_nr=$artikel_nr";

  if (mysqli_query($conn, $sql)) {
    echo "Artikel is succesvol bijgewerkt.";
  }else {
    echo "Fout bij het bijwerken van artikel: " . mysqli_error($conn);
  }
}

mysqli_close($conn);

