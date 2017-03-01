<?php
class jobcontent{
    // database connection
    private $conn;
	
	private	$jobid,
			$jobcatID,
			$nowtime,
			$newjobclosedate,
			$jobdatevalid,
			$openjob,
			$todaysdate,
			$jobemployertext,
			$jobref,
			$jobtitle,
			$service,
			$salary,
			$hours,
			$closedate,
			$jobdesc,
			$jobcontact,
			$jobinterview,
			$jobdescfile,
			$personfile,			
			$joblocationtext,
			$jobaddresstext;
 
    public function __construct($db){
        $this->conn = $db;
    }
	//getter and setter methods
	public function set_jobref($jobref){
		$this->jobref = $jobref;
	}
	public function get_jobref(){
		return $this->jobref;
	}
	public function set_jobtitle($jobtitle){
		$this->jobtitle = $jobtitle;
	}
	public function get_jobtitle(){
		return $this->jobtitle;
	}
	public function set_service($service){
		$this->service = $service;
	}
	public function get_service(){
		return $this->service;
	}
	public function set_salary($salary){
		$this->salary = $salary;
	}
	public function get_salary(){
		return $this->salary;
	}
	public function set_hours($hours){
		$this->hours = $hours;
	}
	public function get_hours(){
		return $this->hours;
	}
	// setter method for closing date also formats the data
	public function set_closedate($closedate){
		$this->closedate = date("l dS F Y", strtotime($closedate));
	}
	public function get_closedate(){
		return $this->closedate;
	}
	public function set_jobdesc($jobdesc){
		$this->jobdesc = $jobdesc;
	}
	public function get_jobdesc(){
		return $this->jobdesc;
	}
	public function set_jobcontact($jobcontact){
		$this->jobcontact = $jobcontact;
	}
	public function get_jobcontact(){
		return $this->jobcontact;
	}
	public function set_jobinterview($jobinterview){
		$this->jobinterview = $jobinterview;
	}
	public function get_jobinterview(){
		return $this->jobinterview;
	}
	public function set_jobdescfile($jobdescfile){
		$this->jobdescfile = $jobdescfile;
	}
	public function get_jobdescfile(){
		return $this->jobdescfile;
	}
	public function set_personfile($personfile){
		$this->personfile = $personfile;
	}
	public function get_personfile(){
		return $this->personfile;
	}
	public function set_jobemployertext($jobemployertext){
		$this->jobemployertext = $jobemployertext;
	}
	public function get_jobemployertext(){
		return $this->jobemployertext;
	}
	public function set_joblocationtext($joblocationtext){
		$this->joblocationtext = $joblocationtext;
	}
	public function get_joblocationtext(){
		return $this->joblocationtext;
	}
	public function set_jobaddresstext($jobaddresstext){
		$this->jobaddresstext = $jobaddresstext;
	}
	public function get_jobaddresstext(){
		return $this->jobaddresstext;
	}

	
    
	public function readOneJob($jobid){
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
    $stmt->bindParam(1, $jobid);
    $stmt->execute();
 
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
 	// put all the data into variables so we can use them on the page
	$this->set_jobref(stripslashes($row['jobRef']));
	$this->set_jobtitle(stripslashes($row['jobTitle']));
	$this->set_service(stripslashes($row['Service']));
	$this->set_salary(stripslashes($row['Salary']));
	$this->set_hours(stripslashes($row['Hours']));
	$this->set_closedate($row['CloseDate']);
	$this->set_jobdesc(stripslashes($row['jobDesc']));
	$this->set_jobcontact(stripslashes($row['jobContact']));
	$this->set_jobinterview(stripslashes($row['jobInterview']));
	$this->set_jobdescfile(stripslashes($row['jobdescDoc']));
	$this->set_personfile(stripslashes($row['applicantDoc']));
    $this->set_jobemployertext(stripslashes($row['jobEmployer']));
    $this->set_joblocationtext(stripslashes($row['jobLocation']));
	$this->set_jobaddresstext(stripslashes($row['jobAddress']));
	}
	
	public function readOneJobExpiry($jobid){
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
    $stmt->bindParam(1, $jobid);
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
	
	
	
	public function getJobList($jobcatID){
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
    $stmt->bindParam(1, $jobcatID);
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
				  echo "<p><b>Closing date :</b> ".$row['CloseDate']."</p>";
				  echo "<p class='jobinfolink'><a href='displayjobdetailpage.php?jobID=".$row['jobID']."&filtered=$jobcatID' class='btn btn-info'>View Full Info</a></p>";
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