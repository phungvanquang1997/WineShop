<?php
	require_once "./lib/db.php";
	if(isset($_GET["idNSX"]))
	{

		$idNSX = $_GET["idNSX"];
		$sql = "select * from nhasanxuat where IDnsx = $idNSX";
		$rs = load($sql);
		$rs = $rs->fetch_assoc();
		$NSX = $rs["TenNSX"];

		
	}
	$check = 0;
	if(isset($_POST["btnUpdate"]))
	{
		if(isset($_POST["txtTenNSX"]))
		{
				$NSX = $_POST["txtTenNSX"];			
		}
		$sql = "update nhasanxuat set TenNSX = '$NSX' where IDnsx = $idNSX";
		write($sql);
		$check = 1;
	}
	if(isset($_POST["btnDelete"]))
	{
		if(isset($_GET["idNSX"]))
		{
			$idNSX = $_GET["idNSX"];
			$sql = "delete from nhasanxuat where idNSX = $idNSX";
			write($sql);
			header('Location: AdminLogin_NhaSanXuat.php');
		}
	}
?>
<div class="col-md-12">
	<form method="post" action="" name="frmEdit">
		<div class="form-group">
			<label for="txtMaNSX">Mã nhà sản xuất</label>
			<input type="text" class="form-control" id="txtMaNSX" name="txtMaNSX" readonly value="<?= $idNSX ?>">
		</div>


		<div class="form-group">
			<label for="txtTenNSX">Tên nhà sản xuất</label>
			<input type="text" class="form-control" id="txtTenNSX" name="txtTenNSX" value="<?= $NSX?>">
		</div>

		<a class="btn btn-primary" href="AdminLogin_NhaSanXuat.php" role="button" title="Back">
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
	<?php
		if($check==1)
		{
	?>
			<div class="alert alert-success" role="alert">
				<strong>Chỉnh sửa sản phẩm thành công!</strong>.
			</div>
	<?php
		} 
	?>
</div>