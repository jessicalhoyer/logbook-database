<h3>Insert Character</h3>

<form method="post" action="includes/inc_insert_char.php">
	<label for="char_name">Character Name:</label>
	<input type="text" id="char_name" name="char_name" size="25"/><br/>
	
	<label for="species">Species:</label>
	<input type="text" id="species" name="species" size="20"/><br/>
	
	<label for="creation_date">Creation Date (YYYY-MM-DD):</label>
	<input type="text" id="creation_date" name="creation_date" size="15"/><br/>
	
	<label for="alliance">Alliance:</label>
	<input type="text" id="alliance" name="alliance" size="20"/><br/>
	
	<label for="gender">Gender:</label>
	<input type="text" id="gender" name="gender" size="15"/><br/>
	
	<label for="deceased">Deceased?:</label>
	<select id="deceased" name="deceased">
		<option value="no">No</option>
		<option value="yes">Yes</option>
	</select><br/>
	
	<label for="adopted">Adopted?:</label>
	<select id="adopted" name="adopted">
		<option value="no">No</option>
		<option value="yes">Yes</option>
	</select><br/>
	
	<label for="adopted_out">Adopted Out?:</label>
	<select id="adopted_out" name="adopted_out">
		<option value="no">No</option>
		<option value="yes">Yes</option>
	</select><br/>
	
	<input type="submit" name="char_insert" id="char_insert" value="Submit"/>
	<input type="reset" name="reset" id="reset" value="Reset"/>
</form>


<?php

// INSERT CHARACTER
if(isset($_POST['char_insert'])) {
	
	$servername = "127.0.0.1:3306";
	$username = "root";
	$password = "";
	$dbname = "Logbook";

	$conn = new mysqli($servername, $username, $password, $dbname);
	
	// Gather form variables
	$char_name = ucwords(strtolower(trim($_POST['char_name'])));
	$species = ucwords(strtolower(trim($_POST['species'])));
	$creation_date = trim($_POST['creation_date']);
	$alliance = ucfirst(strtolower(trim($_POST['alliance'])));
	$gender = ucfirst(strtolower(trim($_POST['gender'])));
	$deceased = $_POST['deceased'];
	$adopted = $_POST['adopted'];
	$adopted_out = $_POST['adopted_out'];
	$char_file = strtolower(trim($_POST['char_name'] . ".html"));
	
	$query = "INSERT INTO Characters (CharName, Species, CreationDate, Alliance, Gender, Deceased, Adopted, AdoptedOut, FileName) VALUES ('$char_name', '$species', '$creation_date', '$alliance', '$gender', '$deceased', '$adopted', '$adopted_out', '$char_file');";
	
	if (empty($char_name) || empty($species) || empty($gender) || empty($alliance)) {
		echo "Error: You must fill out all fields!";
	}
	else {
		if (mysqli_query($conn, $query) === True) {
			echo "Character record created successfully!";
		}
		else {
			echo "Error inserting data: " . mysqli_error($conn);
		}
	}

	
}

?>

<script>
window.onload = function() {
	document.getElementById("char_name").focus();
}
</script>