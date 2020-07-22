<!DOCTYPE html>
<head>
	<html lang="en">
	<meta http-equiv="content-type" content="text/html; charset=iso-8859-1" />
	<meta charset="utf-8"/>
	
	<title>burning bright</title>
	
	<link href="styles/main.css" rel="stylesheet" type="text/css"/>
	
	<link href="https://fonts.googleapis.com/css?family=Quattrocento|Open+Sans&display=swap" rel="stylesheet">
	
	
</head>
<body>

<nav>
	<ul>
	<?php include("includes/inc_dbconn.php") ?>
	
		<li><a href="index.php">Home</a></li>
		<li><a href="threads.php">Threads</a></li>
	</ul>
</nav>

<div id="wrapper">

<h1>burning bright</h1>

<div id="main">

	<h2>Search for Threads</h2>
	
<form class="searchbar" method="get" action="threads.php">
<label for="query">Search Query:</label>
<input type="text" name="query" id="query"/>


<label for="search_by">Search By:</label>
<select id="search_by" name="search_by">
	<option value="sb_char_name">Character Name</option>
	<option value="sb_thread_name">Thread Name</option>
	<option value="sb_roleplayer">Roleplayers</option>
	<option value="sb_other_char">Other Characters</option>
	<option value="sb_location_board">Location Board</option>
	<option value="sb_location">Location</option>
	<option value="sb_start_date">Start Date</option>
	<option value="sb_end_date">End Date</option>
</select>


<label>Order By:</label>
<select id="order_by" name="order_by">
	<option value="ob_default">Default</option>
	<option value="ob_alphabetical">Alphabetical</option>
	<option value="ob_start_date">Start Date</option>
	<option value="ob_end_date">End Date</option>
</select>

<input type="submit" name="search" id="search" value="Search"/>
</form>

<?php

if (isset($_GET['search'])) {
	
	if (isset($_GET['pageno'])) {
		$pageno = $_GET['pageno'];
	}
	else {
		$pageno = 1;
	}
	
	// Gather form variables
	$query_value = addslashes($_GET['query']);
	$sb_list = $_GET['search_by'];
	$ob_list = $_GET['order_by'];
	
	// SEARCH BY
	if($sb_list == "sb_char_name") {
	
		$query = "SELECT DISTINCT C.CharName, ThreadName, Roleplayers, Characters, LocationBoard, Location, C.FileName AS CharFile, T.FileName AS ThreadFile, DATE_FORMAT(StartDate, \"%M, %d, %Y\") AS StartDate, DATE_FORMAT(EndDate, \"%M, %d, %Y\") AS EndDate FROM EquineCharacters AS C JOIN CharactersThreads AS TC ON C.CharID = TC.CharID JOIN Threads AS T JOIN CharactersThreads ON T.ThreadID = TC.ThreadID WHERE C.CharName = '$query_value'";
		$total_pages_sql = "SELECT DISTINCT ThreadName FROM EquineCharacters AS C JOIN CharactersThreads AS TC ON C.CharID = TC.CharID JOIN Threads AS T JOIN CharactersThreads ON T.ThreadID = TC.ThreadID WHERE C.CharName = '$query_value'";
	}
	
	else if($sb_list == "sb_thread_name") {
		
		$query = "SELECT DISTINCT C.CharName, ThreadName, Roleplayers, Characters, LocationBoard, Location, C.FileName AS CharFile, T.FileName AS ThreadFile, DATE_FORMAT(StartDate, \"%M, %d, %Y\") AS StartDate, DATE_FORMAT(EndDate, \"%M, %d, %Y\") AS EndDate FROM EquineCharacters AS C JOIN CharactersThreads AS TC ON C.CharID = TC.CharID JOIN Threads AS T JOIN CharactersThreads ON T.ThreadID = TC.ThreadID WHERE ThreadName = '$query_value'";
		$total_pages_sql = "SELECT DISTINCT ThreadName FROM EquineCharacters AS C JOIN CharactersThreads AS TC ON C.CharID = TC.CharID JOIN Threads AS T JOIN CharactersThreads ON T.ThreadID = TC.ThreadID WHERE ThreadName = '$query_value'";
		
	}
	
	else if($sb_list == "sb_location_board") {
		
		$query = "SELECT DISTINCT C.CharName, ThreadName, Roleplayers, Characters, LocationBoard, Location, C.FileName AS CharFile, T.FileName AS ThreadFile, DATE_FORMAT(StartDate, \"%M, %d, %Y\") AS StartDate, DATE_FORMAT(EndDate, \"%M, %d, %Y\") AS EndDate FROM EquineCharacters AS C JOIN CharactersThreads AS TC ON C.CharID = TC.CharID JOIN Threads AS T JOIN CharactersThreads ON T.ThreadID = TC.ThreadID WHERE LocationBoard = '$query_value'";
		$total_pages_sql = "SELECT DISTINCT ThreadName FROM EquineCharacters AS C JOIN CharactersThreads AS TC ON C.CharID = TC.CharID JOIN Threads AS T JOIN CharactersThreads ON T.ThreadID = TC.ThreadID WHERE LocationBoard = '$query_value'";
	}
	
	else if($sb_list == "sb_location") {
		
		$query = "SELECT DISTINCT C.CharName, ThreadName, Roleplayers, Characters, LocationBoard, Location, C.FileName AS CharFile, T.FileName AS ThreadFile, DATE_FORMAT(StartDate, \"%M, %d, %Y\") AS StartDate, DATE_FORMAT(EndDate, \"%M, %d, %Y\") AS EndDate FROM EquineCharacters AS C JOIN CharactersThreads AS TC ON C.CharID = TC.CharID JOIN Threads AS T JOIN CharactersThreads ON T.ThreadID = TC.ThreadID WHERE Location = '$query_value'";
		$total_pages_sql = "SELECT DISTINCT ThreadName FROM EquineCharacters AS C JOIN CharactersThreads AS TC ON C.CharID = TC.CharID JOIN Threads AS T JOIN CharactersThreads ON T.ThreadID = TC.ThreadID WHERE Location = '$query_value'";
	}
	
	else if($sb_list == "sb_roleplayer") {
		
		$query = "SELECT DISTINCT C.CharName, ThreadName, Roleplayers, Characters, LocationBoard, Location, C.FileName AS CharFile, T.FileName AS ThreadFile, DATE_FORMAT(StartDate, \"%M, %d, %Y\") AS StartDate, DATE_FORMAT(EndDate, \"%M, %d, %Y\") AS EndDate FROM EquineCharacters AS C JOIN CharactersThreads AS TC ON C.CharID = TC.CharID JOIN Threads AS T JOIN CharactersThreads ON T.ThreadID = TC.ThreadID WHERE Roleplayers LIKE '%$query_value%'";
		$total_pages_sql = "SELECT DISTINCT ThreadName FROM EquineCharacters AS C JOIN CharactersThreads AS TC ON C.CharID = TC.CharID JOIN Threads AS T JOIN CharactersThreads ON T.ThreadID = TC.ThreadID WHERE Roleplayers LIKE '%$query_value%'";
	}
	
	else if($sb_list == "sb_other_char") {
		
		$query = "SELECT DISTINCT C.CharName, ThreadName, Roleplayers, Characters, LocationBoard, Location, C.FileName AS CharFile, T.FileName AS ThreadFile, DATE_FORMAT(StartDate, \"%M, %d, %Y\") AS StartDate, DATE_FORMAT(EndDate, \"%M, %d, %Y\") AS EndDate FROM EquineCharacters AS C JOIN CharactersThreads AS TC ON C.CharID = TC.CharID JOIN Threads AS T JOIN CharactersThreads ON T.ThreadID = TC.ThreadID WHERE Characters LIKE '%$query_value%'";
		$total_pages_sql = "SELECT DISTINCT ThreadName FROM EquineCharacters AS C JOIN CharactersThreads AS TC ON C.CharID = TC.CharID JOIN Threads AS T JOIN CharactersThreads ON T.ThreadID = TC.ThreadID WHERE Characters LIKE '%$query_value%'";
	}
	
	else if($sb_list == "sb_start_date") {
		
		$query = "SELECT DISTINCT C.CharName, ThreadName, Roleplayers, Characters, LocationBoard, Location, C.FileName AS CharFile, T.FileName AS ThreadFile, DATE_FORMAT(StartDate, \"%M, %d, %Y\") AS StartDate, DATE_FORMAT(EndDate, \"%M, %d, %Y\") AS EndDate FROM EquineCharacters AS C JOIN CharactersThreads AS TC ON C.CharID = TC.CharID JOIN Threads AS T JOIN CharactersThreads ON T.ThreadID = TC.ThreadID WHERE StartDate = '$query_value'";
		$total_pages_sql = "SELECT DISTINCT ThreadName FROM EquineCharacters AS C JOIN CharactersThreads AS TC ON C.CharID = TC.CharID JOIN Threads AS T JOIN CharactersThreads ON T.ThreadID = TC.ThreadID WHERE StartDate = '$query_value'";
	}
	
	else if($sb_list == "sb_end_date") {
		
		$query = "SELECT DISTINCT C.CharName, ThreadName, Roleplayers, Characters, LocationBoard, Location, C.FileName AS CharFile, T.FileName AS ThreadFile, DATE_FORMAT(StartDate, \"%M, %d, %Y\") AS StartDate, DATE_FORMAT(EndDate, \"%M, %d, %Y\") AS EndDate FROM EquineCharacters AS C JOIN CharactersThreads AS TC ON C.CharID = TC.CharID JOIN Threads AS T JOIN CharactersThreads ON T.ThreadID = TC.ThreadID WHERE EndDate = '$query_value'";
		$total_pages_sql = "SELECT DISTINCT ThreadName FROM EquineCharacters AS C JOIN CharactersThreads AS TC ON C.CharID = TC.CharID JOIN Threads AS T JOIN CharactersThreads ON T.ThreadID = TC.ThreadID WHERE EndDate = '$query_value'";
	}
	
	// ORDER BY
	if($ob_list = "ob_alphabetical") {
		$query .= "ORDER BY ThreadName";
	}
	else if($ob_list = "ob_start_date") {
		$query .= "ORDER BY StartDate";
	}
	else if($ob_list = "ob_end_date") {
		$query .= "ORDER BY EndDate";
	}

	
	$no_of_records_per_page = 15;
	$offset = ($pageno - 1) * $no_of_records_per_page;
	
	$total_pages_sql .= ";";
	$query .= " LIMIT $offset, $no_of_records_per_page;";
	
	// get rows via mysqli_num_rows ??
	$total_pages_result = mysqli_query($conn, $total_pages_sql);
	$total_rows = mysqli_num_rows($total_pages_result);
	$total_pages = ceil($total_rows / $no_of_records_per_page);

	$result = mysqli_query($conn, $query);
	$result_array = mysqli_fetch_array(mysqli_query($conn, $query));
	$result_count = mysqli_num_rows($result);
	
	
	?>

		<p>There <?php if($total_rows == 1) echo "is $total_rows result."; else echo "are $total_rows results.";?></p>

	<div id="pagination">
		<a href="?query=<?php echo "$query_value";?>&search_by=<?php echo "$sb_list";?>&order_by=<?php echo"$ob_list";?>&search=Search&pageno=1">First</a>
        <a href="?query=<?php echo "$query_value";?>&search_by=<?php echo "$sb_list";?>&order_by=<?php echo"$ob_list";?>&search=Search<?php if($pageno <= 1){ echo '#'; } else { echo "&pageno=".($pageno - 1); } ?>">Prev</a>
        <a href="?query=<?php echo "$query_value";?>&search_by=<?php echo "$sb_list";?>&order_by=<?php echo"$ob_list";?>&search=Search<?php if($pageno >= $total_pages){ echo '#'; } else { echo "&pageno=".($pageno + 1); } ?>">Next</a>
        <a href="?query=<?php echo "$query_value";?>&search_by=<?php echo "$sb_list";?>&order_by=<?php echo"$ob_list";?>&search=Search&pageno=<?php echo $total_pages; ?>">Last</a>
	</div>	
		
	<?php
	
	while($row = mysqli_fetch_assoc($result)) {
		
	?>
		
		<div class="threadlist">
		<h3><a href="Threads/<?php echo $row['ThreadFile']?>"><?php echo $row['ThreadName'] ?></a></h3>
		<p><i><?php echo $row['StartDate']?> to <?php echo $row['EndDate']?></i></p>
		
		<p><a href="Characters/<?php echo $row['CharFile']?>"><?php echo $row['CharName'] ?></a><br/></p>
		
		<p><b>With:</b> <?php echo $row['Characters']?><br/></p>

		<p><b>Played By:</b> <?php echo $row['Roleplayers']?><br/></p>
			
		<p><b>In:</b> <?php echo $row['Location'] ?> (<?php echo $row['LocationBoard'] ?>)</p>
		</div>


	<?php
		

	}
}


	$conn->close();
?>

</div>

</div>

</body>
</html>