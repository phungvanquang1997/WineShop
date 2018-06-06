<?php
require_once "./lib/db.php";
$show_alert=0;


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

if (isset($_POST["btnLogin"])) 
{
	$username = $_POST["txtUserName"];
	$password = $_POST["txtPassword"];
	$enc_password = md5($password);
	$sql = "select * from users where f_Username = '$username' and f_Password = '$enc_password'";
	$rs = load($sql);
	if ($rs->num_rows > 0) {
		$_SESSION["current_user"] = $rs->fetch_object();
		$_SESSION["dang_nhap_chua"] = 1;
		$_SESSION["IDUSER"] = $_SESSION["current_user"]->f_Username;
		if(isset($_POST["cbRemember"])) {

			$user_id = $_SESSION["IDUSER"] = $_SESSION["current_user"]->f_Username;
			setcookie("auth_user_id", $user_id, time() + 86400);

		} 
		$_SESSION["SaveProducts"] = array();

		header("Location: index.php");
		ob_end_flush();
	} else {
		$show_alert = 1;
	}
}
?>
<div class="row">
<div class="col-md-4 col-md-offset-4">
<form method="post" action="">
<div class="form-group">
<label for="txtUserName">Tên đăng nhập</label>
<input type="text" class="form-control" id="txtUserName" name="txtUserName" placeholder="John">
</div>
<div class="form-group">
<label for="txtPassword">Mật khẩu</label>
<input type="password" class="form-control" id="txtPassword" name="txtPassword" placeholder="******">
</div>
<?php if ($show_alert == 1) : ?>
	<div class="alert alert-danger" role="alert">
		<strong>Tài khoản hoặc mật khẩu không tồn tại!</strong>
	</div>
<?php endif; ?>
<div class="checkbox">
	<label>
		<input name="cbRemember" type="checkbox"> Ghi nhớ
	</label>
</div>
<button type="submit" class="btn btn-success btn-block" name="btnLogin">
	<span class="glyphicon glyphicon-user"></span>
	Đăng nhập
</button>


</form>
</div>
</div>





