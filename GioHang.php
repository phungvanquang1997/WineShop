<?php
session_start();
	if ($_SESSION["dang_nhap_chua"] == 0) {
			header("Location: login.php");
		}
$title="Giỏ Hàng";
$page_title ="Giỏ Hàng";

	//$base_filename = basename(__FILE__, '.php');
$page_body_file = "GioHang_rieng.php";
include 'index_public.php';

