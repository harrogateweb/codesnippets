<?php
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
	
	// setters and getters
	public function set_pagetext($pagetext){
		$this->pagetext = $pagetext;
	}
	public function get_pagetext(){
		return $this->pagetext;
	}
	public function set_pagetitle($pagetitle){
		$this->pagetitle = $pagetitle;
	}
	public function get_pagetitle(){
		return $this->pagetitle;
	}
    
	public function readOne($recid){
    $query = "SELECT
                *
            FROM
                " . $this->table_name . "
            WHERE
                recid = ?
            LIMIT
                0,1";
    $stmt = $this->conn->prepare( $query );
    $stmt->bindParam(1, $recid);
    $stmt->execute();
 
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    $this->set_pagetext(stripslashes($row['pagecontent']));
    $this->set_pagetitle(stripslashes($row['pagetitle']));
	}
	public function __destruct(){
		// destroy object
	}
}
?>