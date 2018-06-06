<?php
require_once "./lib/db.php";

?>

<div class="panel-body">	
	<?php
	$sql = "select count(*) as num_rows from orders o , orderdetails od , 
	users u where o.OrderID = od.OrderID and o.UserID = u.f_ID
	group by o.OrderID";
	$rs = load($sql);
	$c = $rs->fetch_assoc();
	$num_rows = $c["num_rows"];

	if($num_rows == 0)
	{


		?>		 	
		<div>Không có đơn đặt hàng nào</div>
		<?php } 
		else {
			?>
			<table class="table table-hover">


				<thead>
					<tr >
						<th class = "text-center">Mã hóa đơn</th>				
						<th class = "text-center">Tổng tiền</th>				
						<th class = "text-center">Trạng thái </th>
						<th class = "text-center">Tên khách hàng</th>
						<th class = "text-right">#</th>
					</tr>

					<?php
					$sql = "select distinct o.OrderID,o.Status,sum(od.Amount) as Amount,u.f_Name from orders o , orderdetails od , 
					users u where o.OrderID = od.OrderID and o.UserID = u.f_ID
					group by o.OrderID order by o.OrderDate DESC";
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
					</thead>
					<tbody>	
						<tr class = "text-center">
							<td><?= $row["OrderID"]?></td>
							<td><?= number_format($row["Amount"]) ?></td>
							<td class = "<?php 
							if($row["Status"]==0)
							{ 
								echo 'bg-danger color text-center';
							}  	
							if($row["Status"]==1)
							{
								echo 'background1 color1 text-center';
							}
							if($row["Status"]==2)
							{
								echo 'background2 color2 text-center';
							}

							?> ">

							<?= $status?>
						</td>

						<td><?= $row["f_Name"] ?></td>
						<td class= "text-right">
							<a class="btn btn-info btn-s " href="AdminLogin_DonHang_CapNhat.php?OrderID=<?= $row["OrderID"] ?>" name = "btnXemChiTiet" role="button">
								<span class="glyphicon glyphicon-cog"></span>
								<b>Cập nhật</b> 
							</a>
						</td>
					</tr>
				</tbody>
				<?php
			} }
			?>
		</table>
	</div>				
