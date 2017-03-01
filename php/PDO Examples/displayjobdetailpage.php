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
$jobid=$_GET['jobid'];
// set job to be returned then call the class to return the job content
$jobcontent->readOneJob($jobid);
?>
<!DOCTYPE html>
<html lang="en">
<head>
<title>Job detail display page</title>
</head>
<body>
<?php
// Display the job information on the page use getter methods rather than accessing object properties directly.
				  echo "<h2 class='cyanh2'>Job Information</h2>";
				  echo "<p><b>Employer :</b> ".$jobcontent->get_jobemployertext()."</p>";
				  echo "<p><b>Job Title :</b> ".$jobcontent->get_jobtitle()."</p>";
				  echo "<p><b>Reference number :</b> ".$jobcontent->get_jobref()."</p>";
				  echo "<p><b>Service :</b> ".$jobcontent->get_service()."</p>";
				  echo "<p><b>Location :</b> ".$jobcontent->get_joblocationtext()."</p>";
				  echo "<p><b>Salary :</b> ".$jobcontent->get_salary()."</p>";
				  echo "<p><b>Hours :</b> ".$jobcontent->get_hours()."</p>";
				  echo "<p><b>Closing date :</b> ".$jobcontent->get_closedate()."</p>";
				  echo "<p><b>Brief summary of job</b></p>";
				  echo "<p>".$jobcontent->get_jobdesc()."</p>";
				  echo "<p><b>Contact information</b></p>";
				  echo "<p>".$jobcontent->get_jobcontact()."</p>";
				  echo "<p><b>Interview information</b></p>";
                  echo "<p>".$jobcontent->get_jobinterview()."</p>";
				  echo "<p><b>How to apply</b></p>";
				  echo "<p>We allow the following methods for applications:<p>";
				  echo "<a href='applynew.php?jobid=$jobid' class='btn btn-info'>Click here to apply now online</a>";// jobid variable value is set in get variable
				  echo "<p><a href='EmploymentApplicationForm2015.pdf'>Download our application form</a> - Please enter ".$jobcontent->get_jobref()." for Post applied for and post your completed Application Form to : ".$jobcontent->get_jobaddresstext()."<p>";
  				  echo "<p>Downloadable application forms require adobe reader which can be obtained from the <a href='http://get.adobe.com/reader/' target='_blank'>Adobe website</a><p>";
				  echo "<p><b>Below is a list of job related documents. Click on a document to view it</b></p>";
				  if ($jobcontent->get_jobdescfile()<>""){
  				  echo "<p><a href='hrarch/".$jobcontent->get_jobdescfile()."'>Job description and person specification</a></p>";
				  }
				  if ($jobcontent->get_personfile()<>""){
				  echo "<p><a href='hrarch/".$jobcontent->get_personfile()."'>Person specification</a></p>";
				  }
				  echo "<p>&nbsp;</p>";
				?>
                <p><a href="javascript:history.go(-1)">Return to job list</a></p>
</body>