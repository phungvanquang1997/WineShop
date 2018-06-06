<?php
require_once "./lib/db.php";


if ($_SESSION["dang_nhap_chua"] == 1)
{
	$DangNhap= $_SESSION["current_user"]->f_Username;
}
else
{
	$DangNhap="Đăng Nhập";
}


// if(!isset($_SESSION["SearchString"]))
// {
// 	header("Location : index.php");
// }

if(isset($_GET["ProID"]))
{
	$ProId = $_GET["ProID"];
	$sql = "update products set View = View + 1 where ProID = $ProId";
	write($sql);
}

$Viewid = 0;
if(isset($_GET["Viewid"]))
{
	$Viewid = $_GET["Viewid"];
}

if (isset($_SESSION["Search"]))
{
	$stringSearch = $_SESSION["Search"];

}

if(isset($_POST["btnSearch"]))
{
	$stringSearch = $_POST["txtSearch"];
		$_SESSION["Search"] = $stringSearch; // lưu lại session_start
		// var_dump($_POST["btnSearch"]);
		// if($stringSearch == "")
		// {
		// 	header("Location : Search.php");
		// }
	}

	?>

	<?php 

	$limit = 4;
	$current_page = 1;
	if (isset($_GET["page"])) {
		$current_page = $_GET["page"];
	}
	$num_pages = 0;
	$num_rows =0;
	if($stringSearch != "")
	{							
								if(is_numeric($stringSearch)) // tìm kiếm theo giá
								{
									$c_sql = "select count(*) as num_rows from products where Price = '$stringSearch'";
									$c_rs = load($c_sql);
									$c_row = $c_rs->fetch_assoc();
									$num_rows = $c_row["num_rows"];
									$num_pages = ceil($num_rows / $limit);
									$offset = ($current_page - 1) * $limit;
									$sql = "select * from products where Price = '$stringSearch' limit $offset, $limit";
								}
								else
								{							
									// Tìm theo tên sản phẩm
									$c_sql = "select count(*) as num_rows from products where ProName like '%$stringSearch%'";
									$c_rs = load($c_sql);
									//var_dump($c_sql);
									$c_row = $c_rs->fetch_assoc();
									$num_rows = $c_row["num_rows"]; 
									$num_pages = ceil($num_rows / $limit);

									$offset = ($current_page - 1) * $limit;
									$sql = "select * from products where ProName like '%$stringSearch%' limit $offset, $limit";
									//Nếu tên sản phẩm không có ( < 0 ) thì tìm theo nhà sna3 xuất
									if($num_rows==0)
									{

										$c_sql = "select count(*) as num_rows from products p , NhaSanXuat n where p.nsx = n.IDnsx and n.TenNSX like '%$stringSearch%'";
										$c_rs = load($c_sql);
									//var_dump($c_sql);
										$c_row = $c_rs->fetch_assoc();
										$num_rows = $c_row["num_rows"];

										$num_pages = ceil($num_rows / $limit);
										$offset = ($current_page - 1) * $limit;
										
										$sql = "select * from products p , NhaSanXuat n where p.nsx = n.IDnsx and n.TenNSX like '%$stringSearch%'";
										
									}
									
								}

							}	


							$next_page = $current_page + 1;
							$prev_page = $current_page - 1;



							if ($current_page < 1 || $current_page > $num_pages) {
								$current_page = 1;
							}

							// $offset = 0;
							$rs = load($sql);
							if($num_rows>0)
							{
								while ($row = $rs->fetch_assoc()) :
									?>
									<div class="col-md-6">
										<div class="thumbnail">
											<img src="imgs/sp/<?= $row["ProID"] ?>/main_thumbs.jpg" alt="...">
											<div class="caption">
												<h5><?= $row["ProName"] ?></h5>
												<h4><?= number_format($row["Price"]) ?></h4>
												<p style="height: 40px"><?= $row["TinyDes"] ?></p>
												<br>
												<p>
													<a href="XemChiTiet.php?page<?= $current_page?>&ProID=<?= $row["ProID"]?>" class="btn btn-primary" role="button">Chi tiết</a>
													<a href="order.php?ProID=<?= $row["ProID"] ?>" class="btn btn-danger" role="button">
														<span class="glyphicon glyphicon-shopping-cart"></span>
														Đặt mua
													</a>
													<a class="btn btn-default" role = "button" style="width: 100px">
														<span class="glyphicon glyphicon-eye-open" ></span>
														Xem : <?= $row["View"] ?> 
													</a>
													<a class="btn btn-default" role = "button">
														<span class="glyphicon glyphicon-ok-circle"></span>
														Bán : <?= $row["SoLuongBan"] ?> 
													</a>
												</p>
											</div>
										</div>
									</div>
									<?php 
								endwhile; }else{
									?>
									<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
										Không có sản phẩm thoả điều kiện.
									</div>
									<?php
								};
								?>
								<table class="table table-hover">
									<td colspan="4" class="text-center">

										<?php if ($prev_page > 0) : ?>

											<a class="btn btn-primary Size" href="?page=<?= $prev_page ?>" role="button">
												<span class="glyphicon glyphicon-arrow-left"></span>
												Prev
											</a>
										<?php endif; ?>
										<?php if ($next_page <= $num_pages) : ?>
											<a class="btn btn-primary" href="?page=<?= $next_page ?>" role="button">
												<span class="glyphicon glyphicon-arrow-right"></span>
												Next
											</a>
										<?php endif; ?>
									</td>
								</table>
								