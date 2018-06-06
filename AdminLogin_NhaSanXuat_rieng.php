<?php
require_once "./lib/db.php";

?>

<div class="panel-body">	
			<table class="table table-hover">
				
				<thead>
					<tr >
						<th class = "text-center">Mã nhà sản xuất</th>				
						<th class = "text-center">Tên nhà sản xuất</th>				
						<th class = "text-right">#</th>
					</tr>
				</thead>

				<tbody>	
					<?php
					$sql = "select * from nhasanxuat";
					$rs = load($sql);
					while ($row = $rs->fetch_assoc()) {
						# code...
							
					?>
					<tr class="text-center">
						<td> <?= $row["IDnsx"] ?></td>
						<td><?= $row["TenNSX"] ?></td>
						<td class= "text-right">
							<a class="btn btn-info btn-s" href="AdminLogin_NhaSanXuat_Update.php?idNSX=<?= $row["IDnsx"]?>" name = "btnChinhSua" role="button">
								<span class="glyphicon glyphicon-cog"></span>
								<b>Cập nhật</b> 
							</a>
							<a class="btn btn-danger btn-s "  name = "btnXoa" href="AdminLogin_NhaSanXuat_Delete.php?idNSX=<?= $row["IDnsx"]?>"  role="button">
								<span class="glyphicon glyphicon-ban-circle"></span>
								<b>Xóa</b> 
							</a>
						</td>
					</tr>
					<?php 
							}
						?>
				</tbody>
					
		</table>
</div>				
