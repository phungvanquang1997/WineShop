<?php
require_once "./lib/db.php";

if (isset($_GET["btnDatMua"])) {
	header("Location: Search.php");
}
require_once './vendor/autoload.php';
use Gregwar\Captcha\CaptchaBuilder;

$show_alert = 0;
$show_alertUser = 0;
$show_alertPW = 0;
$show_alertEM = 0;
$show_alertDC = 0;
$show_alertPWRS = 0;
$show_alertPWRS2 = 0;
$show_alertSuccess = 0;
$show_alertName=0;
$Capcha=-1;
if (isset($_POST["btnRegister"]))
{
	$Name = $_POST["txtHoTen"];
	
	$Id = $_POST["txtTenDangNhap"];
	$sqlKTID="select * from users where f_Username= '".$Id."'";
	$rs = load($sqlKTID);
	if ($rs->num_rows > 0) 
	{
		$show_alert = 1;
		
	}
	if(strlen($Name)==0)
	{
		$show_alertName=1;
	}
	if(strlen($Id)==0 and $show_alert!=1)
	{
		$show_alertUser=1;
	}
	$Password = $_POST["txtPassword"];
	if(strlen($Password)==0)
	{
		$show_alertPW=1;
	}
	
	$PasswordRS = $_POST["txtPasswordreset"];
	if(strlen($PasswordRS)==0)
	{
		$show_alertPWRS=1;
	}
	if($PasswordRS!=$Password and $show_alertPWRS!=1)
	{
		$show_alertPWRS2=1;
	}


	$Email = $_POST["Email"];
	if(strlen($Email)==0)
	{
		$show_alertEM=1;
	}
	$DiaChi=$_POST["txtDiaChi"];
	if(strlen($DiaChi)==0)
	{
		$show_alertDC=1;
	}

	$enc_password = md5($Password);
	$input = $_POST["txtUserInput"];
	if ($input == $_SESSION["captcha"]) {
		$Capcha=1;
	}
	else
	{
		$Capcha=0;
	}
	date_default_timezone_set('Asia/Ho_Chi_Minh');
	$NgayDK=date('Y/m/d');
	$sql = "insert into users(f_Username,f_Password,f_Name,f_Email,f_NgayTaoTK,f_Permission,f_DiaChi,f_Admin) values ('$Id', '$enc_password', '$Name', '$Email', '$NgayDK', '0','$DiaChi','0')";

	if($show_alert!=1 and $show_alertDC!=1 and $show_alertEM!=1 and $show_alertPW!=1 and $show_alertPWRS!=1 and $show_alertUser!=1 and $Capcha==1 and $show_alertPWRS2!=1 and $show_alertName!=1)
	{
		write($sql);
		header("Location: index.php");
		ob_end_flush();
		
	}
	
}

if (isset($_POST["btnLogin"])) {
	header("Location: login.php");
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
?>


<form class="col-md-4">
	<!-- <img src="imgs/sp/1/main_thumbs.jpg"> -->
</form>

<form class="col-md-5 col" method="post" >
	<!-- <h1 style="text-align: center;"> </h1> -->
	<div class="form-group">
		<label for="txtHoTen">Họ tên</label>
		<input type="text" class="form-control" id="txtHoTen" name="txtHoTen">

	</div>
	<?php if ($show_alertName == 1) : ?>
		<div class="alert alert-danger" role="alert">
			<strong>Họ tên không được để trống!</strong>
		</div>
	<?php endif; ?>

	<div class="form-group">
		<label for="exampleInputPassword1">Tên đăng nhập</label>
		<input type="text" class="form-control" id="txtTenDangNhap" name="txtTenDangNhap" placeholder="PhungVanQuang">
	</div>
	<?php if ($show_alertUser == 1) : ?>
		<div class="alert alert-danger" role="alert">
			<strong>Tên đăng nhập không được để trống!</strong>
		</div>
	<?php endif; ?>

	<?php if ($show_alert == 1) : ?>
		<div class="alert alert-danger" role="alert">
			<strong>Tài Khoản đã tồn tại vui lòng nhập tài khoản khác!</strong>
		</div>
	<?php endif; ?>

	<div class="form-group">
		<label for="txtPassword">Password</label>
		<input type="password" class="form-control" id="txtPassword" name="txtPassword" placeholder="******">
	</div>
	<?php if ($show_alertPW == 1) : ?>
		<div class="alert alert-danger" role="alert">
			<strong>Password không được để trống!</strong>
		</div>
	<?php endif; ?>

	<div class="form-group">
		<label for="txtPassword">Nhập lại Password</label>
		<input type="password" class="form-control" id="txtPasswordreset" name="txtPasswordreset" placeholder="******">
	</div>

	<?php if ($show_alertPWRS == 1) : ?>
		<div class="alert alert-danger" role="alert">
			<strong>Không được để trống phần Nhập lại Password!</strong>
		</div>
	<?php endif; ?>

	<?php if ($show_alertPWRS2 == 1) : ?>
		<div class="alert alert-danger" role="alert">
			<strong>Nhập lại Password không chính xác!</strong>
		</div>
	<?php endif; ?>


	<div class="form-group">
		<label for="exampleInputPassword1">Địa chỉ</label>
		<input type="text" class="form-control" id="txtDiaChi" name="txtDiaChi" placeholder="Nguyễn Văn Cừ">
	</div>
	<?php if ($show_alertDC == 1) : ?>
		<div class="alert alert-danger" role="alert">
			<strong>Địa chỉ không được để trống!</strong>
		</div>
	<?php endif; ?>

	<div class="form-group">
		<label for="exampleInputEmail1">Email address</label>
		<input type="email" class="form-control" id="txtEmail" aria-describedby="emailHelp" name="Email" placeholder="Enter email">						    
	</div>
	<?php if ($show_alertEM == 1) : ?>
		<div class="alert alert-danger" role="alert">
			<strong>Không được để email trống!</strong>
		</div>
	<?php endif; ?>	





	<div class="form-group">
		<?php
		$builder = new CaptchaBuilder;
		$builder->build();
		$_SESSION["captcha"] = $builder->getPhrase();
		?>
		<img src="<?= $builder->inline() ?>" alt="captcha" />
	</div>
	<div class="form-group">
		<label for="txtUserInput">Captcha</label>
		<input type="text" class="form-control" id="txtUserInput" name="txtUserInput">
	</div>





	<?php if ($show_alertSuccess == 1) : ?>
		<div class="alert alert-success" role="alert">
			<strong>Đăng kí thành công</strong>
		</div>
	<?php endif; ?>
	<?php if ($Capcha == 0) : ?>
		<div class="alert alert-danger" role="alert">
			<strong>Mã xác thực không đúng!</strong>
		</div>
	<?php endif; ?>	




	<br>


		<button type="submit" class="btn btn-success btn-block" name="btnRegister">
			<span class="glyphicon glyphicon-user"></span>
			Đăng kí
		</button>	

</form>
