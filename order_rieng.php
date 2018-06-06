<?php
require_once "./lib/db.php";

if (!isset($_SESSION["dang_nhap_chua"])) {
	$_SESSION["dang_nhap_chua"] = 0;
}
if ($_SESSION["dang_nhap_chua"] == 0) {
	header("Location: login.php");
	ob_end_flush();
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
if(isset($_POST["btnSearch"]))
{
	$stringSearch = $_POST["txtSearch"];
	$_SESSION["Search"] = $_POST["txtSearch"];
	header("Location: search.php");
}	
if(isset($_GET["ProID"]))
{
	$ProID = $_GET["ProID"];
}
$success = -1;
$numrow = -1;
$soluong = 0;
$Exists=1;

if(isset($_POST["txtSoLuong"]))
{

	if(is_numeric($_POST["txtSoLuong"]))
	{
		$soluong = $_POST["txtSoLuong"];
		$sql = "select count(*) as num_rows from products where ProID = $ProID and Quantity > $soluong";
		$c_rs = load($sql);
		$c_row = $c_rs->fetch_assoc();
		$numrow = $c_row["num_rows"];
	}
}

if($numrow == 0)
{
	$success = 0;
}
if($numrow > 0)
{
	$success = 1;
}

?>


<?php 

$sql1 = "select count(*) as num_row from products where ProID = $ProID";
$rs = load($sql1);
$c_rs = $rs->fetch_assoc();
$c_row = $c_rs["num_row"];
if($c_row > 0)
{
	$sql = "select * from products where ProID = $ProID";

	$rs = load($sql);

	$row = $rs->fetch_assoc()
	?>
	<div class="col-md-6">
		<div class="thumbnail">
			<img src="imgs/sp/<?= $row["ProID"] ?>/main_thumbs.jpg" alt="...">
			<div class="caption">
				<h5><?= $row["ProName"] ?></h5>
				<h4><?= number_format($row["Price"]) ?></h4>
				<p style="height: 40px"><?= $row["TinyDes"] ?></p>
				<br>
				<p>
					<a href="XemChiTiet.php?ProID=<?= $row["ProID"]?>" class="btn btn-primary" role="button">Chi tiết</a>

					<a href="order.php?ProID=<?= $row["ProID"]?>" class="btn btn-danger" role="button" name ="btnDatMua">
						<span class="glyphicon glyphicon-shopping-cart"></span>
						Đặt mua
					</a>

					<a class="btn btn-default" role = "button" style="width: 100px">
						<span class="glyphicon glyphicon-eye-open" ></span>
						Xem : <?= $row["View"] ?> 
					</a>
					<a class="btn btn-default" role = "button">
						<span class="glyphicon glyphicon-ok-circle"></span>
						Bán : <?= $row["SoLuongBan"] ?> 
					</a>
				</p>
			</div>

		</div>
	</div>

	<div class="col-md-3">
		<form method="post" action="">
			<div class="form-group">
				<label for="txtUserName">Số lượng</label>
				<input type="text" class="form-control" id="txtSoLuong" name="txtSoLuong" placeholder="Nhập số lượng cần mua">
			</div>

			<button type="submit" class="btn btn-success btn-block" name="btnXacNhan" onclick="Check()">
				<span class="glyphicon glyphicon-hand-right"></span>
				Xác nhận
			</button>	
			<?php 
			if(isset($_POST["txtSoLuong"]))
			{
				if(!is_numeric($_POST["txtSoLuong"])){
					?>
					<div class="alert alert-danger" role="alert">
						<a href="#" class="alert-link text-center">Vui lòng chỉ nhập số</a>
					</div>
					<?php 
				}
			}
			//$sl=(int)$_POST["txtSoLuong"];
			if($success == 0 && $soluong!=0 )
			{
				?>	
				<div class="alert alert-danger" role="alert">
					<a href="#" class="alert-link text-center"> Lỗi !!! Số lượng mua > Số lượng tồn </a>
				</div>
				<?php 	
			}
			//$sl=(int)$_POST["txtSoLuong"];

			if($success == 1 && $soluong!=0 ){
				for($i = 0 ; $i < count($_SESSION["SaveProducts"]); $i=$i+4)
				{

					if($_SESSION["SaveProducts"][$i] == $ProID )
					{
						$Exists=0;
						?>

						<META http-equiv="refresh" content="0;URL=GioHang.php">

						<?php 
						break;
					}
				}
				if($Exists==1)
				{

					?>
					<div class="alert alert-success" role="alert">
						<a href="#" class="alert-link text-center">Đặt mua thành công !! Vui lòng kiểm tra giỏ hàng</a>
					</div>

					<?php

					$sql = "select * from products where ProID = $ProID";
					$rs = load($sql);

					$row = $rs->fetch_assoc();
					$array = array();

					array_push($_SESSION["SaveProducts"], $row["ProID"],$row["ProName"],$row["Price"],$soluong);

				}
			}
			//$sl=(int)$_POST["txtSoLuong"];
			if(isset($_POST["txtSoLuong"]))
			{
				if($soluong==0 && $success != 0 && is_numeric($_POST["txtSoLuong"])){
					?>
					<div class="alert alert-danger" role="alert">
						<a href="#" class="alert-link text-center"> Lỗi !!! Số lượng mua phải lớn hơn 0 </a>
					</div>
					<?php 
				}
			}
			?>								
		</form>
	</div>
	<?php } else { ?>
	<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
		Mày ngáo à.
	</div>
	<?php
};
?>




