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

if ($_SESSION["dang_nhap_chua"] == 1)
{
	$DangNhap= $_SESSION["current_user"]->f_Username;
}
else
{
	$DangNhap="Đăng Nhập";
}

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
				<a class="navbar-brand" href="AdminLogin_DonHang.php">
					<span class="glyphicon glyphicon-home text-danger"></span>
					<span class = "text-danger"> AdminDashBoard </span>
				</a>
			</div>
			<!-- Collect the nav links, forms, and other content for toggling -->
			<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
				<ul class="nav navbar-nav">			
				</ul>
				<form action="index.php" class="navbar-form navbar-left" method="POST">
					
					
				</form>
				<ul class="nav navbar-nav navbar-right">
					<?php 
					if ($_SESSION["dang_nhap_chua"]==1):


						?>	
						<li><a href="GioHang.php">Giỏ hàng của bạn</a></li>			
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
							<h3 class="panel-title">Quản lý chức năng</h3>
						</div>
						<div class="list-group">
							<a href="AdminLogin_NhaSanXuat.php" class="list-group-item list-group-item-success">Quản lý Nhà sản xuất</a>
							<a href="AdminLogin_SanPham.php" class="list-group-item list-group-item-info">Quản lý Sản phẩm</a>
							<a href="AdminLogin_DonHang.php" class="list-group-item list-group-item-warning">Quản lý đơn hàng</a>
							
						</div>	
					</div>
				</div>
				<div class="col-xs-9 col-sm-9 col-md-9 col-lg-9">
					<div class="panel panel-default">
						
						<?php 
						if($page_title=="Quản lý sản phẩm")
						{

							?>
							<div class="panel-heading col-xs-9 col-sm-9 col-md-9 col-lg-9" style="height: 55px">
								<?= $page_title ?>
							</div>
							<p class="panel-heading col-xs-3 col-sm-3 col-md-3 col-lg-3 text-right">
								<a href="AdminLogin_SanPham_Add.php" class="btn btn-success" role="button" name ="btnThem">
									<span class="glyphicon glyphicon-plus"></span>
									Thêm sản phẩm
								</a>
							</p>
							<?php 
						} 

						else if($page_title=="Quản lý nhà sản xuất")
						{

							?>
							<div class="panel-heading col-xs-9 col-sm-9 col-md-9 col-lg-9" style="height: 55px">
								<?= $page_title ?>
							</div>
							<p class="panel-heading col-xs-3 col-sm-3 col-md-3 col-lg-3 text-right">
								<a href="AdminLogin_NhaSanXuat_Add.php" class="btn btn-success" role="button" name ="btnThem">
									<span class="glyphicon glyphicon-plus"></span>
									Thêm nhà sản xuất
								</a>
							</p>
							<?php 
						} 
						else
						{
							?>
							<div class="panel-heading">
								<h3 class="panel-title"><?= $page_title ?></h3>
							</div>
							<?php 
						}
						?>

					<div class="panel-body">						
						<?php include_once $page_body_file; ?>
					</div>
				</div>
			</div>
		</div>
	</div>
	<script src="assets/js.js"></script>
	<script src="assets/jquery-3.1.1.min.js"></script>
	<script src="assets/bootstrap-3.3.7-dist/js/bootstrap.min.js"></script>
	<script src="assets/tinymce/tinymce.min.js"></script>
	<script type="text/javascript">
		tinymce.init({
			selector: '#txtFullDes',
			menubar: false,
			toolbar1: "styleselect | bold italic | link image | alignleft aligncenter alignright | bullist numlist | fontselect | fontsizeselect | forecolor backcolor",
		    // toolbar2: "",
		    // plugins: 'link image textcolor',
		    //height: 300,
		    // encoding: "xml",
		});
	</script>
</body>
</html>