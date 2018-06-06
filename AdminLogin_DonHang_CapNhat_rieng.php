<?php
require_once "./lib/db.php";


if(isset($_GET["OrderID"]))
{
	$orderID = $_GET["OrderID"];
}
if (isset($_POST["select"]))
{
	$choice = $_POST["select"];
}
if(isset($_POST["btnUpdate"]))
{
	$sql = "update orders set Status = $choice where OrderID = $orderID";
	write($sql);

}
?>
<div class="col-md-12">
	<?php 
							//var_dump($_SESSION["ChiTietHoaDon"]);
	if(isset($_GET["OrderID"]))
	{
								//var_dump($_SESSION["ChiTietHoaDon"]);
		if(isset($_GET["OrderID"]) > 0)
		{
			?>
			<table class="table table-hover text-center spacing">
				<thead>

					<tr>
						<th scope="col" class="text-center">Mã sản phẩm</th>
						<th scope="col"  class="text-center">Tên sản phẩm</th>	
						<th scope="col" class="text-center">Giá </th>					
						<th scope="col" class="text-center">Số lượng</th>
						<th scope="col" class="text-center">Trạng thái hiện tại</th>

					</tr>
				</thead>

				<tbody>
					<div class="alert alert-success text-center" >
						<span class="alert-link text-center"> Thông tin chi tiết hóa đơn : <?= $orderID ?>  </span>
					</div>
					<?php 
					$sql = "select o.`Status` as Status ,od.Quantity as Quantity,od.ProID as ProID,p.Price as Price,p.ProName as ProName from orders o , orderdetails od , products p where p.ProID = od.ProID AND od.OrderID = $orderID and o.OrderID = od.OrderID";
					$rs = load($sql);
					while($row = $rs->fetch_assoc())
					{
						if($row["Status"]==0)
						{
							$status = "Chưa giao";
						}  
						if($row["Status"]==1)
						{
							$status = "Đang giao";
						}  
						if($row["Status"]==2)
						{
							$status = "Đã giao";
						}  
						?>
						<tr class = "bg-info">							
							<td> <?= $row["ProID"] ?> </th>
								<td > <?= $row["ProName"] ?> </td>
								<td >	<?= number_format($row["Price"]) ?></td>
								<td > <?= $row["Quantity"] ?></td>	

								<td> <?= $status ?></td>																	
							</tr>
						</tbody>
						<?php 
					}
				}
				?>
			</table>
			<?php 
		}			
		?>
		<div class="col-md-12">


			<form method="post" action="" name="frmEdit">
				<b class = "text-danger ">Cập nhật trạng thái : </b>		
				<select name ="select" style="width: 90px">
					<option value="0">Chưa giao</option>
					<option value="1">Đang giao</option>
					<option value="2">Đã giao</option>
				</select>
				<br>
				<br>

				<a class="btn btn-primary btn-s" href="AdminLogin_DonHang.php" role="button" title="Back">
					<span class="glyphicon glyphicon-backward"></span>
				</a>

				<button type="submit" class="btn btn-success btn-sm" name="btnUpdate">
					<span class="glyphicon glyphicon-check"></span>
					Cập nhật
				</button>


			</form>
			<br>
			<?php if(isset($_POST["btnUpdate"]))
			{
				?>
				<div class="alert alert-success" role="alert">
					<strong>Cấp nhật số lượng thành công!</strong>.
				</div>
				<?php								 
			}
			?>

		</div>

	</div>