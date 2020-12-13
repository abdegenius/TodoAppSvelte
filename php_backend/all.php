<?php 
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: GET");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
include 'inc/CRUD.php';
$crud = new CRUD;
$query = $crud->all("lists");
if(!empty($query)){ 
	http_response_code(200);
	echo json_encode($query);
}
?>