<?php
	require_once "./lib/db.php";
	session_start();
	$_SESSION["DaThanhToan"] = 0;


	if(isset($_SESSION["SaveProducts"]))
	{
		if(count($_SESSION["SaveProducts"])==0)
		{
			$_SESSION["DaThanhToan"] = 0;
		}


		else
		{
			$UserID = $_SESSION["IDUSER"];
			$sql2 = "insert into orders(OrderDate,UserID,Status) VALUES(CURDATE(),$UserID,0)";

			write($sql2);
			$get_MaxOrderID = "select Max(OrderID) as Max from orders";
			$rs = load($get_MaxOrderID);
			$t = $rs->fetch_assoc();
			$max = $t["Max"];


			for($i = 0 ; $i < count($_SESSION["SaveProducts"]) ; $i = $i+4)
			{
				$ProID = $_SESSION["SaveProducts"][$i];
				$Price = $_SESSION["SaveProducts"][$i+2];
				$Quantity = $_SESSION["SaveProducts"][$i+3];		
				
				$sql = "update products set Quantity = Quantity - $Quantity where ProID = $ProID";
				$sql1 = "update products set SoLuongBan = SoLuongBan + $Quantity where ProID = $ProID";
			

				$sql3 = "insert into orderdetails values('$max','$ProID','$Quantity','$Price',$Quantity*$Price,CURDATE())";
		
				write($sql1);		
				write($sql);
				write($sql3);

			}
			//var_dump($sql1);var_dump($sql);var_dump($sql3);var_dump($sql2);

			

			$_SESSION["DaThanhToan"] = 1;
		}

		header('Location: GioHang.php');
	}
	
?>