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
		<li><a href="characters.php">Characters</a></li>
	</ul>
</nav>

<div id="wrapper">

<h1>burning bright</h1>

<div id="main">

<h2>Search for Characters</h2>

<form class="searchbar" method="get" action="characters-view.php">
<label for="query">Search Query:</label>
<input type="text" name="query" id="query"/>


<label for="search_by">Search By:</label>
<select id="search_by" name="search_by">
	<option value="sb_char_name">Character Name</option>
	<option value="sb_creation_date">Creation Date</option>
	<option value="sb_alliance">Alliance</option>
	<option value="sb_gender">Gender</option>
</select>


<label>Order By:</label>
<select id="order_by" name="order_by">
	<option value="ob_default">Default</option>
	<option value="ob_alphabetical">Alphabetical</option>
	<option value="ob_creation_date">Creation Date</option>
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
	
	$query_value = $_GET['query'];
	$sb_list = $_GET['search_by'];
	$ob_list = $_GET['order_by'];
	
	if ($sb_list == "sb_char_name") {
		$query = "SELECT * FROM Characters WHERE CharName = '$query_value'";
		$total_pages_sql = "SELECT COUNT(*) FROM Characters WHERE CharName = '$query_value';";
	}
	else if ($sb_list == "sb_creation_date") {
		$query = "SELECT * FROM Characters WHERE CreationDate = $query_value";
		$total_pages_sql = "SELECT COUNT(*) FROM Characters WHERE CreationDate = $query_value;";
	}
	else if ($sb_list == "sb_alliance") {
		$query = "SELECT * FROM Characters WHERE Alliance = '$query_value'";
		$total_pages_sql = "SELECT COUNT(*) FROM Characters WHERE Alliance = '$query_value';";
	}
	else if ($sb_list == "sb_gender") {
		$query = "SELECT * FROM Characters WHERE Gender = '$query_value'";
		$total_pages_sql = "SELECT COUNT(*) FROM Characters WHERE Gender = '$query_value';";
	}
	
	if ($ob_list == "ob_alphabetical") {
		$query .= "ORDER BY CharName";
	}
	else if ($ob_list == "ob_creation_date") {
		$query .= "ORDER BY CreationDate";
	}
	
	$no_of_records_per_page = 15;
	$offset = ($pageno - 1) * $no_of_records_per_page;
	
	$total_pages_sql .= ";";
	$query .= " LIMIT $offset, $no_of_records_per_page;";
	
	// get rows via mysqli_num_rows ??
	$total_pages_result = mysqli_query($conn, $total_pages_sql);
	$total_rows = mysqli_fetch_array($total_pages_result)[0];
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
		
		<div class="button">
			<a href="Characters/<?php echo $row['FileName']?>"><?php echo $row['CharName'] ?></a>
			
		</div>
		
		<?php
	}
	

}
	
mysqli_close($conn);
	
?>

</div>

</div>

</body>
</html>
