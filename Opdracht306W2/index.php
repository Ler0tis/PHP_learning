
<!DOCTYPE html>
<html>
<head>
	<title>BMI Calculator</title>
</head>
<body>
	<h1>BMI Calculator</h1>
	<form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
		<label for="height">Lengte (in cm):</label>
		<input type="text" name="height" id="height">
		<label for="weight">Gewicht (in kg):</label>
		<input type="text" name="weight" id="weight">
		<input type="submit" value="Bereken BMI">
	</form>

	<?php
	if ($_SERVER["REQUEST_METHOD"] == "POST") {
		$height = $_POST["height"];
		$weight = $_POST["weight"];

		if (!empty($height) && !empty($weight)) {
			$bmi = $weight / (($height/100) * ($height/100));
			echo "<p>Uw BMI is: " . $bmi, 1 . "</p>";
			if ($bmi < 18.5) {
				echo "<p>U hebt ondergewicht.</p>";
			} elseif ($bmi >= 18.5 && $bmi < 25) {
				echo "<p>U hebt een gezond gewicht.</p>";
			} elseif ($bmi >= 25 && $bmi < 30) {
				echo "<p>U hebt matig overgewicht.</p>";
			} else {
				echo "<p>U hebt ernstig overgewicht.</p>";
			}
		} else {
			echo "<p>Voer uw lengte en gewicht in zonder komma's of punten.</p>";
			}
	}
	?>
</body>
</html>