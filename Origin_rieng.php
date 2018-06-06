<?php
require_once "./lib/db.php";

if(isset($_GET["ProID"]))
{
	$ProId = $_GET["ProID"];
	$sql = "update products set View = View + 1 where ProID = $ProId";
	write($sql);
}

if( !isset($_GET["id_QG"]) && !isset($_GET["id"]))
{
	
	header("Location: index.php");
	ob_end_flush();
}

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
$Search;
if(isset($_GET["id"]))
{
	$id = $_GET["id"];
	$Search="NSX";
}

if(isset($_GET["id_QG"]))
{
	$id = $_GET["id_QG"];
	$Search="OriginID";
}
	$limit = 4;
	

	$current_page = 1;
	if (isset($_GET["page"])) {
		$current_page = $_GET["page"];
	}

	$next_page = $current_page + 1;
	$prev_page = $current_page - 1;


	$c_sql = "select count(*) as num_rows from products where  $Search = $id";

	$c_rs = load($c_sql);
	$c_row = $c_rs->fetch_assoc();
	$num_rows = $c_row["num_rows"];
	$num_pages = ceil($num_rows / $limit);


	if ($current_page < 1 || $current_page > $num_pages) {
		$current_page = 1;
	}

							// $offset = 0;
	$offset = ($current_page - 1) * $limit;

	$sql = "select * from products where  $Search = $id limit $offset, $limit";
	$rs = load($sql);
	while ($row = $rs->fetch_assoc()) :
		?>
		<div class="col-md-6" style="padding-top: 10px">
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
			</div>

		</div>
		<?php 
	endwhile;

?>



<table class="table table-hover">
	<td colspan="4" class="text-center">

		<?php if ($prev_page > 0) : ?>

			<a class="btn btn-primary Size" href="?page=<?= $prev_page ?>&id=<?= $id?>" role="button">
				<span class="glyphicon glyphicon-arrow-left"></span>
				Prev
			</a>
		<?php endif; ?>
		<?php if ($next_page <= $num_pages) : ?>
			<a class="btn btn-primary" href="?page=<?= $next_page ?>&id=<?= $id?>" role="button">
				<span class="glyphicon glyphicon-arrow-right"></span>
				Next
			</a>
		<?php endif; ?>
	</td>
</table>
