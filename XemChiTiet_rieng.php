<?php
require_once "./lib/db.php";

if(isset($_GET["ProID"]))
{
	$proID  = $_GET["ProID"];
}

if ($_SESSION["dang_nhap_chua"] == 1)
{
	$DangNhap= $_SESSION["current_user"]->f_Username;
}
else
{
	$DangNhap="Đăng Nhập";
}

$sql = "update products set View = View + 1 where ProID = $proID";
write($sql);

$success = -1;
$numrow = -1;
$soluong = 0;
$Exists=1;

if(isset($_POST["txtSoLuong"]))
{

	if(is_numeric($_POST["txtSoLuong"]))
	{
		$soluong = $_POST["txtSoLuong"];
		$sql = "select count(*) as num_rows from products where ProID = $proID and Quantity > $soluong";
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




<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="padding: 0px" >
	

	<div class="panel-body" >
		<?php 

		$sql = "select * from products p , nhasanxuat n , Origin o where p.NSX = n.IDnsx and  p.ProID = $proID and p.OriginID = o.OriginID";
		$rs = load($sql);
		$row = $rs->fetch_assoc();
		$NSX = $row["NSX"];
		?>
		<div class="col-md-12">

			<div class="thumbnail">
				<!-- 	<img src="imgs/sp/<?= $row["ProID"] ?>/main.jpg" alt="..."> -->

				<div class="bxslider">
					<div>
						<img src="imgs/sp/<?= $row["ProID"]?>/main.jpg" height="600" width="600">
					</div>
					<div>
						<img src="imgs/sp/<?= $row["ProID"]?>/main_thumbs.jpg" height="600" width="600" >
					</div>
				</div>
				<div class="caption">
					
					<h5>Tên sản phẩm : <b> <?= $row["ProName"] ?> </b></h5>
					<h5>Giá : <b><?= number_format($row["Price"]) ?></b></h5>
					<h5>Tên nhà sản xuất : <b><?= $row["TenNSX"] ?> </b></h5>
					<h5>Xuất sứ : <b><?= $row["OriginName"] ?> </b></h5>
					<h5>Loại : <b>Rượu</b></h5>
					<h5>Mô tả chi tiết sản phẩm : </h5>
					<p><?= $row["FullDes"] ?></p>
					<h3> Số lượng </h3>
					<form method="post" action="">
						<div class="form-group col-md-3">								
							<input type="text" class="form-control" id="txtSoLuong" name="txtSoLuong" placeholder="Nhập số lượng cần mua">
						</div>
						<button type="submit" class="btn btn-danger" name ="btnDatMua">
							<span class="glyphicon glyphicon-shopping-cart"></span>
							Đặt mua
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
						if($success == 0 && $soluong!=0 )
						{
							?>	
							<div class="alert alert-danger" role="alert">
								<a href="#" class="alert-link text-center"> Lỗi !!! Số lượng mua > Số lượng tồn </a>
							</div>
							<?php 	
						}


						if($success == 1 && $soluong!=0 ){
							for($i = 0 ; $i < count($_SESSION["SaveProducts"]); $i=$i+4)
							{
								
								if($_SESSION["SaveProducts"][$i] == $proID )
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

								$sql = "select * from products where ProID = $proID";
								$rs = load($sql);

								$row = $rs->fetch_assoc();
								$array = array();

								array_push($_SESSION["SaveProducts"], $row["ProID"],$row["ProName"],$row["Price"],$soluong);

							}

						}
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

						<a class="btn btn-default" role = "button">
							<span class="glyphicon glyphicon-eye-open" ></span>
							Lượt xem : <?= $row["View"] ?> 
						</a>
						<a class="btn btn-default" role = "button">
							<span class="glyphicon glyphicon-ok-circle"></span>
							Đã Bán : <?= $row["SoLuongBan"] ?> 
						</a>


					</form>



				</div>
			</div>
		</div>				

	</div>


	<div class="panel-body">
		<h3 class= "font">5 Sản phẩm cùng nhà sản xuất</h3>
		<?php 

		$limit = 4;

		$sql = "select * from products where nsx = $NSX limit 5";
		$rs = load($sql);
		while ($row = $rs->fetch_assoc()) :
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
							<a href="order.php?ProID=<?= $row["ProID"]?>" class="btn btn-danger" role="button">
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
			<?php 
		endwhile;
		?>
	</div>

	<div class="panel-body">
		<h3 class="font">5 Sản phẩm cùng loại</h3>
		<?php 

		$limit = 4;

		$sql = "select * from products limit 5";
		$rs = load($sql);
		while ($row = $rs->fetch_assoc()) :
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
							<a href="order.php?ProID=<?= $row["ProID"]?>" class="btn btn-danger" role="button">
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
			<?php 
		endwhile;
		?>
	</div>
</div>
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