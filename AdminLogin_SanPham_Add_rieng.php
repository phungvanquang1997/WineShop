<?php
require_once "./lib/db.php";


if(isset($_POST["btnThem"]))
{
	$ProName = $_POST["txtProName"];
	$TinyDes = $_POST["txtTinyDes"];
	$FullDes = $_POST["txtFullDes"];
	$Price = $_POST["txtPrice"];
	$Quantity = $_POST["txtQuantity"];
	$OriginName = $_POST["txtOrigin"];
	$Ten_NSX = $_POST["txtNSX"];
	$check=-1;
	if(strlen($ProName)==0)
	{
		$check=2;
	}
	if(strlen($TinyDes)==0)
	{
		$check=3;
	}
	if(strlen($FullDes)==0)
	{
		$check=4;
	}
	if(strlen($Price)==0 ||!is_numeric($Price) || $Price==0)
	{
		$check=5;
	}
	if(strlen($Quantity)==0 ||!is_numeric($Quantity) || $Quantity==0)
	{
		$check=6;
	}
	if(strlen($OriginName)==0)
	{
		$check=7;
	}
	if(strlen($Ten_NSX)==0)
	{
		$check=8;
	}


	if($check==-1)
	{

		// Sản kiểu dữ liệu varchar -> text tại table : Origin / OriginName
		$sql = "select count(*) as num_rows from Origin where OriginName like '%$OriginName%' ";
		$rs = load($sql);
		if($rs->num_rows>0)
		{
			$c = $rs->fetch_assoc();

			$num = $c["num_rows"];

			$sql_MaxID = "select max(OriginID)  as maxID from origin";
			$rs = load($sql_MaxID);
			$rs = $rs->fetch_assoc();
		$maxID = $rs["maxID"]; // lấy giá trị ID lớn nhất

		$sql_MaxNSX = "select max(IDnsx) as maxNSX from nhasanxuat";
		$rs = load($sql_MaxNSX);
		$rs = $rs->fetch_assoc();
		$maxNSX = $rs["maxNSX"];

		$sql_MaxProID = "select max(ProID) as maxProID from products";
		$rs = load($sql_MaxProID);
		$rs = $rs->fetch_assoc();
		$maxProID = $rs["maxProID"];
	}
	else
	{
		$num=0;
	}



		if($num == 0 ) // k có quốc gia nào cùng với quốc gia nhập vào
		{
			$maxID = $maxID + 1;
			$sql1 = "insert into Origin values('$maxID','$OriginName')";
			write($sql1);
		  $sql1 = "select * from Origin where OriginName = '$OriginName'"; // để lấy mã quốc gia vừa insert
		  $rs = load($sql1);
		  $row = $rs->fetch_assoc();
		  $OriginID = $row["OriginID"];
		}
		else
		{
			$sql2 = "select * from Origin where OriginName like '%$OriginName%' ";
			$rs = load($sql2);
			$row = $rs->fetch_assoc();
			$OriginID = $row["OriginID"];
		}
		//
		$sql = "select count(*) as num_rows from nhasanxuat where TenNSX like '%$Ten_NSX%' ";
		$rs = load($sql);
		$c = $rs->fetch_assoc();
		$num = $c["num_rows"];

		if($num == 0 ) // k có nhà sx nào cùng với quốc gia nhập vào
		{
			$maxNSX = $maxNSX + 1;
			$sql1 = "insert into nhasanxuat values('$maxNSX','$Ten_NSX')";
			write($sql1);
		  $sql1 = "select * from nhasanxuat where TenNSX = '$Ten_NSX'"; // để lấy mã nhà sx vừa insert
		  $rs = load($sql1);
		  $row = $rs->fetch_assoc();
		  $IDnsx = $row["IDnsx"];
		}
		else
		{
		  $sql1 = "select * from nhasanxuat where TenNSX like '%$Ten_NSX%' "; // để lấy mã nhà sx vừa insert
		  $rs = load($sql1);
		  $row = $rs->fetch_assoc();
		  $IDnsx = $row["IDnsx"];
		}

		//insert sản phẩm
		$dt = new DateTime();
		$time = $dt->format('Y-m-d H:i:s');

		$maxProID = $maxProID + 1;
		$sql3 = "insert into products values ('$maxProID','$ProName','$TinyDes','$FullDes','$Price','$Quantity','$OriginID',0,0,'$time','$IDnsx')";
		$id = write($sql3);
		$check = 1; // xác nhận đã thêm sản phẩm

		
		//thêm hình ảnh
		$f = $_FILES["fuMain"];
		mkdir("imgs/sp/$id");

		if ($f["error"] > 0) {

		} else {


			$tmp_name = $f["tmp_name"];
			$name = $f["name"];
			$destination = "imgs/sp/$id/main.jpg";

			move_uploaded_file($tmp_name, $destination);
		}

		$f1 = $_FILES["fuThumbs"];
		if ($f["error"] > 0) {

		} else {



			$tmp_name = $f1["tmp_name"];
			$name = $f1["name"];
			$destination = "imgs/sp/$id/main_thumbs.jpg";

			move_uploaded_file($tmp_name, $destination);
		}
	}
}
?>
<div class="panel-body">			 	
	<form action="" method="POST" enctype="multipart/form-data">
		<div class="form-group">
			<label for="exampleInputEmail1">Tên sản phẩm</label>
			<input type="text" class="form-control" name ="txtProName" placeholder="Rượu vang">
		</div>
		<div class="form-group">
			<label for="exampleInputEmail1">Mô tả nhỏ</label>
			<input type="text" class="form-control" name ="txtTinyDes" placeholder="...">
		</div>		

		<div class="form-group">
			<label for="txtFullDes" class="col-sm-2 control-label">Chi tiết</label>
			<div class="col-sm-12">
				<textarea rows="4" id="txtFullDes" name="txtFullDes" class="form-control"></textarea>
			</div>
		</div>	
		<div class="form-group">
			<label for="fuThumbs" class="col-sm-2 control-label">Ảnh nhỏ</label>
			<div >
				<input type="file" class="form-control" id="fuThumbs" name="fuThumbs">
			</div>
		</div>
		<div class="form-group">
			<label for="fuMain" class="col-sm-2 control-label">Ảnh lớn</label>
			<div >
				<input type="file" class="form-control size" id="fuMain" name="fuMain">
			</div>
		</div>


		<div class="form-group">
			<label for="exampleInputEmail1">Giá sản phẩm</label>
			<input type="text" class="form-control" name ="txtPrice"  placeholder="100000">
		</div>		
		<div class="form-group">
			<label for="exampleInputEmail1">Số lượng</label>
			<input type="text" class="form-control" name ="txtQuantity"  placeholder="10">
		</div>
		<div class="form-group">
			<label for="exampleInputEmail1">Quốc gia</label>
			<input type="text" class="form-control" name ="txtOrigin"  placeholder="Việt Nam">
		</div>		
		<div class="form-group">
			<label for="exampleInputEmail1">Nhà sản xuất</label>
			<input type="text" class="form-control" name ="txtNSX"  placeholder="...">
		</div>		
		<div class = "text-center">
			<button type="submit" class="btn btn-success" name ="btnThem">
				<span class = "glyphicon glyphicon-ok"></span>
				Xác nhận
			</button>		
		</div> 		 
	</form>
	<?php if(isset($_POST["btnThem"]))
	{
		if ($check == 1) { ?>
		<div class="alert alert-success" role="alert">
			<strong>Thêm sản phẩm thành công!</strong>.
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
	<strong>Mô tả nhỏ không được để trống</strong>.
</div>
<?php
}
if ($check == 4) { ?>
<div class="alert alert-danger" role="alert">
	<strong>Mô tả chi tiết không được để trống</strong>.
</div>
<?php
}
if ($check == 5) { ?>
<div class="alert alert-danger" role="alert">
	<strong>Giá không được để trống và phải là con số lớn hơn 0!</strong>.
</div>

<?php
}
if ($check == 6) { ?>
<div class="alert alert-danger" role="alert">
	<strong>Số lượng không được để trống phải là con số lớn hơn 0!</strong>.
</div>

<?php
}
if ($check == 7) { ?>
<div class="alert alert-danger" role="alert">
	<strong>Quốc gia không được để trống!</strong>.
</div>


<?php
}
if ($check == 8) { ?>
<div class="alert alert-danger" role="alert">
	<strong>Tên nhà sản xuất không được để trống!</strong>.
</div>
<?php
}
if ($check == 9) { ?>
<div class="alert alert-danger" role="alert">
	<strong>ảnh không được để trống!</strong>.
</div>
<?php
}

}
?>
</div>		

