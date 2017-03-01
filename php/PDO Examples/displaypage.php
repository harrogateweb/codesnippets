<?php
//session would be here on live site
// session_start();
// get database connection
include("config/pdodb.php");
$database = new PDOdatabase();
$db = $database->getConnection();
//Instantiate page class
include_once("classes/selectpage.php");
$pagecontent = new pagecontent($db);
?>
<!DOCTYPE html>
<html lang="en">
<head>
<title>PDO get and display data from MySQL database</title>
</head>
<body>
<h2>PDO Example MySQL select</h2>
<hr>
<?php
// set recid to ID of page to be returned and call the class to return the content
$pagecontent->readOne(1);
// display content on the page using getter methods
echo "<h3>". $pagecontent->get_pagetitle()."</h3>";
echo $pagecontent->get_pagetext();
?>
</body>