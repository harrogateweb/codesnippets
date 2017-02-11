<?php
include("config/pdodb.php");
include_once("objects/selectjobdetail.php");
?>
<!DOCTYPE html>
<html lang="en">
<head>
<title>PDO Examples - returning jobs by type, featured job links with expiry date and manual override</title>
</head>
<body>
<h2 class="brightpurpleh2">Current job vacancies</h2>
<hr>

<div id="jobcatstrip16">
<ul>
<li id="catjoblink1"><a href="selectlistoffilteredjobs.php?pid=1">Vacancies Type 1</a></li>
<li id="catjoblink2"><a href="selectlistoffilteredjobs.php?pid=2">Vacancies Type 2</a></li>
<li id="catjoblink3"><a href="selectlistoffilteredjobs.php?pid=3">Vacancies Type 3</a></li>
<li id="catjoblink4"><a href="selectlistoffilteredjobs.php?pid=4">Vacancies Type 4</a></li>
</ul>
</div><!-- end #jobcatstrip16 div -->

<?php
$featjob1=1;
$featjob2=3;
$featjob3=5;
/* The next 3 variables give us the facility to manually turn any of the 3 featured jobs off by setting them to 1 */
$featjob1off=0;
$featjob2off=0;
$featjob3off=0;

// set job to be returned
$jobcontent->jobID = $featjob1;
// run the class to return if featured job valid or not
$featjob1valid = $jobcontent->readOneJobExpiry();

// set job to be returned
$jobcontent->jobID = $featjob2;
// run the class to return if featured job valid or not
$featjob2valid = $jobcontent->readOneJobExpiry();

// set job to be returned
$jobcontent->jobID = $featjob3;
// run the class to return if featured job valid or not
$featjob3valid = $jobcontent->readOneJobExpiry();
?>
<div id="featuredjobsstrip">
<?php
if (($featjob1valid)&&($featjob1off!=1)){
echo "<div id='featuredjob1'>
<a href='selectjobdetailpage.php?jobID=$featjob1&filtered=1'>click here to apply</a>
</div>";
}

if (($featjob2valid)&&($featjob2off!=1)){
echo "<div id='featuredjob2'>
<a href='selectjobdetailpage?jobID=$featjob2&filtered=1'>click here to apply</a>
</div>";
}

if (($featjob3valid)&&($featjob3off!=1)){
echo "<div id='featuredjob3'>
<a href='selectjobdetailpage?jobID=$featjob3&filtered=1'>click here to apply</a>
</div>";
}
?>
</div><!-- end #featuredjobstrip div -->

</body>