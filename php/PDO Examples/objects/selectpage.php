<?php
$database = new PDOdatabase();
$db = $database->getConnection();
$pagecontent = new pagecontent($db);

class pagecontent{
    // database connection and table name
    private $conn;
    private $table_name = "pagecontent";
 
    // object properties
    public $recid;
	public $pagetext;
	public $pagetitle;
 
    public function __construct($db){
        $this->conn = $db;
    }
    
	public function readOne(){
    $query = "SELECT
                *
            FROM
                " . $this->table_name . "
            WHERE
                recid = ?
            LIMIT
                0,1";
    $stmt = $this->conn->prepare( $query );
    $stmt->bindParam(1, $this->recid);
    $stmt->execute();
 
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
 
    $this->recid = $row['recid'];
    $this->pagetext = stripslashes($row['pagecontent']);
    $this->pagetitle = stripslashes($row['pagetitle']);
	}
	public function __destruct(){
		// destroy object
	}
}
?>