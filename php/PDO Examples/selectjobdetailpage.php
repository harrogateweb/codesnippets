<?php
session_start();
include("config/pdodb.php");
include_once("objects/selectjobdetail.php");
// set job to be returned
$jobcontent->jobID = $_GET['jobID'];
// run the class to return the job content
$jobcontent->readOneJob();
$closedate = date("l dS F Y", strtotime($jobcontent->closedate) );
?>
<!DOCTYPE html>
<html lang="en">
<head>
<title>Job detail display page</title>
</head>
<body>
<?php
// Display the job information on the page
				  echo "<h2 class='cyanh2'>Job Information</h2>";
				  echo "<p><b>Employer :</b> ".$jobcontent->jobemployertext."</p>";
				  echo "<p><b>Job Title :</b> ".$jobcontent->jobtitle."</p>";
				  echo "<p><b>Reference number :</b> ".$jobcontent->jobref."</p>";
				  echo "<p><b>Service :</b> ".$jobcontent->service."</p>";
				  echo "<p><b>Location :</b> ".$jobcontent->joblocationtext."</p>";
				  echo "<p><b>Salary :</b> ".$jobcontent->salary."</p>";
				  echo "<p><b>Hours :</b> ".$jobcontent->hours."</p>";
				  echo "<p><b>Closing date :</b> ".$closedate."</p>";
				  echo "<p><b>Brief summary of job</b></p>";
				  echo "<p>".$jobcontent->jobdesc."</p>";
				  echo "<p><b>Contact information</b></p>";
				  echo "<p>".$jobcontent->jobcontact."</p>";
				  echo "<p><b>Interview information</b></p>";
                  echo "<p>".$jobcontent->jobinterview."</p>";
				  echo "<p><b>How to apply</b></p>";
				  echo "<p>We allow the following methods for applications:<p>";
				  echo "<a href='applynew.php?jobid=$jobcontent->jobid' class='btn btn-info'>Click here to apply now online</a>";
				  echo "<p><a href='EmploymentApplicationForm2015.pdf'>Download our application form</a> - Please enter ".$jobcontent->jobref." for Post applied for and post your completed Application Form to : ".$jobcontent->jobaddresstext."<p>";
  				  echo "<p>Downloadable application forms require adobe reader which can be obtained from the <a href='http://get.adobe.com/reader/' target='_blank'>Adobe website</a><p>";
				  echo "<p><b>Below is a list of job related documents. Click on a document to view it</b></p>";
				  if ($jobcontent->jobdescfile<>""){
  				  echo "<p><a href='hrarch/".$jobcontent->jobdescfile."'>Job description and person specification</a></p>";
				  }
				  if ($jobcontent->personfile<>""){
				  echo "<p><a href='hrarch/".$jobcontent->personfile."'>Person specification</a></p>";
				  }
				  echo "<p>&nbsp;</p>";
				?>
                <p><a href="javascript:history.go(-1)">Return to job list</a></p>
</body>