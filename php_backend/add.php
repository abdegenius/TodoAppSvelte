<?php 
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

  include 'inc/CRUD.php';
$crud = new CRUD;
$receive = file_get_contents('php://input');
$data = json_decode($receive);
$item = $data->item;
$query = $crud->create([$item], "item", "lists");
if($query==1){ 
	http_response_code(200);
	echo json_encode(['response' => true]); 
}
if($query==0){ 
	echo json_encode(['response' => false]); 
}
?>