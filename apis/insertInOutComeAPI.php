<?php 
//insertInOutComeAPI
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST"); //GET = check getAll , POST = insert , PUT = update , DELETE = delete
header("Access-Control-Allow-Headers: Content-Type");
header("Content-Type: application/json; charset=UTF-8");

require_once "./../connectdb.php";
require_once "./../models/money.php";

//create instant object
$connDB = new ConnectDB();
$money = new Money($connDB->getConnectionDB());


//receive value from client 
$data = json_decode(file_get_contents("php://input"));

//set value to Model variable
$money->moneyDetail = $data->moneyDetail;
$money->moneyDate = $data->moneyDate;
$money->moneyInOut = $data->moneyInOut;
$money->moneyType = $data->moneyType;
$money->userId = $data->userId;




//call insertInOutComeAPI function
$result = $money ->insertInOutComeAPI();

if ($result == true){
    $resultArray = array("message" => "1");
    
    //inset update delete complete
    echo json_encode(  $resultArray, JSON_UNESCAPED_UNICODE);   
}else{
    //inset update delete fail  
    $resultArray = array("message" => "0");  
    echo json_encode(  $resultArray, JSON_UNESCAPED_UNICODE); 
    
}