
<!DOCTYPE html>
<html>
<head>
<title>Articles</title>
</head>

<body>
    <main>
        <div class="header-content">
            <h1>PC4U Artikelen</h1>
        <nav>
            <div class="nav-list">
                <ul>
                    <li><a href="add_article.php">Toevoegen</a></li>
                    <li><a href="index.php">Tonen</a></li>
                    <li><a href="update_article.php">Aanpassen</a></li>
                </ul>
            </div>
            
        </nav>
        </div>
        
        <div class="show-content">
            <h3>Bestaande Artikelen</h3>
            <?php include 'db_connect.php';
            // SQL-query uitvoeren om alle artikelen op te halen
            $sql = "SELECT artikel_nr, artikel_naam, prijs FROM articles";
            $result = $conn->query($sql);

            // Controleren of er resultaten zijn gevonden
            if ($result->num_rows > 0) {
            // Resultaten weergeven in HTML
            echo "<table>
                <tr>
                    <th>Artikelnummer</th>
                    <th>Artikelnaam</th>
                    <th>Prijs</th>
                </tr>";

            while($row = $result->fetch_assoc()) {
                echo "<tr><td>" . $row["artikel_nr"] . "</td><td>" . $row["artikel_naam"] . "</td><td>" . $row["prijs"] . "</td></tr>";
                
            }
            echo "</table>";
            } else {
            echo "Geen artikelen gevonden.";
            }

            // Databaseverbinding sluiten
            $conn->close();
            ?>

        </div>
        
    
    </main>
</body>
</html>