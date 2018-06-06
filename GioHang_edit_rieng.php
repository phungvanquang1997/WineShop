<?php
require_once "./lib/db.php";

if(!isset($_GET["id"]))
{
	header("Location : index.php");
		//ob_end_flush();
}


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
		$_SESSION["TempSaveProducts"] = array(); // tạo mảng rỗng để xử lý

	if ($_SESSION["dang_nhap_chua"] == 1)
	{
		$DangNhap= $_SESSION["current_user"]->f_Username;
	}
	else
	{
		$DangNhap="Đăng Nhập";
	}	

	if(!isset($_GET["id"]))
	{
		header("Location : index.php");
		//ob_end_flush();
	}
	if(isset($_GET["id"]))
	{
		$id = $_GET["id"];
	}


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
	$soluong = $_SESSION["SaveProducts"][$index];

	if(isset($_POST["btnUpdate"]))
	{
		$soluong = $_POST["txtSoLuong"];
		$sql = "select count(*) as num_row from products where ProID = $id and Quantity > $soluong";
		$rs = load($sql);
		$c_rs = $rs->fetch_assoc();
		$num_row = $c_rs["num_row"];
		if($num_row > 0 )
		{
			$check = 1;
			$_SESSION["SaveProducts"][$index] = $soluong; // cập nhật lại số lượng sau khi chỉnh sửa
		}
		else
			$check = 0; 	

	}

	if(isset($_POST["btnDelete"]))
	{
		unset($_SESSION["SaveProducts"][$index]);
		unset($_SESSION["SaveProducts"][$index-1]);
		unset($_SESSION["SaveProducts"][$index-2]);
		unset($_SESSION["SaveProducts"][$index-3]);
		//$_SESSION["SaveProducts"] trước đó là các chỉ mục random , không thể duyệt 0,1,2,3...,5,6,7,8,10,11,12,13,14...

		$_SESSION["SaveProducts"] = array_values($_SESSION["SaveProducts"]);//Chuyển sang dạng chỉ mục tuần tự 0,1,2,3..n
		
		header('Location: GioHang.php');

	}




	?>

	<div class="col-md-12">
		<form method="post" action="" name="frmEdit">
			<div class="form-group">
				<label for="txtMaSP">Mã sản phẩm</label>
				<input type="text" class="form-control" id="txtMaSP" name="txtMaSP" readonly value="<?= $maSP ?>">
			</div>

			<div class="form-group">
				<label for="txtTenSP">Tên sản phẩm</label>
				<input type="text" class="form-control" id="txtMaSP" name="txtTenSP" readonly value="<?= $tenSP ?>">
			</div>

			<div class="form-group">
				<label for="txtSoLuong">Số lượng</label>
				<input type="text" class="form-control" id="txtSoLuong" name="txtSoLuong" value="<?= $soluong?>">
			</div>

			<a class="btn btn-primary" href="GioHang.php" role="button" title="Back">
				<span class="glyphicon glyphicon-backward"></span>
			</a>

			<button type="submit" class="btn btn-success" name="btnUpdate">
				<span class="glyphicon glyphicon-check"></span>
				Chỉnh sửa
			</button>

			<button type="submit" class="btn btn-danger" name="btnDelete">
				<span class="glyphicon glyphicon-remove"></span>
				Xoá 
			</button>
		</form>
		<?php if(isset($_POST["btnUpdate"]))
		{
			if ($check == 1) { ?>
			<div class="alert alert-success" role="alert">
				<strong>Cấp nhật số lượng thành công!</strong>.
			</div>
			<?php }
			else 
			{
				?>
				<br>
				<div class="alert alert-danger" role="alert">
					<strong>Số lượng thay đổi > số lượng tồn. !</strong>
				</div>
				<?php }
			} ?>
		</div>
