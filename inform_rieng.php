<?php

require_once "./lib/db.php";
if ($_SESSION["dang_nhap_chua"] == 0)
{
	header("Location: index.php");
}	
if (isset($_POST["btnBack"])) 
{
	header("Location: index.php");
	//var_dump(header("Location: index.php"));
	ob_end_flush();
	//echo "string";
	//header("Location: index.php");
	exit;
}	
$TenTK= $_SESSION["current_user"]->f_Username ;

$sql="select f_Email from users where f_Username= '".$TenTK."'";

$Email=$_SESSION["current_user"]->f_Email;
$DiaCHi=$_SESSION["current_user"]->f_DiaChi;


if (isset($_POST["btnEdit"])) 
{
	$Email=$_POST["txtEmail"];
	$sqlEmail="update users set f_Email='" .$Email."' where f_Username='".$TenTK."'";
	write($sqlEmail);
	$DiaCHi=$_POST["txtDiaChi"];

	$sqlDiaChi="update users set f_DiaChi='" .$DiaCHi."' where f_Username='".$TenTK."'";
	write($sqlDiaChi);
	$_SESSION["current_user"]->f_Email = $Email;
	$_SESSION["current_user"]->f_DiaChi = $DiaCHi;


}



$Viewid = 0;
if(isset($_GET["Viewid"]))
{
	$Viewid = $_GET["Viewid"];
}
$stringSearch = "";
if(isset($_POST["btnSearch"]))
{
	$stringSearch = $_POST["txtSearch"];
	$_SESSION["Search"] = $_POST["txtSearch"];
	header("Location: search.php");
}

if(isset($_POST["btnSearch"]))
{
	$stringSearch = $_POST["txtSearch"];
	$_SESSION["Search"] = $_POST["txtSearch"];
	header("Location: search.php");
}

?>



<div class="col-md-6 col-md-offset-3">
	<form method="post" action="">
		<div class="form-group">
			<label for="txtUserName">Tên đăng nhập</label>
			<input type="text" class="form-control" id="txtUserName" name="txtUserName" readonly value="<?= $TenTK ?>">		
		</div>
		<div class="form-group">
			<label for="txtPassword">Email</label>
			<input type="text" class="form-control" id="txtEmail" name="txtEmail" value="<?= $Email?>">

		</div>
		<div class="form-group">
			<label for="txtPassword">Địa chỉ</label>
			<input type="text" class="form-control" id="txtDiaChi" name="txtDiaChi" value="<?= $DiaCHi?>">

		</div>

		<button type="submit" class="col-md-4 col-md-offset-1 btn btn-primary" name="btnBack">
			<span class="glyphicon glyphicon-home"></span>
			Quay về
		</button>	

		<button type="submit" class="col-md-4 col-md-offset-1 btn btn-danger " name="btnEdit">
			<span class="glyphicon glyphicon-edit" ></span>
			Chỉnh sửa
		</button>
	</form>
</div>


