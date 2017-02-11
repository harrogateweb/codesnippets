<?php
session_start();
include("config/pdodb.php");
include_once("objects/selectjobdetail.php");
?>
<!DOCTYPE html>
<html lang="en">
<head>
<title>Display listy of jobs - Multiple row PDO MySQL Example</title>
</head>
<body>
<h2>Your job search results - <a href='selectjobs.php'>Start a new search</a></h2>
<hr>
<?php
// set job category/type of jobs to be returned
$jobcontent->jobcatID = $_GET['pid'];
// run the class to return the content
$jobcontent->getJobList();
// display the formatted results returned from the class on the page
getJobList();
?>
</body>