<h3>Insert Thread</h3>

<form method="post" action="inc_insert_thread.php">

	<label for="char_name">Character Name:</label>
	<input type="text" id="char_name" name="char_name" size="25"/><br/>
	
	<label for="thread_name">Thread Name:</label>
	<input type="text" id="thread_name" name="thread_name" size="40"/><br/>
	
	<label for="start_date">Start Date (YYYY-MM-DD):</label>
	<input type="text" id="start_date" name="start_date" size="15"/><br/>
	
	<label for="end_date">End Date (YYYY-MM-DD):</label>
	<input type="text" id="end_date" name="end_date" size="15"/><br/>
	
	<label for="site_version">Site Version:</label>
	<input type="text" id="site_version" name="site_version" size="10"/><br/>
	
	<label for="location_board">Location Board:</label>
	<input type="text" id="location_board" name="location_board" size="30"/><br/>
	
	<label for="location">Location:</label>
	<input type="text" id="location" name="location" size="30"/><br/>
	
	<input type="submit" name="thread_insert" id="thread_insert" value="Submit"/>
	<input type="reset" name="reset" id="reset" value="Reset"/>
</form>

<p id="error"></p>

<?php

// INSERT THREAD, OTHER CHARACTER, AND LINKING TABLES
if(isset($_POST['thread_insert'])) {
	// Gather form variables
	$char_name = ucfirst(strtolower(trim($_POST['char_name'])));
	$thread_name = strtolower($_POST['thread_name']);
	$start_date = $_POST['start_date'];
	$end_date = $_POST['end_date'];
	$site_version = strtoupper($_POST['site_version']);
	$location_board = ucwords(strtolower(trim($_POST['location_board'])));
	$location = ucwords(strtolower(trim($_POST['location'])));
	
	$thread_file = strtolower($_POST['thread_name'] . ".html");
	
	// Query to insert data into thread table
	$thread_query = "INSERT INTO Threads (ThreadName, StartDate, EndDate, SiteVersion, LocationBoard, Location, FileName) VALUES ('$thread_name', '$start_date', '$end_date', $site_version, '$location_board', '$location', '$thread_file');";
	
	if (empty($char_name) || empty($thread_name) || empty($start_date) || empty($end_date) || empty($site_version) || empty($location_board) || empty($location)) {
		echo "Error: You must fill out all fields!";
	}
	else {
		if(mysqli_query($conn, $thread_query) === True) {
			echo "Thread record created successfully!<br/>";
			
			// Query to insert data into thread_character linking table
			// Grab the respective IDs based on the names inputed
			$get_char_id = "SELECT CharID FROM Characters WHERE CharName = '$char_name';";
			$get_thread_id = "SELECT ThreadID FROM Threads WHERE ThreadName = '$thread_name';";
	
			// Query the database for those IDs
			$char_id_query = mysqli_fetch_array(mysqli_query($conn, $get_char_id));
			$thread_id_query = mysqli_fetch_array(mysqli_query($conn, $get_thread_id));
	
			// Select the actual IDs from the array given by the database
			$actual_char_id = $char_id_query['CharID'];
			$actual_thread_id = $thread_id_query['ThreadID'];
	
			// Insert the record into the linking table
			$link_query = "INSERT INTO CharactersThreads (CharID, ThreadID) VALUES ($actual_char_id, $actual_thread_id);";
	

			if(mysqli_query($conn, $link_query) === True) {
				echo "Linking table record created successfully!";
			}
			else {
				echo "Error inserting data. " . mysqli_error($conn);
			}
		}
		else {
			echo "Error inserting data: " . mysqli_error($conn) . "<br/>";
		}
	}
	

}

	$conn->close();
?>
<script>
window.onload = function() {
	document.getElementById("char_name").focus();
}
</script>