<?php

// მოცემული ფუნქცია დათვლის გაყიდვების მენეჯერის გამომუშავებულ ბონუსს გადახდილი თანხის მიხედვით.
function sales_manager_commission($price, $sale_type, $start_date){
	if($start_date >= "2017-05-11" && $start_date < "2018-07-11"){
		if($sale_type == "შიდა"){
			return ($price * 0.6) / 100;
		}
		elseif($sale_type == "მაკლერი"){
			return ($price * 0.2) / 100;
		}
		elseif($sale_type == "ინსაიდერი"){
			return 0;
		}	
	}
	elseif($start_date >= "2018-07-11" && $start_date < "2020-12-11"){
		if($sale_type == "შიდა"){
			return ($price * 1.5) / 100;
		}
		elseif($sale_type == "მაკლერი"){
			return ($price * 0.50) / 100;
		}
		elseif($sale_type == "ინსაიდერი"){
			return ($price * 0.50) / 100;
		}	
	}
	elseif($start_date >= "2020-12-11" && $start_date < "2021-07-17"){
		if($sale_type == "შიდა"){
			return ($price * 3) / 100;
		}
		elseif($sale_type == "მაკლერი"){
			return ($price * 1) / 100;
		}
		elseif($sale_type == "ინსაიდერი"){
			return ($price * 1) / 100;
		}	
	}
}


// მოცემული ფუნქცია დათვლის მაკლერის მიერ გამომუშავებულ ბონუსს გადახდილი თანხის მიხედვით.
function intermediary_commission($price, $comission_type){
	switch($comission_type){
		case "წესი #1":
			return ($price * 8) / 100;
			break;
		case "წესი #2":
			return ($price * 5) / 100;
			break;
		case "წესი #3":
			return ($price * 12) / 100;
			break;
		case "წესი #4":
			return ($price * 10) / 100;
			break;
		case "წესი #5":
			return ($price * 5) / 100;
			break;
		case "წესი #6":
			return ($price * 10) / 100;
			break;
		case "წესი #7":
			return ($price * 5) / 100;
			break;
		default:
			return "";
	}
}

?>