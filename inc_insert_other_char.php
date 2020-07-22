<h3>Insert Character</h3>

<form method="post" action="inc_insert_char.php">
	<label for="char_name">Character Name:</label>
	<input type="text" id="char_name" name="char_name" size="25"/><br/>
	
	<label for="roleplayer">Roleplayer:</label>
	<input type="text" id="roleplayer" name="roleplayer" size="20"/><br/>
	
	
	<input type="reset" name="reset" id="reset" value="Reset"/>
	<input type="submit" name="char_insert" id="char_insert" value="Submit"/>
</form>


<?php

// INSERT CHARACTER
if(isset($_POST['char_insert'])) {
	
	// Gather form variables
	$char_name = ucwords(strtolower(trim($_POST['char_name'])));
	$roleplayer = ucwords(strtolower(trim($_POST['roleplayer'])));
	
	$query = "INSERT INTO OtherCharacters (CharName, Roleplayer) VALUES ('$char_name', '$species', '$roleplayer');";
	
	if (empty($char_name) || empty($roleplayer)) {
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