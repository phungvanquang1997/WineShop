<?php
	require_once "./lib/db.php";


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

?>

					 	<?php 
					  		if(isset($_SESSION["current_user"]))
					    	{
					    		$u_id = $_SESSION["current_user"]->f_Username;
					    	
					  			$sql = "select count(*) as num_row from orders o where o.Username = '$u_id'";
					  			
					  			$rs = load($sql);
					  		//	var_dump($sql);
					  			$c_rs = $rs->fetch_assoc();
					  			$numrow = $c_rs["num_row"];

					  			$sql = "select count(*) as SoLuongHoaDon from orders o where o.Username = '$u_id'";
					  					
					  			$rs = load($sql);
					  			$c_rs = $rs->fetch_assoc();
					  
					  			$SoLuongHoaDon = $c_rs["SoLuongHoaDon"];

					  		}
					  		if($numrow > 0)
					  		{
					  	?>
						<div class="col-md-7">
						
							<table class="table table-hover spacing">
							  <thead>
							    <tr>
							      <th scope="col">Hóa đơn</th>
							      <th scope="col">&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbspNgày lập</th>	
							      <th scope="col">Trạng thái</th>					
							      <th scope="col">&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp Chi tiết</th>

							    </tr>
							  </thead>
							  <tbody>

							  	<div class="alert alert-success text-center " >
								  <span class="alert-link text-center"> Bạn có <?= $SoLuongHoaDon ?> hóa đơn </span>
								</div>
								 <?php 
								    	$sql = "select * from orders o where o.Username = '$u_id'";
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
								<tr>
							      <th scope="row"> <?= $row["OrderID"] ?></th>
							      <td > <?= $row["OrderDate"]  ?> </td>
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
									<td class="text-right">
											<a class="btn btn-info btn-s " href="ChiTietHoaDon.php?OrderID=<?= $row["OrderID"] ?>" name = "btnXemChiTiet" role="button">
												<span class="glyphicon glyphicon-search"></span>
												Xem chi tiết 
											</a>
									</td>																		
							    </tr>

								<?php } ?>	
							  </tbody>
							</table>
							    <?php 

									} 
									else{
							    ?>	
									<span class="text-center">:( Không có lịch sử mua hàng</span>

								<?php } ?>
						</div>
						<div class="col-md-5">
						<?php 
							//var_dump($_SESSION["ChiTietHoaDon"]);
							if(isset($_SESSION["ChiTietHoaDon"]))
							{
								//var_dump($_SESSION["ChiTietHoaDon"]);
								if($_SESSION["ChiTietHoaDon"] > 0)
								{
						 ?>
							<table class="table table-hover text-center spacing">
								  <thead>
								
								    <tr>
								      <th scope="col">Mã sản phẩm</th>
								      <th scope="col">Tên sản phẩm</th>	
								      <th scope="col">Giá </th>					
								      <th scope="col" class="text-center">Số lượng</th>

								    </tr>
								  </thead>
								
								 <tbody>
								 	<div class="alert alert-success text-center" >
									  <span class="alert-link text-center"> Thông tin chi tiết hóa đơn : <?= $_SESSION["ChiTietHoaDon"] ?>  </span>
									</div>
									<?php 

										$orderID = $_SESSION["ChiTietHoaDon"] ;
										$sql = "select od.Quantity as Quantity,od.ProID as ProID,p.Price as Price,p.ProName as ProName from orderdetails od , products p where p.ProID = od.ProID AND od.OrderID = $orderID";
										$rs = load($sql);
										while($row = $rs->fetch_assoc())
										{
									?>
									<tr class = "bg-info">							
								      <th scope="row"> <?= $row["ProID"] ?> </th>
								      <td > <?= $row["ProName"] ?> </td>
								      <td >	<?= number_format($row["Price"]) ?></td>
									  <td > <?= $row["Quantity"] ?>
									  </td>																		
								    </tr>
								</tbody>
								    <?php 
										}
								     ?>
								</table>
						<?php 
								}
								$_SESSION["ChiTietHoaDon"] = 0;

							}
						?>
						</div>
					