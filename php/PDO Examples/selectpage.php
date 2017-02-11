<?php
include("config/pdodb.php");
include_once("objects/selectpage.php");
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
// set recid to ID of page to be returned
$pagecontent->recid = 1;
// run the class to return the content
$pagecontent->readOne();
// display content on the page
echo "<h3>". $pagecontent->pagetitle ."</h3>";
echo $pagecontent->pagetext;
?>
</body>