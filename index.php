<?php
/*
ნიკა დუმბაძე | 2021

გვერდი შექმნილია მონაცემთა ბაზაზე დაყრდნობით, რომელიც თანდართულია მოცემულ ფაილებთან ერთად.

ფასები შერჩეულია random მეთოდით, ამიტომ შეიძლება აღინიშნებოდეს გარკვეული უზუსტობები.

მოცემული გვერდის შემთხვევაში ბაზის სახელია: nd_apartments

*/


	// მონაცემთა ბაზასთან კავშირის დამყარება.
	include "dbconfig.php";
	$db = new connectToDataBase("localhost", "root", "", "nd_apartments");

	include "commission.php"; // ბონუსების გაცემის ფუნქციები თანამშრომლებისთვის.
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>My Apartment</title>
</head>
<body>
	<h3>ფილტრი</h3>
	<form name="filterForm" action="index.php" method="post">
		<label for="contractID"> კონტრაქტის ნომერი: </label>
    	<input type="text" id="contractID" name="contractID">
		<label for="sales_manager"> გაყიდვების მენეჯერი: </label>
		<select id="sales_manager" name="sales_manager">
			<option></option>
		<?php
			$sm = $db->getSalesManagers();
			$uniquesm = array_unique($sm, SORT_REGULAR);
			foreach($uniquesm as $value){	
		?>
		  <option value="<?php echo $value["SALES_MANAGER"];?>"><?php echo $value["SALES_MANAGER"];?></option>
		<?php
			}
		?>
		</select>
		<label for="purchase_type"> გაყიდვის ტიპი: </label>
    	<select id="purchase_type" name="purchase_type">
			<option></option>
      		<option value="ერთიანი გადახდა">ერთიანი გადახდა</option>
      		<option value="განვადება">განვადება</option>
    	</select><br><br>
		<label for="from_date"> დაწყების თარიღი: </label>
		<input type="date" id="from_date" name="from_date">
		<label for="to_date"> დასრულების თარიღი: </label>
		<input type="date" id="to_date" name="to_date"><br><br>
		<input type="submit" name="submit" value="ძებნა">
	</form>
	<a href="?unset($_POST["submit"])">გასუფთავება</a>
	<hr>
	<table border=1 style="width: 100%;">
		<tr>
			<th> თარიღი </th>
			<th> კონტრაქტის ნომერი </th> 
			<th> ხელშეკრულების ტიპი </th>
			<th> გაყიდვების მენეჯერი </th>
			<th> გადახდილი თანხა </th> 
			<th> გაყიდვის ტიპი </th>
			<th> გადახდის ტიპი </th>
			<th> მაკლერი </th> 
			<th> საკომისიო პოლიტიკა </th>
			<th> გაყიდვების მენეჯერის ბონუსი </th> 
			<th> მაკლერის ბონუსი </th>	
		</tr>
		<?php
		if(isset($_POST["submit"])){
			$contractID = $_POST["contractID"]; 
			$sales_manager = $_POST["sales_manager"]; 
			$purchase_type = $_POST["purchase_type"]; 
			
			$fdate = $_POST["from_date"];
			$from_date = strtotime($fdate);
			$from_date = date("Y/m/d", $from_date);
			
			$todate = $_POST["to_date"];
			$to_date = strtotime($todate);
			$to_date = date("Y/m/d", $to_date);
			
			$arr = $db->getfilter("sales", $contractID, $sales_manager, $purchase_type, $from_date, $to_date);
			foreach($arr as $value){
		?>
		<tr>
			<td><?php echo $value["START_DATE"];?></td>
			<td><?php echo $value["CONTRACT_NUMBER"];?></td>
			<td><?php echo $value["CONTRACT_TYPE"];?></td>
			<td><?php echo $value["SALES_MANAGER"];?></td>
			<td><?php echo $value["PAID"];?></td>
			<td><?php echo $value["SALE_TYPE"];?></td>
			<td><?php echo $value["PURCHASE_TYPE"];?></td>
			<td><?php echo $value["INTERMEDIARY"];?></td>
			<td><?php echo $value["COMMISSION_TYPE"];?></td>
			<td><?php echo sales_manager_commission($value["PAID"], $value["SALE_TYPE"], $value["START_DATE"]);?></td>
			<td><?php echo intermediary_commission($value["PAID"], $value["COMMISSION_TYPE"]);?></td>	
		</tr>
		<?php
			}
		}
		else{
			$arr = $db->getContent(); // sales ცხრილებიდან ყველა ინფორმაციის წამოღება.
			foreach($arr as $value){
		?>
		<tr>
			<td><?php echo $value["START_DATE"];?></td>
			<td><?php echo $value["CONTRACT_NUMBER"];?></td>
			<td><?php echo $value["CONTRACT_TYPE"];?></td>
			<td><?php echo $value["SALES_MANAGER"];?></td>
			<td><?php echo $value["PAID"];?></td>
			<td><?php echo $value["SALE_TYPE"];?></td>
			<td><?php echo $value["PURCHASE_TYPE"];?></td>
			<td><?php echo $value["INTERMEDIARY"];?></td>
			<td><?php echo $value["COMMISSION_TYPE"];?></td>
			<td><?php echo sales_manager_commission($value["PAID"], $value["SALE_TYPE"], $value["START_DATE"]);?></td>
			<td><?php echo intermediary_commission($value["PAID"], $value["COMMISSION_TYPE"]);?></td>	
		</tr>
		<?php		
			}
		}	
		?>
	</table>
	
</body>
</html>