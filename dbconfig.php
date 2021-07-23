<?php
// მონაცემთა ბაზების კლასი.
class connectToDataBase{
	private $host = ""; // ჰოსტის მისამართი.
	private $user = ""; // მომხმარებელი.
	private $password = ""; // პაროლი.
	private $dbName = ""; // მონაცემთა ბაზა.
	private $db; // ცვლადი, რომელიც გამოიყენება მონაცემთა ბაზასთან დასაკავშირებლად.
	
	// კონსტრუქტორი.
	function __construct($host="localhost", $user="root", $password="", $dbName=""){
		$this->host = $host;
		$this->user = $user;
		$this->password = $password;
		$this->dbName= $dbName;
		$this->db = $this->dbConnect();
	}
	// ბაზასთან დაკავშირება.
	private function dbConnect(){
		$db = new mysqli($this->host, $this->user, $this->password, $this->dbName);
		if ($db->connect_error){
			trigger_error('Database connection failed:'.$db->connect_error, E_USER_ERROR);
		}
		return $db;
	}
		
	// ბაზიდან ყველა მონაცემების წამოღება მასივის სახით.
	function getContent($tblName="sales"){
		$db = $this->db;
		$arr = array();
		$query = "SELECT * FROM $tblName";
		$data = mysqli_query($db, $query) or die("error");
		if(mysqli_num_rows($data) > 0){
			while($row = mysqli_fetch_assoc($data)){
				$arr[] = $row;
			}
		}
		return $arr;	
	}
	
	// ბაზიდან გაყიდვების მენეჯერის სახელების წამოღება.
	function getSalesManagers($tblName="sales"){
		$db = $this->db;
		$arr = array();
		$query = "SELECT SALES_MANAGER FROM $tblName";
		$data = mysqli_query($db, $query) or die("error");
		if(mysqli_num_rows($data) > 0){
			while($row = mysqli_fetch_assoc($data)){
				$arr[] = $row;
			}
		}
		return $arr;	
	}
	
	// ბაზიდან გაფილტრული მონაცემების წამოღება.
	function getfilter($tblName="sales", $contractID="", $sales_manager="", $purchase_type="", $from_date="", $to_date=""){
		$db = $this->db;
		$arr = array();
		$query = "SELECT * FROM $tblName WHERE CONTRACT_NUMBER = '$contractID' OR SALES_MANAGER = '$sales_manager' OR
		PURCHASE_TYPE = '$purchase_type' OR START_DATE >= '$from_date' AND START_DATE <= '$to_date'";
		$data = mysqli_query($db, $query) or die("error");
		if(mysqli_num_rows($data) > 0){
			while($row = mysqli_fetch_assoc($data)){
				$arr[] = $row;
			}
		}
		return $arr;	
	}
}
?>