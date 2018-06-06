<?php 

$limit = 10;


$current_page = 1;
if (isset($_GET["page"])) {
	$current_page = $_GET["page"];
}
$num_rows = 0;
$num_pages = 0;

$next_page = $current_page + 1;
$prev_page = $current_page - 1;



if($Viewid==0)
							{	// $offset = 0;
								$c_sql = "select count(*) as num_rows from products";
								$c_rs = load($c_sql);
								$c_row = $c_rs->fetch_assoc();
								$num_rows = $c_row["num_rows"];
								$num_pages = ceil($num_rows / $limit);
								$offset = ($current_page - 1) * $limit;
								$sql = "select * from products limit $offset, $limit";
							}

							if($Viewid==1)
							{
								
								//$c_row = $c_rs->fetch_assoc();
								$num_rows = 10;
								$num_pages = ceil($num_rows / $limit);
								$offset = ($current_page - 1) * $limit;
								$sql = "select * from products order by SoLuongBan DESC limit 10";
							}


							if($Viewid==2)
							{
																//$c_row = $c_rs->fetch_assoc();
								$num_rows = 10;
								$num_pages = ceil($num_rows / $limit);
								$offset = ($current_page - 1) * $limit;
								$sql = "select * from products order by NgayNhap DESC limit 10";
							}


							if($Viewid==3)
							{
																//$c_row = $c_rs->fetch_assoc();
								$num_rows = 10;;
								$num_pages = ceil($num_rows / $limit);
								$offset = ($current_page - 1) * $limit;
								$sql = "select * from products order by View DESC limit 10";
							}
							

							if ($current_page < 1 || $current_page > $num_pages) {
								$current_page = 1;
							}

							$rs = load($sql);

							if($num_rows >0)
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
													<a href="XemChiTiet.php?ProID=<?= $row["ProID"]?>" class="btn btn-primary" role="button">Chi tiết</a>

													<a href="order.php?ProID=<?= $row["ProID"]?>" class="btn btn-danger" role="button" name ="btnDatMua">
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
											<div id = "Show">

											</div>
										</div>
									</div>
									<?php 
								endwhile; }else{;
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


					