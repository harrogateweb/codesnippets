<?php
$database = new PDOdatabase();
$db = $database->getConnection();
$jobcontent = new jobcontent($db);

class jobcontent{
    // database connection
    private $conn;
	
	public	$nowtime,
			$newjobclosedate,
			$jobdatevalid,
			$openjob,
			$todaysdate;
 
    public function __construct($db){
        $this->conn = $db;
    }
    
	public function readOneJob(){
	//this function runs a join query on 4 tables and returns detailed information from all of them for one job only
    $query = "SELECT
                jobs.*, jobemployers.jobEmployer AS jobEmployer, joblocations.jobLocation AS jobLocation, jobaddress.jobaddress AS jobAddress
            FROM
                jobs, jobemployers, joblocations, jobaddress
            WHERE
                jobID = ? AND jobs.empID=jobemployers.employerID AND jobs.jobLocationID=joblocations.joblocID AND jobs.jobaddID=jobaddress.jobaddID
            LIMIT
                0,1";
    $stmt = $this->conn->prepare( $query );
    $stmt->bindParam(1, $this->jobID);
    $stmt->execute();
 
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
 	// put all the data into variables so we can use them on the page
    $this->jobid = $row['jobID'];
    $this->jobLocationID = $row['jobLocationID'];
	$this->jobref = $row['jobRef'];
	$this->jobtitle = $row['jobTitle'];
	$this->service = $row['Service'];
	$this->salary = $row['Salary'];
	$this->hours = $row['Hours'];
	$this->closedate = $row['CloseDate'];
	$this->jobdesc = $row['jobDesc'];
	$this->jobcontact= $row['jobContact'];
	$this->jobinterview= $row['jobInterview'];
	$this->jobdescfile= $row['jobdescDoc'];
	$this->personfile= $row['applicantDoc'];
    $this->jobemployertext = stripslashes($row['jobEmployer']);
    $this->joblocationtext = stripslashes($row['jobLocation']);
	$this->jobaddresstext = stripslashes($row['jobAddress']);
	}
	
	public function readOneJobExpiry(){
	//This function is passed one job by jobID then it checks the closing date against todays date to check if job is still open and returns true or false (the other variable openjob is used as a manual override which prevents job from ever expiring)
    $query = "SELECT
                *
            FROM
                jobs
            WHERE
                jobID = ? 
            LIMIT
                0,1";
    
	$stmt = $this->conn->prepare( $query );
    $stmt->bindParam(1, $this->jobID);
    $stmt->execute();
 
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
	
	$nowtime=time();
	$newjobclosedate=strtotime(stripslashes($row['CloseDate']));
	$openjob=$row['openjob'];
	
		if (($nowtime<=$newjobclosedate)||($openjob==1)){
		return true;
		}
		else{
		return false;
		}
	}
	
	
	
	public function getJobList(){
	// This function again uses a 4 table join but return multiple rows as a result with each row outputted as a formatted block of html
	$todaysdate = time() - (1 * 24 * 60 * 60);
    $query = "SELECT
                jobs.*, jobemployers.jobEmployer AS jobEmployer, joblocations.jobLocation AS jobLocation, jobaddress.jobaddress AS jobAddress
            FROM
                jobs, jobemployers, joblocations, jobaddress
            WHERE
                 (UNIX_TIMESTAMP(CloseDate)>=$todaysdate OR openjob=1) AND jobcatID = ? AND jobhidden=0 AND jobs.empID=jobemployers.employerID AND jobs.jobLocationID=joblocations.joblocID AND jobs.jobaddID=jobaddress.jobaddID
            ORDER BY
				jobs.dateadded DESC";
    $stmt = $this->conn->prepare( $query );
    $stmt->bindParam(1, $this->jobcatID);
    $stmt->execute();
 
    if($stmt->rowCount()>0)
         {
			 	while($row = $stmt->fetch(PDO::FETCH_ASSOC))
 		 		{
                   
                  echo "<h2 class='cyanh2'>Job Title :</b> ".$row['jobTitle']."</h2>";
				  echo "<p><b>Organisation :</b> ".$row['jobEmployer']."</p>";
				  echo "<p><b>Location :</b> ".$row['jobLocation']."</p>";
				  echo "<p><b>Reference :</b> ".$row['jobRef']."</p>";
				  echo "<p><b>Salary :</b> ".$row['Salary']."</p>";
				  echo "<p><b>Hours :</b> ".$row['Hours']."</p>";
				  echo "<p><b>Closing date :</b> ".$closedate."</p>";
				  echo "<p class='jobinfolink'><a href='jobdetail.php?jobID=".$row['jobID']."&filtered=$this->jobcatID' class='btn btn-info'>View Full Info</a></p>";
				  echo "<hr>";
                }
         }
         else
         {
				  echo "<p>Sorry there are no job vacancies of this type at the moment.</p>";
         }
	}
	
	public function __destruct(){
		// destroy object
	}
}
?>