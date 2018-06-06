<?php
require_once "./lib/db.php";


if(isset($_GET["ProID"]))
{
	$proid = $_GET["ProID"];
	$sql = "select * from products p , nhasanxuat n where p.ProID = $proid and p.NSX =  n.idNSX";
	$rs = load($sql);
	$row = $rs->fetch_assoc();
	$tenSP = $row["ProName"];
	$soluong = $row["Quantity"];
	$NSX = $row["TenNSX"];
	$Gia= $row["Price"];
}
$check = -1;


if(isset($_POST["btnUpdate"]))
{
	$soluong = $_POST["txtSoLuong"];
	$tenSP = $_POST["txtTenSP"];
	$TenNSX = $_POST["txtTenNSX"];
	$Gia= $_POST["txtGia"];
	if(strlen($tenSP)==0)
	{
		$check=2;
	}
	if(strlen($soluong)==0 ||!is_numeric($soluong) || $soluong==0)
	{
		$check=3;
	}
	if(strlen($TenNSX)==0)
	{
		$check=4;
	}
	if(strlen($Gia)==0 ||!is_numeric($Gia) || $Gia==0)
	{
		$check=5;
	}

	if($check==-1)
	{
		$sql = "update products set ProName = '$tenSP' where ProID = $proid";
		write($sql);
		$sql = "update products set Quantity = $soluong where ProID = $proid";
		write($sql);

		$sql = "update products set Price = $Gia where ProID = $proid";
		write($sql);

		$sql ="select count(*) as num_rows from nhasanxuat n where n.TenNSX = '$TenNSX'";
		$rs = load($sql);
		if($rs->num_rows>0)
		{
			$c = $rs->fetch_assoc();
			$num = $c["num_rows"];
		}
		else
		{
			$num=0;
		}

	if($num==0) // nếu không tìm ra nhà sản xuất tương ứng
	{ 
		$sql1 = "insert into nhasanxuat(TenNSX) values('$TenNSX')";// thêm 1  nhà sản xuất khác tương ứng

		write($sql1);
		
		$sql2 = "select idNSX , TenNSX from nhasanxuat where TenNSX = '$TenNSX'";
		$rs = load($sql2);
		$rs = $rs->fetch_assoc();
		$idNSX = $rs["idNSX"];
		$TenNSX = $NSX = $rs["TenNSX"];
		
		$sql3 = "update products set NSX = $idNSX where ProID = $proid";
		write($sql3);
		
	}
	else
	{
		$sql2 ="select n.IDnsx from nhasanxuat n where n.TenNSX = '$TenNSX'";

		$rs = load($sql2);
		$rs = $rs->fetch_assoc();
		$idNSX = $rs["IDnsx"];

		$sql3 = "update products set NSX = $idNSX where ProID = $proid";
		write($sql3);
		$sql4 ="select n.TenNSX from nhasanxuat n , products p where n.idNSX = p.NSX and p.ProID = $proid";
		$NSX = load($sql4);
		$NSX = $NSX->fetch_assoc();
		$NSX = $NSX["TenNSX"];

	}
	

	$check = 1;
		//$sql1 = "update nhasanxuat set TenNSX = $TenNSX where "
}
}
if(isset($_POST["btnDelete"]))
{
	$sql = "delete from products where ProID = $proid";
	write($sql);
	header('Location: AdminLogin_SanPham.php');
}

?>
<div class="col-md-12">
	<form method="post" action="" name="frmEdit">
		<div class="form-group">
			<label for="txtMaSP">Mã sản phẩm</label>
			<input type="text" class="form-control" id="txtMaSP" name="txtMaSP" readonly value="<?= $proid ?>">
		</div>

		<div class="form-group">
			<label for="txtTenSP">Tên sản phẩm</label>
			<input type="text" class="form-control" id="txtMaSP" name="txtTenSP" value="<?= $tenSP ?>">
		</div>

		<div class="form-group">
			<label for="txtSoLuong">Số lượng</label>
			<input type="text" class="form-control" id="txtSoLuong" name="txtSoLuong" value="<?= $soluong?>">
		</div>

		<div class="form-group">
			<label for="txtSoLuong">Tên nhà sản xuất</label>
			<input type="text" class="form-control" id="txtSoLuong" name="txtTenNSX" value="<?= $NSX?>">
		</div>
		<div class="form-group">
			<label for="txtSoLuong">Giá</label>
			<input type="text" class="form-control" id="txtSoLuong" name="txtGia" value="<?= $Gia?>">
		</div>

		<a class="btn btn-primary" href="AdminLogin_SanPham.php" role="button" title="Back">
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
			<strong>Cập nhật thành công!</strong>.
		</div>
		<?php
	}
	if ($check == 2) { ?>
	<div class="alert alert-danger" role="alert">
		<strong>Tên sản phẩm không được để trống!</strong>.
	</div>
	<?php
}
if ($check == 3) { ?>
<div class="alert alert-danger" role="alert">
	<strong>Số lượng không được để trống phải là con số lớn hơn 0!</strong>.
</div>
<?php
}
if ($check == 4) { ?>
<div class="alert alert-danger" role="alert">
	<strong>Tên nhà sản xuất không được để trống!</strong>.
</div>
<?php
}
if ($check == 5) { ?>
<div class="alert alert-danger" role="alert">
	<strong>Giá không được để trống và phải là con số lớn hơn 0!</strong>.
</div>
<?php
}
}
?>
</div>