<?php

define("HOST", "127.0.0.1");
define("DB", "qlbh");
define("UID", "root");
define("PWD", "");

function load($sql) {
	$cn = new mysqli(HOST, UID, PWD, DB);
	if ($cn->connect_errno) {
	    die("FAILED");
	}
	$cn->query("set names 'utf8'");
	$rs = $cn->query($sql);
	return $rs;
}

function write($sql) {
	$cn = new mysqli(HOST, UID, PWD, DB);
	if ($cn->connect_errno) {
	    die("FAILED");
	}
	$cn->query("set names 'utf8'");
	$cn->query($sql);
	return $cn->insert_id;
}