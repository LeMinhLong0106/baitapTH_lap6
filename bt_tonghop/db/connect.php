<?php # Script - mysqli_connect.php

// This file contains the database access information. 
// This file also establishes a connection to MySQL, 
// selects the database, and sets the encoding.

// Set the database access information as constants:
DEFINE ('DB_USER', 'root');
DEFINE ('DB_PASSWORD', '');
DEFINE ('DB_HOST', 'localhost');
DEFINE ('DB_NAME', 'qlnv');

// Make the connection:
$connect = @mysqli_connect (DB_HOST, DB_USER, DB_PASSWORD, DB_NAME) 
		OR die ('Could not connect to MySQL: ' . mysqli_connect_error() );

// Set the encoding...
mysqli_set_charset($connect, 'utf8');


function execute($sql) {
	// lưu dữ liệu vào bảng
    // mở kết nối với cơ sở dữ liệu
	$con = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
	//insert, update, delete
	mysqli_query($con, $sql);

	//close connection
	mysqli_close($con);
}

function executeResult($sql) {
	// lưu dữ liệu vào bảng
    // mở kết nối với cơ sở dữ liệu
	$con = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
	//insert, update, delete
	$result = mysqli_query($con, $sql);
	$data   = [];
	if ($result != null){
		while ($row = mysqli_fetch_array($result, 1)) {
			$data[] = $row;
		}
	}
	//close connection
	// mysqli_close($con);

	return $data;
}
//lấy 1 sản phẩm 
function executeSingleResult($sql) {
	// lưu dữ liệu vào bảng
    // mở kết nối với cơ sở dữ liệu
	$con = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
	//insert, update, delete
	$result = mysqli_query($con, $sql);
	$row =null;
	if($result != null){
		$row    = mysqli_fetch_array($result, 1);
	}
	//close connection
	// mysqli_close($con);
	return $row;
}
