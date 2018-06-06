<?php 
require_once "./lib/db.php";

if (!isset($_SESSION["dang_nhap_chua"])) {
	$_SESSION["dang_nhap_chua"] = 0;
}
if ($_SESSION["dang_nhap_chua"] == 0) {
	if(isset($_COOKIE["auth_user_id"])) {
			// tái tạo session
		$user_id = $_COOKIE["auth_user_id"];
		$sql = "select * from users where f_Username = $user_id";
		$rs = load($sql);
		$_SESSION["current_user"] = $rs->fetch_object();
		$_SESSION["dang_nhap_chua"] = 1;
	} else {
		header("Location: login.php");
	}
}
$show_alert = 0;
$show_alertPWRS = 0;
$show_alertPWRS2 = 0;
$show_alertPW = 0;
$show_alertSuccess = 0;
$check=0;

$TenTK= $_SESSION["current_user"]->f_Username ;
if (isset($_POST["btnChangePassWord"])) 
{
	$Password = $_POST["txtPassword"];
	$enc_password = md5($Password);

	$sql="select * from users where f_Username= ".$TenTK. " and f_Password='".$enc_password."'";
	$rs = load($sql);
	$Passwordnew = $_POST["txtPasswordnew"];
	if ($rs->num_rows > 0) 
	{
		
		$check=1;
	} 
	else 
	{
		$show_alert=1;
	}

	if(strlen($Passwordnew)<5 and $show_alert!=1 and $show_alertSuccess!=1)
	{
		$show_alertPW=1;
	}
	if($show_alertPW!=1 and $show_alert!=1 and $show_alertSuccess!=1 )
	{
		$show_alertPWRS2=1;
	}
	if($check==1)
	{
		$Passwordretype = $_POST["txtretype"];
		if($Passwordnew!=$Passwordretype and $show_alertPW!=1)
		{
			$show_alertPWRS2=1;
		}
		if($Passwordnew==$Passwordretype and $show_alertPW!=1 )
		{
			$show_alertPWRS2=-1;

			$enc_passwordnew = md5($Passwordnew);
			$sql="update users set f_Password='".$enc_passwordnew.  "' where f_Username= '".$TenTK. "' and f_Password='".$enc_password."'";
			write($sql);
			//header("Location: logout.php");
			$show_alertSuccess=1;
			
		}
	}
}

if (isset($_GET["btnDatMua"])) {
	header("Location: Search.php");
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
if ($_SESSION["dang_nhap_chua"] == 1)
{
	$DangNhap= $_SESSION["current_user"]->f_Username;
}
else
{
	$DangNhap="Đăng Nhập";
}
?>


<div class="col-xs-5 col-sm-5 col-md-5 col-lg-5 col-md-offset-4">
	<form method="post" action="">
		<div class="form-group">
			<label for="txtUserName">Tên đăng nhập</label>
			<input type="text" class="form-control" id="txtUserName" name="txtUserName" readonly value="<?= $TenTK ?>">		
		</div>
		<div class="form-group">
			<label for="txtPassword">Mật khẩu cũ</label>
			<input type="password" class="form-control" id="txtPassword" name="txtPassword" placeholder="******">

		</div>
		<?php if ($show_alert == 1) : ?>
			<div class="alert alert-danger" role="alert">
				<strong>Mật khẩu không phù hợp!</strong>
			</div>
		<?php endif; ?>

		<div class="form-group">
			<label for="txtPassword">Mật khẩu mới</label>
			<input type="password" class="form-control" id="txtPasswordnew" name="txtPasswordnew" placeholder="******">
		</div>

		<?php if ($show_alertPW == 1) : ?>
			<div class="alert alert-danger" role="alert">
				<strong>Password phải hơn 5 kí tự!</strong>
			</div>
		<?php endif; ?>

		<div class="form-group">
			<label for="txtPassword">Nhập lại mật khẩu</label>
			<input type="password" class="form-control" id="txtretype" name="txtretype" placeholder="******">
		</div>

		<?php if ($show_alertPWRS2 == 1) : ?>
			<div class="alert alert-danger" role="alert">
				<strong>Nhập lại Password không chính xác!</strong>
			</div>
		<?php endif; ?>

		<?php if ($show_alertSuccess == 1) : ?>
			<div class="alert alert-success" role="alert">
				<strong>Đổi mật khẩu thành công</strong>
			</div>
		<?php endif; ?>



		<button type="submit" class="btn btn-success btn-block" name="btnChangePassWord">
			<span class="glyphicon glyphicon-user"></span>
			Xác nhận 
		</button>		
	</form>

</div>
