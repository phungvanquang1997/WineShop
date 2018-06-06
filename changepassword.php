<?php
session_start();

if ($_SESSION["dang_nhap_chua"] == 0) {
	header("Location: login.php");
}
$title="Thay đổi mật khẩu";
$page_title= "Thay đổi mật khẩu";
// if($stringSearch == "")
// {

// 

// }
// else{

// 	$page_title="Thông tin tìm kiếm";
// }


	//$base_filename = basename(__FILE__, '.php');
$page_body_file = "changepassword_rieng.php";
include 'index_public.php';

