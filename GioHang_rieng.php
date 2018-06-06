<?php
require_once "./lib/db.php";




if(isset($_POST["btnSearch"]))
{
	$stringSearch = $_POST["txtSearch"];
	$_SESSION["Search"] = $_POST["txtSearch"];
	header("Location: search.php");
}	

if(isset($_SESSION["SaveProducts"]))
{
	$_SESSION["TempSaveProducts"] = $_SESSION["SaveProducts"];
}
else
		$_SESSION["TempSaveProducts"] = array(); // tạo mảng rỗng để xử lý khi user chưa đăng nhập sẽ bắt lỗi 'không có giở hàng'

	if ($_SESSION["dang_nhap_chua"] == 1)
	{
		$DangNhap= $_SESSION["current_user"]->f_Username;
	}
	else
	{
		$DangNhap="Đăng Nhập";
	}


	?>
	<div class="col-md-12">
		<?php 
		if(count($_SESSION["TempSaveProducts"])>0)
		{
			?>
			<table class="table table-hover">
				<thead>
					<tr>
						<th>Mã sản phẫm</th>
						<th>Tên sản phẩm</th>
						<th>Giá</th>
						<th>Số lượng</th>
					</tr>
				</thead>
				<tbody>
					<?php
									//var_dump(array_values($_SESSION["SaveProducts"]));

					$Total = 0;
									//var_dump($_SESSION["DaThanhToan"]);	
					for($i = 0 ; $i < count($_SESSION["SaveProducts"]); $i=$i+4)
					{
						$Total += ($_SESSION["SaveProducts"][$i+2]*$_SESSION["SaveProducts"][$i+3]);

						?>
						<tr>
							<td><?= $_SESSION["SaveProducts"][$i] ?></td>
							<td><?= $_SESSION["SaveProducts"][$i+1] ?></td>
							<td><?= number_format($_SESSION["SaveProducts"][$i+2]) ?></td>
							<td><?= $_SESSION["SaveProducts"][$i+3] ?></td>
							<td class="text-right">
								<a class="btn btn-default btn-xs" href="GioHang_edit.php?id=<?= $_SESSION["SaveProducts"][$i]  ?>" role="button">
									<span class="glyphicon glyphicon-pencil"></span>
								</a>
								<a class="btn btn-danger btn-xs" href="GioHang_delete.php?id=<?= $_SESSION["SaveProducts"][$i]  ?>" role="button">
									<span class="glyphicon glyphicon-remove"></span>
								</a>
							</td>
						</tr>
						<?php
					}
					?>
					<div class="alert alert-info" role="alert">
						Tổng tiền hóa đơn : <?= number_format($Total) ?>
					</div>	
				</tbody>
			</table>
			<?php }  else{ ?>
			<span>Không có giỏ hàng nào cả </span>
			<?php  } ?>

		</div>
		<?php 
		if($_SESSION["SaveProducts"] != null)
		{
			?>
			<div class = "col-md-12">
				<form method="post" action="">
					<div class="text-right"> 

						<a href="XacNhanMua.php?" class="btn btn-success" role="button" name ="btnDatMua">
							<span class="glyphicon glyphicon-shopping-cart"></span>
							Thanh Toán

						</a>


					</div>

					<br>
					<?php if(isset($_SESSION["DaThanhToan"])){
						if($_SESSION["DaThanhToan"]==1){
							$_SESSION["SaveProducts"] = array();
							$_SESSION["DaThanhToan"]=0;
										 // Sau khi thanh toán , sẽ new Session SaveProduct 

							?>
							<div class="alert alert-success text-center" >
								<a href="#" class="alert-link text-center"> Thanh toán thành công </a>
							</div>	
							<?php 	 }
						} ?>					
					</div>	
					<?php } ?>
					