<?php
//getAllMoneyByuserId
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET"); //GET = check getAll , POST = insert , PUT = update , DELETE = delete
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
$money->userId = $data->userId;

//call getAlltripByUserId function
$result = $money->getAllMoneyByuserId();

if($result->rowCount() > 0){
    //มี
    $resultInfo = array();
    //Extract ข้อมูลที่ได้มาจากคำสั่ง SQL เก็บในตัวแปร
    while ($resultData = $result->fetch(PDO::FETCH_ASSOC)) {
        extract($resultData);
        //สร้างตัวแปรอาร์เรย์เก็บข้อมูล เพื่อส่งกลับไปยัง client
        $resultArray = array(
            //list ข้อมูลที่จะส่งไปยัง client
            "message" => "1",
            "moneyId" => strval($moneyId),
            "moneyDetail" => $moneyDetail,
            "moneyDate" => $moneyDate,
            "moneyInOut" => strval($moneyInOut),
            "moneyType" => strval($moneyType),
            "userId" => strval($userId)
        );
    
        array_push($resultInfo, $resultArray);
    }

    echo json_encode($resultInfo, JSON_UNESCAPED_UNICODE);
}else{
    //ไม่มี
    echo json_encode(array("message" => "0"));
}
