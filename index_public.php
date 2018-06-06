<?php
require_once "./lib/db.php";

if(!isset($_SESSION["dang_nhap_chua"]))
{
	$_SESSION["dang_nhap_chua"] = 0;
}
if ($_SESSION["dang_nhap_chua"] == 0) {
	if(isset($_COOKIE["auth_user_id"])) {
			// tái tạo session
		//var_dump($_COOKIE["auth_user_id"]);
		$user_id = $_COOKIE["auth_user_id"];
		$sql = "select * from users where f_Username = $user_id";
		$rs = load($sql);
		$_SESSION["current_user"] = $rs->fetch_object();
		$_SESSION["dang_nhap_chua"] = 1;
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

$timeslap = time();
$dated = $timeslap - 1522620000;
$d =  ceil($dated / (24*3600));
$k =  ($dated / (24*3600));
?>

<!DOCTYPE html>
<html>
<head>
	
	<title>Online Shop</title>
	<meta charset="utf-8">
	<link rel="stylesheet" type="text/css" href="assets/bootstrap-3.3.7-dist/css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="assets/style.css">
	<link rel="stylesheet" href="assets/bxslider-4-4.2.12/dist/jquery.bxslider.css">
	<!-- <link rel="stylesheet" type="text/javascript" href="assets/js.js"> -->
</head>
<body>
	<nav class="navbar navbar-default">
		<div class="container-fluid">
			<!-- Brand and toggle get grouped for better mobile display -->
			<div class="navbar-header">
				<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
					<span class="sr-only">Toggle navigation</span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
				</button>
				<a class="navbar-brand" href="index.php">
					<span class="glyphicon glyphicon-home"></span>
				</a>
			</div>
			<!-- Collect the nav links, forms, and other content for toggling -->
			<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
				<ul class="nav navbar-nav">			
				</ul>
				<form action="index.php" class="navbar-form navbar-left" method="POST">
					<div class="form-group">
						<input type="text" class="form-control" placeholder="Search" name = "txtSearch">
					</div>
					<button type="submit" class="btn btn-default" name = "btnSearch">Tìm kiếm</button>
				</form>
				<ul class="nav navbar-nav navbar-right">
					<?php 
					if ($_SESSION["dang_nhap_chua"]==1):


						?>	
						<li><a href="GioHang.php"><?= $k?>Giỏ hàng của bạn <?= $d ?></a></li>			
						<li class="dropdown">
							<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><b><?= $DangNhap ?></b> <span class="caret"></span></a>
							<ul class="dropdown-menu">	
								<li><a href="inform.php">Thông tin cá nhân</a></li>
								<li><a href="LichSuMuaHang.php">Lịch sử mua hàng</a></li>
								<li><a href="changepassword.php">Đổi mật khẩu</a></li>
								<?php 
									
									$Admin=$_SESSION["current_user"]->f_Permission;
									
									if($Admin==1)
									{
								 ?>
								 <li><a href="AdminLogin_DonHang.php">Admin</a></li>
								 <?php } ?>
								<li role="separator" class="divider"></li>
								<li><a href="logout.php">Thoát</a></li>
							</ul>
						</li>
						<?php 
					endif;
					
					?>
					<?php 
					if ($_SESSION["dang_nhap_chua"]==0):
						?>	
						<li><a href="register.php">Đăng kí</a></li>
						<li><a href="login.php">Đăng Nhập</a></li>
						<?php 
					endif;					
					?>
				</ul>
			</div>
		</div>
	</nav>
	<div class="container-fluid">
		<div class="row">
			<div class="col-xs-3 col-sm-3 col-md-3 col-lg-3">
				<div class="panel panel-default">
					<div class="panel-heading">
						<h3 class="panel-title">Nhà sản xuất</h3>
					</div>
					<div class="list-group">
						<?php
						$sql = "select * from NhaSanXuat";
						$rs = load($sql);
						while ($row = $rs->fetch_assoc()) :
							?>
							<a href="Origin.php?id=<?= $row["IDnsx"] ?>" class="list-group-item"><?= $row["TenNSX"] ?></a>
							<?php
						endwhile;
						?>
					</div>

					<div class="panel-heading">
						<h3 class="panel-title">Quốc gia</h3>
					</div>
					<div class="list-group">
						<?php
						$sql = "select * from origin";
						$rs = load($sql);
						while ($row = $rs->fetch_assoc()) :
							?>
							<a href="country.php?id_QG=<?= $row["OriginID"] ?>" class="list-group-item"><?= $row["OriginName"] ?></a>
							<?php
						endwhile;
						?>
					</div>

					<div class="panel-heading">
						<h3 class="panel-title">Hiển thị sản phẩm </h3>
					</div>
					<div class="list-group">
						<a href="index.php?Viewid=1" class="list-group-item"><?= $row["OriginName"] ?>Hiển thị 10 sản phẩm bán chạy nhất</a>		
						<a href="index.php?Viewid=2" class="list-group-item"><?= $row["OriginName"] ?>Hiển thị 10 sản phẩm mới nhất</a>	
						<a href="index.php?Viewid=3" class="list-group-item"><?= $row["OriginName"] ?>Hiển thị 10 sản phẩm được xem nhiều nhất</a>

					</div>
				</div>
			</div>
			<div class="col-xs-9 col-sm-9 col-md-9 col-lg-9">
				<div class="panel panel-default">
					<div class="panel-heading">
						<h3 class="panel-title"><?= $page_title ?></h3>
					</div>
					<div class="panel-body" style="padding: 0px">						
						<?php include_once $page_body_file; ?>
					</div>
				</div>
			</div>
		</div>
	</div>
	<script src="assets/js.js"></script>
	<script src="assets/jquery-3.1.1.min.js"></script>
	<script src="assets/bootstrap-3.3.7-dist/js/bootstrap.min.js"></script>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
	<script src="assets/bxslider-4-4.2.12/dist/jquery.bxslider.min.js"></script>
	<script type="text/javascript">
		$(function(){
			$('.bxslider').bxSlider({
				mode: 'fade',
				captions: true,
				slideWidth: 600
			});
		});



	</script>
</body>
</html>