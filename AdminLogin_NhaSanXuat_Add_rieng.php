<?php
	require_once "./lib/db.php";

	$NSX = "";
	$check = 0;
	if(isset($_POST["btnXacNhan"]))
	{
		if(isset($_POST["txtTenNSX"]))
		{
				$NSX = $_POST["txtTenNSX"];			
		}
		$sql = "insert into nhasanxuat(TenNSX) values('$NSX')";
		write($sql);
		$check = 1;
	}

?>
<div class="col-md-12">
	<form method="post" action="" name="frmEdit">
		<div class="form-group">
			<label for="txtTenNSX">Tên nhà sản xuất</label>
			<input type="text" class="form-control" id="txtTenNSX" name="txtTenNSX" value="<?= $NSX ?>">
		</div>

		<a class="btn btn-primary" href="AdminLogin_NhaSanXuat.php" role="button" title="Back">
			<span class="glyphicon glyphicon-backward"></span>
		</a>

		<button type="submit" class="btn btn-success" name="btnXacNhan">
			<span class="glyphicon glyphicon-check"></span>
					Xác nhận
		</button>


	</form>
	<?php
		if($check==1)
		{
	?>
			<div class="alert alert-success" role="alert">
				<strong> Thêm nhà sản xuất thành công!</strong>.
			</div>
	<?php
		} 
	?>
</div>