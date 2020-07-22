<!DOCTYPE html>
<head>
	<html lang="en">
	<meta http-equiv="content-type" content="text/html; charset=iso-8859-1" />
	<meta charset="utf-8"/>
	
	<title>burning bright</title>
	
	<link href="styles/main.css" rel="stylesheet" type="text/css"/>
	
	<link href="https://fonts.googleapis.com/css?family=Quattrocento&display=swap" rel="stylesheet">
	
	
</head>
<body>

<nav>
	<ul>
	<?php include("includes/inc_dbconn.php") ?>
	
		<li><a href="index.php">Home</a></li>
		<li><a href="manage.php">Manage</a></li>
	</ul>
</nav>

<div id="wrapper">

<h1>burning bright</h1>

<div id="main">

	<h2>Manage</h2>
	
	<br/><br/>
	
	<a class="button" href="manage.php?page=insert_char">Insert Character</a>
	
	<a class="button" href="manage.php?page=insert_thread">Insert Thread</a>
	
	<a class="button" href="manage.php?page=add_char">Add Character</a>
	
	
	<div id="dynamic_content">
	
	<?php
			
	if (isset($_GET['page'])) {
		switch ($_GET['page']) {
			case 'insert_char':
				?>
				
				<h3>Insert Character</h3>

				<form method="post" action="manage.php?page=insert_char">
					<label for="char_name">Character Name:</label>
					<input type="text" id="char_name" name="char_name" size="25"/><br/>
					
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
					
					
					// Gather form variables
					$char_name = addslashes(ucwords(strtolower(trim($_POST['char_name']))));
					$creation_date = trim($_POST['creation_date']);
					$alliance = ucfirst(strtolower(trim($_POST['alliance'])));
					$gender = ucfirst(strtolower(trim($_POST['gender'])));
					$deceased = ucfirst($_POST['deceased']);
					$adopted = ucfirst($_POST['adopted']);
					$adopted_out = ucfirst($_POST['adopted_out']);
					$char_file = strtolower(trim($_POST['char_name'] . ".php"));
					
					$query = "INSERT INTO EquineCharacters (CharName, CreationDate, Alliance, Gender, Deceased, Adopted, AdoptedOut, FileName) VALUES ('$char_name', '$creation_date', '$alliance', '$gender', '$deceased', '$adopted', '$adopted_out', '$char_file');";
					
					if (empty($char_name) || empty($gender) || empty($alliance)) {
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
		<?php
				
				break;
			case 'insert_thread':
				?>
								
				<h3>Insert Thread</h3>

				<form method="post" action="manage.php?page=insert_thread">
				
					<label for="thread_name">Thread Name:</label>
					<input type="text" id="thread_name" name="thread_name" size="40"/><br/>

					<label for="char_name">Character Name:</label>
					<input type="text" id="char_name" name="char_name" size="25"/><br/>
					
					<label for="site_version">Site Version:</label>
					<input type="text" id="site_version" name="site_version" size="10"/><br/>
					
					<label for="location">Location:</label>
					<input type="text" id="location" name="location" size="30"/><br/>
					
					<label for="location_board">Location Board:</label>
					<input type="text" id="location_board" name="location_board" size="30"/><br/>
					
					<label for="roleplayers">Roleplayers:</label>
					<input type="text" id="roleplayers" name="roleplayers" size="40"/><br/>
					
					<label for="characters">Other Characters:</label>
					<input type="text" id="characters" name="characters" size="40"/><br/>
					
					<label for="start_date">Start Date (YYYY-MM-DD):</label>
					<input type="text" id="start_date" name="start_date" size="15"/><br/>
					
					<label for="end_date">End Date (YYYY-MM-DD):</label>
					<input type="text" id="end_date" name="end_date" size="15"/><br/>
					
					<input type="submit" name="thread_insert" id="thread_insert" value="Submit"/>
					<input type="reset" name="reset" id="reset" value="Reset"/>
				</form>

				<?php

				// INSERT THREAD, OTHER CHARACTER, AND LINKING TABLES
				if(isset($_POST['thread_insert'])) {
					// Gather form variables
					$char_name = addslashes(ucfirst(strtolower(trim($_POST['char_name']))));
					$thread_name = addslashes(strtolower($_POST['thread_name']));
					$site_version = strtoupper($_POST['site_version']);
					$location_board = ucwords(strtolower(trim($_POST['location_board'])));
					$location = addslashes(ucwords(strtolower(trim($_POST['location']))));
					$roleplayers = ucwords(strtolower(trim($_POST['roleplayers'])));
					$other_characters = addslashes(ucwords(strtolower(trim($_POST['characters']))));
					$start_date = $_POST['start_date'];
					$end_date = $_POST['end_date'];
					
					
					$thread_file = strtolower($_POST['thread_name'] . ".php");
					
					// Query to insert data into thread table
					$thread_query = "INSERT INTO Threads (ThreadName, SiteVersion, LocationBoard, Location, Roleplayers, Characters, StartDate, EndDate, FileName) VALUES ('$thread_name', '$site_version', '$location_board', '$location', '$roleplayers', '$other_characters', '$start_date', '$end_date', '$thread_file');";
					
					if (empty($char_name) || empty($thread_name) || empty($start_date) || empty($end_date) || empty($site_version) || empty($location_board) || empty($location)) {
						echo "Error: You must fill out all fields!";
					}
					else {
						if(mysqli_query($conn, $thread_query) === True) {
							echo "Thread record created successfully!<br/>";
							
							// Query to insert data into thread_character linking table
							// Grab the respective IDs based on the names inputed
							$get_char_id = "SELECT CharID FROM EquineCharacters WHERE CharName = '$char_name';";
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
				
				?>
				<script>
				window.onload = function() {
					document.getElementById("thread_name").focus();
				}
				</script>
				
				<?php
				break;
			case 'add_char':
			?>
			<h3>Add Character to Thread</h3>

				<form method="post" action="manage.php?page=add_char">

					<label for="char_name">Character Name:</label>
					<input type="text" id="char_name" name="char_name" size="25"/><br/>
					
					<label for="thread_name">Thread Name:</label>
					<input type="text" id="thread_name" name="thread_name" size="40"/><br/>
					
					<input type="submit" name="add_char" id="add_char" value="Submit"/>
					<input type="reset" name="reset" id="reset" value="Reset"/>
				</form>

				<?php

				// INSERT THREAD, OTHER CHARACTER, AND LINKING TABLES
				if(isset($_POST['add_char'])) {
					// Gather form variables
					$char_name = addslashes(ucfirst(strtolower(trim($_POST['char_name']))));
					$thread_name = addslashes(strtolower($_POST['thread_name']));
					
					if (empty($char_name) || empty($thread_name)) {
						echo "Error: You must fill out all fields!";
					}
					else {
						// Query to insert data into thread_character linking table
						// Grab the respective IDs based on the names inputed
						$get_char_id = "SELECT CharID FROM EquineCharacters WHERE CharName = '$char_name';";
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
				}

				?>
				<script>
				window.onload = function() {
					document.getElementById("char_name").focus();
				}
				</script>

				<?php
				break;
		}
	}
	
	mysqli_close($conn);
	?>
	

	</div>

</div>

</div>

</body>
</html>