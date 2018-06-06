
<?php	
	require_once "./lib/db.php";
	session_start();

	if(isset($_GET["id"]))
	{
		$id = $_GET["id"];
		$sql = "select * from products where ProID = $id";
		$rs = load($sql);
		$row = $rs->fetch_assoc();
		$maSP = $row["ProID"];
		$tenSP = $row["ProName"];
		$index = 0;
		for($i = 0 ; $i < count($_SESSION["SaveProducts"]); $i=$i+4)
		{
			if($_SESSION["SaveProducts"][$i] == $maSP )
			{
				$index = $i + 3;
			}
		}


		unset($_SESSION["SaveProducts"][$index]);
		unset($_SESSION["SaveProducts"][$index-1]);
		unset($_SESSION["SaveProducts"][$index-2]);
		unset($_SESSION["SaveProducts"][$index-3]);
		//$_SESSION["SaveProducts"] trước đó là các chỉ mục random , không thể duyệt 0,1,2,3...,5,6,7,8,10,11,12,13,14...

		$_SESSION["SaveProducts"] = array_values($_SESSION["SaveProducts"]);//Chuyển sang dạng chỉ mục tuần tự 0,1,2,3..n
		// var_dump($_SESSION["SaveProducts"]);
		header('Location: GioHang.php');
	}
?>

