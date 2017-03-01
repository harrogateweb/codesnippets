<?php
//session would be here on live site
// session_start();
// get database connection
include("config/pdodb.php");
$database = new PDOdatabase();
$db = $database->getConnection();
//Instantiate jobs class
include_once("classes/selectjobdetail.php");
$jobcontent = new jobcontent($db);
?>
<!DOCTYPE html>
<html lang="en">
<head>
<title>Display listy of jobs - Multiple row PDO MySQL Example</title>
</head>
<body>
<h2>Your job search results - <a href='displayjobs.php'>Start a new search</a></h2>
<hr>
<?php
// set job category/type of jobs to be returned then call the class to return the content
$jobcontent->getJobList($_GET['pid']);
?>
</body>