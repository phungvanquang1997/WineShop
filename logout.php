<?php
session_start();
if (isset($_SESSION["dang_nhap_chua"])) {
	unset($_SESSION["dang_nhap_chua"]);
	unset($_SESSION["current_user"]);

	// xoá cookie auth_user_id
	setcookie("auth_user_id", "", time() - 3600);
}

header('Location: index.php');